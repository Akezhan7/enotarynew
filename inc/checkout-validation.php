<?php
/**
 * Серверная валидация форм чекаута
 * 
 * Дополнительная проверка данных на стороне сервера
 * для обеспечения безопасности и целостности данных
 * 
 * @package enotarynew
 */

// Запретить прямой доступ
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ============================================
 * ВАЛИДАЦИЯ ПРИ ОФОРМЛЕНИИ ЗАКАЗА
 * ============================================
 */

/**
 * Проверка обязательных полей и форматов
 */
add_action( 'woocommerce_checkout_process', 'enotary_validate_checkout_fields' );

function enotary_validate_checkout_fields() {
    // Получаем тип плательщика
    $payer_type = WC()->session->get( 'active_payer_type', 'individual' );
    
    // Общие обязательные поля для всех типов
    enotary_validate_required_field( 'billing_first_name', 'ФИО' );
    enotary_validate_required_field( 'billing_email', 'Email' );
    enotary_validate_required_field( 'billing_phone', 'Телефон' );
    
    // Валидация формата email
    if ( ! empty( $_POST['billing_email'] ) ) {
        if ( ! is_email( $_POST['billing_email'] ) ) {
            wc_add_notice( 'Введите корректный email адрес', 'error' );
        }
    }
    
    // Валидация телефона (должен содержать 11 цифр)
    if ( ! empty( $_POST['billing_phone'] ) ) {
        $phone_digits = preg_replace( '/\D/', '', $_POST['billing_phone'] );
        if ( strlen( $phone_digits ) !== 11 ) {
            wc_add_notice( 'Номер телефона должен содержать 11 цифр', 'error' );
        }
    }
    
    // Валидация ФИО (минимум 2 слова)
    if ( ! empty( $_POST['billing_first_name'] ) ) {
        $name_parts = preg_split( '/\s+/', trim( $_POST['billing_first_name'] ) );
        $name_parts = array_filter( $name_parts );
        
        if ( count( $name_parts ) < 2 ) {
            wc_add_notice( 'Введите ФИО полностью (минимум 2 слова)', 'error' );
        }
    }
    
    // Специфичная валидация для каждого типа плательщика
    switch ( $payer_type ) {
        case 'individual':
            enotary_validate_individual_fields();
            break;
            
        case 'entrepreneur':
            enotary_validate_entrepreneur_fields();
            break;
            
        case 'legal':
            enotary_validate_legal_fields();
            break;
    }
    
    // Проверка согласия на обработку персональных данных
    if ( empty( $_POST['personal_data_consent'] ) ) {
        wc_add_notice( 'Необходимо дать согласие на обработку персональных данных', 'error' );
    }
}

/**
 * Валидация полей физического лица
 */
function enotary_validate_individual_fields() {
    // ИНН физического лица (10 или 12 цифр) - ОБЯЗАТЕЛЬНОЕ
    enotary_validate_required_field( 'billing_inn', 'ИНН' );
    
    if ( ! empty( $_POST['billing_inn'] ) ) {
        $inn = preg_replace( '/\D/', '', $_POST['billing_inn'] );
        if ( strlen( $inn ) !== 10 && strlen( $inn ) !== 12 ) {
            wc_add_notice( 'ИНН физического лица должен содержать 10 или 12 цифр', 'error' );
        }
    }
    
    // Адрес по паспорту - ОБЯЗАТЕЛЬНОЕ
    enotary_validate_required_field( 'billing_passport_address', 'Адрес по паспорту' );
    
    if ( ! empty( $_POST['billing_passport_address'] ) ) {
        if ( strlen( trim( $_POST['billing_passport_address'] ) ) < 5 ) {
            wc_add_notice( 'Адрес должен содержать минимум 5 символов', 'error' );
        }
    }
    
    // Почтовый индекс (6 цифр) - ОБЯЗАТЕЛЬНОЕ
    enotary_validate_required_field( 'billing_postcode_custom', 'Почтовый индекс' );
    
    if ( ! empty( $_POST['billing_postcode_custom'] ) ) {
        $postcode = preg_replace( '/\D/', '', $_POST['billing_postcode_custom'] );
        if ( strlen( $postcode ) !== 6 ) {
            wc_add_notice( 'Почтовый индекс должен содержать 6 цифр', 'error' );
        }
    }
}

