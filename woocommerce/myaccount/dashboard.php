<?php
/**
 * My Account Dashboard
 *
 * Главная страница (Dashboard) личного кабинета WooCommerce
 * Современный дизайн с карточками статистики и быстрыми действиями
 *
 * @package enotarynew
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);
?>

<!-- Приветствие -->
<div class="dashboard-welcome mb-6">
	<h2 class="text-2xl font-bold text-[#262626] mb-3">
		<?php
		printf(
			/* translators: 1: user display name */
			esc_html__( 'Добро пожаловать, %s!', 'enotarynew' ),
			'<span class="text-[#375d74]">' . esc_html( $current_user->display_name ? $current_user->display_name : $current_user->user_email ) . '</span>'
		);
		?>
	</h2>
	<p class="text-sm text-[#979797] leading-relaxed">
		<?php
		/* translators: 1: Orders URL 2: Address URL 3: Account URL. */
		$dashboard_desc = __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">billing address</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' );
		if ( wc_shipping_enabled() ) {
			/* translators: 1: Orders URL 2: Addresses URL 3: Account URL. */
			$dashboard_desc = __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' );
		}
		printf(
			wp_kses( $dashboard_desc, $allowed_html ),
			esc_url( wc_get_endpoint_url( 'orders' ) ),
			esc_url( wc_get_endpoint_url( 'edit-address' ) ),
			esc_url( wc_get_endpoint_url( 'edit-account' ) )
		);
		?>
	</p>
</div>

<?php
/**
 * Получаем статистику заказов пользователя
 */
$customer_orders = wc_get_orders( array(
	'customer' => get_current_user_id(),
	'limit'    => -1,
) );

$total_orders = count( $customer_orders );
$completed_orders = 0;
$processing_orders = 0;
$total_spent = 0;

foreach ( $customer_orders as $order ) {
	$status = $order->get_status();
	
	if ( 'completed' === $status ) {
		$completed_orders++;
	}
	
	// Считаем заказы в обработке (processing + on-hold)
	if ( in_array( $status, array( 'processing', 'on-hold' ) ) ) {
		$processing_orders++;
	}
	
	if ( in_array( $status, array( 'completed', 'processing', 'on-hold' ) ) ) {
		$total_spent += $order->get_total();
	}
}
?>

<!-- Карточки статистики -->
<div class="dashboard-stats-grid grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-10">
	
	<!-- Всего заказов -->
	<div class="stat-card bg-gradient-to-br from-blue-50 to-blue-100 rounded-[16px] p-4 md:p-5 border border-blue-200 hover:border-blue-300 transition-all hover:shadow-md">
		<div class="stat-icon w-10 h-10 md:w-12 md:h-12 bg-blue-500 rounded-[10px] flex items-center justify-center mb-3">
			<svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
			</svg>
		</div>
		<p class="text-2xl md:text-3xl font-bold text-[#262626] mb-0.5"><?php echo esc_html( $total_orders ); ?></p>
		<p class="text-xs md:text-sm text-blue-700 font-semibold">Всего заказов</p>
	</div>

	<!-- Завершенные заказы -->
	<div class="stat-card bg-gradient-to-br from-green-50 to-green-100 rounded-[16px] p-4 md:p-5 border border-green-200 hover:border-green-300 transition-all hover:shadow-md">
		<div class="stat-icon w-10 h-10 md:w-12 md:h-12 bg-green-500 rounded-[10px] flex items-center justify-center mb-3">
			<svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
			</svg>
		</div>
		<p class="text-2xl md:text-3xl font-bold text-[#262626] mb-0.5"><?php echo esc_html( $completed_orders ); ?></p>
		<p class="text-xs md:text-sm text-green-700 font-semibold">Выполнено</p>
	</div>

	<!-- В обработке -->
	<div class="stat-card bg-gradient-to-br from-orange-50 to-orange-100 rounded-[16px] p-4 md:p-5 border border-orange-200 hover:border-orange-300 transition-all hover:shadow-md">
		<div class="stat-icon w-10 h-10 md:w-12 md:h-12 bg-orange-500 rounded-[10px] flex items-center justify-center mb-3">
			<svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
			</svg>
		</div>
		<p class="text-2xl md:text-3xl font-bold text-[#262626] mb-0.5"><?php echo esc_html( $processing_orders ); ?></p>
		<p class="text-xs md:text-sm text-orange-700 font-semibold">В обработке</p>
	</div>

	<!-- Потрачено всего -->
	<div class="stat-card bg-gradient-to-br from-purple-50 to-purple-100 rounded-[16px] p-4 md:p-5 border border-purple-200 hover:border-purple-300 transition-all hover:shadow-md">
		<div class="stat-icon w-10 h-10 md:w-12 md:h-12 bg-purple-500 rounded-[10px] flex items-center justify-center mb-3">
			<svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
			</svg>
		</div>
		<p class="text-xl md:text-2xl font-bold text-[#262626] mb-0.5"><?php echo wc_price( $total_spent ); ?></p>
		<p class="text-xs md:text-sm text-purple-700 font-semibold">Всего потрачено</p>
	</div>

