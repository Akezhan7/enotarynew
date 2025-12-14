<?php
/**
 * Login Form
 *
 * Форма входа для личного кабинета WooCommerce
 * Адаптированная версия template-login.php в стилистике E-Notary
 *
 * @package enotarynew
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="my-account-auth-wrapper min-h-[50vh] flex items-center justify-center w-full">
	<div class="auth-forms-container grid grid-cols-1 <?php echo 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ? 'lg:grid-cols-2' : ''; ?> gap-8 max-w-5xl mx-auto w-full">

				<!-- ФОРМА ВХОДА -->
				<div class="auth-form-col">
					<div class="auth-form-box bg-white rounded-[20px] shadow-[0_10px_40px_rgba(0,0,0,0.06)] p-8">
						
						<div class="form-header mb-6 text-center">
							<h2 class="text-2xl md:text-3xl font-bold text-[#262626] mb-2">Войти в аккаунт</h2>
							<p class="text-sm text-[#979797]">Введите ваши данные для входа</p>
						</div>

						<form class="woocommerce-form woocommerce-form-login login" method="post">

							<?php do_action( 'woocommerce_login_form_start' ); ?>

							<!-- Username/Email -->
							<div class="form-row form-row-wide mb-4">
								<label for="username" class="block text-sm font-semibold text-[#262626] mb-2">
									<?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required text-red-500">*</span>
								</label>
								<input 
									type="text" 
									class="woocommerce-Input woocommerce-Input--text input-text w-full px-4 py-3 border border-gray-200 rounded-[10px] text-[#262626] placeholder-[#979797] focus:border-[#375d74] focus:ring-2 focus:ring-[#375d74] focus:ring-opacity-20 transition-all outline-none" 
									name="username" 
									id="username" 
									autocomplete="username" 
									value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" 
									placeholder="Введите email"
								/>
							</div>

							<!-- Password -->
							<div class="form-row form-row-wide mb-4">
								<label for="password" class="block text-sm font-semibold text-[#262626] mb-2">
									<?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required text-red-500">*</span>
								</label>
								<div class="relative">
									<input 
										class="woocommerce-Input woocommerce-Input--text input-text w-full px-4 py-3 pr-12 border border-gray-200 rounded-[10px] text-[#262626] placeholder-[#979797] focus:border-[#375d74] focus:ring-2 focus:ring-[#375d74] focus:ring-opacity-20 transition-all outline-none" 
										type="password" 
										name="password" 
										id="password" 
										autocomplete="current-password" 
										placeholder="Введите пароль"
									/>
									<button 
										type="button" 
										class="password-toggle-btn absolute right-3 top-1/2 -translate-y-1/2 text-[#979797] hover:text-[#375d74] transition-colors"
										onclick="togglePasswordVisibility('password')"
									>
										<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
										</svg>
									</button>
								</div>
							</div>

							<?php do_action( 'woocommerce_login_form' ); ?>

							<!-- Remember Me + Forgot Password -->
							<div class="form-row flex items-center justify-between mb-6">
								<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme inline-flex items-center">
									<input 
										class="woocommerce-form__input woocommerce-form__input-checkbox w-4 h-4 text-[#375d74] border-gray-300 rounded focus:ring-[#375d74] focus:ring-2 cursor-pointer" 
										name="rememberme" 
										type="checkbox" 
										id="rememberme" 
										value="forever" 
									/>
									<span class="ml-2 text-sm text-[#262626]"><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
								</label>
								<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="text-sm font-semibold text-[#375d74] hover:text-[#2a4a5c] transition-colors">
									<?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?>
								</a>
							</div>

							<!-- Submit Button -->
							<div class="form-row">
								<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
								<button 
									type="submit" 
									class="woocommerce-button button woocommerce-form-login__submit w-full bg-[#375d74] hover:bg-[#2d4d5f] text-white font-bold py-3 px-6 rounded-[10px] transition-all duration-300 hover:shadow-lg transform hover:-translate-y-0.5" 
									name="login" 
									value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"
								>
									<?php esc_html_e( 'Log in', 'woocommerce' ); ?>
								</button>
							</div>

							<?php do_action( 'woocommerce_login_form_end' ); ?>

						</form>

					</div>
				</div>

				<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

				<!-- ФОРМА РЕГИСТРАЦИИ -->
				<div class="auth-form-col">
					<div class="auth-form-box bg-white rounded-[20px] shadow-[0_10px_40px_rgba(0,0,0,0.06)] p-8">
						
						<div class="form-header mb-6 text-center">
							<h2 class="text-2xl md:text-3xl font-bold text-[#262626] mb-2">Регистрация</h2>
							<p class="text-sm text-[#979797]">Создайте новый аккаунт</p>
						</div>

						<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

							<?php do_action( 'woocommerce_register_form_start' ); ?>

							<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

								<!-- Username -->
								<div class="form-row form-row-wide mb-4">
									<label for="reg_username" class="block text-sm font-semibold text-[#262626] mb-2">
										<?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required text-red-500">*</span>
									</label>
									<input 
										type="text" 
										class="woocommerce-Input woocommerce-Input--text input-text w-full px-4 py-3 border border-gray-200 rounded-[10px] text-[#262626] placeholder-[#979797] focus:border-[#375d74] focus:ring-2 focus:ring-[#375d74] focus:ring-opacity-20 transition-all outline-none" 
										name="username" 
										id="reg_username" 
										autocomplete="username" 
										value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" 
										placeholder="Введите имя пользователя"
									/>
								</div>

							<?php endif; ?>

							<!-- Email -->
							<div class="form-row form-row-wide mb-4">
								<label for="reg_email" class="block text-sm font-semibold text-[#262626] mb-2">
									<?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required text-red-500">*</span>
								</label>
								<input 
									type="email" 
									class="woocommerce-Input woocommerce-Input--text input-text w-full px-4 py-3 border border-gray-200 rounded-[10px] text-[#262626] placeholder-[#979797] focus:border-[#375d74] focus:ring-2 focus:ring-[#375d74] focus:ring-opacity-20 transition-all outline-none" 
									name="email" 
									id="reg_email" 
									autocomplete="email" 
									value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" 
									placeholder="Введите email"
								/>
							</div>

							<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

								<!-- Password -->
								<div class="form-row form-row-wide mb-4">
									<label for="reg_password" class="block text-sm font-semibold text-[#262626] mb-2">
										<?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required text-red-500">*</span>
									</label>
									<div class="relative">
										<input 
											type="password" 
											class="woocommerce-Input woocommerce-Input--text input-text w-full px-4 py-3 pr-12 border border-gray-200 rounded-[10px] text-[#262626] placeholder-[#979797] focus:border-[#375d74] focus:ring-2 focus:ring-[#375d74] focus:ring-opacity-20 transition-all outline-none" 
											name="password" 
											id="reg_password" 
											autocomplete="new-password" 
											placeholder="Придумайте пароль"
										/>
										<button 
											type="button" 
											class="password-toggle-btn absolute right-3 top-1/2 -translate-y-1/2 text-[#979797] hover:text-[#375d74] transition-colors"
											onclick="togglePasswordVisibility('reg_password')"
										>
											<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
											</svg>
										</button>
									</div>
								</div>

							<?php else : ?>

								<p class="text-sm text-[#979797] mb-4">
									<?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?>
								</p>

							<?php endif; ?>

							<?php do_action( 'woocommerce_register_form' ); ?>

							<!-- Submit Button -->
							<div class="form-row mt-6">
								<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
								<button 
									type="submit" 
									class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit w-full bg-[#375d74] hover:bg-[#2d4d5f] text-white font-bold py-3 px-6 rounded-[10px] transition-all duration-300 hover:shadow-lg transform hover:-translate-y-0.5" 
									name="register" 
									value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"
								>
									<?php esc_html_e( 'Register', 'woocommerce' ); ?>
								</button>
							</div>

							<?php do_action( 'woocommerce_register_form_end' ); ?>

						</form>

					</div>
				</div>

				<?php endif; ?>

	</div><!-- .auth-forms-container -->
</div><!-- .my-account-auth-wrapper -->

<script>
function togglePasswordVisibility(fieldId) {
	const field = document.getElementById(fieldId);
	if (field) {
		field.type = field.type === 'password' ? 'text' : 'password';
	}
}
</script>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

