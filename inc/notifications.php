<?php
/**
 * Система уведомлений об истечении срока сертификата
 * 
 * ТЗ пункт 215: Автоматическая и ручная рассылка клиентам
 * о приближающемся истечении срока действия сертификата
 * 
 * @package enotarynew
 */

// Запретить прямой доступ
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ============================================
 * ЗАДАЧА 1: АВТОМАТИЧЕСКАЯ РАССЫЛКА (CRON)
 * ============================================
 */

/**
 * Регистрация кастомного расписания Cron
 * Добавляет интервал "раз в день" если его нет
 */
add_filter( 'cron_schedules', 'enotary_add_daily_cron_schedule' );

function enotary_add_daily_cron_schedule( $schedules ) {
    if ( ! isset( $schedules['daily'] ) ) {
        $schedules['daily'] = array(
            'interval' => 86400, // 24 часа в секундах
            'display'  => __( 'Раз в день', 'enotarynew' ),
        );
    }
    return $schedules;
}

/**
 * Активация Cron задачи при активации темы
 */
add_action( 'after_setup_theme', 'enotary_schedule_certificate_check' );

function enotary_schedule_certificate_check() {
    if ( ! wp_next_scheduled( 'enotary_daily_check' ) ) {
        // Запланировать на 9:00 утра каждый день
        wp_schedule_event( strtotime( 'tomorrow 09:00' ), 'daily', 'enotary_daily_check' );
    }
}

/**
 * Деактивация Cron задачи при переключении темы
 */
add_action( 'switch_theme', 'enotary_deactivate_certificate_check' );

function enotary_deactivate_certificate_check() {
    $timestamp = wp_next_scheduled( 'enotary_daily_check' );
    if ( $timestamp ) {
        wp_unschedule_event( $timestamp, 'enotary_daily_check' );
    }
}

/**
 * Основная функция проверки истекающих сертификатов (запускается Cron)
 * 
 * Проверяет все заказы и отправляет уведомления если:
 * - До истечения сертификата осталось ровно 30 дней
 * - До истечения сертификата осталось ровно 7 дней
 */
add_action( 'enotary_daily_check', 'enotary_check_expiring_certificates' );

function enotary_check_expiring_certificates() {
    // Проверка что WooCommerce активен
    if ( ! function_exists( 'wc_get_orders' ) ) {
        return;
    }
    
    // Получаем все завершенные и обрабатываемые заказы
    $args = array(
        'limit'   => -1,
        'status'  => array( 'completed', 'processing' ),
        'orderby' => 'date',
        'order'   => 'DESC',
    );
    
    $orders = wc_get_orders( $args );
    
    if ( empty( $orders ) ) {
        return;
    }
    
    // Текущая дата (сброс времени до 00:00:00)
    $today = new DateTime( 'today', new DateTimeZone( 'Europe/Moscow' ) );
    
    // Счетчики для логирования
    $checked_count = 0;
    $sent_count = 0;
    
    foreach ( $orders as $order ) {
        $order_id = $order->get_id();
        
        // Получаем дату истечения сертификата
        $expiry_date_str = $order->get_meta( '_certificate_expiry_date', true );
        
        // Пропускаем если дата не указана
        if ( empty( $expiry_date_str ) ) {
            continue;
        }
        
        $checked_count++;
        
        try {
            // Парсим дату истечения
            $expiry_date = new DateTime( $expiry_date_str, new DateTimeZone( 'Europe/Moscow' ) );
            
            // Вычисляем разницу в днях
            $interval = $today->diff( $expiry_date );
            $days_left = (int) $interval->format( '%r%a' );
            
            // Проверяем: осталось ровно 30 или 7 дней
            if ( $days_left !== 30 && $days_left !== 7 ) {
                continue;
            }
            
            // Проверяем не отправляли ли мы уже сегодня уведомление
            $last_notice_date = $order->get_meta( '_expiry_notice_sent', true );
            $today_str = $today->format( 'Y-m-d' );
            
            if ( $last_notice_date === $today_str ) {
                // Уже отправляли сегодня, пропускаем
                continue;
            }
            
            // Отправляем уведомление
            $email_sent = enotary_send_expiry_notification( $order, $days_left );
            
            if ( $email_sent ) {
                // Сохраняем дату отправки уведомления
                $order->update_meta_data( '_expiry_notice_sent', $today_str );
                $order->update_meta_data( '_expiry_notice_days', $days_left );
                $order->save();
                
                // Добавляем заметку к заказу
                $order->add_order_note(
                    sprintf(
                        'Автоматически отправлено напоминание о продлении сертификата (осталось %d дней).',
                        $days_left
                    )
                );
                
                $sent_count++;
            }
            
        } catch ( Exception $e ) {
            // Логируем ошибку парсинга даты
            error_log( sprintf(
                'ENotary Notifications: Ошибка парсинга даты для заказа #%d: %s',
                $order_id,
                $e->getMessage()
            ) );
        }
    }
    
    // Логируем результаты проверки
    error_log( sprintf(
        'ENotary Notifications: Проверено заказов: %d, отправлено уведомлений: %d',
        $checked_count,
        $sent_count
    ) );
}

/**
 * Отправка email уведомления клиенту
 * 
 * @param WC_Order $order Объект заказа
 * @param int $days_left Количество дней до истечения
 * @return bool Успешность отправки
 */
function enotary_send_expiry_notification( $order, $days_left ) {
    // Получаем данные клиента
    $customer_email = $order->get_billing_email();
    $customer_name = $order->get_billing_first_name();
    $order_id = $order->get_id();
    $expiry_date_str = $order->get_meta( '_certificate_expiry_date', true );
    
    if ( empty( $customer_email ) ) {
        return false;
    }
    
    // Форматируем дату истечения для письма
    try {
        $expiry_date = new DateTime( $expiry_date_str );
        $expiry_formatted = $expiry_date->format( 'd.m.Y' );
    } catch ( Exception $e ) {
        $expiry_formatted = $expiry_date_str;
    }
    
    // Определяем степень срочности
    $urgency_text = ( $days_left <= 7 ) ? 'СРОЧНО!' : 'Обратите внимание';
    $urgency_color = ( $days_left <= 7 ) ? '#d32f2f' : '#f57c00';
    
    // Тема письма
    $subject = sprintf(
        '%s Истекает срок действия сертификата ЭП (заказ №%d)',
        ( $days_left <= 7 ) ? '⚠️' : '📅',
        $order_id
    );
    
    // Тело письма (HTML)
    $message = enotary_get_expiry_email_template( array(
        'customer_name'    => $customer_name,
        'order_id'         => $order_id,
        'days_left'        => $days_left,
        'expiry_date'      => $expiry_formatted,
        'urgency_text'     => $urgency_text,
        'urgency_color'    => $urgency_color,
        'order_url'        => $order->get_view_order_url(),
    ) );
    
    // Заголовки письма
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . get_bloginfo( 'name' ) . ' <' . get_option( 'admin_email' ) . '>',
    );
    
    // Отправка письма
    $sent = wp_mail( $customer_email, $subject, $message, $headers );
    
    // Логируем результат
    if ( $sent ) {
        error_log( sprintf(
            'ENotary Notifications: Отправлено уведомление для заказа #%d (%s, осталось %d дней)',
            $order_id,
            $customer_email,
            $days_left
        ) );
    } else {
        error_log( sprintf(
            'ENotary Notifications: ОШИБКА отправки для заказа #%d (%s)',
            $order_id,
            $customer_email
        ) );
    }
    
    return $sent;
}

/**
 * Шаблон HTML письма о продлении сертификата
 * 
 * @param array $data Данные для подстановки в шаблон
 * @return string HTML письма
 */
