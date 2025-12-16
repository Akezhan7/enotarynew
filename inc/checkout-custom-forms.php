<?php
/**
 * Кастомные формы чекаута для разных типов плательщиков
 * 
 * Обрабатывает динамическое отображение форм и фильтрацию методов оплаты
 * в зависимости от типа лица (ФЛ, ИП, ЮЛ)
 * 
 * @package enotarynew
 */

// Запретить прямой доступ
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ============================================
 * ОТКЛЮЧЕНИЕ СТАНДАРТНЫХ ПОЛЕЙ WOOCOMMERCE
 * ============================================
 */

/**
 * Полное управление полями чекаута
 * Убираем стандартные поля и добавляем кастомные
 */
add_filter( 'woocommerce_checkout_fields', 'enotary_customize_checkout_fields', 9999 );

function enotary_customize_checkout_fields( $fields ) {
    // Проверка что WooCommerce активен
    if ( ! function_exists( 'WC' ) || ! WC()->session ) {
        return $fields;
    }
    
    $payer_type = WC()->session->get( 'active_payer_type' );
    
    // НЕ очищаем полностью, а оставляем базовые поля для совместимости
    // Скрываем ненужные стандартные поля через CSS класс
    
    // Базовые обязательные поля для WooCommerce (минимум)
    $fields['billing']['billing_first_name'] = array(
        'type'     => 'text',
        'label'    => 'ФИО',
        'required' => true,
        'class'    => array( 'form-row-wide', 'enotary-hidden-field' ),
        'priority' => 10,
    );
    
    $fields['billing']['billing_email'] = array(
        'type'     => 'email',
        'label'    => 'Email',
        'required' => true,
        'class'    => array( 'form-row-wide', 'enotary-hidden-field' ),
        'priority' => 20,
    );
    
    $fields['billing']['billing_phone'] = array(
        'type'     => 'tel',
        'label'    => 'Телефон',
        'required' => true,
        'class'    => array( 'form-row-wide', 'enotary-hidden-field' ),
        'priority' => 30,
    );
    
    // Скрытые обязательные для WC (для валидации)
    $fields['billing']['billing_country'] = array(
        'type'     => 'text',
        'default'  => 'RU',
        'required' => false,
        'class'    => array( 'enotary-hidden-field' ),
    );
    
    $fields['billing']['billing_address_1'] = array(
        'type'     => 'text',
        'required' => false,
        'class'    => array( 'enotary-hidden-field' ),
    );
    
    $fields['billing']['billing_city'] = array(
        'type'     => 'text',
        'required' => false,
        'class'    => array( 'enotary-hidden-field' ),
    );
    
    $fields['billing']['billing_postcode'] = array(
        'type'     => 'text',
        'required' => false,
        'class'    => array( 'enotary-hidden-field' ),
    );
    
    // Отключаем поля, которые WooCommerce требует по умолчанию, но мы не используем
    $fields['billing']['billing_last_name'] = array(
        'type'     => 'text',
        'required' => false,
        'class'    => array( 'enotary-hidden-field' ),
    );
    
    $fields['billing']['billing_state'] = array(
        'type'     => 'text',
        'required' => false,
        'class'    => array( 'enotary-hidden-field' ),
    );
    
    // Добавляем кастомные поля в зависимости от типа лица
    if ( $payer_type === 'individual' ) {
        $fields['billing']['billing_inn'] = array(
            'type'     => 'text',
            'label'    => 'ИНН (физ. лица)',
            'required' => false,
            'priority' => 100,
        );
        $fields['billing']['billing_passport_address'] = array(
            'type'     => 'text',
            'label'    => 'Адрес (по паспорту)',
            'required' => true,
            'priority' => 110,
        );
        $fields['billing']['billing_postcode_custom'] = array(
            'type'     => 'text',
            'label'    => 'Почтовый индекс',
            'required' => false,
            'priority' => 120,
        );
    } elseif ( $payer_type === 'entrepreneur' ) {
        $fields['billing']['billing_inn'] = array(
            'type'     => 'text',
            'label'    => 'ИНН',
            'required' => true,
            'priority' => 100,
        );
        $fields['billing']['billing_passport_address'] = array(
            'type'     => 'text',
            'label'    => 'Адрес (по паспорту)',
            'required' => true,
            'priority' => 110,
        );
        $fields['billing']['billing_postcode_custom'] = array(
            'type'     => 'text',
            'label'    => 'Почтовый индекс',
            'required' => false,
            'priority' => 120,
        );
    } elseif ( $payer_type === 'legal' ) {
        $fields['billing']['billing_company'] = array(
            'type'     => 'text',
            'label'    => 'Наименование юр. лица',
            'required' => true,
            'priority' => 90,
        );
        $fields['billing']['billing_inn'] = array(
            'type'     => 'text',
            'label'    => 'ИНН (юр. лица)',
            'required' => true,
            'priority' => 100,
        );
        $fields['billing']['billing_kpp'] = array(
            'type'     => 'text',
            'label'    => 'КПП',
            'required' => true,
            'priority' => 110,
        );
        $fields['billing']['billing_okpo'] = array(
            'type'     => 'text',
            'label'    => 'ОКПО',
            'required' => false,
            'priority' => 120,
        );
        $fields['billing']['billing_legal_address'] = array(
            'type'     => 'text',
            'label'    => 'Юридический адрес',
            'required' => true,
            'priority' => 130,
        );
        $fields['billing']['billing_postcode_custom'] = array(
            'type'     => 'text',
            'label'    => 'Почтовый индекс',
            'required' => false,
            'priority' => 140,
        );
    }
    
    // Удаляем shipping поля (доставка не нужна)
    $fields['shipping'] = array();
    
    // Удаляем поле заметок к заказу
    if ( isset( $fields['order']['order_comments'] ) ) {
        unset( $fields['order']['order_comments'] );
    }
    
    return $fields;
}

