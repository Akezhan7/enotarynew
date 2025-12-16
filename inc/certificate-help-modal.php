<?php
/**
 * Модальное окно подбора сертификата (ТЗ п.230)
 * 
 * "Если необходимого сертификата нет, должна быть возможность 
 * обратиться в УЦ для подбора ссылки в ручном режиме"
 * 
 * @package enotarynew
 */

// Запретить прямой доступ
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * AJAX обработчик отправки формы подбора сертификата
 */
add_action( 'wp_ajax_certificate_help_request', 'enotary_handle_certificate_help_request' );
add_action( 'wp_ajax_nopriv_certificate_help_request', 'enotary_handle_certificate_help_request' );

function enotary_handle_certificate_help_request() {
    // Проверка nonce для безопасности
    check_ajax_referer( 'certificate_help_nonce', 'nonce' );
    
    // Получаем и валидируем данные
    $name = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
    $phone = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] ) : '';
    $comment = isset( $_POST['comment'] ) ? sanitize_textarea_field( $_POST['comment'] ) : '';
    $page = isset( $_POST['page'] ) ? sanitize_text_field( $_POST['page'] ) : 'Неизвестно';
    
    // Валидация обязательных полей
    if ( empty( $name ) || empty( $phone ) ) {
        wp_send_json_error( array(
            'message' => 'Пожалуйста, заполните все обязательные поля.'
        ) );
    }
    
    // Валидация телефона (упрощенная)
    if ( ! preg_match( '/^[\d\s\+\(\)\-]{10,}$/', $phone ) ) {
        wp_send_json_error( array(
            'message' => 'Пожалуйста, введите корректный номер телефона.'
        ) );
    }
    
    // Отправка email менеджеру
    $sent = enotary_send_certificate_help_email( $name, $phone, $comment, $page );
    
    if ( $sent ) {
        wp_send_json_success( array(
            'message' => 'Спасибо! Наш менеджер свяжется с вами в ближайшее время.'
        ) );
    } else {
        wp_send_json_error( array(
            'message' => 'Произошла ошибка. Пожалуйста, позвоните нам по телефону +7 (495) 363-30-93'
        ) );
    }
}

/**
 * Отправка email менеджеру
 */
function enotary_send_certificate_help_email( $name, $phone, $comment, $page ) {
    $admin_email = get_option( 'admin_email' );
    $site_name = get_bloginfo( 'name' );
    
    $subject = '[' . $site_name . '] Запрос на подбор сертификата';
    
    // HTML шаблон письма
    $message = enotary_get_certificate_help_email_html( $name, $phone, $comment, $page );
    
    // Заголовки
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $site_name . ' <' . $admin_email . '>',
        'Reply-To: ' . $name . ' <noreply@' . $_SERVER['HTTP_HOST'] . '>'
    );
    
    return wp_mail( $admin_email, $subject, $message, $headers );
}

/**
 * HTML шаблон письма менеджеру
 */
