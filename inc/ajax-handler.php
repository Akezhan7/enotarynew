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
    $service_name = isset( $_POST['service_name'] ) ? sanitize_text_field( $_POST['service_name'] ) : 'УКЭП';
    
    // Валидация типа плательщика (должен быть: 'individual', 'entrepreneur' или 'legal')
    $allowed_payer_types = array( 'individual', 'entrepreneur', 'legal' );
    if ( ! empty( $payer_type ) && ! in_array( $payer_type, $allowed_payer_types, true ) ) {
        $payer_type = 'individual'; // Дефолт, если пришло что-то некорректное
    }
    
    // Валидация: обязательно должен быть выбран тип плательщика
    if ( empty( $payer_type ) ) {
        wp_send_json_error( array(
            'message' => 'Пожалуйста, выберите тип плательщика.'
        ) );
    }
    
    // Проверяем что items - это массив (может быть пустым, это нормально)
    if ( ! is_array( $items ) ) {
        $items = array();
    }
    
    // Очистка корзины
    WC()->cart->empty_cart();
    
    // Счетчик добавленных товаров
    $added_count = 0;
    
    // Сохраняем тип плательщика в сессии (НЕ добавляем в корзину!)
    // Тип плательщика используется только для выбора форм и способов оплаты
    if ( ! empty( $payer_type ) ) {
        WC()->session->set( 'active_payer_type', $payer_type );
        
        // Получаем данные типа плательщика для label
        $payer_types_data = get_payer_types_options();
        if ( isset( $payer_types_data[ $payer_type ] ) ) {
            $payer_label = $payer_types_data[ $payer_type ]['label'] ?? '';
            WC()->session->set( 'payer_type_label', $payer_label );
        }
    }
    
    // Добавляем только выбранные товары/услуги (БЕЗ типа плательщика)
    if ( ! empty( $items ) && is_array( $items ) ) {
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
            
            // Добавление товара в корзину с метаданными о названии услуги
            $cart_item_key = WC()->cart->add_to_cart( 
                $product_id, 
                $quantity,
                0,
                array(),
                array( 
                    '_service_name' => $service_name,
                    '_is_additional' => true
                )
            );
            
            if ( $cart_item_key ) {
                $added_count++;
            }
        }
    }
    
    // Проверка что хотя бы один товар добавлен (валидация на клиенте должна это гарантировать)
    // Но оставляем проверку для безопасности
    if ( $added_count === 0 && empty( $items ) ) {
        wp_send_json_error( array(
            'message' => 'Не удалось добавить товары в корзину. Проверьте выбранные товары.'
        ) );
    }
    
    // Сохранение ID базового товара (для информации)
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
    $payer_type_label = WC()->session->get( 'payer_type_label' );
    $base_product_id = WC()->session->get( 'base_product_id' );
    $bundle_items = WC()->session->get( 'bundle_items' );
    
    // Сохраняем тип плательщика
    if ( ! empty( $payer_type ) ) {
        update_post_meta( $order_id, '_payer_type', $payer_type );
        update_post_meta( $order_id, '_payer_type_label', $payer_type_label );
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
    WC()->session->__unset( 'payer_type_label' );
    WC()->session->__unset( 'base_product_id' );
    WC()->session->__unset( 'bundle_items' );
}

/**
 * Отображение информации о наборе в админке заказа
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'display_bundle_info_in_admin', 10, 1 );

function display_bundle_info_in_admin( $order ) {
    $payer_type = get_post_meta( $order->get_id(), '_payer_type', true );
    $payer_type_label = get_post_meta( $order->get_id(), '_payer_type_label', true );
    $base_product_id = get_post_meta( $order->get_id(), '_base_product_id', true );
    
    if ( $payer_type ) {
        $payer_type_labels = array(
            'legal' => 'Юридическое лицо',
            'entrepreneur' => 'Индивидуальный предприниматель',
            'individual' => 'Физическое лицо',
        );
        
        $label = ! empty( $payer_type_label ) ? $payer_type_label : ( isset( $payer_type_labels[ $payer_type ] ) ? $payer_type_labels[ $payer_type ] : $payer_type );
        
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
