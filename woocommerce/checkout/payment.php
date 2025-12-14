<?php
/**
 * Checkout Payment Section (Tailwind styled)
 *
 * @package enotarynew
 */

defined( 'ABSPATH' ) || exit;

if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}
?>

<div id="payment" class="woocommerce-checkout-payment border-t border-[rgba(0,0,0,0.05)] px-4 py-2.5 sm:px-5 sm:py-3">
	
	<?php if ( WC()->cart->needs_payment() ) : ?>
		<div class="mb-2">
			<h3 class="font-bold text-[13px] sm:text-[14px] text-[#262626] leading-[1.15] mb-2">Способ оплаты</h3>
			<ul class="wc_payment_methods payment_methods methods list-none p-0 m-0">
				<?php
				if ( ! empty( $available_gateways ) ) {
					foreach ( $available_gateways as $gateway ) {
						wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
					}
				} else {
					echo '<li class="p-2 bg-[#f0f0f1] rounded-lg text-xs">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Способы оплаты недоступны', 'woocommerce' ) : esc_html__( 'Заполните данные выше', 'woocommerce' ) ) . '</li>';
				}
				?>
			</ul>
		</div>
	<?php endif; ?>
	
	<div class="form-row place-order mt-0">
		
		<?php wc_get_template( 'checkout/terms.php' ); ?>

		<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

		<?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="button alt w-full bg-gradient-to-br from-[#375d74] to-[#2a4a5a] hover:from-[#2a4a5a] hover:to-[#375d74] text-white font-bold text-[14px] sm:text-[15px] py-3 sm:py-3.5 px-6 rounded-[10px] uppercase tracking-wide shadow-[0_4px_12px_rgba(55,93,116,0.2)] hover:shadow-[0_6px_20px_rgba(55,93,116,0.3)] hover:-translate-y-0.5 transition-all duration-300 active:translate-y-0' . esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ) . '" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

		<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

		<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
	</div>
</div>

<?php
if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}
