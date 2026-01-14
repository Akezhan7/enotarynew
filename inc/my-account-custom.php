<?php
/**
 * Кастомизация Личного Кабинета WooCommerce
 * 
 * ТЗ пункты 219, 229, 231: Вывод сертификатов, лицензий, инструкций
 * 
 * @package enotarynew
 */

// Запретить прямой доступ
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ============================================
 * ВЫВОД ИНФОРМАЦИОННЫХ БЛОКОВ В ЛК КЛИЕНТА
 * ============================================
 */

/**
 * Добавить информационные блоки перед таблицей заказа
 */
add_action( 'woocommerce_order_details_before_order_table', 'enotary_display_customer_order_info', 10, 1 );

function enotary_display_customer_order_info( $order ) {
    if ( ! $order ) {
        return;
    }
    
    $order_id = $order->get_id();
    
    echo '<div class="enotary-customer-blocks">';
    
    // BLOCK 1: Сертификат ЭП
    enotary_display_certificate_block( $order );
    
    // BLOCK 2: Лицензии и ПО
    // enotary_display_software_block( $order );
    
    // BLOCK 3: Реферальные ссылки для расширений
    // ОТКЛЮЧЕНО: Клиент попросил убрать блок "Полезные ссылки для работы"
    // enotary_display_referral_links_block( $order );
    
    // BLOCK 4: Инструкции для УНЭП
    enotary_display_unep_instructions_block( $order );
    
    echo '</div>';
}

/**
 * БЛОК 1: Сертификат электронной подписи
 */
function enotary_display_certificate_block( $order ) {
    $certificate_file_id = $order->get_meta( '_certificate_file_id', true );
    $certificate_expiry = $order->get_meta( '_certificate_expiry_date', true );
    $order_status = $order->get_status();
    
    // Если есть файл сертификата
    if ( ! empty( $certificate_file_id ) ) {
        $file_url = wp_get_attachment_url( $certificate_file_id );
        $file_name = basename( get_attached_file( $certificate_file_id ) );
        
        // Проверяем срок действия
        $expiry_warning = '';
        $expiry_class = '';
        
        if ( ! empty( $certificate_expiry ) ) {
            try {
                $today = new DateTime( 'today' );
                $expiry_date = new DateTime( $certificate_expiry );
                $interval = $today->diff( $expiry_date );
                $days_left = (int) $interval->format( '%r%a' );
                
                $formatted_date = date_i18n( 'd.m.Y', strtotime( $certificate_expiry ) );
                
                if ( $days_left < 0 ) {
                    $expiry_warning = '<span class="expiry-expired">Срок истёк: ' . $formatted_date . '</span>';
                    $expiry_class = 'expired';
                } elseif ( $days_left <= 30 ) {
                    $expiry_warning = '<span class="expiry-warning">Срок действия до: ' . $formatted_date . ' (осталось ' . $days_left . ' дн.)</span>';
                    $expiry_class = 'warning';
                } else {
                    $expiry_warning = '<span class="expiry-ok">Срок действия до: ' . $formatted_date . '</span>';
                    $expiry_class = 'ok';
                }
            } catch ( Exception $e ) {
                $expiry_warning = '<span class="expiry-ok">Срок действия до: ' . esc_html( $certificate_expiry ) . '</span>';
            }
        }
        
        ?>
        <div class="enotary-info-block certificate-block <?php echo esc_attr( $expiry_class ); ?>">
            <h3>Ваш сертификат электронной подписи готов</h3>
            <?php if ( $expiry_warning ) : ?>
                <div class="certificate-expiry"><?php echo $expiry_warning; ?></div>
            <?php endif; ?>
            <p class="certificate-file">
                <strong>Файл:</strong> <?php echo esc_html( $file_name ); ?>
            </p>
            <a href="<?php echo esc_url( $file_url ); ?>" class="download-button" download>
                Скачать сертификат
            </a>
        </div>
        <?php
        
    } elseif ( in_array( $order_status, array( 'processing', 'completed' ) ) ) {
        // Заказ оплачен, но сертификат еще не выпущен
        ?>
        <div class="enotary-info-block pending-block">
            <h3>Сертификат находится в процессе выпуска</h3>
            <p>Ваши документы проверяются. Мы отправим уведомление на email, как только сертификат будет готов.</p>
            <p><small>Обычно это занимает 1-3 рабочих дня.</small></p>
        </div>
        <?php
    }
}

/**
 * БЛОК 2: Программное обеспечение и Лицензии
 */
