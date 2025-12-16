<?php
/**
 * Template Name: Страница входа (Login)
 * 
 * Кастомный шаблон для страницы входа на основе Figma дизайна
 * 
 * @package enotarynew
 */

// Если пользователь уже авторизован, редирект на главную
if ( is_user_logged_in() ) {
    wp_redirect( home_url() );
    exit;
}

// Обработка формы входа
$login_error = '';
$login_success = '';

if ( isset( $_POST['enotary_login_submit'] ) ) {
    // Проверка nonce для безопасности
    if ( ! isset( $_POST['enotary_login_nonce'] ) || ! wp_verify_nonce( $_POST['enotary_login_nonce'], 'enotary_login_action' ) ) {
        $login_error = 'Ошибка безопасности. Попробуйте еще раз.';
    } else {
        $username = sanitize_text_field( $_POST['user_login'] );
        $password = $_POST['user_password'];
        $remember = isset( $_POST['remember_me'] ) ? true : false;

        $creds = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => $remember,
        );

        $user = wp_signon( $creds, false );

        if ( is_wp_error( $user ) ) {
            $login_error = 'Неверный email или пароль.';
        } else {
            // Успешный вход - редирект
            // Проверяем параметр redirect_to из URL
            $redirect_to = isset( $_GET['redirect_to'] ) && ! empty( $_GET['redirect_to'] ) 
                ? esc_url_raw( urldecode( $_GET['redirect_to'] ) ) 
                : home_url();
            
            wp_redirect( $redirect_to );
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход - <?php bloginfo( 'name' ); ?></title>
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
                    <p>Пожалуйста, введите ваши данные</p>
                </div>
            </div>

            <!-- Сообщения -->
            <?php if ( ! empty( $login_error ) ) : ?>
                <div class="auth-error-message">
                    <?php echo esc_html( $login_error ); ?>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $login_success ) ) : ?>
                <div class="auth-success-message">
                    <?php echo esc_html( $login_success ); ?>
                </div>
            <?php endif; ?>

            <!-- Форма входа -->
            <form method="post" action="" class="auth-form">
                <?php wp_nonce_field( 'enotary_login_action', 'enotary_login_nonce' ); ?>
                
                <!-- Email -->
                <div class="auth-input-wrapper">
                    <input 
                        type="email" 
                        name="user_login" 
                        class="auth-input" 
                        placeholder="Эл. почта" 
                        required 
                        autocomplete="email"
                    >
                </div>

                <!-- Пароль -->
                <div class="auth-password-field">
                    <div class="auth-input-with-icon">
                        <input 
                            type="password" 
                            name="user_password" 
                            class="auth-input" 
                            placeholder="Ваш пароль" 
                            required 
                            autocomplete="current-password"
                            id="login-password"
                        >
                        <div class="password-toggle-icon" onclick="togglePassword('login-password')">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/eye-icon.svg" alt="Показать пароль">
                        </div>
                    </div>
                    
                    <!-- Забыли пароль -->
                    <a href="<?php echo wp_lostpassword_url(); ?>" class="forgot-password-link">
                        Забыли пароль?
                    </a>
                </div>

                <!-- Кнопка входа -->
                <button type="submit" name="enotary_login_submit" class="auth-submit-btn">
                    Войти
                </button>

                <!-- Ссылка на регистрацию -->
                <p class="auth-switch-link">
                    Нет аккаунта? 
                    <a href="<?php 
                        $register_url = wp_registration_url();
                        // Передаём параметр redirect_to на страницу регистрации, если он есть
                        if ( isset( $_GET['redirect_to'] ) && ! empty( $_GET['redirect_to'] ) ) {
                            $register_url = add_query_arg( 'redirect_to', urlencode( $_GET['redirect_to'] ), $register_url );
                        }
                        echo esc_url( $register_url );
                    ?>">
                        Создайте новую учётную запись
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
    </script>

    <?php wp_footer(); ?>
</body>
</html>
