<?php
/**
 * Кастомная интеграция с плагином WooCommerce PDF Invoices & Packing Slips
 * 
 * Функционал для юридических лиц:
 * - Вывод реквизитов (ИНН, КПП, ОКПО) в PDF счете
 * - Кнопка скачивания счета на странице "Спасибо за заказ"
 * 
 * @package enotarynew
 */

// Запретить прямой доступ
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ============================================
 * ЗАДАЧА 1: Вывод реквизитов юрлица в PDF
 * ============================================
 */

/**
 * Добавление реквизитов юридического лица в PDF счет
 * 
 * Выводит ИНН, КПП, ОКПО, Организацию, Юридический адрес
 * после стандартного адреса выставления счета
 * 
 * @param string $template_type Тип документа (invoice, packing-slip, etc)
 * @param WC_Order $order Объект заказа
 */
add_action( 'wpo_wcpdf_after_billing_address', 'enotary_pdf_add_legal_entity_details', 10, 2 );

function enotary_pdf_add_legal_entity_details( $template_type, $order ) {
    // Проверка: только для счетов (invoice)
    if ( $template_type !== 'invoice' ) {
        return;
    }
    
    // Получить ID заказа
    $order_id = $order->get_id();
    
    // Получить реквизиты юридического лица из мета-полей
    $company_name    = get_post_meta( $order_id, '_billing_company', true );
    $inn             = get_post_meta( $order_id, '_billing_inn', true );
    $kpp             = get_post_meta( $order_id, '_billing_kpp', true );
    $okpo            = get_post_meta( $order_id, '_billing_okpo', true );
    $legal_address   = get_post_meta( $order_id, '_billing_legal_address', true );
    
    // Проверка: есть ли хотя бы ИНН или КПП (признак юрлица)
    if ( empty( $inn ) && empty( $kpp ) ) {
        return;
    }
    
    // Вывод реквизитов в PDF
    echo '<div class="legal-entity-details" style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #ddd;">';
    
    if ( ! empty( $company_name ) ) {
        echo '<strong>Организация:</strong> ' . esc_html( $company_name ) . '<br>';
    }
    
    if ( ! empty( $inn ) ) {
        echo '<strong>ИНН:</strong> ' . esc_html( $inn ) . '<br>';
    }
    
    if ( ! empty( $kpp ) ) {
        echo '<strong>КПП:</strong> ' . esc_html( $kpp ) . '<br>';
    }
    
    if ( ! empty( $okpo ) ) {
        echo '<strong>ОКПО:</strong> ' . esc_html( $okpo ) . '<br>';
    }
    
    if ( ! empty( $legal_address ) ) {
        echo '<strong>Юридический адрес:</strong> ' . esc_html( $legal_address ) . '<br>';
    }
    
    echo '</div>';
}

/**
 * ============================================
 * ЗАДАЧА 2: Кнопка скачивания счета
 * ============================================
 */

/**
 * Добавление кнопки "Скачать счет" на страницу благодарности
 * 
 * Отображается только для юридических лиц (метод оплаты 'bacs')
 * 
 * @param int $order_id ID заказа
 */
add_action( 'woocommerce_thankyou', 'enotary_pdf_download_button', 10, 1 );

function enotary_pdf_download_button( $order_id ) {
    // Проверка валидности ID заказа
    if ( ! $order_id ) {
        return;
    }
    
    // Получить объект заказа
    $order = wc_get_order( $order_id );
    
    if ( ! $order ) {
        return;
    }
    
    // КРИТИЧЕСКАЯ ПРОВЕРКА: Только для метода оплаты 'bacs' (юрлица)
    if ( $order->get_payment_method() !== 'bacs' ) {
        return;
    }
    
    // Генерация защищенной ссылки на скачивание PDF счета
    $invoice_url = wp_nonce_url( 
        add_query_arg( array(
            'action'        => 'generate_wpo_wcpdf',
            'document_type' => 'invoice',
            'order_ids'     => $order_id,
            'my-account'    => true,
        ), admin_url( 'admin-ajax.php' ) ),
        'generate_wpo_wcpdf'
    );
    
    // Вывод кнопки в стилистике сайта (Tailwind CSS)
    ?>
    <div class="enotary-pdf-download-section" style="margin-top: 30px; margin-bottom: 20px; text-align: center;">
        <a href="<?php echo esc_url( $invoice_url ); ?>" 
           target="_blank"
           class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-[#2d4d5f] text-white font-bold text-base lg:text-lg px-6 py-3 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg no-underline"
           style="background-color: #375d74; color: #ffffff; padding: 14px 28px; border-radius: 10px; text-decoration: none; display: inline-block; font-weight: 700; transition: all 0.2s;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            Скачать счет на оплату (PDF)
        </a>
        <p style="margin-top: 12px; font-size: 14px; color: #979797;">
            Распечатайте и оплатите счет в вашем банке
        </p>
    </div>
    <?php
}
