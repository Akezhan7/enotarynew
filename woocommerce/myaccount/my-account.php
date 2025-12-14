<?php
/**
 * My Account page
 *
 * Главный контейнер личного кабинета WooCommerce
 * Стилизация в общей стилистике E-Notary с использованием Tailwind
 *
 * @package enotarynew
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

// Хук уже вызывается ниже в aside, убираем дубликат
?>

<div class="woocommerce-MyAccount-wrapper w-full content-wrapper pb-[40px] lg:pb-[60px]">
	<!-- Сетка: навигация + контент -->
	<div class="my-account-grid grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-6 xl:gap-10">
		
		<!-- Боковая навигация (карточка) -->
		<aside class="my-account-navigation-wrapper">
			<?php do_action( 'woocommerce_account_navigation' ); ?>
		</aside>

		<!-- Основной контент -->
		<div class="woocommerce-MyAccount-content-wrapper">
			<!-- Контент страниц: dashboard, orders, downloads и т.д. -->
			<div class="woocommerce-MyAccount-content w-full bg-white rounded-[20px] shadow-[0_4px_20px_rgba(0,0,0,0.08)] p-6 md:p-8 lg:p-10">
				<?php
				/**
				 * My Account content.
				 *
				 * @hooked woocommerce_account_content - 10
				 */
				do_action( 'woocommerce_account_content' );
				?>
			</div>
		</div>

	</div><!-- .my-account-grid -->

</div><!-- .woocommerce-MyAccount-wrapper -->