</div>

<!-- Быстрые действия -->
<div class="dashboard-quick-actions">
	<h3 class="text-lg md:text-xl font-bold text-[#262626] mb-5">Быстрые действия</h3>
	
	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
		
		<!-- Заказать УКЭП -->
		<a href="<?php echo esc_url( home_url( '/order-ukep/' ) ); ?>" class="quick-action-card group bg-white hover:bg-[#375d74] border border-gray-200 hover:border-[#375d74] rounded-[14px] p-5 transition-all duration-300 hover:shadow-lg no-underline">
			<div class="flex items-start gap-4">
				<div class="action-icon w-11 h-11 bg-[#375d74] group-hover:bg-white rounded-[10px] flex items-center justify-center transition-colors flex-shrink-0">
					<svg class="w-5 h-5 text-white group-hover:text-[#375d74] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
					</svg>
				</div>
				<div class="flex-1 min-w-0">
					<h4 class="text-sm md:text-base font-bold text-[#262626] group-hover:text-white mb-0.5 transition-colors">Заказать УКЭП</h4>
					<p class="text-xs md:text-sm text-[#979797] group-hover:text-white group-hover:text-opacity-90 transition-colors">Квалифицированная ЭП</p>
				</div>
			</div>
		</a>

		<!-- Заказать УНЭП -->
		<a href="<?php echo esc_url( home_url( '/order-unep/' ) ); ?>" class="quick-action-card group bg-white hover:bg-[#375d74] border border-gray-200 hover:border-[#375d74] rounded-[14px] p-5 transition-all duration-300 hover:shadow-lg no-underline">
			<div class="flex items-start gap-4">
				<div class="action-icon w-11 h-11 bg-[#375d74] group-hover:bg-white rounded-[10px] flex items-center justify-center transition-colors flex-shrink-0">
					<svg class="w-6 h-6 text-white group-hover:text-[#375d74] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
					</svg>
				</div>
				<div class="flex-1 min-w-0">
					<h4 class="text-sm md:text-base font-bold text-[#262626] group-hover:text-white mb-0.5 transition-colors">Заказать УНЭП</h4>
					<p class="text-xs md:text-sm text-[#979797] group-hover:text-white group-hover:text-opacity-90 transition-colors">Усиленная неквалиф. ЭП</p>
				</div>
			</div>
		</a>

		<!-- Заказать МЧД -->
		<a href="<?php echo esc_url( home_url( '/order-mchd/' ) ); ?>" class="quick-action-card group bg-white hover:bg-[#375d74] border border-gray-200 hover:border-[#375d74] rounded-[14px] p-5 transition-all duration-300 hover:shadow-lg no-underline">
			<div class="flex items-start gap-4">
				<div class="action-icon w-11 h-11 bg-[#375d74] group-hover:bg-white rounded-[10px] flex items-center justify-center transition-colors flex-shrink-0">
					<svg class="w-5 h-5 text-white group-hover:text-[#375d74] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
					</svg>
				</div>
				<div class="flex-1 min-w-0">
					<h4 class="text-sm md:text-base font-bold text-[#262626] group-hover:text-white mb-0.5 transition-colors">Заказать МЧД</h4>
					<p class="text-xs md:text-sm text-[#979797] group-hover:text-white group-hover:text-opacity-90 transition-colors">Машиночитаемая доверенность</p>
				</div>
			</div>
		</a>

		<!-- Мои заказы -->
		<a href="<?php echo esc_url( wc_get_endpoint_url( 'orders' ) ); ?>" class="quick-action-card group bg-white hover:bg-[#375d74] border border-gray-200 hover:border-[#375d74] rounded-[14px] p-5 transition-all duration-300 hover:shadow-lg no-underline">
			<div class="flex items-start gap-4">
				<div class="action-icon w-11 h-11 bg-gray-600 group-hover:bg-white rounded-[10px] flex items-center justify-center transition-colors flex-shrink-0">
					<svg class="w-5 h-5 text-white group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
					</svg>
				</div>
				<div class="flex-1 min-w-0">
					<h4 class="text-sm md:text-base font-bold text-[#262626] group-hover:text-white mb-0.5 transition-colors">Мои заказы</h4>
					<p class="text-xs md:text-sm text-[#979797] group-hover:text-white group-hover:text-opacity-90 transition-colors">История и статусы</p>
				</div>
			</div>
		</a>

		<!-- Настройки аккаунта -->
		<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' ) ); ?>" class="quick-action-card group bg-white hover:bg-[#375d74] border border-gray-200 hover:border-[#375d74] rounded-[14px] p-5 transition-all duration-300 hover:shadow-lg no-underline">
			<div class="flex items-start gap-4">
				<div class="action-icon w-11 h-11 bg-gray-600 group-hover:bg-white rounded-[10px] flex items-center justify-center transition-colors flex-shrink-0">
					<svg class="w-5 h-5 text-white group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
					</svg>
				</div>
				<div class="flex-1 min-w-0">
					<h4 class="text-sm md:text-base font-bold text-[#262626] group-hover:text-white mb-0.5 transition-colors">Настройки</h4>
					<p class="text-xs md:text-sm text-[#979797] group-hover:text-white group-hover:text-opacity-90 transition-colors">Изменить данные аккаунта</p>
				</div>
			</div>
		</a>

		<!-- Поддержка -->
		<a href="tel:+74953633093" class="quick-action-card group bg-white hover:bg-[#375d74] border border-gray-200 hover:border-[#375d74] rounded-[14px] p-5 transition-all duration-300 hover:shadow-lg no-underline">
			<div class="flex items-start gap-4">
				<div class="action-icon w-11 h-11 bg-gray-600 group-hover:bg-white rounded-[10px] flex items-center justify-center transition-colors flex-shrink-0">
					<svg class="w-5 h-5 text-white group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
					</svg>
				</div>
				<div class="flex-1 min-w-0">
					<h4 class="text-sm md:text-base font-bold text-[#262626] group-hover:text-white mb-0.5 transition-colors">Поддержка</h4>
					<p class="text-xs md:text-sm text-[#979797] group-hover:text-white group-hover:text-opacity-90 transition-colors">+7 (495) 363-30-93</p>
				</div>
			</div>
		</a>

	</div>
</div>

<?php
/**
 * My Account dashboard.
 *
 * @since 2.6.0
 */
do_action( 'woocommerce_account_dashboard' );

/**
 * Deprecated woocommerce_before_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action( 'woocommerce_before_my_account' );

/**
 * Deprecated woocommerce_after_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */

