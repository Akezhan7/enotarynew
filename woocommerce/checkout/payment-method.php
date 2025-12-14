<?php
/**
 * Output a single payment method (Tailwind styled)
 *
 * @package enotarynew
 */

defined( 'ABSPATH' ) || exit;
?>
<li class="wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?> flex items-center gap-2 py-1.5">
	<input 
		id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" 
		type="radio" 
		class="input-radio accent-primary w-[14px] h-[14px] cursor-pointer flex-shrink-0" 
		name="payment_method" 
		value="<?php echo esc_attr( $gateway->id ); ?>" 
		<?php checked( $gateway->chosen, true ); ?> 
		data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" 
	/>

	<label 
		for="payment_method_<?php echo esc_attr( $gateway->id ); ?>" 
		class="font-semibold text-[12px] sm:text-[13px] text-[#262626] cursor-pointer m-0"
	>
		<?php echo $gateway->get_title(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?>
	</label>
</li>