/**
 * ============================================
 * СКРЫТИЕ НЕНУЖНЫХ ЭЛЕМЕНТОВ ЧЕКАУТА
 * ============================================
 */

/**
 * Убираем купоны с чекаута
 */
add_filter( 'woocommerce_coupons_enabled', 'enotary_disable_coupons_on_checkout' );
function enotary_disable_coupons_on_checkout( $enabled ) {
    if ( is_checkout() ) {
        return false;
    }
    return $enabled;
}

/**
 * Убираем блок доставки полностью
 */
add_filter( 'woocommerce_cart_needs_shipping', '__return_false' );

/**
 * Убираем заметки к заказу
 */
add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );

/**
 * Убираем дополнительные поля
 */
add_filter( 'woocommerce_checkout_fields', 'enotary_remove_checkout_additional_fields', 10000 );
function enotary_remove_checkout_additional_fields( $fields ) {
    // Удаляем все дополнительные поля
    unset( $fields['order'] );
    return $fields;
}

/**
 * ============================================
 * ОТКЛЮЧЕНИЕ WOOCOMMERCE BLOCKS НА ЧЕКАУТЕ
 * ============================================
 */

/**
 * Принудительно отключаем WooCommerce Blocks на чекауте
 */
add_filter( 'woocommerce_checkout_block_enabled', '__return_false', 999 );

/**
 * Отключаем Blocks на странице чекаута
 */
function enotary_disable_wc_blocks_checkout( $content ) {
    if ( is_checkout() && ! is_wc_endpoint_url() ) {
        // Заменяем блоки на классический шорткод
        if ( has_block( 'woocommerce/checkout', $content ) ) {
            $content = '[woocommerce_checkout]';
        }
    }
    return $content;
}
add_filter( 'the_content', 'enotary_disable_wc_blocks_checkout', 1 );

/**
 * Передаем данные полей в JavaScript для совместимости
 */
function enotary_localize_checkout_fields() {
    if ( ! is_checkout() || ! function_exists( 'WC' ) ) {
        return;
    }
    
    $checkout = WC()->checkout();
    $fields = $checkout->get_checkout_fields();
    
    wp_localize_script( 'wc-checkout', 'checkout_fields', array(
        'billing' => isset( $fields['billing'] ) ? $fields['billing'] : array(),
        'shipping' => isset( $fields['shipping'] ) ? $fields['shipping'] : array(),
        'additional-information' => isset( $fields['order'] ) ? $fields['order'] : array(),
        'contact' => array(),
    ) );
}
add_action( 'wp_enqueue_scripts', 'enotary_localize_checkout_fields', 999 );

