<?php
/**
 * Система подбора сертификата (ТЗ пункт 230)
 * 
 * "Если необходимого сертификата нет, должна быть возможность 
 * обратиться в УЦ для подбора ссылки в ручном режиме."
 * 
 * @package enotarynew
 */

// Запретить прямой доступ
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ============================================
 * AJAX ОБРАБОТЧИК ФОРМЫ ПОДБОРА СЕРТИФИКАТА
 * ============================================
 */

/**
 * Регистрация AJAX действий для залогиненных и незалогиненных пользователей
 */
add_action( 'wp_ajax_submit_certificate_help', 'enotary_handle_certificate_help_form' );
add_action( 'wp_ajax_nopriv_submit_certificate_help', 'enotary_handle_certificate_help_form' );

/**
 * Обработка формы подбора сертификата
 */
function enotary_handle_certificate_help_form() {
    // Проверка nonce для безопасности
    check_ajax_referer( 'certificate_help_nonce', 'nonce' );
    
    // Получение и валидация данных
    $name = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
    $phone = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] ) : '';
    $comment = isset( $_POST['comment'] ) ? sanitize_textarea_field( $_POST['comment'] ) : '';
    
    // Валидация обязательных полей
    if ( empty( $name ) || empty( $phone ) ) {
        wp_send_json_error( array(
            'message' => 'Пожалуйста, заполните все обязательные поля.'
        ) );
    }
    
    // Валидация телефона (базовая)
    $phone_clean = preg_replace( '/\D/', '', $phone );
    if ( strlen( $phone_clean ) < 10 ) {
        wp_send_json_error( array(
            'message' => 'Пожалуйста, введите корректный номер телефона.'
        ) );
    }
    
    // Отправка email менеджеру
    $sent = enotary_send_certificate_help_email( $name, $phone, $comment );
    
    if ( $sent ) {
        wp_send_json_success( array(
            'message' => 'Спасибо! Ваша заявка принята. Мы свяжемся с вами в ближайшее время.'
        ) );
    } else {
        wp_send_json_error( array(
            'message' => 'Произошла ошибка при отправке заявки. Пожалуйста, свяжитесь с нами по телефону +7 (495) 363-30-93.'
        ) );
    }
}

/**
 * ============================================
 * EMAIL УВЕДОМЛЕНИЕ МЕНЕДЖЕРУ
 * ============================================
 */

/**
 * Отправка email менеджеру о заявке на подбор сертификата
 */
function enotary_send_certificate_help_email( $name, $phone, $comment ) {
    $to = get_option( 'admin_email' );
    $subject = '🔔 Новая заявка на подбор сертификата - ' . get_bloginfo( 'name' );
    
    // HTML письмо
    $message = enotary_get_certificate_help_email_html( $name, $phone, $comment );
    
    // Заголовки для HTML письма
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
    );
    
    // Отправляем письмо
    return wp_mail( $to, $subject, $message, $headers );
}

/**
 * HTML шаблон письма для менеджера
 */
