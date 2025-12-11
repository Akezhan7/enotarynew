<?php
/**
 * AJAX обработчик для добавления товаров в корзину WooCommerce
 * 
 * @package enotarynew
 */

// Запретить прямой доступ
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Регистрация AJAX обработчиков
 */
add_action( 'wp_ajax_enotary_add_to_cart', 'enotary_add_to_cart_handler' );
add_action( 'wp_ajax_nopriv_enotary_add_to_cart', 'enotary_add_to_cart_handler' );

/**
 * Обработчик AJAX запроса для добавления товара в корзину
 */
function enotary_add_to_cart_handler() {
    // Проверка nonce для безопасности
    check_ajax_referer( 'enotary_cart_nonce', 'nonce' );
    
    // Проверка что WooCommerce активен
    if ( ! function_exists( 'wc_get_product' ) ) {
        wp_send_json_error( array(
            'message' => 'WooCommerce не активен'
        ) );
    }
    
    // Получение данных из POST запроса
    $product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'] ) : 0;
    $total_price = isset( $_POST['total_price'] ) ? floatval( $_POST['total_price'] ) : 0;
    $payer_type = isset( $_POST['payer_type'] ) ? sanitize_text_field( $_POST['payer_type'] ) : '';
    $selected_options = isset( $_POST['selected_options'] ) ? json_decode( stripslashes( $_POST['selected_options'] ), true ) : array();
    
    // Валидация данных
    if ( ! $product_id || ! $total_price ) {
        wp_send_json_error( array(
            'message' => 'Неверные данные. Пожалуйста, проверьте выбранные опции.'
        ) );
    }
    
    // Проверка существования товара
    $product = wc_get_product( $product_id );
    if ( ! $product ) {
        wp_send_json_error( array(
            'message' => 'Товар не найден.'
        ) );
    }
    
    // Очистка корзины
    WC()->cart->empty_cart();
    
    // Добавление товара в корзину
    $cart_item_key = WC()->cart->add_to_cart( $product_id, 1 );
    
    if ( ! $cart_item_key ) {
        wp_send_json_error( array(
            'message' => 'Не удалось добавить товар в корзину.'
        ) );
    }
    
    // Сохранение данных в сессию WooCommerce
    WC()->session->set( 'enotary_custom_price', $total_price );
    WC()->session->set( 'enotary_payer_type', $payer_type );
    WC()->session->set( 'enotary_selected_options', $selected_options );
    WC()->session->set( 'enotary_cart_item_key', $cart_item_key );
    
    // Применение кастомной цены к товару
    enotary_apply_custom_price_to_cart();
    
    // Получение URL страницы оформления заказа
    $checkout_url = wc_get_checkout_url();
    
    // Отправка успешного ответа
    wp_send_json_success( array(
        'message' => 'Товар успешно добавлен в корзину',
        'redirect_url' => $checkout_url,
        'cart_total' => WC()->cart->get_cart_total()
    ) );
}

/**
 * Применение кастомной цены к товару в корзине
 */
function enotary_apply_custom_price_to_cart() {
    add_action( 'woocommerce_before_calculate_totals', 'enotary_set_custom_cart_price', 10, 1 );
}

/**
 * Установка кастомной цены для товара в корзине
 * 
 * @param WC_Cart $cart Объект корзины
 */
function enotary_set_custom_cart_price( $cart ) {
    // Проверка чтобы не выполнялось при каждом обновлении корзины
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }
    
    // Проверка что это не повторный вызов
    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 ) {
        return;
    }
    
    // Получение сохраненных данных из сессии
    $custom_price = WC()->session->get( 'enotary_custom_price' );
    $cart_item_key = WC()->session->get( 'enotary_cart_item_key' );
    
    if ( ! $custom_price || ! $cart_item_key ) {
        return;
    }
    
    // Применение кастомной цены к товару
    foreach ( $cart->get_cart() as $key => $cart_item ) {
        if ( $key === $cart_item_key ) {
            $cart_item['data']->set_price( $custom_price );
        }
    }
}

/**
 * Добавление мета-данных к заказу
 * 
 * @param int $order_id ID заказа
 */
function enotary_add_order_meta( $order_id ) {
    $payer_type = WC()->session->get( 'enotary_payer_type' );
    $selected_options = WC()->session->get( 'enotary_selected_options' );
    
    if ( $payer_type ) {
        update_post_meta( $order_id, '_enotary_payer_type', $payer_type );
    }
    
    if ( $selected_options ) {
        update_post_meta( $order_id, '_enotary_selected_options', $selected_options );
    }
    
    // Очистка сессии после создания заказа
    WC()->session->__unset( 'enotary_custom_price' );
    WC()->session->__unset( 'enotary_payer_type' );
    WC()->session->__unset( 'enotary_selected_options' );
    WC()->session->__unset( 'enotary_cart_item_key' );
}
add_action( 'woocommerce_checkout_order_processed', 'enotary_add_order_meta', 10, 1 );

/**
 * Отображение информации о типе плательщика в админке заказа
 * 
 * @param WC_Order $order Объект заказа
 */
function enotary_display_order_meta_in_admin( $order ) {
    $payer_type = get_post_meta( $order->get_id(), '_enotary_payer_type', true );
    $selected_options = get_post_meta( $order->get_id(), '_enotary_selected_options', true );
    
    if ( $payer_type ) {
        echo '<p><strong>Тип плательщика:</strong> ' . esc_html( $payer_type ) . '</p>';
    }
    
    if ( $selected_options && is_array( $selected_options ) ) {
        echo '<div><strong>Выбранные опции:</strong><ul>';
        foreach ( $selected_options as $option ) {
            if ( isset( $option['name'] ) && isset( $option['price'] ) ) {
                echo '<li>' . esc_html( $option['name'] ) . ' - ' . esc_html( $option['price'] ) . '₽';
                if ( isset( $option['quantity'] ) && $option['quantity'] > 1 ) {
                    echo ' (x' . intval( $option['quantity'] ) . ')';
                }
                echo '</li>';
            }
        }
        echo '</ul></div>';
    }
}
add_action( 'woocommerce_admin_order_data_after_billing_address', 'enotary_display_order_meta_in_admin', 10, 1 );