/**
 * ============================================
 * МЕХАНИЗМ 1: Обязательная регистрация
 * ============================================
 */

/**
 * Принудительная регистрация перед чекаутом
 * 
 * Редиректит незалогиненных пользователей на страницу входа
 * с передачей URL возврата через GET параметр
 */
add_action( 'template_redirect', 'enotary_force_login_before_checkout' );

function enotary_force_login_before_checkout() {
    // Проверка: это страница чекаута?
    if ( is_checkout() && ! is_user_logged_in() && ! is_wc_endpoint_url( 'order-received' ) ) {
        // Получаем URL чекаута для возврата
        $checkout_url = wc_get_checkout_url();
        
        // Редирект на страницу my-account с параметром redirect_to
        $login_url = add_query_arg( 'redirect_to', urlencode( $checkout_url ), wc_get_page_permalink( 'myaccount' ) );
        wp_redirect( $login_url );
        exit;
    }
}

/**
 * Редирект на чекаут после успешного входа
 */
add_filter( 'woocommerce_login_redirect', 'enotary_redirect_after_login', 10, 2 );

function enotary_redirect_after_login( $redirect, $user ) {
    // Эта функция не будет вызываться для template-login.php
    // Оставляем для совместимости с WooCommerce формами, если они используются где-то еще
    if ( isset( $_REQUEST['redirect_to'] ) && ! empty( $_REQUEST['redirect_to'] ) ) {
        $redirect_to = esc_url_raw( urldecode( $_REQUEST['redirect_to'] ) );
        if ( strpos( $redirect_to, 'checkout' ) !== false ) {
            return $redirect_to;
        }
    }
    return $redirect;
}

/**
 * Редирект на чекаут после успешной регистрации
 */
add_filter( 'woocommerce_registration_redirect', 'enotary_redirect_after_registration', 10, 1 );

function enotary_redirect_after_registration( $redirect ) {
    // Эта функция не будет вызываться для template-register.php
    // Оставляем для совместимости с WooCommerce формами, если они используются где-то еще
    if ( isset( $_REQUEST['redirect_to'] ) && ! empty( $_REQUEST['redirect_to'] ) ) {
        $redirect_to = esc_url_raw( urldecode( $_REQUEST['redirect_to'] ) );
        if ( strpos( $redirect_to, 'checkout' ) !== false ) {
            return $redirect_to;
        }
    }
    return $redirect;
}

/**
 * ============================================
 * МЕХАНИЗМ 2: Фильтр методов оплаты
 * ============================================
 */

/**
 * Фильтрация доступных способов оплаты по типу лица
 * 
 * Логика:
 * - ЮЛ (legal) → только bacs (Счет на оплату)
 * - ФЛ/ИП (individual/entrepreneur) → cheque (Чековые платежи) + robokassa (когда будет готова)
 * 
 * @param array $gateways Доступные платежные шлюзы
 * @return array Отфильтрованные шлюзы
 */
add_filter( 'woocommerce_available_payment_gateways', 'enotary_filter_payment_gateways' );

function enotary_filter_payment_gateways( $gateways ) {
    // Проверка что WooCommerce активен
    if ( ! function_exists( 'WC' ) || ! WC()->session ) {
        return $gateways;
    }
    
    // Считать тип лица из сессии
    $payer_type = WC()->session->get( 'active_payer_type' );
    
    // Если тип не определен - показываем всё (фоллбэк)
    if ( empty( $payer_type ) ) {
        return $gateways;
    }
    
    // Юрлицо - ТОЛЬКО счет (bacs)
    if ( $payer_type === 'legal' ) {
        foreach ( $gateways as $key => $gateway ) {
            // Скрыть всё кроме bacs
            if ( $key !== 'bacs' ) {
                unset( $gateways[ $key ] );
            }
        }
    }
    
    // ФЛ и ИП - чековые платежи (cheque) + robokassa
    elseif ( $payer_type === 'individual' || $payer_type === 'entrepreneur' ) {
        foreach ( $gateways as $key => $gateway ) {
            // Оставляем только cheque и robokassa для физ. лиц и ИП
            if ( $key !== 'cheque' && $key !== 'robokassa' ) {
                unset( $gateways[ $key ] );
            }
        }
    }
    
    return $gateways;
}

