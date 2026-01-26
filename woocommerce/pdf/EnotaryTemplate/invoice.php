<?php
/**
 * Кастомный шаблон счета на оплату (Российский стандарт)
 * Template: EnotaryTemplate
 *
 * @package EnotaryNew
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// === ДАННЫЕ ЗАКАЗА ===
$order = $this->order;
$order_id = $order->get_id();

// === ДАННЫЕ ПОКУПАТЕЛЯ ===
$payer_type = $order->get_meta( '_active_payer_type' );
$billing_company = $order->get_meta( '_billing_company' );
if ( empty( $billing_company ) ) {
    $billing_company = $order->get_billing_company();
}
$billing_inn = $order->get_meta( '_billing_inn' );
$billing_kpp = $order->get_meta( '_billing_kpp' );
$billing_okpo = $order->get_meta( '_billing_okpo' );
$billing_legal_address = $order->get_meta( '_billing_legal_address' );
$billing_passport_address = $order->get_meta( '_billing_passport_address' );
$billing_postcode = $order->get_meta( '_billing_postcode_custom' );
$billing_first_name = $order->get_billing_first_name();
$billing_last_name = $order->get_billing_last_name();
$billing_phone = $order->get_billing_phone();
$billing_email = $order->get_billing_email();

// === ДАТА ДОКУМЕНТА ===
$date_created = $order->get_date_created();
$timestamp = $date_created ? $date_created->getTimestamp() : time();
$months_genitive = array( '', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря' );
$date_day = date_i18n( 'd', $timestamp );
$date_month = $months_genitive[ intval( date_i18n( 'n', $timestamp ) ) ];
$date_year = date_i18n( 'Y', $timestamp );

// === ИТОГИ ===
$total = floatval( $order->get_total() );
$tax_total = floatval( $order->get_total_tax() );

// === ФУНКЦИЯ СУММА ПРОПИСЬЮ ===
if ( ! function_exists( 'enotary_num2str' ) ) {
    function enotary_num2str( $num ) {
        $nul = 'ноль';
        $ten = array(
            array( '', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять' ),
            array( '', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять' ),
        );
        $a20 = array( 'десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать' );
        $tens = array( 2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто' );
        $hundred = array( '', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот' );
        $unit = array(
            array( 'копейка', 'копейки', 'копеек', 1 ),
            array( 'рубль', 'рубля', 'рублей', 0 ),
            array( 'тысяча', 'тысячи', 'тысяч', 1 ),
            array( 'миллион', 'миллиона', 'миллионов', 0 ),
            array( 'миллиард', 'миллиарда', 'миллиардов', 0 ),
        );

        list( $rub, $kop ) = explode( '.', sprintf( '%015.2f', floatval( $num ) ) );
        $out = array();

        if ( intval( $rub ) > 0 ) {
            foreach ( str_split( $rub, 3 ) as $uk => $v ) {
                if ( ! intval( $v ) ) continue;
                $uk = count( $unit ) - $uk - 1;
                $gender = $unit[ $uk ][3];
                list( $i1, $i2, $i3 ) = array_map( 'intval', str_split( $v, 1 ) );
                $out[] = $hundred[ $i1 ];
                if ( $i2 > 1 ) {
                    $out[] = $tens[ $i2 ] . ' ' . $ten[ $gender ][ $i3 ];
                } else {
                    $out[] = $i2 > 0 ? $a20[ $i3 ] : $ten[ $gender ][ $i3 ];
                }
                if ( $uk > 1 ) {
                    $out[] = enotary_morph( $v, $unit[ $uk ][0], $unit[ $uk ][1], $unit[ $uk ][2] );
                }
            }
        } else {
            $out[] = $nul;
        }

        $out[] = enotary_morph( intval( $rub ), $unit[1][0], $unit[1][1], $unit[1][2] );
        $out[] = $kop . ' ' . enotary_morph( $kop, $unit[0][0], $unit[0][1], $unit[0][2] );

        return trim( preg_replace( '/ {2,}/', ' ', implode( ' ', $out ) ) );
    }

    function enotary_morph( $n, $f1, $f2, $f5 ) {
        $n = abs( intval( $n ) ) % 100;
        if ( $n > 10 && $n < 20 ) return $f5;
        $n = $n % 10;
        if ( $n > 1 && $n < 5 ) return $f2;
        if ( $n == 1 ) return $f1;
        return $f5;
    }
}

do_action( 'wpo_wcpdf_before_document', $this->get_type(), $this->order );
?>

<!-- ШАПКА: Логотип + Уведомление -->
<table class="header-table">
    <tr>
        <td class="logo-cell">
            <?php if ( $this->has_header_logo() ) : ?>
                <?php $this->header_logo(); ?>
            <?php endif; ?>
        </td>
        <td class="notice-cell">
            Внимание! Оплата данного счета означает согласие с условиями поставки товара. Уведомление об оплате обязательно, в противном случае не гарантируется наличие товара на складе. Товар отпускается по факту прихода денег на р/с Поставщика, самовывозом, при наличии доверенности и паспорта.
        </td>
    </tr>
</table>

<!-- БАНКОВСКИЕ РЕКВИЗИТЫ -->
<table class="bank-table">
    <tr>
        <td class="bank-combined" rowspan="2">АО БАНК РУССКИЙ СТАНДАРТ Г. МОСКВА<br><span class="subtext">Банк получателя</span></td>
        <td class="label-cell">БИК</td>
        <td class="value-cell">044525151</td>
    </tr>
    <tr>
        <td class="label-cell">Сч. №</td>
        <td class="value-cell">30101810845250000151</td>
    </tr>
    <tr>
        <td class="inn-kpp-cell">
            <strong>ИНН</strong> 7714028893 &nbsp; <strong>КПП</strong> 772501001
        </td>
        <td class="label-cell-nobottom" rowspan="2">Сч. №</td>
        <td class="value-cell-nobottom" rowspan="2">40702810800060000193</td>
    </tr>
    <tr>
        <td class="recipient-cell">
            <span class="subtext">Получатель</span> АО "СИГНАЛ-КОМ"
        </td>
    </tr>
</table>

<!-- ЗАГОЛОВОК СЧЕТА -->
<h1 class="invoice-title">Счет на оплату № <?php echo esc_html( $this->get_number() ); ?> от <?php echo esc_html( $date_day ); ?> <?php echo esc_html( $date_month ); ?> <?php echo esc_html( $date_year ); ?> г.</h1>

<!-- ПОСТАВЩИК -->
<p class="party-info">
    <strong>Поставщик:</strong> АО "СИГНАЛ-КОМ", ИНН 7714028893, КПП 772501001, 115088, Москва г, Крутицкая наб., дом 23, кв. 64, тел.: (495) 969-30-34
</p>

<!-- ПОКУПАТЕЛЬ -->
<p class="party-info">
    <strong>Покупатель:</strong>
    <?php
    // Формируем строку покупателя в зависимости от типа
    $buyer_parts = array();

    if ( $payer_type === 'legal' && ! empty( $billing_company ) ) {
        $buyer_parts[] = esc_html( $billing_company );
    } else {
        $fio = trim( $billing_last_name . ' ' . $billing_first_name );
        if ( ! empty( $fio ) ) {
            $buyer_parts[] = esc_html( $fio );
        }
    }

    if ( ! empty( $billing_inn ) ) {
        $buyer_parts[] = 'ИНН: ' . esc_html( $billing_inn );
    }

    if ( ! empty( $billing_kpp ) ) {
        $buyer_parts[] = 'КПП: ' . esc_html( $billing_kpp );
    }

    // Адрес (юридический или паспортный)
    $address = ! empty( $billing_legal_address ) ? $billing_legal_address : $billing_passport_address;
    if ( ! empty( $address ) ) {
        if ( ! empty( $billing_postcode ) ) {
            $address = $billing_postcode . ', ' . $address;
        }
        $buyer_parts[] = esc_html( $address );
    }

    if ( ! empty( $billing_phone ) ) {
        $buyer_parts[] = 'Тел: ' . esc_html( $billing_phone );
    }

    echo implode( ', ', $buyer_parts );
    ?>
</p>

<!-- ТАБЛИЦА ТОВАРОВ -->
<table class="items-table">
    <thead>
        <tr>
            <th class="col-num">№</th>
            <th class="col-name">Товары (работы, услуги)</th>
            <th class="col-qty">Кол-во</th>
            <th class="col-unit">Ед.</th>
            <th class="col-price">Цена</th>
            <th class="col-sum">Сумма</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $counter = 1;
        $items_count = 0;

        foreach ( $this->get_order_items() as $item_id => $item ) :
            $items_count++;

            // Получаем данные о товаре из заказа для точных расчетов
            $wc_item = $order->get_item( $item_id );
            if ( $wc_item ) {
                // Сумма с НДС = сумма товара + налог на товар
                $line_total = floatval( $wc_item->get_total() ) + floatval( $wc_item->get_total_tax() );
                $qty = floatval( $wc_item->get_quantity() );
            } else {
                // Fallback
                $qty = floatval( $item['quantity'] );
                $price_raw = isset( $item['order_price'] ) ? $item['order_price'] : '0';
                $price_clean = preg_replace( '/[^\d,.]/', '', strip_tags( $price_raw ) );
                $price_clean = str_replace( ',', '.', $price_clean );
                $line_total = floatval( $price_clean );
            }

            $unit_price = $qty > 0 ? $line_total / $qty : $line_total;
        ?>
        <tr>
            <td class="col-num"><?php echo esc_html( $counter++ ); ?></td>
            <td class="col-name"><?php echo esc_html( $item['name'] ); ?></td>
            <td class="col-qty"><?php echo esc_html( $item['quantity'] ); ?></td>
            <td class="col-unit">шт.</td>
            <td class="col-price"><?php echo number_format( $unit_price, 2, ',', ' ' ); ?></td>
            <td class="col-sum"><?php echo number_format( $line_total, 2, ',', ' ' ); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- ИТОГИ -->
<table class="totals-table">
    <tr>
        <td class="totals-spacer"></td>
        <td class="totals-label">Итого:</td>
        <td class="totals-value"><?php echo number_format( $total, 2, ',', ' ' ); ?></td>
    </tr>
    <?php if ( $tax_total > 0 ) : ?>
    <tr>
        <td class="totals-spacer"></td>
        <td class="totals-label">В том числе НДС:</td>
        <td class="totals-value"><?php echo number_format( $tax_total, 2, ',', ' ' ); ?></td>
    </tr>
    <?php else : ?>
    <tr>
        <td class="totals-spacer"></td>
        <td class="totals-label">Без налога (НДС):</td>
        <td class="totals-value">-</td>
    </tr>
    <?php endif; ?>
    <tr class="total-row">
        <td class="totals-spacer"></td>
        <td class="totals-label"><strong>Всего к оплате:</strong></td>
        <td class="totals-value"><strong><?php echo number_format( $total, 2, ',', ' ' ); ?></strong></td>
    </tr>
</table>

<!-- СУММА ПРОПИСЬЮ -->
<p class="amount-words">
    Всего наименований <?php echo esc_html( $items_count ); ?>, на сумму <?php echo number_format( $total, 2, ',', ' ' ); ?> руб.<br>
    <strong><?php echo mb_convert_case( enotary_num2str( $total ), MB_CASE_TITLE, 'UTF-8' ); ?></strong>
</p>

<?php
// Путь к изображениям подписей и печати
$theme_url = get_template_directory_uri();
$stamp_url = $theme_url . '/assets/images/SC_AO_185.png';
$sign_director_url = $theme_url . '/assets/images/sv.png';
$sign_accountant_url = $theme_url . '/assets/images/mli.png';
?>

<!-- ПОДПИСИ С ПЕЧАТЬЮ -->
<div class="signatures-wrapper">
    <!-- Печать - абсолютное позиционирование поверх подписи руководителя -->
    <img src="<?php echo esc_url( $stamp_url ); ?>" alt="Печать" class="stamp-img">
    
    <!-- Строка подписей -->
    <table class="signatures-table">
        <tr>
            <td class="sig-cell">Руководитель</td>
            <td class="sig-line-cell">
                <span class="sig-underline"></span>
                <img src="<?php echo esc_url( $sign_director_url ); ?>" alt="" class="sig-img-director">
            </td>
            <td class="sig-cell">Смирнов В. А.</td>
            <td class="sig-spacer"></td>
            <td class="sig-cell">Бухгалтер</td>
            <td class="sig-line-cell">
                <span class="sig-underline"></span>
                <img src="<?php echo esc_url( $sign_accountant_url ); ?>" alt="" class="sig-img-acc">
            </td>
            <td class="sig-cell">Муравьева Л. И.</td>
        </tr>
    </table>
</div>

<?php do_action( 'wpo_wcpdf_after_document', $this->get_type(), $this->order ); ?>