/**
 * Валидация полей индивидуального предпринимателя
 */
function enotary_validate_entrepreneur_fields() {
    // ИНН ИП (10 или 12 цифр) - ОБЯЗАТЕЛЬНОЕ
    enotary_validate_required_field( 'billing_inn', 'ИНН' );
    
    if ( ! empty( $_POST['billing_inn'] ) ) {
        $inn = preg_replace( '/\D/', '', $_POST['billing_inn'] );
        if ( strlen( $inn ) !== 10 && strlen( $inn ) !== 12 ) {
            wc_add_notice( 'ИНН ИП должен содержать 10 или 12 цифр', 'error' );
        }
    }
    
    // Адрес (по паспорту) - ОБЯЗАТЕЛЬНОЕ (минимум 5 символов)
    enotary_validate_required_field( 'billing_passport_address', 'Адрес (по паспорту)' );
    
    if ( ! empty( $_POST['billing_passport_address'] ) ) {
        if ( strlen( trim( $_POST['billing_passport_address'] ) ) < 5 ) {
            wc_add_notice( 'Адрес должен содержать минимум 5 символов', 'error' );
        }
    }
    
    // Почтовый индекс (6 цифр) - ОБЯЗАТЕЛЬНОЕ
    enotary_validate_required_field( 'billing_postcode_custom', 'Почтовый индекс' );
    
    if ( ! empty( $_POST['billing_postcode_custom'] ) ) {
        $postcode = preg_replace( '/\D/', '', $_POST['billing_postcode_custom'] );
        if ( strlen( $postcode ) !== 6 ) {
            wc_add_notice( 'Почтовый индекс должен содержать 6 цифр', 'error' );
        }
    }
}

/**
 * Валидация полей юридического лица
 */
function enotary_validate_legal_fields() {
    // Название компании (обязательное, минимум 3 символа)
    enotary_validate_required_field( 'billing_company', 'Название компании' );
    
    if ( ! empty( $_POST['billing_company'] ) ) {
        if ( strlen( trim( $_POST['billing_company'] ) ) < 3 ) {
            wc_add_notice( 'Название компании должно содержать минимум 3 символа', 'error' );
        }
    }
    
    // ИНН юридического лица (10 цифр)
    enotary_validate_required_field( 'billing_inn', 'ИНН' );
    
    if ( ! empty( $_POST['billing_inn'] ) ) {
        $inn = preg_replace( '/\D/', '', $_POST['billing_inn'] );
        if ( strlen( $inn ) !== 10 ) {
            wc_add_notice( 'ИНН юридического лица должен содержать 10 цифр', 'error' );
        }
    }
    
    // КПП (обязательное, 9 цифр)
    enotary_validate_required_field( 'billing_kpp', 'КПП' );
    
    if ( ! empty( $_POST['billing_kpp'] ) ) {
        $kpp = preg_replace( '/\D/', '', $_POST['billing_kpp'] );
        if ( strlen( $kpp ) !== 9 ) {
            wc_add_notice( 'КПП должен содержать 9 цифр', 'error' );
        }
    }
    
    // ОКПО (опционально, но если заполнен - от 8 до 14 цифр)
    if ( ! empty( $_POST['billing_okpo'] ) ) {
        $okpo = preg_replace( '/\D/', '', $_POST['billing_okpo'] );
        if ( strlen( $okpo ) < 8 || strlen( $okpo ) > 14 ) {
            wc_add_notice( 'ОКПО должен содержать от 8 до 14 цифр', 'error' );
        }
    }
    
    // Юридический адрес (обязательное, минимум 5 символов)
    enotary_validate_required_field( 'billing_legal_address', 'Юридический адрес' );
    
    if ( ! empty( $_POST['billing_legal_address'] ) ) {
        if ( strlen( trim( $_POST['billing_legal_address'] ) ) < 5 ) {
            wc_add_notice( 'Юридический адрес должен содержать минимум 5 символов', 'error' );
        }
    }
    
    // Почтовый индекс (6 цифр)
    if ( ! empty( $_POST['billing_postcode_custom'] ) ) {
        $postcode = preg_replace( '/\D/', '', $_POST['billing_postcode_custom'] );
        if ( strlen( $postcode ) !== 6 ) {
            wc_add_notice( 'Почтовый индекс должен содержать 6 цифр', 'error' );
        }
    }
}