/**
 * ============================================
 * МЕХАНИЗМ 4: Сохранение кастомных полей
 * ============================================
 */

/**
 * Сохранение кастомных полей в мета-данные заказа
 * 
 * @param int $order_id ID заказа
 */
add_action( 'woocommerce_checkout_update_order_meta', 'enotary_save_custom_checkout_fields' );

function enotary_save_custom_checkout_fields( $order_id ) {
    // Получаем объект заказа
    $order = wc_get_order( $order_id );
    
    if ( ! $order ) {
        return;
    }
    
    // Проверка что WooCommerce активен
    if ( ! function_exists( 'WC' ) || ! WC()->session ) {
        return;
    }
    
    $payer_type = WC()->session->get( 'active_payer_type' );
    $payer_type_label = WC()->session->get( 'payer_type_label' );
    
    // Сохранить тип лица (ВАЖНО: используем _active_payer_type для совместимости с админкой)
    if ( ! empty( $payer_type ) ) {
        $order->update_meta_data( '_active_payer_type', sanitize_text_field( $payer_type ) );
    }
    
    if ( ! empty( $payer_type_label ) ) {
        $order->update_meta_data( '_payer_type_label', sanitize_text_field( $payer_type_label ) );
    }
    
    // Список всех возможных кастомных полей
    $custom_fields = array(
        'billing_inn',
        'billing_kpp',
        'billing_okpo',
        'billing_legal_address',
        'billing_company',
        'billing_passport_address',
        'billing_postcode_custom',
    );
    
    // Сохранение каждого поля если оно заполнено
    foreach ( $custom_fields as $field ) {
        if ( isset( $_POST[ $field ] ) && ! empty( $_POST[ $field ] ) ) {
            $order->update_meta_data( '_' . $field, sanitize_text_field( $_POST[ $field ] ) );
        }
    }
    
    // Сохраняем все изменения
    $order->save();
}

/**
 * Отображение кастомных полей в админке заказа
 * 
 * @param WC_Order $order Объект заказа
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'enotary_display_custom_fields_in_admin', 10, 1 );

function enotary_display_custom_fields_in_admin( $order ) {
    $order_id = $order->get_id();
    
    // Получить кастомные поля
    $inn = get_post_meta( $order_id, '_billing_inn', true );
    $kpp = get_post_meta( $order_id, '_billing_kpp', true );
    $okpo = get_post_meta( $order_id, '_billing_okpo', true );
    $legal_address = get_post_meta( $order_id, '_billing_legal_address', true );
    $company_name = get_post_meta( $order_id, '_billing_company', true );
    $passport_address = get_post_meta( $order_id, '_billing_passport_address', true );
    $postcode_custom = get_post_meta( $order_id, '_billing_postcode_custom', true );
    
    // Вывести блок если есть хотя бы одно заполненное поле
    if ( $inn || $kpp || $okpo || $legal_address || $company_name || $passport_address || $postcode_custom ) {
        echo '<div class="enotary-custom-fields" style="margin-top: 15px; padding: 10px; background: #f0f0f1; border-left: 3px solid #2271b1;">';
        echo '<h3 style="margin-top: 0;">Дополнительные реквизиты</h3>';
        
        if ( $company_name ) {
            echo '<p><strong>Наименование юр. лица:</strong> ' . esc_html( $company_name ) . '</p>';
        }
        if ( $inn ) {
            echo '<p><strong>ИНН:</strong> ' . esc_html( $inn ) . '</p>';
        }
        if ( $kpp ) {
            echo '<p><strong>КПП:</strong> ' . esc_html( $kpp ) . '</p>';
        }
        if ( $okpo ) {
            echo '<p><strong>ОКПО:</strong> ' . esc_html( $okpo ) . '</p>';
        }
        if ( $legal_address ) {
            echo '<p><strong>Юридический адрес:</strong> ' . esc_html( $legal_address ) . '</p>';
        }
        if ( $passport_address ) {
            echo '<p><strong>Адрес (по паспорту):</strong> ' . esc_html( $passport_address ) . '</p>';
        }
        if ( $postcode_custom ) {
            echo '<p><strong>Почтовый индекс:</strong> ' . esc_html( $postcode_custom ) . '</p>';
        }
        
        echo '</div>';
    }
}

/**
 * Отображение кастомных полей в email уведомлениях
 * 
 * @param WC_Order $order Объект заказа
 * @param bool $sent_to_admin Отправлено админу
 * @param bool $plain_text Простой текст
 */
