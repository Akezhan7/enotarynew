<?php
/**
 * Переопределенный основной шаблон чекаута
 * 
 * @package enotarynew
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

// Если чекаут отключен
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}
?>

<div class="enotary-checkout-wrapper w-full responsive-container">
	<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

		<?php if ( $checkout->get_checkout_fields() ) : ?>

			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

			<!-- Форма заполнения данных -->
			<div id="customer_details" class="mb-6">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>

			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

		<?php endif; ?>
		
		<!-- Блок итогов заказа под формой -->
		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

		<div id="order_review" class="woocommerce-checkout-review-order bg-white border border-[rgba(0,0,0,0.05)] rounded-[12px] sm:rounded-[15px] lg:rounded-[20px] overflow-hidden shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
			<div class="border-b border-[rgba(0,0,0,0.05)] px-4 py-3 sm:px-5 sm:py-3.5">
				<h2 class="font-bold text-[15px] sm:text-[16px] lg:text-[18px] text-[#262626] leading-[1.15] m-0">Ваш заказ</h2>
			</div>
			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		</div>

		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

	</form>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