function enotary_display_software_block( $order ) {
    $license_key = $order->get_meta( '_software_license_key', true );
    
    // Проверяем, куплен ли криптопровайдер или токен
    $has_software = false;
    $software_items = array();
    
    foreach ( $order->get_items() as $item ) {
        $product_name = $item->get_name();
        
        // Проверяем по ключевым словам
        if ( 
            stripos( $product_name, 'криптопровайдер' ) !== false ||
            stripos( $product_name, 'signal-com' ) !== false ||
            stripos( $product_name, 'криптопро' ) !== false ||
            stripos( $product_name, 'токен' ) !== false ||
            stripos( $product_name, 'рутокен' ) !== false ||
            stripos( $product_name, 'smarttoken' ) !== false
        ) {
            $has_software = true;
            $software_items[] = $product_name;
        }
    }
    
    if ( ! $has_software && empty( $license_key ) ) {
        return; // Не выводим блок, если нет ПО
    }
    
    ?>
    <div class="enotary-info-block software-block">
        <div class="block-icon"></div>
        <div class="block-content">
            <h3>Программное обеспечение и лицензии</h3>
            
            <?php if ( ! empty( $license_key ) ) : ?>
                <div class="license-keys" style="background: #f9fafb; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #375d74;">
                    <h4 style="margin-top: 0; color: #375d74;">Ваши лицензионные ключи</h4>
                    <pre style="background: white; padding: 12px; border-radius: 6px; overflow-x: auto; font-family: monospace; font-size: 13px; line-height: 1.6; border: 1px solid #e5e7eb;"><?php echo esc_html( $license_key ); ?></pre>
                    <p style="margin-bottom: 0;"><small>💡 Скопируйте эти ключи и сохраните в надежном месте.</small></p>
                </div>
            <?php endif; ?>
            
            <?php if ( $has_software ) : ?>
                <div class="software-items">
                    <p><strong>Приобретенное ПО:</strong></p>
                    <ul>
                        <?php foreach ( $software_items as $item_name ) : ?>
                            <li><?php echo esc_html( $item_name ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <div class="software-downloads">
                <h4>Полезные ссылки для скачивания:</h4>
                <ul class="download-links">
                    <?php 
                    // Получаем ссылки из настроек ACF
                    $driver_cryptopro = get_field('driver_cryptopro', 'option');
                    $driver_rutoken = get_field('driver_rutoken', 'option');
                    $distr_signalcom = get_field('distr_signalcom', 'option');
                    
                    // Выводим только заполненные ссылки
                    if ( $driver_cryptopro ) : ?>
                        <li>
                            <a href="<?php echo esc_url( $driver_cryptopro ); ?>" target="_blank" rel="noopener">
                                📥 Скачать КриптоПро CSP
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if ( $driver_rutoken ) : ?>
                        <li>
                            <a href="<?php echo esc_url( $driver_rutoken ); ?>" target="_blank" rel="noopener">
                                📥 Скачать драйверы Рутокен
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if ( $distr_signalcom ) : ?>
                        <li>
                            <a href="<?php echo esc_url( $distr_signalcom ); ?>" target="_blank" rel="noopener">
                                📥 Скачать Signal-COM
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php
}

/**
 * БЛОК 3: Реферальные ссылки для расширений (Росреестр, Федресурс и т.д.)
 */
function enotary_display_referral_links_block( $order ) {
    // Проверяем, куплены ли расширения
    $extensions = array();
    
    foreach ( $order->get_items() as $item ) {
        $product_name = $item->get_name();
        
        // Проверяем по названиям расширений
        if ( stripos( $product_name, 'росреестр' ) !== false ) {
            $extensions['rosreestr'] = 'Росреестр';
        }
        if ( stripos( $product_name, 'федресурс' ) !== false ) {
            $extensions['fedresurs'] = 'Федресурс';
        }
        if ( stripos( $product_name, 'b2b' ) !== false ) {
            $extensions['b2b'] = 'ЭТП B2B';
        }
        if ( stripos( $product_name, 'fabrikant' ) !== false ) {
            $extensions['fabrikant'] = 'ЭТП Fabrikant';
        }
    }
    
    if ( empty( $extensions ) ) {
        return; // Нет расширений - не выводим блок
    }
    
    ?>
    <div class="enotary-info-block referral-block">
        <h3>Полезные ссылки для работы</h3>
        <p>Вы приобрели расширения для следующих площадок:</p>
        
        <ul class="referral-links">
            <?php if ( isset( $extensions['rosreestr'] ) ) : ?>
                <li>
                    <strong>Росреестр:</strong> 
                    <a href="https://rosreestr.gov.ru/" target="_blank" rel="noopener">
                        Личный кабинет Росреестра
                    </a>
                </li>
            <?php endif; ?>
                
                <?php if ( isset( $extensions['fedresurs'] ) ) : ?>
                    <li>
                        <strong>Федресурс:</strong> 
                        <a href="https://fedresurs.ru/" target="_blank" rel="noopener">
                            Единый федеральный реестр сведений о банкротстве
                        </a>
                    </li>
                <?php endif; ?>
                
                <?php if ( isset( $extensions['b2b'] ) ) : ?>
                    <li>
                        <strong>ЭТП B2B:</strong> 
                        <a href="https://www.b2b-center.ru/" target="_blank" rel="noopener">
                            Электронная торговая площадка B2B-Center
                        </a>
                    </li>
                <?php endif; ?>
                
                <?php if ( isset( $extensions['fabrikant'] ) ) : ?>
                    <li>
                        <strong>ЭТП Fabrikant:</strong> 
                        <a href="https://fabrikant.ru/" target="_blank" rel="noopener">
                            Электронная торговая площадка Fabrikant
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            
            <p class="info-note">
                <small>💡 Используйте ваш сертификат ЭП для входа в личные кабинеты этих площадок.</small>
            </p>
    </div>
    <?php
}

/**
 * БЛОК 4: Инструкции для УНЭП и МЧД
 */
function enotary_display_unep_instructions_block( $order ) {
    // Проверяем, куплен ли УНЭП или МЧД
    $has_unep = false;
    $has_mchd = false;
    
    foreach ( $order->get_items() as $item ) {
        $product_name = $item->get_name();
        
        if ( 
            stripos( $product_name, 'унэп' ) !== false ||
            stripos( $product_name, 'неквалифицированный' ) !== false
        ) {
            $has_unep = true;
        }
        
        if ( 
            stripos( $product_name, 'мчд' ) !== false ||
            stripos( $product_name, 'машиночитаемая' ) !== false ||
            stripos( $product_name, 'доверенность' ) !== false
        ) {
            $has_mchd = true;
        }
    }
    
    // Если нет ни УНЭП, ни МЧД - не выводим блок
    if ( ! $has_unep && ! $has_mchd ) {
        return;
    }
    
    // Получаем инструкции из настроек ACF
    $instruction_unep = get_field('instruction_unep', 'option');
    $instruction_mchd = get_field('instruction_mchd', 'option');
    
    ?>
    <div class="enotary-info-block instructions-block">
        <h3>Инструкции</h3>
        
        <div class="instructions-downloads">
            <ul>
                <?php if ( $has_unep && $instruction_unep ) : ?>
                    <li>
                        <a href="<?php echo esc_url( $instruction_unep['url'] ); ?>" target="_blank" class="instruction-link" download>
                            📥 Инструкция: Формирование запроса (УНЭП)
                        </a>
                        <small><?php echo size_format( $instruction_unep['filesize'] ); ?></small>
                    </li>
                <?php endif; ?>
                
                <?php if ( $has_mchd && $instruction_mchd ) : ?>
                    <li>
                        <a href="<?php echo esc_url( $instruction_mchd['url'] ); ?>" target="_blank" class="instruction-link" download>
                            📥 Инструкция: Заказ МЧД
                        </a>
                        <small><?php echo size_format( $instruction_mchd['filesize'] ); ?></small>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        
        <p class="help-note">
            💬 Если у вас возникли вопросы, обратитесь в нашу <a href="tel:+74953633093">службу поддержки: +7 (495) 363-30-93</a>
        </p>
    </div>
    <?php
}

/**
 * ============================================
 * ПРИНУДИТЕЛЬНОЕ ИСПОЛЬЗОВАНИЕ КАСТОМНЫХ ШАБЛОНОВ
 * ============================================
 */

/**
 * Убедиться, что WooCommerce использует наши кастомные шаблоны
 */
function enotary_force_my_account_templates( $template, $template_name, $template_path ) {
    // Если это шаблон my-account
    if ( strpos( $template_name, 'myaccount/' ) === 0 ) {
        $custom_template = get_template_directory() . '/woocommerce/' . $template_name;
        
        // Если наш кастомный шаблон существует, используем его
        if ( file_exists( $custom_template ) ) {
            $template = $custom_template;
        }
    }
    
    return $template;
}
add_filter( 'woocommerce_locate_template', 'enotary_force_my_account_templates', 10, 3 );

/**
 * ============================================
 * ПОДКЛЮЧЕНИЕ СТИЛЕЙ ЛИЧНОГО КАБИНЕТА
 * ============================================
 */

/**
 * Подключить CSS файл для личного кабинета
 */
function enotary_enqueue_my_account_styles() {
    // Только на странице личного кабинета
    if ( is_account_page() ) {
        wp_enqueue_style( 
            'enotary-my-account', 
            get_template_directory_uri() . '/assets/my-account.css', 
            array( 'woocommerce-general', 'woocommerce-layout' ), // Загружаем ПОСЛЕ WooCommerce
            '1.0.1' 
        );
    }
}
add_action( 'wp_enqueue_scripts', 'enotary_enqueue_my_account_styles', 99 );

/**
 * ============================================
 * ОТКЛЮЧЕНИЕ НЕНУЖНЫХ СТИЛЕЙ WOOCOMMERCE
 * ============================================
 */

/**
 * Отключить некоторые стили WooCommerce на странице личного кабинета
 */
function enotary_dequeue_woocommerce_styles( $enqueue_styles ) {
    if ( is_account_page() ) {
        // Отключаем smallscreen стили WooCommerce
        unset( $enqueue_styles['woocommerce-smallscreen'] );
    }
    return $enqueue_styles;
}
add_filter( 'woocommerce_enqueue_styles', 'enotary_dequeue_woocommerce_styles' );

/**
 * ============================================
 * ФИЛЬТРАЦИЯ И ОЧИСТКА ЛИЧНОГО КАБИНЕТА
 * ============================================
 */

/**
 * Удалить ненужные пункты меню из личного кабинета
 * 
 * @param array $items Пункты меню личного кабинета
 * @return array Отфильтрованные пункты меню
 */
function enotary_filter_my_account_menu_items( $items ) {
    // Список элементов для удаления (можно настроить по необходимости)
    $items_to_remove = array(
        'downloads',       // Загрузки
        'edit-address',    // Адреса
        // 'payment-methods', // Способы оплаты (раскомментировать, если не нужны)
    );
    
    foreach ( $items_to_remove as $item ) {
        if ( isset( $items[ $item ] ) ) {
            unset( $items[ $item ] );
        }
    }
    
    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'enotary_filter_my_account_menu_items', 20 );

/**
 * Скрыть archive и другие элементы блога из личного кабинета
 * Убираем лишний контент, который может показываться на странице my-account
 */
function enotary_remove_archive_from_my_account() {
    // Если мы на странице личного кабинета WooCommerce
    if ( is_account_page() ) {
        // Удаляем хуки вывода архива постов
        remove_action( 'woocommerce_account_content', 'woocommerce_output_all_notices', 5 );
        
        // Отключаем sidebar на странице личного кабинета
        add_filter( 'woocommerce_show_page_title', '__return_false' );
        
        // Деактивируем все сайдбары и виджеты на странице ЛК
        unregister_sidebar( 'sidebar-1' );
        
        // Убираем вывод любых виджетов в футере для страницы ЛК
        remove_action( 'wp_footer', 'wp_print_footer_scripts', 20 );
    }
}
add_action( 'template_redirect', 'enotary_remove_archive_from_my_account' );

/**
 * Отключить все динамические сайдбары на странице личного кабинета
 */
function enotary_disable_sidebars_on_my_account( $sidebars_widgets ) {
    if ( is_account_page() ) {
        $sidebars_widgets = array();
    }
    return $sidebars_widgets;
}
add_filter( 'sidebars_widgets', 'enotary_disable_sidebars_on_my_account' );

/**
 * Убрать заголовок страницы "My Account" (он дублируется в нашем кастомном шаблоне)
 */
add_filter( 'woocommerce_account_menu_items', function( $items ) {
    // Оставляем только нужные пункты меню
    return $items;
}, 999 );

/**
 * Скрыть sidebar и другие элементы WordPress на странице личного кабинета
 */
function enotary_my_account_body_class( $classes ) {
    if ( is_account_page() ) {
        $classes[] = 'enotary-my-account-page';
        $classes[] = 'no-sidebar';
    }
    return $classes;
}
add_filter( 'body_class', 'enotary_my_account_body_class' );

/**
 * Добавить дополнительные CSS стили для скрытия лишних элементов и переопределения WooCommerce
 */
function enotary_my_account_inline_css() {
    if ( ! is_account_page() ) {
        return;
    }
    ?>
    <style>
        /* Скрываем архивы, сайдбар и другие элементы блога на странице ЛК */
        .enotary-my-account-page .widget_archive,
        .enotary-my-account-page .widget_categories,
        .enotary-my-account-page .widget_recent_entries,
        .enotary-my-account-page .widget_recent_comments,
        .enotary-my-account-page aside#secondary,
        .enotary-my-account-page .site-footer .widget-area,
        .enotary-my-account-page .sidebar,
        .is-account-page .widget_archive,
        .is-account-page .widget_categories,
        .is-account-page aside#secondary {
            display: none !important;
        }
        
        /* Убираем лишние отступы */
        .enotary-my-account-page .site-content {
            padding: 0 !important;
        }
        
        /* Динамический отступ сверху для ЛК под фиксированную шапку */
        .woocommerce-MyAccount-wrapper {
            padding-top: 130px !important;
        }
        
        @media (max-width: 1024px) {
            .woocommerce-MyAccount-wrapper {
                padding-top: 110px !important;
            }
        }
        
        @media (max-width: 768px) {
            .woocommerce-MyAccount-wrapper {
                padding-top: 90px !important;
            }
        }
    </style>
    <?php
}
add_action( 'wp_head', 'enotary_my_account_inline_css', 999 );