add_action( 'woocommerce_email_after_order_table', 'enotary_add_custom_fields_to_emails', 10, 3 );

function enotary_add_custom_fields_to_emails( $order, $sent_to_admin, $plain_text ) {
    $order_id = $order->get_id();
    
    // Получить кастомные поля
    $inn = get_post_meta( $order_id, '_billing_inn', true );
    $kpp = get_post_meta( $order_id, '_billing_kpp', true );
    $company_name = get_post_meta( $order_id, '_billing_company', true );
    $legal_address = get_post_meta( $order_id, '_billing_legal_address', true );
    $passport_address = get_post_meta( $order_id, '_billing_passport_address', true );
    
    if ( $inn || $kpp || $company_name || $legal_address || $passport_address ) {
        if ( $plain_text ) {
            echo "\n\nДополнительные реквизиты:\n";
            if ( $company_name ) echo "Наименование юр. лица: $company_name\n";
            if ( $inn ) echo "ИНН: $inn\n";
            if ( $kpp ) echo "КПП: $kpp\n";
            if ( $legal_address ) echo "Юридический адрес: $legal_address\n";
            if ( $passport_address ) echo "Адрес (по паспорту): $passport_address\n";
        } else {
            echo '<h2>Дополнительные реквизиты</h2><ul>';
            if ( $company_name ) echo '<li><strong>Наименование юр. лица:</strong> ' . esc_html( $company_name ) . '</li>';
            if ( $inn ) echo '<li><strong>ИНН:</strong> ' . esc_html( $inn ) . '</li>';
            if ( $kpp ) echo '<li><strong>КПП:</strong> ' . esc_html( $kpp ) . '</li>';
            if ( $legal_address ) echo '<li><strong>Юридический адрес:</strong> ' . esc_html( $legal_address ) . '</li>';
            if ( $passport_address ) echo '<li><strong>Адрес (по паспорту):</strong> ' . esc_html( $passport_address ) . '</li>';
            echo '</ul>';
        }
    }
}

/**
 * Автозаполнение скрытых обязательных полей
 * 
 * Заполняет пустые служебные поля дефолтными значениями
 * чтобы избежать блокировки заказа при отключенном debug-режиме
 * 
 * @param array $data Данные чекаута
 * @param WP_Error $errors Объект ошибок
 */
add_action( 'woocommerce_after_checkout_validation', 'enotary_autofill_hidden_fields', 5, 2 );

function enotary_autofill_hidden_fields( $data, $errors ) {
    // Автозаполнение billing_last_name из billing_first_name
    if ( empty( $_POST['billing_last_name'] ) && ! empty( $_POST['billing_first_name'] ) ) {
        $_POST['billing_last_name'] = sanitize_text_field( $_POST['billing_first_name'] );
    }
    
    // Автозаполнение billing_state (область/регион)
    if ( empty( $_POST['billing_state'] ) ) {
        $_POST['billing_state'] = 'RU';
    }
    
    // Автозаполнение billing_address_1 из passport_address или legal_address
    if ( empty( $_POST['billing_address_1'] ) ) {
        if ( ! empty( $_POST['billing_passport_address'] ) ) {
            $_POST['billing_address_1'] = sanitize_text_field( $_POST['billing_passport_address'] );
        } elseif ( ! empty( $_POST['billing_legal_address'] ) ) {
            $_POST['billing_address_1'] = sanitize_text_field( $_POST['billing_legal_address'] );
        } else {
            $_POST['billing_address_1'] = 'Не указан';
        }
    }
    
    // Автозаполнение billing_city
    if ( empty( $_POST['billing_city'] ) ) {
        $_POST['billing_city'] = 'Москва';
    }
    
    // Автозаполнение billing_postcode из billing_postcode_custom
    if ( empty( $_POST['billing_postcode'] ) && ! empty( $_POST['billing_postcode_custom'] ) ) {
        $_POST['billing_postcode'] = sanitize_text_field( $_POST['billing_postcode_custom'] );
    } elseif ( empty( $_POST['billing_postcode'] ) ) {
        $_POST['billing_postcode'] = '000000';
    }
    
    // Автозаполнение billing_country
    if ( empty( $_POST['billing_country'] ) ) {
        $_POST['billing_country'] = 'RU';
    }
}

