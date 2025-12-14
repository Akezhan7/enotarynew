<?php
/**
 * Login Form
 *
 * Форма входа для личного кабинета WooCommerce
 * Идентичная template-login.php в стилистике E-Notary
 *
 * @package enotarynew
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Подключаем auth.css
wp_enqueue_style( 'enotary-auth', get_template_directory_uri() . '/assets/auth.css', array(), '1.0.0' );

do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="auth-page-wrapper">
	<div class="auth-container">
		
		<!-- Заголовок -->
		<div class="auth-header">
			<div class="auth-header-content">
				<h1>Добро пожаловать!</h1>
				<p>Пожалуйста, введите ваши данные</p>
			</div>
		</div>

		<!-- Форма входа -->
		<form class="auth-form woocommerce-form woocommerce-form-login login" method="post">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<!-- Email -->
			<div class="auth-input-wrapper">
				<input 
					type="text" 
					class="auth-input" 
					name="username" 
					id="username" 
					autocomplete="username" 
					value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" 
					placeholder="Эл. почта"
					required
				/>
			</div>

			<!-- Пароль -->
			<div class="auth-password-field">
				<div class="auth-input-with-icon">
					<input 
						class="auth-input" 
						type="password" 
						name="password" 
						id="password" 
						autocomplete="current-password" 
						placeholder="Ваш пароль"
						required
					/>
					<div class="password-toggle-icon" onclick="togglePassword('password')">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/eye-icon.svg" alt="Показать пароль">
					</div>
				</div>
				
				<!-- Забыли пароль -->
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="forgot-password-link">
					Забыли пароль?
				</a>
			</div>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<!-- Кнопка входа -->
			<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
			<button 
				type="submit" 
				class="auth-submit-btn" 
				name="login" 
				value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"
			>
				Войти
			</button>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

			<!-- Ссылка на регистрацию -->
			<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
				<p class="auth-switch-link">
					Нет аккаунта? 
					<a href="<?php echo esc_url( add_query_arg( 'action', 'register' ) ); ?>">
						Создайте новую учётную запись
					</a>
				</p>
			<?php endif; ?>

		</form>

	</div><!-- .auth-container -->
</div><!-- .auth-page-wrapper -->

<script>
function togglePassword(fieldId) {
	const field = document.getElementById(fieldId);
	if (field) {
		field.type = field.type === 'password' ? 'text' : 'password';
	}
}
</script>

<style>
/* WooCommerce может добавлять дополнительные элементы - скрываем их */
.woocommerce-form-login .woocommerce-message,
.woocommerce-form-login .woocommerce-error {
	margin-bottom: 16px;
}
</style>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
