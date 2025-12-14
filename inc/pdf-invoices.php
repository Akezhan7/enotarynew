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
    
    // Получить реквизиты юридического лица из объекта заказа
    // ПРАВИЛЬНО: используем $order->get_meta() вместо get_post_meta()
    // Это работает как с HPOS, так и без него
    $company_name    = $order->get_billing_company(); // Стандартное поле WooCommerce
    $inn             = $order->get_meta( '_billing_inn' );
    $kpp             = $order->get_meta( '_billing_kpp' );
    $okpo            = $order->get_meta( '_billing_okpo' );
    $legal_address   = $order->get_meta( '_billing_legal_address' );
    
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
    
    // Вывод кнопки в компактной стилистике (Tailwind CSS)
    ?>
    <div class="enotary-pdf-download-section mt-5 sm:mt-6 pt-5 sm:pt-6 border-t border-[rgba(0,0,0,0.05)] text-center">
        <a href="<?php echo esc_url( $invoice_url ); ?>" 
           target="_blank"
           class="inline-flex items-center justify-center gap-2 bg-[#375d74] hover:bg-[#2d4d5f] text-white font-bold text-[13px] sm:text-sm px-5 py-2.5 sm:px-6 sm:py-3 rounded-[10px] transition-all duration-200 shadow-md hover:shadow-lg no-underline">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            Скачать счет на оплату (PDF)
        </a>
        <p class="mt-2 sm:mt-3 text-[11px] sm:text-[12px] text-[#979797]">
            Распечатайте и оплатите счет в вашем банке
        </p>
    </div>
    <?php
}

/**
 * ============================================
 * ЗАДАЧА 3: Отключение кнопок плагина для ФИЗ/ИП
 * ============================================
 */

/**
 * Полностью отключить стандартные кнопки плагина PDF Invoices
 * Используем wp_loaded вместо init, чтобы плагин уже был загружен
 */
add_action( 'wp_loaded', 'enotary_disable_pdf_plugin_buttons', 999 );

function enotary_disable_pdf_plugin_buttons() {
    // Удаляем все хуки плагина PDF Invoices
    if ( class_exists( 'WPO_WCPDF' ) ) {
        $wpo_wcpdf = WPO_WCPDF();
        
        // Удаляем кнопки на странице благодарности и деталях заказа
        if ( isset( $wpo_wcpdf->frontend ) ) {
            remove_action( 'woocommerce_thankyou', array( $wpo_wcpdf->frontend, 'show_download_button' ), 10 );
            remove_action( 'woocommerce_order_details_after_order_table', array( $wpo_wcpdf->frontend, 'show_download_button' ), 10 );
        }
    }
}

/**
 * ЖЕСТКОЕ отключение прав на генерацию PDF для не-юр лиц
 * Плагин вообще не сможет генерировать документы для физ.лиц и ИП
 */
add_filter( 'wpo_wcpdf_document_is_allowed', 'enotary_filter_pdf_documents', 999, 2 );

function enotary_filter_pdf_documents( $allowed, $document ) {
    // Пытаемся получить заказ из документа разными способами
    $order = null;
    
    if ( isset( $document->order ) && is_object( $document->order ) ) {
        $order = $document->order;
    } elseif ( method_exists( $document, 'get_order' ) ) {
        $order = $document->get_order();
    }
    
    // Если заказ не найден - разрешаем (пусть плагин сам решает)
    if ( ! $order || ! is_object( $order ) ) {
        return $allowed;
    }
    
    // Проверяем метод оплаты
    $payment_method = $order->get_payment_method();
    
    // ТОЛЬКО bacs (юр.лица) имеют право на PDF
    // Все остальные (cheque, robokassa и т.д.) - НЕТ
    if ( $payment_method !== 'bacs' ) {
        return false;
    }
    
    return $allowed;
}

/**
 * Скрыть кнопки в личном кабинете для не-юр лиц
 */
add_filter( 'wpo_wcpdf_myaccount_allowed_order_statuses', 'enotary_hide_pdf_buttons_myaccount', 999, 2 );

function enotary_hide_pdf_buttons_myaccount( $allowed, $order = null ) {
    if ( ! $order ) {
        return array(); // Если заказ не передан - блокируем
    }
    
    $payment_method = $order->get_payment_method();
    
    // Если не bacs - никакие статусы не разрешены
    if ( $payment_method !== 'bacs' ) {
        return array();
    }
    
    return $allowed;
}

/**
 * CSS-хак: скрыть стандартные кнопки плагина, если они просочатся
 */
add_action( 'wp_head', 'enotary_hide_pdf_buttons_css', 999 );

function enotary_hide_pdf_buttons_css() {
    // Только для страниц заказов
    if ( ! is_wc_endpoint_url( 'order-received' ) && ! is_account_page() ) {
        return;
    }
    
    ?>
    <style>
        /* Скрыть стандартные кнопки плагина PDF Invoices */
        .wpo-wcpdf-download-button,
        .wpo-wcpdf-invoice-button,
        .wcpdf-invoice-button,
        a[href*="generate_wpo_wcpdf"]:not(.enotary-pdf-download-section a) {
            display: none !important;
        }
        
        /* Наша кастомная кнопка всегда видна (если есть) */
        .enotary-pdf-download-section {
            display: block !important;
        }
    </style>
    <?php
}