/**
 * Валидация кастомных полей при оформлении заказа
 * 
 * @param array $data Данные чекаута
 * @param WP_Error $errors Объект ошибок
 */
add_action( 'woocommerce_after_checkout_validation', 'enotary_validate_custom_checkout_fields', 10, 2 );

function enotary_validate_custom_checkout_fields( $data, $errors ) {
    // Проверка ИНН (если заполнен)
    if ( isset( $_POST['billing_inn'] ) && ! empty( $_POST['billing_inn'] ) ) {
        $inn = sanitize_text_field( $_POST['billing_inn'] );
        
        // ИНН должен содержать от 10 до 12 цифр
        if ( ! preg_match( '/^\d{10,12}$/', $inn ) ) {
            $errors->add( 'validation', 'ИНН должен содержать от 10 до 12 цифр.' );
        }
    }
    
    // Проверка КПП (если заполнен)
    if ( isset( $_POST['billing_kpp'] ) && ! empty( $_POST['billing_kpp'] ) ) {
        $kpp = sanitize_text_field( $_POST['billing_kpp'] );
        
        // КПП должен содержать 9 цифр
        if ( ! preg_match( '/^\d{9}$/', $kpp ) ) {
            $errors->add( 'validation', 'КПП должен содержать 9 цифр.' );
        }
    }
    
    // Проверка ОКПО (если заполнен)
    if ( isset( $_POST['billing_okpo'] ) && ! empty( $_POST['billing_okpo'] ) ) {
        $okpo = sanitize_text_field( $_POST['billing_okpo'] );
        
        // ОКПО должен содержать от 8 до 12 цифр
        if ( ! preg_match( '/^\d{8,12}$/', $okpo ) ) {
            $errors->add( 'validation', 'ОКПО должен содержать от 8 до 12 цифр.' );
        }
    }
    
    // Проверка почтового индекса (если заполнен)
    if ( isset( $_POST['billing_postcode_custom'] ) && ! empty( $_POST['billing_postcode_custom'] ) ) {
        $postcode = sanitize_text_field( $_POST['billing_postcode_custom'] );
        
        // Индекс должен содержать 6 цифр
        if ( ! preg_match( '/^\d{6}$/', $postcode ) ) {
            $errors->add( 'validation', 'Почтовый индекс должен содержать 6 цифр.' );
        }
    }
}

/**
 * ============================================
 * РЕФЕРАЛЬНАЯ СИСТЕМА НА THANK YOU PAGE (ТЗ п.229)
 * ============================================
 * 
 * "Если выполнен заказ УКЭП ФЛ и ИП, проверить оплату и 
 * вывести форму с реферальными ссылками"
 */

/**
 * Вывод реферального блока на странице благодарности
 */
add_action( 'woocommerce_thankyou', 'enotary_display_referral_block', 20 );

