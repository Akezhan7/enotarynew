<?php
/**
 * Orders
 *
 * Таблица заказов в личном кабинете
 * Стилизация в Tailwind CSS в общей стилистике E-Notary
 *
 * @package enotarynew
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php if ( $has_orders ) : ?>

	<!-- Заголовок секции -->
	<div class="orders-header mb-6">
		<h2 class="text-2xl md:text-3xl font-bold text-[#262626]">
			<?php esc_html_e( 'Orders', 'woocommerce' ); ?>
		</h2>
		<p class="text-sm text-[#979797] mt-2">
			История ваших заказов и текущий статус
		</p>
	</div>

	<!-- Таблица заказов (Адаптивная) -->
	<div class="orders-table-wrapper overflow-x-auto">
		<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table w-full">
			<thead class="bg-gray-50">
				<tr class="text-left">
					<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
						<th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?> px-4 py-4 text-sm font-bold text-[#262626] uppercase tracking-wider">
							<span class="nobr"><?php echo esc_html( $column_name ); ?></span>
						</th>
					<?php endforeach; ?>
				</tr>
			</thead>

			<tbody>
				<?php
				foreach ( $customer_orders->orders as $customer_order ) {
					$order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					$item_count = $order->get_item_count() - $order->get_item_count_refunded();
					?>
					<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order border-b border-gray-100 hover:bg-gray-50 transition-colors">
						
						<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
							<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?> px-4 py-4" data-title="<?php echo esc_attr( $column_name ); ?>">
								<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
									<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

								<?php elseif ( 'order-number' === $column_id ) : ?>
									<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="text-[#375d74] hover:text-[#2a4a5c] font-semibold transition-colors">
										#<?php echo esc_html( $order->get_order_number() ); ?>
									</a>

								<?php elseif ( 'order-date' === $column_id ) : ?>
									<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>" class="text-sm text-[#262626]">
										<?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?>
									</time>

								<?php elseif ( 'order-status' === $column_id ) : ?>
									<?php 
									$status = $order->get_status();
									$status_name = wc_get_order_status_name( $status );
									
									// Определение цветов для статусов
									$status_colors = array(
										'pending'    => 'bg-yellow-100 text-yellow-800 border-yellow-200',
										'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
										'on-hold'    => 'bg-orange-100 text-orange-800 border-orange-200',
										'completed'  => 'bg-green-100 text-green-800 border-green-200',
										'cancelled'  => 'bg-red-100 text-red-800 border-red-200',
										'refunded'   => 'bg-gray-100 text-gray-800 border-gray-200',
										'failed'     => 'bg-red-100 text-red-800 border-red-200',
									);
									
									$status_class = isset( $status_colors[ $status ] ) ? $status_colors[ $status ] : 'bg-gray-100 text-gray-800 border-gray-200';
									?>
									<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border <?php echo esc_attr( $status_class ); ?>">
										<?php echo esc_html( $status_name ); ?>
									</span>

								<?php elseif ( 'order-total' === $column_id ) : ?>
									<span class="text-base font-bold text-[#262626]">
										<?php
										/* translators: 1: formatted order total 2: total order items */
										echo wp_kses_post( sprintf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count ) );
										?>
									</span>

								<?php elseif ( 'order-actions' === $column_id ) : ?>
									<?php
									$actions = wc_get_account_orders_actions( $order );

									if ( ! empty( $actions ) ) {
										foreach ( $actions as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
											// Определение стилей для разных действий
											$action_classes = array(
												'view'   => 'bg-[#375d74] hover:bg-[#2d4d5f] text-white',
												'pay'    => 'bg-green-600 hover:bg-green-700 text-white',
												'cancel' => 'bg-red-600 hover:bg-red-700 text-white',
											);
											
											$btn_class = isset( $action_classes[ $key ] ) ? $action_classes[ $key ] : 'bg-gray-600 hover:bg-gray-700 text-white';
											
											echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button button ' . sanitize_html_class( $key ) . ' inline-block px-4 py-2 rounded-[8px] text-sm font-semibold transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md mr-2 mb-2 ' . esc_attr( $btn_class ) . '">' . esc_html( $action['name'] ) . '</a>';
										}
									}
									?>
								<?php endif; ?>
							</td>
						<?php endforeach; ?>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>

	<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination mt-8 flex justify-between items-center gap-4">
			<?php if ( 1 !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button inline-flex items-center gap-2 px-6 py-3 bg-[#375d74] hover:bg-[#2d4d5f] text-white font-semibold rounded-[10px] transition-all duration-300 transform hover:-translate-y-0.5" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>">
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
					</svg>
					<?php esc_html_e( 'Previous', 'woocommerce' ); ?>
				</a>
			<?php endif; ?>

			<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button inline-flex items-center gap-2 px-6 py-3 bg-[#375d74] hover:bg-[#2d4d5f] text-white font-semibold rounded-[10px] transition-all duration-300 transform hover:-translate-y-0.5 ml-auto" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>">
					<?php esc_html_e( 'Next', 'woocommerce' ); ?>
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
					</svg>
				</a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php else : ?>

	<!-- Если заказов нет -->
	<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info text-center py-12">
		<div class="inline-block p-8 bg-gray-50 rounded-[20px]">
			<!-- Иконка -->
			<div class="mb-4">
				<svg class="w-20 h-20 mx-auto text-[#979797]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
				</svg>
			</div>
			
			<p class="text-lg font-semibold text-[#262626] mb-2">
				<?php esc_html_e( 'No order has been made yet.', 'woocommerce' ); ?>
			</p>
			<p class="text-sm text-[#979797] mb-6">
				Начните свой первый заказ сертификата ЭП
			</p>
			
			<a 
				class="woocommerce-Button button inline-flex items-center gap-2 px-6 py-3 bg-[#375d74] hover:bg-[#2d4d5f] text-white font-semibold rounded-[10px] transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg" 
				href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"
			>
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
				</svg>
				<?php esc_html_e( 'Browse products', 'woocommerce' ); ?>
			</a>
		</div>
	</div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>

