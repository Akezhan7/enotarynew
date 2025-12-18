<?php
/**
 * Отображение информации об услуге в названиях товаров корзины
 * 
 * @package enotarynew
 */

// Запретить прямой доступ
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Добавить префикс услуги к названию товара в корзине
 */
add_filter( 'woocommerce_cart_item_name', 'add_service_name_to_cart_item', 10, 3 );

function add_service_name_to_cart_item( $product_name, $cart_item, $cart_item_key ) {
    // Проверяем есть ли метаданные о названии услуги
    if ( isset( $cart_item['_service_name'] ) && ! empty( $cart_item['_service_name'] ) ) {
        $service_name = esc_html( $cart_item['_service_name'] );
        
        // Добавляем префикс с названием услуги
        $product_name = '<span class="service-label" style="color: #0066cc; font-weight: 600;">[' . $service_name . ']</span> ' . $product_name;
    }
    
    return $product_name;
}

/**
 * Сохранить метаданные товара при добавлении в корзину
 */
add_filter( 'woocommerce_add_cart_item_data', 'save_service_name_to_cart_item', 10, 3 );

function save_service_name_to_cart_item( $cart_item_data, $product_id, $variation_id ) {
    // Это будет работать, если передавать через add_to_cart с параметром cart_item_data
    // Мы уже передаем через ajax-handler.php
    return $cart_item_data;
}

/**
 * Сохранить название услуги как метаданные заказа
 */
add_action( 'woocommerce_checkout_create_order_line_item', 'save_service_name_to_order_item', 10, 4 );

function save_service_name_to_order_item( $item, $cart_item_key, $values, $order ) {
    // Сохраняем название услуги в метаданные позиции заказа
    if ( isset( $values['_service_name'] ) ) {
        $item->add_meta_data( '_service_name', $values['_service_name'], true );
    }
    
    // Также отмечаем является ли это товаром типа плательщика или дополнением
    if ( isset( $values['_is_payer_type'] ) ) {
        $item->add_meta_data( '_is_payer_type', true, true );
    }
    
    if ( isset( $values['_is_additional'] ) ) {
        $item->add_meta_data( '_is_additional', true, true );
    }
}

/**
 * Отображение названия услуги в названии товара в заказе (админка и email)
 */
add_filter( 'woocommerce_order_item_name', 'add_service_name_to_order_item', 10, 3 );

function add_service_name_to_order_item( $product_name, $item, $is_visible ) {
    // Получаем название услуги из метаданных
    $service_name = $item->get_meta( '_service_name', true );
    
    if ( ! empty( $service_name ) ) {
        // Добавляем префикс с названием услуги
        $product_name = '[' . esc_html( $service_name ) . '] ' . $product_name;
    }
    
    return $product_name;
}

/**
 * Скрыть служебные метаданные от отображения в заказе
 */
add_filter( 'woocommerce_hidden_order_itemmeta', 'hide_service_metadata' );

function hide_service_metadata( $hidden_meta ) {
    $hidden_meta[] = '_service_name';
    $hidden_meta[] = '_is_payer_type';
    $hidden_meta[] = '_is_additional';
    
    return $hidden_meta;
}
