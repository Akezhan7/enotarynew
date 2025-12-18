<?php
/**
 * AJAX обработчик формы обратной связи на странице Контакты
 */

// Регистрация AJAX действий
add_action('wp_ajax_contact_form_submit', 'handle_contact_form_submit');
add_action('wp_ajax_nopriv_contact_form_submit', 'handle_contact_form_submit');

function handle_contact_form_submit() {
    // Проверка nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'enotary-ajax-nonce')) {
        wp_send_json_error([
            'message' => 'Ошибка безопасности. Обновите страницу и попробуйте снова.'
        ]);
    }
    
    // Валидация и санитизация данных
    $name = isset($_POST['contact_name']) ? sanitize_text_field($_POST['contact_name']) : '';
    $email = isset($_POST['contact_email']) ? sanitize_email($_POST['contact_email']) : '';
    $phone = isset($_POST['contact_phone']) ? sanitize_text_field($_POST['contact_phone']) : '';
    $message = isset($_POST['contact_message']) ? sanitize_textarea_field($_POST['contact_message']) : '';
    $agree = isset($_POST['agree']) ? sanitize_text_field($_POST['agree']) : '';
    
    // Проверка обязательных полей
    if (empty($name) || empty($email)) {
        wp_send_json_error([
            'message' => 'Пожалуйста, заполните все обязательные поля'
        ]);
    }
    
    // Проверка email
    if (!is_email($email)) {
        wp_send_json_error([
            'message' => 'Пожалуйста, введите корректный email адрес'
        ]);
    }
    
    // Проверка согласия на обработку данных
    if ($agree !== 'on') {
        wp_send_json_error([
            'message' => 'Необходимо согласие на обработку персональных данных'
        ]);
    }
    
    // Получение email получателя из настроек ACF или использование admin_email
    $to_email = get_field('contact_form_email', 'option');
    if (empty($to_email)) {
        $to_email = get_option('admin_email');
    }
    
    // Формирование темы письма
    $subject = '💬 Новое обращение с сайта - ' . get_bloginfo('name');
    
    // Формирование тела письма (HTML)
    $body = enotary_get_contact_form_email_template(array(
        'name'    => $name,
        'email'   => $email,
        'message' => $message,
        'date'    => current_time('d.m.Y H:i'),
        'ip'      => $_SERVER['REMOTE_ADDR']
    ));
    
    // Заголовки письма
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );
    
    // Отправка письма
    $sent = wp_mail($to_email, $subject, $body, $headers);
    
    if ($sent) {
        wp_send_json_success([
            'message' => 'Спасибо! Ваше сообщение успешно отправлено. Мы свяжемся с вами в ближайшее время.'
        ]);
    } else {
        wp_send_json_error([
            'message' => 'Произошла ошибка при отправке сообщения. Пожалуйста, попробуйте позже или свяжитесь с нами по телефону.'
        ]);
    }
}

/**
 * HTML шаблон письма с формы обратной связи
 * 
 * @param array $data Данные для подстановки в шаблон
 * @return string HTML письма
 */
function enotary_get_contact_form_email_template($data) {
    $name = $data['name'];
    $email = $data['email'];
    $message = !empty($data['message']) ? nl2br(esc_html($data['message'])) : '<em style="color: #979797;">Сообщение не указано</em>';
    $date = $data['date'];
    $ip = $data['ip'];
    
    $site_name = get_bloginfo('name');
    $site_url = home_url();
    
    ob_start();
    ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новое обращение с сайта</title>
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
                                <?php echo esc_html($site_name); ?>
                            </h1>
                            <p style="margin: 8px 0 0 0; color: #ffffff; font-size: 14px; opacity: 0.9;">
                                Удостоверяющий Центр
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Плашка типа сообщения -->
                    <tr>
                        <td style="background-color: #19bd7b; padding: 15px 40px; text-align: center;">
                            <p style="margin: 0; color: #ffffff; font-size: 16px; font-weight: 700;">
                                💬 Новое обращение с сайта
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Основное содержимое -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="margin: 0 0 30px 0; color: #262626; font-size: 16px; line-height: 1.5;">
                                Получено новое сообщение через форму обратной связи на странице <strong>Контакты</strong>.
                            </p>
                            
                            <!-- Информация о клиенте -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 20px 0;">
                                <tr>
                                    <td colspan="2" style="padding: 15px 20px; background-color: #375d74; border-radius: 8px 8px 0 0;">
                                        <p style="margin: 0; color: #ffffff; font-size: 16px; font-weight: 700;">
                                            📋 Данные клиента
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 15px 20px; background-color: #fafafa; border-left: 1px solid #e0e0e0; border-right: 1px solid #e0e0e0; width: 35%;">
                                        <p style="margin: 0; color: #979797; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Имя
                                        </p>
                                    </td>
                                    <td style="padding: 15px 20px; background-color: #fafafa; border-right: 1px solid #e0e0e0;">
                                        <p style="margin: 0; color: #262626; font-size: 15px; font-weight: 600;">
                                            <?php echo esc_html($name); ?>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 15px 20px; background-color: #ffffff; border-left: 1px solid #e0e0e0; border-right: 1px solid #e0e0e0;">
                                        <p style="margin: 0; color: #979797; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Email
                                        </p>
                                    </td>
                                    <td style="padding: 15px 20px; background-color: #ffffff; border-right: 1px solid #e0e0e0;">
                                        <p style="margin: 0; color: #262626; font-size: 15px;">
                                            <a href="mailto:<?php echo esc_attr($email); ?>" style="color: #19bd7b; text-decoration: none; font-weight: 600;">
                                                <?php echo esc_html($email); ?>
                                            </a>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding: 15px 20px; background-color: #fafafa; border-left: 1px solid #e0e0e0; border-right: 1px solid #e0e0e0; border-bottom: 1px solid #e0e0e0; border-radius: 0 0 8px 8px;">
                                        <p style="margin: 0 0 8px 0; color: #979797; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Сообщение
                                        </p>
                                        <p style="margin: 0; color: #262626; font-size: 15px; line-height: 1.6;">
                                            <?php echo $message; ?>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Кнопка быстрого ответа -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0 20px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="mailto:<?php echo esc_attr($email); ?>" style="display: inline-block; padding: 15px 40px; background-color: #19bd7b; color: #ffffff; text-decoration: none; border-radius: 8px; font-size: 16px; font-weight: 700;">
                                            ✉️ Ответить на Email
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Дополнительная информация -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0 0 0; border-top: 1px solid #e0e0e0; padding-top: 20px;">
                                <tr>
                                    <td>
                                        <p style="margin: 0 0 8px 0; color: #979797; font-size: 13px;">
                                            <strong>Дата и время:</strong> <?php echo esc_html($date); ?>
                                        </p>
                                        <p style="margin: 0; color: #979797; font-size: 13px;">
                                            <strong>IP адрес:</strong> <?php echo esc_html($ip); ?>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Футер -->
                    <tr>
                        <td style="background-color: #f0f0f0; padding: 20px 40px; text-align: center; border-top: 1px solid #e0e0e0;">
                            <p style="margin: 0 0 5px 0; color: #979797; font-size: 12px;">
                                Это автоматическое уведомление с сайта
                            </p>
                            <p style="margin: 0; color: #375d74; font-size: 13px; font-weight: 600;">
                                <a href="<?php echo esc_url($site_url); ?>" style="color: #375d74; text-decoration: none;">
                                    <?php echo esc_html($site_name); ?>
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
