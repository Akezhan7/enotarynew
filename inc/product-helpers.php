<?php
/**
 * Product Helper Functions
 * 
 * Функции-помощники для работы с товарами WooCommerce
 * 
 * @package enotarynew
 */

// Запретить прямой доступ
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Получить данные товара по артикулу (SKU)
 * 
 * @param string $sku Артикул товара
 * @return array|false Массив с данными товара или false если не найден
 */
function get_product_data_by_sku( $sku ) {
    // Проверка что WooCommerce доступен
    if ( ! function_exists( 'wc_get_product_id_by_sku' ) ) {
        return false;
    }
    
    if ( empty( $sku ) ) {
        return false;
    }
    
    // Получаем ID товара по SKU
    $product_id = wc_get_product_id_by_sku( $sku );
    
    if ( ! $product_id ) {
        return false;
    }
    
    // Получаем объект товара
    $product = wc_get_product( $product_id );
    
    if ( ! $product ) {
        return false;
    }
    
    // Возвращаем массив с данными
    return array(
        'id'    => $product_id,
        'name'  => $product->get_name(),
        'price' => $product->get_regular_price() ? floatval( $product->get_regular_price() ) : 0,
        'sku'   => $sku,
    );
}

/**
 * Вывести HTML список товаров по категории (для чекбоксов)
 * 
 * @param string $category_slug Слаг категории товаров
 * @param string $section_title Заголовок секции (опционально)
 * @param array $args Дополнительные аргументы (опционально)
 * @param bool $show_quantity Показывать контролы количества (по умолчанию true)
 * @return void
 */
function render_checklist_by_category( $category_slug, $section_title = '', $args = array(), $show_quantity = true ) {
    // Проверка что WooCommerce доступен
    if ( ! function_exists( 'wc_get_products' ) ) {
        echo '<!-- WooCommerce не загружен -->';
        return;
    }
    
    if ( empty( $category_slug ) ) {
        echo '<!-- Ошибка: не указана категория -->';
        return;
    }
    
    // Параметры по умолчанию
    $defaults = array(
        'limit'   => -1,
        'orderby' => 'menu_order',
        'order'   => 'ASC',
    );
    
    $args = wp_parse_args( $args, $defaults );
    
    // Получаем товары из категории
    $products = wc_get_products( array(
        'category' => array( $category_slug ),
        'limit'    => $args['limit'],
        'orderby'  => $args['orderby'],
        'order'    => $args['order'],
        'status'   => 'publish',
    ) );
    
    if ( empty( $products ) ) {
        // Отладочная информация
        $term = get_term_by( 'slug', $category_slug, 'product_cat' );
        if ( ! $term ) {
            echo '<!-- Категория "' . esc_attr( $category_slug ) . '" не существует в базе данных -->';
        } else {
            echo '<!-- Товары в категории "' . esc_attr( $category_slug ) . '" (ID: ' . $term->term_id . ') не найдены -->';
        }
        return;
    }
    
    // Выводим обертку секции
    ?>
    <section class="ibsh w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5">
        <?php if ( ! empty( $section_title ) ) : ?>
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]"><?php echo esc_html( $section_title ); ?></h2>
        <?php endif; ?>
        
        <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full">
    <?php
    
    // Выводим HTML для каждого товара
    $count = count( $products );
    $index = 0;
    
    foreach ( $products as $product ) {
        $product_id = $product->get_id();
        $product_name = $product->get_name();
        $product_price = $product->get_regular_price() ? floatval( $product->get_regular_price() ) : 0;
        $product_description = $product->get_short_description();
        $index++;
        
        // Определяем, нужен ли border-b (для всех кроме последнего)
        $border_class = ( $index < $count ) ? 'border-b border-[rgba(0,0,0,0.05)]' : '';
        
        // Определяем класс для checkbox-custom (если есть описание, добавляем отступ)
        $checkbox_class = ! empty( $product_description ) ? 'checkbox-custom mt-0.5' : 'checkbox-custom';
        
        // Определяем класс для обертки (если есть описание - items-start, иначе items-center)
        $wrapper_align = ! empty( $product_description ) ? 'items-start' : 'items-center';
        
        ?>
        <div class="flex flex-wrap <?php echo esc_attr( $wrapper_align ); ?> gap-2 sm:gap-2.5 p-4 sm:p-5 <?php echo esc_attr( $border_class ); ?>">
            <div class="<?php echo esc_attr( $checkbox_class ); ?>"></div>
            <input 
                type="checkbox" 
                class="service-checkbox hidden" 
                value="<?php echo esc_attr( $product_price ); ?>" 
                data-product-id="<?php echo esc_attr( $product_id ); ?>"
                data-product-name="<?php echo esc_attr( $product_name ); ?>"
                id="product-<?php echo esc_attr( $product_id ); ?>"
            >
            <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">
                    <?php echo esc_html( $product_name ); ?>
                </p>
                <?php if ( ! empty( $product_description ) ) : ?>
                    <div class="font-semibold text-xs sm:text-sm text-secondary leading-[1.15]">
                        <?php echo wp_kses_post( $product_description ); ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ( $show_quantity ) : ?>
                <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full">
                    <div class="quantity-control">
                        <button class="quantity-btn" data-action="decrement"></button>
                        <span class="quantity-value">0</span>
                        <button class="quantity-btn" data-action="increment"></button>
                    </div>
                    <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">
                        <?php echo esc_html( number_format( $product_price, 0, ',', ' ' ) ); ?>₽
                    </p>
                </div>
            <?php else : ?>
                <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right flex-shrink-0">
                    <?php echo esc_html( number_format( $product_price, 0, ',', ' ' ) ); ?>₽
                </p>
            <?php endif; ?>
        </div>
        <?php
    }
    
    ?>
        </div>
    </section>
    <?php
}

/**
 * Получить данные нескольких товаров по массиву SKU
 * 
 * @param array $skus Массив артикулов
 * @return array Массив данных товаров
 */
function get_multiple_products_by_sku( $skus ) {
    $products_data = array();
    
    if ( ! is_array( $skus ) || empty( $skus ) ) {
        return $products_data;
    }
    
    foreach ( $skus as $key => $sku ) {
        $product_data = get_product_data_by_sku( $sku );
        if ( $product_data ) {
            $products_data[ $key ] = $product_data;
        }
    }
    
    return $products_data;
}

/**
 * Проверить существование категории товаров
 * 
 * @param string $category_slug Слаг категории
 * @return bool
 */
function enotary_category_exists( $category_slug ) {
    $term = get_term_by( 'slug', $category_slug, 'product_cat' );
    return ! empty( $term );
}