function enotary_get_certificate_help_email_html( $name, $phone, $comment ) {
    $site_name = get_bloginfo( 'name' );
    $current_time = current_time( 'd.m.Y H:i' );
    
    ob_start();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style="margin: 0; padding: 0; font-family: 'Arial', sans-serif; background-color: #f5f5f5;">
        <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 40px 20px;">
            <tr>
                <td align="center">
                    <!-- Основной контейнер -->
                    <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        
                        <!-- Шапка письма -->
                        <tr>
                            <td style="background: linear-gradient(135deg, #375d74 0%, #2a4a5e 100%); padding: 30px; text-align: center;">
                                <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: bold;">
                                    🔔 Новая заявка на подбор
                                </h1>
                                <p style="margin: 10px 0 0 0; color: rgba(255,255,255,0.9); font-size: 14px;">
                                    Клиент просит помочь с выбором сертификата
                                </p>
                            </td>
                        </tr>
                        
                        <!-- Основное содержимое -->
                        <tr>
                            <td style="padding: 40px 30px;">
                                <p style="margin: 0 0 25px 0; font-size: 16px; color: #262626; line-height: 1.6;">
                                    <strong>Клиент не нашел подходящий сертификат в каталоге</strong> и просит помощи в подборе.
                                </p>
                                
                                <!-- Данные клиента -->
                                <div style="background-color: #f9f9f9; border-left: 4px solid #375d74; padding: 20px; margin: 25px 0; border-radius: 5px;">
                                    <h3 style="margin: 0 0 15px 0; font-size: 16px; color: #262626;">Контактные данные:</h3>
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="padding: 8px 0; font-size: 14px; color: #666;">
                                                <strong style="color: #262626;">👤 Имя:</strong>
                                            </td>
                                            <td style="padding: 8px 0; font-size: 14px; color: #333; text-align: right;">
                                                <?php echo esc_html( $name ); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 8px 0; font-size: 14px; color: #666; border-top: 1px solid #eeeeee;">
                                                <strong style="color: #262626;">📞 Телефон:</strong>
                                            </td>
                                            <td style="padding: 8px 0; font-size: 14px; color: #333; text-align: right; border-top: 1px solid #eeeeee;">
                                                <a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $phone ) ); ?>" style="color: #375d74; text-decoration: none; font-weight: bold;">
                                                    <?php echo esc_html( $phone ); ?>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 8px 0; font-size: 14px; color: #666; border-top: 1px solid #eeeeee;">
                                                <strong style="color: #262626;">🕐 Время заявки:</strong>
                                            </td>
                                            <td style="padding: 8px 0; font-size: 14px; color: #333; text-align: right; border-top: 1px solid #eeeeee;">
                                                <?php echo esc_html( $current_time ); ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <?php if ( ! empty( $comment ) ) : ?>
                                <!-- Комментарий клиента -->
                                <div style="background-color: #f0f8ff; border-left: 4px solid #4a90e2; padding: 20px; margin: 25px 0; border-radius: 5px;">
                                    <h3 style="margin: 0 0 10px 0; font-size: 14px; color: #262626; font-weight: bold;">💬 Комментарий клиента:</h3>
                                    <p style="margin: 0; font-size: 14px; color: #333; line-height: 1.6; white-space: pre-wrap;">
                                        <?php echo esc_html( $comment ); ?>
                                    </p>
                                </div>
                                <?php endif; ?>
                                
                                <!-- Призыв к действию -->
                                <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 25px 0; border-radius: 5px;">
                                    <p style="margin: 0; font-size: 14px; color: #856404; line-height: 1.6;">
                                        <strong>⚡ Действие:</strong> Свяжитесь с клиентом, уточните потребность и подготовьте персональное предложение или ссылку на оплату.
                                    </p>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Быстрые действия -->
                        <tr>
                            <td style="padding: 0 30px 30px 30px;">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="text-align: center;">
                                            <a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $phone ) ); ?>" style="display: inline-block; background-color: #375d74; color: #ffffff; text-decoration: none; font-size: 15px; font-weight: bold; padding: 14px 30px; border-radius: 8px; margin: 5px;">
                                                📞 Позвонить клиенту
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                        <!-- Футер -->
                        <tr>
                            <td style="background-color: #f9f9f9; padding: 20px 30px; text-align: center; border-top: 1px solid #eeeeee;">
                                <p style="margin: 0; font-size: 12px; color: #999999;">
                                    Это автоматическое уведомление от системы <strong><?php echo esc_html( $site_name ); ?></strong>
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
 * ============================================
 * ПОДКЛЮЧЕНИЕ СКРИПТОВ И СТИЛЕЙ
 * ============================================
 */

/**
 * Передача nonce в JavaScript
 */
add_action( 'wp_footer', 'enotary_certificate_help_inline_script', 5 );

function enotary_certificate_help_inline_script() {
    ?>
    <script type="text/javascript">
        var certificateHelpData = {
            ajaxUrl: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
            nonce: '<?php echo wp_create_nonce( 'certificate_help_nonce' ); ?>'
        };
    </script>
    <?php
}