function enotary_display_referral_block( $order_id ) {
    // Проверяем условия показа блока
    if ( ! enotary_should_show_referral_block( $order_id ) ) {
        return;
    }
    
    // Получаем контент из ACF
    $referral_title = get_field( 'referral_title', 'option' );
    $referral_content = get_field( 'referral_content', 'option' );
    
    // Если контент не заполнен - не показываем
    if ( empty( $referral_content ) ) {
        return;
    }
    
    // Устанавливаем заголовок по умолчанию если не задан
    if ( empty( $referral_title ) ) {
        $referral_title = 'Полезные сервисы для вас';
    }
    
    ?>
    <!-- Реферальный блок (ТЗ п.229) -->
    <div class="enotary-referral-block responsive-container mt-6 sm:mt-8">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-[rgba(55,93,116,0.1)] rounded-[12px] sm:rounded-[15px] lg:rounded-[20px] shadow-[0_10px_40px_rgba(0,0,0,0.06)] px-4 sm:px-5 lg:px-6 py-5 sm:py-6 lg:py-7">
            
            <!-- Заголовок блока -->
            <div class="flex items-center gap-3 mb-4 sm:mb-5">
                <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-primary/10 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-[#262626]">
                    <?php echo esc_html( $referral_title ); ?>
                </h3>
            </div>
            
            <!-- Контент с реферальными ссылками -->
            <div class="referral-content text-[14px] sm:text-[15px] text-[#333] leading-relaxed">
                <?php echo wp_kses_post( $referral_content ); ?>
            </div>
            
        </div>
    </div>
    
    <style>
        /* Стили для реферального блока */
        .enotary-referral-block .referral-content a {
            color: #375d74;
            font-weight: 600;
            text-decoration: underline;
            transition: opacity 0.2s;
        }
        .enotary-referral-block .referral-content a:hover {
            opacity: 0.7;
        }
        .enotary-referral-block .referral-content img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 15px 0;
        }
        .enotary-referral-block .referral-content ul,
        .enotary-referral-block .referral-content ol {
            padding-left: 20px;
            margin: 15px 0;
        }
        .enotary-referral-block .referral-content li {
            margin-bottom: 8px;
        }
    </style>
    <?php
}

/**
 * Проверка условий показа реферального блока
 * 
 * Условия (ТЗ п.229):
 * 1. Заказ содержит товары УКЭП
 * 2. Тип плательщика - ФЛ или ИП (НЕ ЮЛ)
 * 3. Заказ оформлен (on-hold, processing или completed)
 */
function enotary_should_show_referral_block( $order_id ) {
    if ( ! $order_id ) {
        return false;
    }
    
    $order = wc_get_order( $order_id );
    if ( ! $order ) {
        return false;
    }
    
    // Проверка 1: Заказ должен быть оформлен (включая "На удержании")
    $allowed_statuses = array( 'on-hold', 'processing', 'completed' );
    if ( ! $order->has_status( $allowed_statuses ) ) {
        return false;
    }
    
    // Проверка 2: Тип плательщика должен быть ФЛ или ИП (НЕ ЮЛ)
    $payer_type = $order->get_meta( '_active_payer_type', true );
    
    // Если нет мета-поля, пробуем определить по методу оплаты
    if ( empty( $payer_type ) ) {
        $payment_method = $order->get_payment_method();
        // bacs = Банковский перевод = Только ЮЛ
        // Значит все остальные = ФЛ или ИП
        if ( $payment_method === 'bacs' ) {
            return false; // Это ЮЛ
        }
    } else {
        // Если мета есть, проверяем точно
        if ( $payer_type === 'legal' ) {
            return false; // Это ЮЛ
        }
    }
    
    // Проверка 3: Заказ должен содержать товары УКЭП
    $has_ukep = enotary_order_has_ukep( $order );
    if ( ! $has_ukep ) {
        return false;
    }
    
    return true;
}

/**
 * Проверяет, содержит ли заказ товары УКЭП
 */
function enotary_order_has_ukep( $order ) {
    foreach ( $order->get_items() as $item ) {
        $product = $item->get_product();
        
        // Проверяем по названию товара
        $product_name = $item->get_name();
        if ( 
            stripos( $product_name, 'укэп' ) !== false ||
            stripos( $product_name, 'квалифицированн' ) !== false ||
            stripos( $product_name, 'кэп' ) !== false
        ) {
            return true;
        }
        
        // Проверяем по категориям товара
        if ( $product ) {
            $categories = wp_get_post_terms( $product->get_id(), 'product_cat', array( 'fields' => 'slugs' ) );
            if ( ! is_wp_error( $categories ) ) {
                foreach ( $categories as $cat_slug ) {
                    if ( 
                        strpos( $cat_slug, 'kvalificzirovannye' ) !== false ||
                        strpos( $cat_slug, 'ukep' ) !== false ||
                        strpos( $cat_slug, 'kep' ) !== false
                    ) {
                        return true;
                    }
                }
            }
        }
    }
    
    return false;
}
