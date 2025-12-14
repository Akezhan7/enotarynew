<?php
/**
 * My Account Navigation
 *
 * Навигационное меню личного кабинета в виде стилизованной карточки
 * 
 * @package enotarynew
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>

<nav class="woocommerce-MyAccount-navigation bg-white rounded-[20px] shadow-[0_4px_20px_rgba(0,0,0,0.08)] p-6" style="width: 100% !important; float: none !important; margin: 0 !important;">
	<!-- Заголовок меню -->
	<div class="navigation-header mb-5 pb-4 border-b-2 border-gray-100">
		<h3 class="text-base font-bold text-[#262626] uppercase tracking-wide">Навигация</h3>
	</div>

	<!-- Список пунктов меню -->
	<ul class="my-account-menu-list space-y-1.5">
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<?php 
			// Определяем, является ли пункт активным
			$is_active = wc_get_account_menu_item_classes( $endpoint );
			$is_current = strpos( $is_active, 'is-active' ) !== false;
			
			// Иконки для пунктов меню
			$icons = array(
				'dashboard'       => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>',
				'orders'          => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>',
				'downloads'       => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>',
				'edit-address'    => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>',
				'edit-account'    => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
				'payment-methods' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>',
				'customer-logout' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>',
			);
			
			$icon = isset( $icons[ $endpoint ] ) ? $icons[ $endpoint ] : '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>';
			?>
			<li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--<?php echo esc_attr( $endpoint ); ?> <?php echo esc_attr( $is_active ); ?>">
				<a 
					href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" 
					class="nav-link-item flex items-center gap-3 px-4 py-3 rounded-[10px] transition-all duration-300 <?php echo $is_current ? 'bg-[#375d74] text-white font-semibold shadow-md' : 'text-[#262626] hover:bg-gray-50 hover:text-[#375d74]'; ?>"
				>
					<!-- Иконка -->
					<span class="nav-icon flex-shrink-0 <?php echo $is_current ? 'text-white' : 'text-[#979797]'; ?>">
						<?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</span>
					
					<!-- Текст -->
					<span class="nav-label flex-1 text-[15px]">
						<?php echo esc_html( $label ); ?>
					</span>

					<!-- Индикатор активности -->
					<?php if ( $is_current ) : ?>
						<span class="nav-indicator">
							<svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
							</svg>
						</span>
					<?php endif; ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>

	<!-- Дополнительная информация внизу меню -->
	<div class="navigation-footer mt-6 pt-5 border-t-2 border-gray-100">
		<div class="support-block p-4 bg-gradient-to-br from-gray-50 to-gray-100 rounded-[12px] border border-gray-200">
			<p class="text-xs text-[#979797] mb-2.5 font-semibold uppercase tracking-wide">Нужна помощь?</p>
			<a href="tel:+74953633093" class="text-sm font-bold text-[#375d74] hover:text-[#2a4a5c] flex items-center gap-2 transition-colors">
				<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
				</svg>
				+7 (495) 363-30-93
			</a>
		</div>
	</div>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>