function enotary_get_expiry_email_template( $data ) {
    $customer_name = ! empty( $data['customer_name'] ) ? $data['customer_name'] : 'Уважаемый клиент';
    $order_id = $data['order_id'];
    $days_left = $data['days_left'];
    $expiry_date = $data['expiry_date'];
    $urgency_text = $data['urgency_text'];
    $urgency_color = $data['urgency_color'];
    $order_url = $data['order_url'];
    
    $site_name = get_bloginfo( 'name' );
    $site_url = home_url();
    
    // Текст призыва к действию
    if ( $days_left <= 7 ) {
        $cta_text = 'Не упустите возможность продолжить использование вашего сертификата без перерыва. Свяжитесь с нами сегодня!';
    } else {
        $cta_text = 'Рекомендуем начать процесс продления заранее, чтобы избежать простоев в работе.';
    }
    
    ob_start();
    ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Напоминание о продлении сертификата</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Open Sans', Arial, sans-serif; background-color: #f5f5f5;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 20px 0;">
        <tr>
            <td align="center">
                <!-- Основной контейнер -->
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    
                    <!-- Шапка с логотипом -->
                    <tr>
                        <td style="background-color: #375d74; padding: 30px 40px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 700;">
                                <?php echo esc_html( $site_name ); ?>
                            </h1>
                            <p style="margin: 8px 0 0 0; color: #ffffff; font-size: 14px; opacity: 0.9;">
                                Удостоверяющий Центр
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Плашка срочности -->
                    <tr>
                        <td style="background-color: <?php echo esc_attr( $urgency_color ); ?>; padding: 15px 40px; text-align: center;">
                            <p style="margin: 0; color: #ffffff; font-size: 16px; font-weight: 700;">
                                <?php echo esc_html( $urgency_text ); ?>
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Основное содержимое -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="margin: 0 0 20px 0; color: #262626; font-size: 16px; line-height: 1.5;">
                                Здравствуйте, <strong><?php echo esc_html( $customer_name ); ?></strong>!
                            </p>
                            
                            <p style="margin: 0 0 20px 0; color: #262626; font-size: 16px; line-height: 1.6;">
                                Напоминаем вам, что срок действия вашего <strong>квалифицированного сертификата электронной подписи</strong> 
                                по заказу <strong>№<?php echo esc_html( $order_id ); ?></strong> истекает через:
                            </p>
                            
                            <!-- Большая плашка с количеством дней -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0; background-color: #fafafa; border: 2px solid <?php echo esc_attr( $urgency_color ); ?>; border-radius: 8px;">
                                <tr>
                                    <td style="padding: 30px; text-align: center;">
                                        <p style="margin: 0 0 10px 0; color: #979797; font-size: 14px; text-transform: uppercase; letter-spacing: 1px;">
                                            Осталось
                                        </p>
                                        <p style="margin: 0; color: <?php echo esc_attr( $urgency_color ); ?>; font-size: 48px; font-weight: 700; line-height: 1;">
                                            <?php echo esc_html( $days_left ); ?>
                                        </p>
                                        <p style="margin: 5px 0 0 0; color: #262626; font-size: 18px; font-weight: 600;">
                                            <?php echo esc_html( enotary_get_days_word( $days_left ) ); ?>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Информация о дате истечения -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 20px 0;">
                                <tr>
                                    <td style="padding: 15px; background-color: #f0f0f0; border-left: 4px solid #375d74; border-radius: 4px;">
                                        <p style="margin: 0; color: #262626; font-size: 14px;">
                                            <strong>Дата окончания действия:</strong> <?php echo esc_html( $expiry_date ); ?>
                                        </p>
                                        <p style="margin: 8px 0 0 0; color: #262626; font-size: 14px;">
                                            <strong>Номер заказа:</strong> #<?php echo esc_html( $order_id ); ?>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 20px 0; color: #262626; font-size: 16px; line-height: 1.6;">
                                <?php echo esc_html( $cta_text ); ?>
                            </p>
                            
                            <!-- Кнопка действия -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="tel:+74953633093" style="display: inline-block; padding: 15px 40px; background-color: #375d74; color: #ffffff; text-decoration: none; border-radius: 8px; font-size: 16px; font-weight: 700; transition: opacity 0.3s;">
                                            📞 Позвонить: +7 (495) 363-30-93
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 10px 0 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="mailto:info@signal-com.ru" style="display: inline-block; padding: 15px 40px; background-color: #19bd7b; color: #ffffff; text-decoration: none; border-radius: 8px; font-size: 16px; font-weight: 700; transition: opacity 0.3s;">
                                            ✉️ Написать: info@signal-com.ru
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Дополнительная информация -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0 0 0; border-top: 1px solid #e0e0e0; padding-top: 20px;">
                                <tr>
                                    <td>
                                        <p style="margin: 0 0 10px 0; color: #262626; font-size: 14px; font-weight: 600;">
                                            Почему важно продлить сертификат вовремя?
                                        </p>
                                        <ul style="margin: 0; padding-left: 20px; color: #262626; font-size: 14px; line-height: 1.6;">
                                            <li>Без действующего сертификата вы не сможете подписывать юридически значимые документы</li>
                                            <li>Процесс продления занимает время, начните его заранее</li>
                                            <li>Избежите штрафов и простоев в работе с контрагентами</li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Подвал -->
                    <tr>
                        <td style="background-color: #fafafa; padding: 30px 40px; text-align: center; border-top: 1px solid #e0e0e0;">
                            <p style="margin: 0 0 10px 0; color: #979797; font-size: 12px;">
                                Это автоматическое уведомление от <?php echo esc_html( $site_name ); ?>
                            </p>
                            <p style="margin: 0 0 15px 0; color: #979797; font-size: 12px;">
                                <a href="<?php echo esc_url( $order_url ); ?>" style="color: #375d74; text-decoration: none;">
                                    Просмотреть заказ №<?php echo esc_html( $order_id ); ?>
                                </a>
                            </p>
                            <p style="margin: 0; color: #979797; font-size: 12px;">
                                <a href="<?php echo esc_url( $site_url ); ?>" style="color: #375d74; text-decoration: none;">
                                    <?php echo esc_html( $site_name ); ?>
                                </a>
                            </p>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
    <?php
    return ob_get_clean();
}

/**
 * Склонение слова "день" в зависимости от числа
 * 
 * @param int $number Количество дней
 * @return string Правильное склонение
 */
function enotary_get_days_word( $number ) {
    $cases = array( 'день', 'дня', 'дней' );
    
    $number = abs( $number );
    
    if ( $number % 100 >= 11 && $number % 100 <= 19 ) {
        return $cases[2];
    }
    
    switch ( $number % 10 ) {
        case 1:
            return $cases[0];
        case 2:
        case 3:
        case 4:
            return $cases[1];
        default:
            return $cases[2];
    }
}

/**
 * ============================================
 * ЗАДАЧА 2: РУЧНАЯ ОТПРАВКА (КНОПКА В ЗАКАЗЕ)
 * ============================================
 */

/**
 * Добавить действие "Напомнить о продлении" в выпадающий список заказа
 */
add_filter( 'woocommerce_order_actions', 'enotary_add_manual_reminder_action' );

function enotary_add_manual_reminder_action( $actions ) {
    global $theorder;
    
    // Проверяем что заказ имеет дату истечения сертификата
    $expiry_date = $theorder->get_meta( '_certificate_expiry_date', true );
    
    if ( ! empty( $expiry_date ) ) {
        $actions['enotary_send_expiry_reminder'] = __( 'Email: Напомнить о продлении сертификата', 'enotarynew' );
    }
    
    return $actions;
}

/**
 * Обработка действия "Напомнить о продлении"
 */
add_action( 'woocommerce_order_action_enotary_send_expiry_reminder', 'enotary_process_manual_reminder' );

function enotary_process_manual_reminder( $order ) {
    // Получаем дату истечения
    $expiry_date_str = $order->get_meta( '_certificate_expiry_date', true );
    
    if ( empty( $expiry_date_str ) ) {
        return;
    }
    
    // Вычисляем количество дней до истечения
    try {
        $today = new DateTime( 'today', new DateTimeZone( 'Europe/Moscow' ) );
        $expiry_date = new DateTime( $expiry_date_str, new DateTimeZone( 'Europe/Moscow' ) );
        $interval = $today->diff( $expiry_date );
        $days_left = (int) $interval->format( '%r%a' );
    } catch ( Exception $e ) {
        $days_left = 0;
    }
    
    // Отправляем уведомление
    $email_sent = enotary_send_expiry_notification( $order, $days_left );
    
    if ( $email_sent ) {
        // Добавляем заметку к заказу
        $order->add_order_note(
            sprintf(
                'Напоминание о продлении сертификата отправлено вручную администратором (осталось %d дней).',
                $days_left
            )
        );
        
        // Обновляем мета-данные
        $today_str = ( new DateTime( 'today' ) )->format( 'Y-m-d' );
        $order->update_meta_data( '_expiry_notice_sent', $today_str );
        $order->update_meta_data( '_expiry_notice_days', $days_left );
        $order->update_meta_data( '_expiry_notice_manual', 'yes' );
        $order->save();
    }
}

/**
 * ============================================
 * ДОПОЛНИТЕЛЬНО: НАСТРОЙКИ И УТИЛИТЫ
 * ============================================
 */

/**
 * Тестовая функция для проверки работы уведомлений
 * Вызывается через URL: /?enotary_test_notifications=1 (только для администраторов)
 */
add_action( 'init', 'enotary_test_notifications_trigger' );

function enotary_test_notifications_trigger() {
    if ( ! isset( $_GET['enotary_test_notifications'] ) || ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    echo '<h2>Тестирование системы уведомлений E-Notary</h2>';
    echo '<p>Запуск проверки истекающих сертификатов...</p>';
    
    enotary_check_expiring_certificates();
    
    echo '<p><strong>Проверка завершена!</strong> Смотрите результаты в error_log или в заметках к заказам.</p>';
    echo '<p><a href="' . admin_url( 'edit.php?post_type=shop_order' ) . '">← Вернуться к заказам</a></p>';
    
    exit;
}

/**
 * Вывод информации о последней отправке уведомления в админке заказа
 */
add_action( 'woocommerce_admin_order_data_after_order_details', 'enotary_display_notification_info' );

function enotary_display_notification_info( $order ) {
    $last_notice_date = $order->get_meta( '_expiry_notice_sent', true );
    $last_notice_days = $order->get_meta( '_expiry_notice_days', true );
    $is_manual = $order->get_meta( '_expiry_notice_manual', true );
    
    if ( ! empty( $last_notice_date ) ) {
        ?>
        <div class="order_data_column" style="clear:both; padding-top: 13px;">
            <h3>📧 Уведомления о продлении</h3>
            <p class="form-field">
                <strong>Последняя отправка:</strong> <?php echo esc_html( date( 'd.m.Y', strtotime( $last_notice_date ) ) ); ?><br>
                <strong>Оставалось дней:</strong> <?php echo esc_html( $last_notice_days ); ?><br>
                <strong>Способ отправки:</strong> <?php echo ( $is_manual === 'yes' ) ? 'Вручную (администратором)' : 'Автоматически (Cron)'; ?>
            </p>
        </div>
        <?php
    }
}
