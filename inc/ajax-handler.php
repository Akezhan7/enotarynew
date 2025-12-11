<?php
/**
 * AJAX Handler for Bundle Cart Operations
 * 
 * Обработчик AJAX для добавления набора товаров в корзину
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
add_action( 'wp_ajax_add_custom_bundle_to_cart', 'add_custom_bundle_to_cart' );
add_action( 'wp_ajax_nopriv_add_custom_bundle_to_cart', 'add_custom_bundle_to_cart' );

/**
 * Добавить набор товаров в корзину
 */
function add_custom_bundle_to_cart() {
    // Проверка nonce для безопасности
    check_ajax_referer( 'enotary_bundle_nonce', 'nonce' );
    
    // Проверка что WooCommerce активен
    if ( ! function_exists( 'WC' ) ) {
        wp_send_json_error( array(
            'message' => 'WooCommerce не активен'
        ) );
    }
    
    // Получение данных из POST запроса
    $items = isset( $_POST['items'] ) ? json_decode( stripslashes( $_POST['items'] ), true ) : array();
    $payer_type = isset( $_POST['payer_type'] ) ? sanitize_text_field( $_POST['payer_type'] ) : '';
    $base_product_id = isset( $_POST['base_product_id'] ) ? intval( $_POST['base_product_id'] ) : 0;
    
    // Валидация данных
    if ( empty( $items ) || ! is_array( $items ) ) {
        wp_send_json_error( array(
            'message' => 'Неверные данные. Пожалуйста, выберите хотя бы один товар.'
        ) );
    }
    
    // Очистка корзины
    WC()->cart->empty_cart();
    
    // Счетчик добавленных товаров
    $added_count = 0;
    
    // Добавление товаров в корзину
    foreach ( $items as $item ) {
        $product_id = isset( $item['id'] ) ? intval( $item['id'] ) : 0;
        $quantity = isset( $item['quantity'] ) ? intval( $item['quantity'] ) : 1;
        
        if ( ! $product_id || $quantity < 1 ) {
            continue;
        }
        
        // Проверка существования товара
        $product = wc_get_product( $product_id );
        if ( ! $product ) {
            continue;
        }
        
        // Добавление товара в корзину
        $cart_item_key = WC()->cart->add_to_cart( $product_id, $quantity );
        
        if ( $cart_item_key ) {
            $added_count++;
        }
    }
    
    // Проверка что хотя бы один товар добавлен
    if ( $added_count === 0 ) {
        wp_send_json_error( array(
            'message' => 'Не удалось добавить товары в корзину. Проверьте наличие товаров.'
        ) );
    }
    
    // Сохранение типа плательщика в сессию
    if ( ! empty( $payer_type ) ) {
        WC()->session->set( 'active_payer_type', $payer_type );
    }
    
    // Сохранение ID базового товара
    if ( $base_product_id > 0 ) {
        WC()->session->set( 'base_product_id', $base_product_id );
    }
    
    // Сохранение информации о наборе товаров
    WC()->session->set( 'bundle_items', $items );
    
    // Получение URL страницы оформления заказа
    $checkout_url = wc_get_checkout_url();
    
    // Отправка успешного ответа
    wp_send_json_success( array(
        'message' => 'Товары успешно добавлены в корзину',
        'redirect_url' => $checkout_url,
        'cart_total' => WC()->cart->get_cart_total(),
        'cart_count' => WC()->cart->get_cart_contents_count(),
        'added_count' => $added_count,
    ) );
}

/**
 * Сохранение информации о наборе в мета-полях заказа
 */
add_action( 'woocommerce_checkout_order_processed', 'save_bundle_info_to_order', 10, 1 );

function save_bundle_info_to_order( $order_id ) {
    // Получаем данные из сессии
    $payer_type = WC()->session->get( 'active_payer_type' );
    $base_product_id = WC()->session->get( 'base_product_id' );
    $bundle_items = WC()->session->get( 'bundle_items' );
    
    // Сохраняем тип плательщика
    if ( ! empty( $payer_type ) ) {
        update_post_meta( $order_id, '_payer_type', $payer_type );
    }
    
    // Сохраняем ID базового товара
    if ( ! empty( $base_product_id ) ) {
        update_post_meta( $order_id, '_base_product_id', $base_product_id );
    }
    
    // Сохраняем информацию о наборе
    if ( ! empty( $bundle_items ) ) {
        update_post_meta( $order_id, '_bundle_items', $bundle_items );
    }
    
    // Очищаем сессию после создания заказа
    WC()->session->__unset( 'active_payer_type' );
    WC()->session->__unset( 'base_product_id' );
    WC()->session->__unset( 'bundle_items' );
}

/**
 * Отображение информации о наборе в админке заказа
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'display_bundle_info_in_admin', 10, 1 );

function display_bundle_info_in_admin( $order ) {
    $payer_type = get_post_meta( $order->get_id(), '_payer_type', true );
    $base_product_id = get_post_meta( $order->get_id(), '_base_product_id', true );
    
    if ( $payer_type ) {
        $payer_type_labels = array(
            'ul' => 'Юридическое лицо',
            'ip' => 'Индивидуальный предприниматель',
            'fl' => 'Физическое лицо',
        );
        
        $label = isset( $payer_type_labels[ $payer_type ] ) ? $payer_type_labels[ $payer_type ] : $payer_type;
        
        echo '<div class="order-payer-type" style="margin-top: 15px; padding: 10px; background: #f0f0f1; border-left: 3px solid #2271b1;">';
        echo '<p><strong>Тип плательщика:</strong> ' . esc_html( $label ) . '</p>';
        
        if ( $base_product_id ) {
            $product = wc_get_product( $base_product_id );
            if ( $product ) {
                echo '<p><strong>Базовый товар:</strong> ' . esc_html( $product->get_name() ) . ' (ID: ' . intval( $base_product_id ) . ')</p>';
            }
        }
        
        echo '</div>';
    }
}