/**
 * Проверка обязательного поля
 */
function enotary_validate_required_field( $field_name, $field_label ) {
    if ( empty( $_POST[ $field_name ] ) || trim( $_POST[ $field_name ] ) === '' ) {
        wc_add_notice( sprintf( 'Поле "%s" обязательно для заполнения', $field_label ), 'error' );
    }
}

/**
 * ============================================
 * ПРИМЕЧАНИЕ: Сохранение данных
 * ============================================
 * 
 * Функция сохранения кастомных полей (enotary_save_custom_checkout_fields)
 * уже объявлена в inc/checkout-custom-forms.php
 * Повторное объявление здесь НЕ ТРЕБУЕТСЯ и вызовет ошибку!
 */

/**
 * ============================================
 * ДОПОЛНИТЕЛЬНЫЕ ХЕЛПЕРЫ
 * ============================================
 */

/**
 * Проверка валидности ИНН (с контрольной суммой)
 * 
 * @param string $inn ИНН для проверки
 * @return bool
 */
function enotary_validate_inn_checksum( $inn ) {
    $inn = preg_replace( '/\D/', '', $inn );
    
    if ( strlen( $inn ) === 10 ) {
        // Проверка ИНН юридического лица (10 цифр)
        $check_sum = 0;
        $coefficients = array( 2, 4, 10, 3, 5, 9, 4, 6, 8 );
        
        for ( $i = 0; $i < 9; $i++ ) {
            $check_sum += intval( $inn[ $i ] ) * $coefficients[ $i ];
        }
        
        $check_digit = ( $check_sum % 11 ) % 10;
        
        return $check_digit === intval( $inn[9] );
    } elseif ( strlen( $inn ) === 12 ) {
        // Проверка ИНН физического лица (12 цифр)
        $coefficients_11 = array( 7, 2, 4, 10, 3, 5, 9, 4, 6, 8 );
        $coefficients_12 = array( 3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8 );
        
        $check_sum_11 = 0;
        for ( $i = 0; $i < 10; $i++ ) {
            $check_sum_11 += intval( $inn[ $i ] ) * $coefficients_11[ $i ];
        }
        $check_digit_11 = ( $check_sum_11 % 11 ) % 10;
        
        $check_sum_12 = 0;
        for ( $i = 0; $i < 11; $i++ ) {
            $check_sum_12 += intval( $inn[ $i ] ) * $coefficients_12[ $i ];
        }
        $check_digit_12 = ( $check_sum_12 % 11 ) % 10;
        
        return ( $check_digit_11 === intval( $inn[10] ) ) && ( $check_digit_12 === intval( $inn[11] ) );
    }
    
    return false;
}

/**
 * Проверка валидности КПП (формат)
 * 
 * @param string $kpp КПП для проверки
 * @return bool
 */
function enotary_validate_kpp_format( $kpp ) {
    $kpp = preg_replace( '/\D/', '', $kpp );
    
    // КПП должен быть 9 цифр
    if ( strlen( $kpp ) !== 9 ) {
        return false;
    }
    
    // Первые 4 цифры - код налогового органа
    // 5-6 цифры - причина постановки на учет
    // 7-9 цифры - порядковый номер
    
    return true;
}
