<?php
/**
 * Страница благодарности после оформления заказа
 * 
 * Компактная стилизация в стиле E-Notary с использованием Tailwind CSS
 * 
 * @package enotarynew
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order responsive-container py-8 md:py-10 lg:py-12">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<!-- Заказ не оплачен -->
			<div class="bg-white border border-red-200 rounded-[12px] sm:rounded-[15px] lg:rounded-[20px] shadow-[0_10px_40px_rgba(0,0,0,0.06)] px-4 sm:px-5 lg:px-6 py-4 sm:py-5 lg:py-6 mb-6">
				<div class="flex items-start gap-3 mb-4">
					<svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
					</svg>
					<div>
						<p class="text-[15px] sm:text-base font-semibold text-[#262626] mb-2">
							<?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?>
						</p>
						<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white text-[13px] sm:text-sm font-semibold px-4 py-2 rounded-[8px] transition-colors no-underline">
							<?php esc_html_e( 'Pay', 'woocommerce' ); ?>
						</a>
					</div>
				</div>
			</div>

		<?php else : ?>

			<!-- Успешный заказ -->
			<div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[12px] sm:rounded-[15px] lg:rounded-[20px] shadow-[0_10px_40px_rgba(0,0,0,0.06)] px-4 sm:px-5 lg:px-6 py-5 sm:py-6 lg:py-7">
				
				<!-- Иконка успеха и заголовок -->
				<div class="text-center mb-5 sm:mb-6">
					<div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-green-100 rounded-full mb-4">
						<svg class="w-8 h-8 sm:w-10 sm:h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
						</svg>
					</div>
					<h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-[#262626] mb-2">
						<?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</h2>
					<p class="text-[13px] sm:text-sm text-[#979797]">
						Ваш заказ принят. Благодарим вас.
					</p>
				</div>

				<!-- Информация о заказе (компактная таблица) -->
				<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-5 sm:mb-6 list-none p-0">

					<li class="woocommerce-order-overview__order order bg-gray-50 rounded-[10px] px-3 py-2.5 sm:px-4 sm:py-3">
						<p class="text-[11px] sm:text-[12px] text-[#979797] uppercase font-semibold mb-1">
							<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
						</p>
						<strong class="text-[13px] sm:text-[14px] text-[#262626] font-bold">
							<?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</strong>
					</li>

					<li class="woocommerce-order-overview__date date bg-gray-50 rounded-[10px] px-3 py-2.5 sm:px-4 sm:py-3">
						<p class="text-[11px] sm:text-[12px] text-[#979797] uppercase font-semibold mb-1">
							<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
						</p>
						<strong class="text-[13px] sm:text-[14px] text-[#262626] font-bold">
							<?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</strong>
					</li>

					<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
						<li class="woocommerce-order-overview__email email bg-gray-50 rounded-[10px] px-3 py-2.5 sm:px-4 sm:py-3">
							<p class="text-[11px] sm:text-[12px] text-[#979797] uppercase font-semibold mb-1">
								<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
							</p>
							<strong class="text-[13px] sm:text-[14px] text-[#262626] font-bold break-all">
								<?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</strong>
						</li>
					<?php endif; ?>

					<li class="woocommerce-order-overview__total total bg-gray-50 rounded-[10px] px-3 py-2.5 sm:px-4 sm:py-3">
						<p class="text-[11px] sm:text-[12px] text-[#979797] uppercase font-semibold mb-1">
							<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
						</p>
						<strong class="text-[13px] sm:text-[14px] text-[#262626] font-bold">
							<?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</strong>
					</li>

					<?php if ( $order->get_payment_method_title() ) : ?>
						<li class="woocommerce-order-overview__payment-method method bg-gray-50 rounded-[10px] px-3 py-2.5 sm:px-4 sm:py-3">
							<p class="text-[11px] sm:text-[12px] text-[#979797] uppercase font-semibold mb-1">
								<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
							</p>
							<strong class="text-[13px] sm:text-[14px] text-[#262626] font-bold">
								<?php echo wp_kses_post( $order->get_payment_method_title() ); ?>
							</strong>
						</li>
					<?php endif; ?>

				</ul>

				<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

			</div>

		<?php endif; ?>

	<?php else : ?>

		<!-- Заказ не найден -->
		<div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[12px] sm:rounded-[15px] lg:rounded-[20px] shadow-[0_10px_40px_rgba(0,0,0,0.06)] px-4 sm:px-5 lg:px-6 py-5 sm:py-6 lg:py-7 text-center">
			<div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-green-100 rounded-full mb-4">
				<svg class="w-8 h-8 sm:w-10 sm:h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
				</svg>
			</div>
			<p class="text-xl sm:text-2xl font-bold text-[#262626] mb-2">
				<?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</p>
			<p class="text-[13px] sm:text-sm text-[#979797]">
				Ваш заказ принят. Благодарим вас.
			</p>
		</div>

	<?php endif; ?>

</div>
