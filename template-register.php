<?php
/**
 * Template Name: Страница регистрации (Register)
 * 
 * Кастомный шаблон для страницы регистрации на основе Figma дизайна
 * 
 * @package enotarynew
 */

// Если пользователь уже авторизован, редирект на главную
if ( is_user_logged_in() ) {
    wp_redirect( home_url() );
    exit;
}

// Проверка, включена ли регистрация
if ( ! get_option( 'users_can_register' ) ) {
    wp_die( 'Регистрация пользователей отключена.' );
}

// Обработка формы регистрации
$register_error = '';
$register_success = '';

if ( isset( $_POST['enotary_register_submit'] ) ) {
    // Проверка nonce
    if ( ! isset( $_POST['enotary_register_nonce'] ) || ! wp_verify_nonce( $_POST['enotary_register_nonce'], 'enotary_register_action' ) ) {
        $register_error = 'Ошибка безопасности. Попробуйте еще раз.';
    } else {
        $user_email = sanitize_email( $_POST['user_email'] );
        $user_password = $_POST['user_password'];
        $user_password_confirm = $_POST['user_password_confirm'];
        $newsletter_consent = isset( $_POST['newsletter_consent'] ) ? true : false;

        // Валидация
        if ( empty( $user_email ) || ! is_email( $user_email ) ) {
            $register_error = 'Пожалуйста, введите корректный email.';
        } elseif ( email_exists( $user_email ) ) {
            $register_error = 'Этот email уже зарегистрирован.';
        } elseif ( empty( $user_password ) || strlen( $user_password ) < 6 ) {
            $register_error = 'Пароль должен содержать минимум 6 символов.';
        } elseif ( $user_password !== $user_password_confirm ) {
            $register_error = 'Пароли не совпадают.';
        } else {
            // Создание пользователя
            $user_id = wp_create_user( $user_email, $user_password, $user_email );

            if ( is_wp_error( $user_id ) ) {
                $register_error = 'Ошибка при регистрации: ' . $user_id->get_error_message();
            } else {
                // Сохранение мета-данных
                if ( $newsletter_consent ) {
                    update_user_meta( $user_id, 'newsletter_consent', '1' );
                }

                // Автоматический вход после регистрации
                wp_set_current_user( $user_id );
                wp_set_auth_cookie( $user_id );

                // Редирект на главную или чекаут
                $redirect_to = isset( $_GET['redirect_to'] ) ? esc_url_raw( $_GET['redirect_to'] ) : home_url();
                wp_redirect( $redirect_to );
                exit;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Регистрация - <?php bloginfo( 'name' ); ?></title>
    <?php wp_head(); ?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/auth.css">
</head>
<body class="auth-page-body">
    <div class="auth-page-wrapper">
        <div class="auth-container">
            <!-- Заголовок -->
            <div class="auth-header">
                <div class="auth-header-content">
                    <h1>Добро пожаловать!</h1>
                    <p>Введите электронный адрес или номер телефона и придумайте пароль.</p>
                </div>
            </div>

            <!-- Сообщения -->
            <?php if ( ! empty( $register_error ) ) : ?>
                <div class="auth-error-message">
                    <?php echo esc_html( $register_error ); ?>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $register_success ) ) : ?>
                <div class="auth-success-message">
                    <?php echo esc_html( $register_success ); ?>
                </div>
            <?php endif; ?>

            <!-- Форма регистрации -->
            <form method="post" action="" class="auth-form">
                <?php wp_nonce_field( 'enotary_register_action', 'enotary_register_nonce' ); ?>
                
                <!-- Email -->
                <div class="auth-input-wrapper">
                    <input 
                        type="email" 
                        name="user_email" 
                        class="auth-input" 
                        placeholder="Эл. почта" 
                        required 
                        autocomplete="email"
                        value="<?php echo isset( $_POST['user_email'] ) ? esc_attr( $_POST['user_email'] ) : ''; ?>"
                    >
                </div>

                <!-- Группа полей пароля -->
                <div class="auth-password-field">
                    <!-- Пароль -->
                    <div class="auth-input-with-icon">
                        <input 
                            type="password" 
                            name="user_password" 
                            class="auth-input" 
                            placeholder="Придумайте пароль" 
                            required 
                            autocomplete="new-password"
                            id="register-password"
                            minlength="6"
                        >
                        <div class="password-toggle-icon" onclick="togglePassword('register-password')">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/eye-icon.svg" alt="Показать пароль">
                        </div>
                    </div>

                    <!-- Подтверждение пароля -->
                    <div class="auth-input-with-icon">
                        <input 
                            type="password" 
                            name="user_password_confirm" 
                            class="auth-input" 
                            placeholder="Повторите пароль" 
                            required 
                            autocomplete="new-password"
                            id="register-password-confirm"
                            minlength="6"
                        >
                        <div class="password-toggle-icon" onclick="togglePassword('register-password-confirm')">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/eye-icon.svg" alt="Показать пароль">
                        </div>
                    </div>

                    <!-- Согласие на рассылку -->
                    <div class="auth-consent-wrapper">
                        <div class="auth-checkbox">
                            <input 
                                type="checkbox" 
                                name="newsletter_consent" 
                                id="newsletter-consent"
                                <?php checked( isset( $_POST['newsletter_consent'] ) ); ?>
                            >
                            <div class="auth-checkbox-custom"></div>
                        </div>
                        <label for="newsletter-consent" class="auth-consent-label">
                            Я даю согласие на <a href="<?php echo home_url( '/politika-konfidentsialnosti/' ); ?>">рассылку уведомлений.</a>
                        </label>
                    </div>
                </div>

                <!-- Кнопка регистрации -->
                <button type="submit" name="enotary_register_submit" class="auth-submit-btn">
                    Начать
                </button>

                <!-- Ссылка на вход -->
                <p class="auth-switch-link">
                    У Вас уже есть аккаунт? 
                    <a href="<?php echo wp_login_url(); ?>">
                        Авторизоваться
                    </a>
                </p>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            var field = document.getElementById(fieldId);
            if (field.type === 'password') {
                field.type = 'text';
            } else {
                field.type = 'password';
            }
        }

        // Проверка совпадения паролей в реальном времени
        document.addEventListener('DOMContentLoaded', function() {
            var password = document.getElementById('register-password');
            var passwordConfirm = document.getElementById('register-password-confirm');

            passwordConfirm.addEventListener('input', function() {
                if (password.value !== passwordConfirm.value) {
                    passwordConfirm.setCustomValidity('Пароли не совпадают');
                } else {
                    passwordConfirm.setCustomValidity('');
                }
            });

            password.addEventListener('input', function() {
                if (passwordConfirm.value && password.value !== passwordConfirm.value) {
                    passwordConfirm.setCustomValidity('Пароли не совпадают');
                } else {
                    passwordConfirm.setCustomValidity('');
                }
            });
        });
    </script>

    <?php wp_footer(); ?>
</body>
</html>
