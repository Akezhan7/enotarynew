<?php
/**
 * Review order table (Tailwind styled)
 *
 * @package enotarynew
 */

defined( 'ABSPATH' ) || exit;
?>

<table class="w-full shop_table woocommerce-checkout-review-order-table">
	<tbody>
		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="border-b border-[rgba(0,0,0,0.05)] last:border-b-0 <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
					<td class="py-2.5 px-4 sm:px-5 font-semibold text-[13px] sm:text-[14px] text-[#262626] leading-[1.3]">
						<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?>
						<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <span class="text-secondary">&times;&nbsp;' . sprintf( '%s', $cart_item['quantity'] ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</td>
					<td class="py-2.5 px-4 sm:px-5 text-right font-bold text-[14px] sm:text-[15px] text-primary leading-[1.3] whitespace-nowrap">
						<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</td>
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</tbody>
	<tfoot class="border-t border-[rgba(0,0,0,0.05)]">

		<tr class="order-total">
			<th class="py-3 px-4 sm:px-5 font-bold text-[15px] sm:text-[16px] text-[#262626] text-left leading-[1.3]">
				Итого
			</th>
			<td class="py-3 px-4 sm:px-5 text-right font-bold text-[16px] sm:text-[18px] text-primary leading-[1.3] whitespace-nowrap">
				<?php wc_cart_totals_order_total_html(); ?>
			</td>
		</tr>

	</tfoot>
</table>
