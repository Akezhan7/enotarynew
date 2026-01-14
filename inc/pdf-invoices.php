<?php
/**
 * Кастомная интеграция с плагином WooCommerce PDF Invoices & Packing Slips
 * * Функционал:
 * - Полная поддержка гостевого скачивания через order_key
 * - Вывод реквизитов юрлица в счете
 * - Скрытие системных кнопок счета для всех, кроме Юрлиц (BACS)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ЗАДАЧА 1: Вывод реквизитов юрлица в PDF
 */
add_action( 'wpo_wcpdf_after_billing_address', 'enotary_pdf_add_legal_entity_details_full', 10, 2 );

function enotary_pdf_add_legal_entity_details_full( $template_type, $order ) {
    if ( $template_type !== 'invoice' ) return;
    
    $company_name    = $order->get_billing_company();
    $inn             = $order->get_meta( '_billing_inn' );
    $kpp             = $order->get_meta( '_billing_kpp' );
    $okpo            = $order->get_meta( '_billing_okpo' );
    $legal_address   = $order->get_meta( '_billing_legal_address' );
    
    if ( empty( $inn ) ) return;
    
    ?>
    <style>
        .legal-details-table { width: 100%; margin-top: 15px; padding-top: 10px; border-top: 1px solid #000; font-size: 9pt; }
        .legal-details-table td { vertical-align: top; padding-bottom: 3px; }
        .label-col { width: 120px; font-weight: bold; color: #333; }
    </style>
    <table class="legal-details-table">
        <?php if ( ! empty( $company_name ) ) : ?>
        <tr><td class="label-col">Организация:</td><td><?php echo esc_html( $company_name ); ?></td></tr>
        <?php endif; ?>
        <tr>
            <td class="label-col">ИНН / КПП:</td>
            <td><?php echo esc_html( $inn ); ?><?php echo ( ! empty( $kpp ) ) ? ' / ' . esc_html( $kpp ) : ''; ?></td>
        </tr>
        <?php if ( ! empty( $okpo ) ) : ?>
        <tr><td class="label-col">ОКПО:</td><td><?php echo esc_html( $okpo ); ?></td></tr>
        <?php endif; ?>
        <?php if ( ! empty( $legal_address ) ) : ?>
        <tr><td class="label-col">Юр. адрес:</td><td><?php echo esc_html( $legal_address ); ?></td></tr>
        <?php endif; ?>
    </table>
    <?php
}

/**
 * ЗАДАЧА 2: Наша кастомная кнопка (видна ТОЛЬКО для BACS)
 */
add_action( 'woocommerce_thankyou', 'enotary_pdf_download_button_guest', 15, 1 );

function enotary_pdf_download_button_guest( $order_id ) {
    if ( ! $order_id ) return;
    $order = wc_get_order( $order_id );
    if ( ! $order || $order->get_payment_method() !== 'bacs' ) return;

    $invoice_url = add_query_arg( array(
        'download_pdf_invoice' => $order_id,
        'order_key'            => $order->get_order_key(),
    ), home_url( '/' ) );

    ?>
    <div class="enotary-pdf-download-section mt-8 pt-6 border-t border-[rgba(0,0,0,0.08)] text-center">
        <a href="<?php echo esc_url( $invoice_url ); ?>" target="_blank"
           class="inline-flex items-center justify-center gap-2 bg-[#375d74] hover:bg-[#2d4d5f] text-white font-bold px-8 py-3.5 rounded-[12px] no-underline transition-all shadow-lg hover:shadow-xl">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            Скачать счет на оплату (PDF)
        </a>
        <p class="mt-3 text-[13px] text-[#777]">Счет для юридического лица сформирован. Регистрация не требуется.</p>
    </div>
    <?php
}

/**
 * ЗАДАЧА 3: Обработчик скачивания
 */
add_action( 'template_redirect', 'enotary_catch_pdf_request' );
function enotary_catch_pdf_request() {
    if ( ! isset( $_GET['download_pdf_invoice'] ) || ! isset( $_GET['order_key'] ) ) return;
    $order_id = absint( $_GET['download_pdf_invoice'] );
    $order = wc_get_order( $order_id );
    if ( $order && $order->get_order_key() === sanitize_text_field( $_GET['order_key'] ) ) {
        if ( function_exists( 'wcpdf_get_document' ) ) {
            $invoice = wcpdf_get_document( 'invoice', $order, true );
            if ( $invoice ) { $invoice->output_pdf(); exit; }
        }
    }
}

/**
 * ЗАДАЧА 4: ОТКЛЮЧЕНИЕ ВСЕХ СИСТЕМНЫХ КНОПОК ПЛАГИНА
 */

// 1. Убираем кнопки из колонки "Действия" (Actions) в таблицах
add_filter( 'wpo_wcpdf_listing_actions', 'enotary_remove_pdf_from_listing', 999, 2 );
add_filter( 'woocommerce_my_account_my_orders_actions', 'enotary_remove_pdf_from_listing', 999, 2 );

function enotary_remove_pdf_from_listing( $actions, $order ) {
    // Удаляем кнопку 'invoice' (счет) из стандартных списков для ВСЕХ
    // Мы выводим свою кнопку отдельно, чтобы не зависеть от шаблонов таблиц
    if ( isset( $actions['invoice'] ) ) {
        unset( $actions['invoice'] );
    }
    return $actions;
}

// 2. Убираем стандартные кнопки плагина через хуки
add_action( 'wp_loaded', function() {
    if ( class_exists( 'WPO_WCPDF' ) && isset( WPO_WCPDF()->frontend ) ) {
        remove_action( 'woocommerce_thankyou', array( WPO_WCPDF()->frontend, 'show_download_button' ), 10 );
        remove_action( 'woocommerce_order_details_after_order_table', array( WPO_WCPDF()->frontend, 'show_download_button' ), 10 );
    }
}, 999 );

// 3. Жесткое скрытие через CSS всех возможных упоминаний кнопок плагина
add_action( 'wp_head', function() {
    ?>
    <style>
        /* Скрываем стандартные кнопки плагина во всех таблицах (Action колонки и т.д.) */
        .wpo-wcpdf-download-button, 
        .wcpdf-button,
        .invoice-button,
        .wcpdf-invoice-button,
        .wpo-wcpdf-invoice-button,
        a.invoice,
        a.invoice-button,
        /* Специально для таблицы на странице благодарности */
        .woocommerce-table__line-item td.woocommerce-table__product-name + td + td a[href*="pdf"],
        .woocommerce-table td.download-actions a,
        .woocommerce-order-details a.button[href*="pdf"],
        /* Если плагин вставляет ссылку в "Действия" */
        .order-actions a[href*="generate_wpo_wcpdf"] {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }

        /* Наша кнопка должна остаться видимой */
        .enotary-pdf-download-section,
        .enotary-pdf-download-section a {
            display: inline-flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            pointer-events: auto !important;
        }
    </style>
    <?php
}, 999 );

// 4. Дополнительная блокировка доступа к PDF через фильтр статусов (на всякий случай)
add_filter( 'wpo_wcpdf_myaccount_allowed_order_statuses', function($statuses) {
    return array(); // Блокируем отображение кнопок в ЛК через штатный механизм плагина
}, 999 );