function enotary_get_certificate_help_email_html( $name, $phone, $comment, $page ) {
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
                    <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        
                        <!-- Шапка -->
                        <tr>
                            <td style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); padding: 30px; text-align: center;">
                                <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: bold;">
                                    🆘 Запрос на подбор сертификата
                                </h1>
                                <p style="margin: 10px 0 0 0; color: rgba(255,255,255,0.9); font-size: 14px;">
                                    Клиент не смог самостоятельно выбрать сертификат
                                </p>
                            </td>
                        </tr>
                        
                        <!-- Основное содержимое -->
                        <tr>
                            <td style="padding: 30px;">
                                <h2 style="margin: 0 0 20px 0; font-size: 18px; color: #262626;">
                                    Данные клиента:
                                </h2>
                                
                                <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 25px;">
                                    <tr>
                                        <td style="padding: 12px; background-color: #f9f9f9; border-radius: 8px; margin-bottom: 10px;">
                                            <p style="margin: 0 0 5px 0; font-size: 12px; color: #999; text-transform: uppercase; font-weight: bold;">
                                                ИМЯ:
                                            </p>
                                            <p style="margin: 0; font-size: 16px; color: #262626; font-weight: bold;">
                                                <?php echo esc_html( $name ); ?>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr style="height: 10px;"></tr>
                                    <tr>
                                        <td style="padding: 12px; background-color: #f9f9f9; border-radius: 8px; margin-bottom: 10px;">
                                            <p style="margin: 0 0 5px 0; font-size: 12px; color: #999; text-transform: uppercase; font-weight: bold;">
                                                ТЕЛЕФОН:
                                            </p>
                                            <p style="margin: 0; font-size: 18px; color: #375d74; font-weight: bold;">
                                                <a href="tel:<?php echo esc_attr( $phone ); ?>" style="color: #375d74; text-decoration: none;">
                                                    <?php echo esc_html( $phone ); ?>
                                                </a>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr style="height: 10px;"></tr>
                                    <tr>
                                        <td style="padding: 12px; background-color: #f9f9f9; border-radius: 8px;">
                                            <p style="margin: 0 0 5px 0; font-size: 12px; color: #999; text-transform: uppercase; font-weight: bold;">
                                                СТРАНИЦА:
                                            </p>
                                            <p style="margin: 0; font-size: 14px; color: #666;">
                                                <?php echo esc_html( $page ); ?>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                                
                                <?php if ( ! empty( $comment ) ) : ?>
                                <h3 style="margin: 0 0 12px 0; font-size: 16px; color: #262626;">
                                    Комментарий клиента:
                                </h3>
                                <div style="background-color: #fff8dc; border-left: 4px solid #ffc107; padding: 15px; border-radius: 5px; margin-bottom: 25px;">
                                    <p style="margin: 0; font-size: 14px; color: #333; line-height: 1.6;">
                                        <?php echo nl2br( esc_html( $comment ) ); ?>
                                    </p>
                                </div>
                                <?php endif; ?>
                                
                                <!-- Кнопка звонка -->
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td align="center" style="padding: 20px 0;">
                                            <a href="tel:<?php echo esc_attr( $phone ); ?>" style="display: inline-block; padding: 15px 40px; background: linear-gradient(135deg, #27ae60 0%, #229954 100%); color: white; text-decoration: none; border-radius: 10px; font-size: 16px; font-weight: bold;">
                                                📞 Позвонить клиенту
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                                
                                <!-- Информация о времени -->
                                <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #eeeeee;">
                                    <p style="margin: 0; font-size: 13px; color: #999; text-align: center;">
                                        📅 Дата и время запроса: <?php echo esc_html( $current_time ); ?>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Футер -->
                        <tr>
                            <td style="background-color: #f9f9f9; padding: 20px; text-align: center; border-top: 1px solid #eeeeee;">
                                <p style="margin: 0; font-size: 13px; color: #666;">
                                    Это автоматическое уведомление от <strong><?php echo esc_html( $site_name ); ?></strong>
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
 * Вывод HTML кнопки и модального окна
 */
function enotary_certificate_help_button_html( $page_name = '' ) {
    // Получаем nonce для безопасности
    $nonce = wp_create_nonce( 'certificate_help_nonce' );
    ?>
    
    <!-- Кнопка вызова модального окна -->
    <div class="certificate-help-button-wrapper" style="text-align: center; margin: 40px 0;">
        <button type="button" class="certificate-help-trigger" onclick="openCertificateHelpModal()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <circle cx="12" cy="12" r="10" stroke-width="2"/>
                <path d="M12 16v-4M12 8h.01" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span>Не нашли нужный сертификат? Поможем подобрать!</span>
        </button>
    </div>
    
    <style>
    .certificate-help-trigger {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 28px;
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(243, 156, 18, 0.3);
    }
    
    .certificate-help-trigger:hover {
        background: linear-gradient(135deg, #e67e22 0%, #d35400 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(243, 156, 18, 0.4);
    }
    
    .certificate-help-trigger svg {
        flex-shrink: 0;
    }
    </style>
    
    <!-- Модальное окно -->
    <div id="certificateHelpModal" class="certificate-help-modal">
        <div class="modal-overlay" onclick="closeCertificateHelpModal()"></div>
        <div class="modal-container">
            <div class="modal-content">
                <button type="button" class="modal-close" onclick="closeCertificateHelpModal()" aria-label="Закрыть">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M18 6L6 18M6 6l12 12" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
                
                <div class="modal-header">
                    <div class="icon-wrapper">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 11v.01M8 11v.01M16 11v.01" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h3>Помощь в подборе сертификата</h3>
                    <p>Оставьте ваши контакты, и наш специалист свяжется с вами для подбора оптимального решения</p>
                </div>
                
                <div id="formMessage" class="form-message"></div>
                
                <form id="certificateHelpForm">
                    <input type="hidden" name="nonce" value="<?php echo esc_attr( $nonce ); ?>">
                    <input type="hidden" name="page" value="<?php echo esc_attr( $page_name ); ?>">
                    
                    <div class="form-group">
                        <label for="helpName">
                            Ваше имя <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="helpName" 
                            name="name" 
                            required
                            placeholder="Иван Иванов"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="helpPhone">
                            Телефон <span class="required">*</span>
                        </label>
                        <input 
                            type="tel" 
                            id="helpPhone" 
                            name="phone" 
                            required
                            placeholder="+7 (___) ___-__-__"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="helpComment">
                            Комментарий (необязательно)
                        </label>
                        <textarea 
                            id="helpComment" 
                            name="comment"
                            placeholder="Расскажите, какой сертификат вам нужен или какие вопросы возникли..."
                        ></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn">
                        <span class="btn-text">Отправить заявку</span>
                        <span class="btn-loader" style="display: none;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="12" cy="12" r="10" stroke-width="3" stroke-linecap="round" stroke-dasharray="32" stroke-dashoffset="32">
                                    <animate attributeName="stroke-dashoffset" values="32;0" dur="1s" repeatCount="indefinite"/>
                                </circle>
                            </svg>
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
    // Открытие модального окна
    function openCertificateHelpModal() {
        document.getElementById('certificateHelpModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    // Закрытие модального окна
    function closeCertificateHelpModal() {
        document.getElementById('certificateHelpModal').classList.remove('active');
        document.body.style.overflow = '';
        // Сброс формы через 300ms (после анимации закрытия)
        setTimeout(function() {
            document.getElementById('certificateHelpForm').reset();
            document.getElementById('formMessage').className = 'form-message';
            document.getElementById('formMessage').textContent = '';
        }, 300);
    }
    
    // Обработка отправки формы
    jQuery(document).ready(function($) {
        $('#certificateHelpForm').on('submit', function(e) {
            e.preventDefault();
            
            var $form = $(this);
            var $submitBtn = $form.find('.submit-btn');
            var $btnText = $submitBtn.find('.btn-text');
            var $btnLoader = $submitBtn.find('.btn-loader');
            var $message = $('#formMessage');
            
            // Блокируем кнопку
            $submitBtn.prop('disabled', true);
            $btnText.hide();
            $btnLoader.show();
            $message.removeClass('success error').hide();
            
            // Отправка AJAX
            $.ajax({
                url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                type: 'POST',
                data: {
                    action: 'certificate_help_request',
                    nonce: $form.find('[name="nonce"]').val(),
                    name: $form.find('[name="name"]').val(),
                    phone: $form.find('[name="phone"]').val(),
                    comment: $form.find('[name="comment"]').val(),
                    page: $form.find('[name="page"]').val()
                },
                success: function(response) {
                    if (response.success) {
                        $message.addClass('success').text(response.data.message).show();
                        $form[0].reset();
                        
                        // Закрываем окно через 3 секунды
                        setTimeout(function() {
                            closeCertificateHelpModal();
                        }, 3000);
                    } else {
                        $message.addClass('error').text(response.data.message).show();
                    }
                },
                error: function() {
                    $message.addClass('error').text('Произошла ошибка. Пожалуйста, попробуйте позже.').show();
                },
                complete: function() {
                    // Разблокируем кнопку
                    $submitBtn.prop('disabled', false);
                    $btnText.show();
                    $btnLoader.hide();
                }
            });
        });
        
        // Закрытие по ESC
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $('#certificateHelpModal').hasClass('active')) {
                closeCertificateHelpModal();
            }
        });
    });
    </script>
    
    <?php
}
