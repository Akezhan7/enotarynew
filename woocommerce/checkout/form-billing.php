<?php
/**
 * Переопределенный шаблон billing формы для чекаута
 * 
 * Отображает разные HTML-формы в зависимости от типа плательщика
 * 
 * @package enotarynew
 */

defined( 'ABSPATH' ) || exit;

// Получаем объект чекаута (КРИТИЧЕСКИ ВАЖНО!)
$checkout = WC()->checkout();

// Получить тип плательщика из сессии
$payer_type = WC()->session->get( 'active_payer_type' );
$payer_type_label = WC()->session->get( 'payer_type_label' );

// DEBUG: Вывод в HTML комментарии для отладки
if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    echo '<!-- DEBUG: Payer Type = ' . esc_html( $payer_type ) . ' -->';
    echo '<!-- DEBUG: Payer Label = ' . esc_html( $payer_type_label ) . ' -->';
}

// Дефолт - физическое лицо, если не указано
if ( empty( $payer_type ) ) {
    $payer_type = 'individual';
    $payer_type_label = 'Физическое лицо';
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        echo '<!-- DEBUG: Using default payer type (individual) -->';
    }
}

// Определить какие формы показывать
$show_individual = ( $payer_type === 'individual' );
$show_entrepreneur = ( $payer_type === 'entrepreneur' );
$show_legal = ( $payer_type === 'legal' );
?>

<div class="woocommerce-billing-fields">
    <!-- Уведомление о типе лица -->
    <?php if ( ! empty( $payer_type_label ) ) : ?>
        <div class="enotary-payer-type-notice" style="background:#f0f0f1;border-left:3px solid #375d74;padding:15px;margin-bottom:20px;border-radius:4px;">
            <p style="margin:0;font-weight:600;color:#262626;">
                Вы оформляете заказ как: <strong style="color:#375d74;"><?php echo esc_html( $payer_type_label ); ?></strong>
            </p>
        </div>
    <?php endif; ?>

    <?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

    <!-- Скрытые обязательные поля для WooCommerce (чтобы валидация работала) -->
    <div style="display:none;">
        <input type="hidden" name="billing_country" value="RU">
        <input type="hidden" name="billing_address_1" value="-">
        <input type="hidden" name="billing_city" value="-">
        <input type="hidden" name="billing_state" value="">
        <input type="hidden" name="billing_postcode" value="000000">
        <input type="hidden" name="billing_last_name" value="">
    </div>

    <!-- ========================================
         ФОРМА ДЛЯ ФИЗИЧЕСКОГО ЛИЦА
         ======================================== -->
    <div class="enotary-form enotary-form-individual <?php echo $show_individual ? 'active' : 'hidden'; ?>">
        <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[12px] sm:rounded-[15px] lg:rounded-[20px] overflow-hidden w-full">
            <!-- Контактная информация -->
            <div class="border-b border-[rgba(0,0,0,0.05)] p-3.5 sm:p-4 lg:p-5">
                <h2 class="font-bold text-[16px] sm:text-[18px] lg:text-[20px] text-[#262626] leading-[1.15]">Контактная информация</h2>
            </div>
            
            <!-- ФИО -->
            <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5">
                <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">ФИО</label>
                <input type="text" name="billing_first_name" placeholder="Ваше ФИО *" value="<?php echo esc_attr( $checkout->get_value( 'billing_first_name' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full" required>
                <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Фамилия Имя Отчество</p>
            </div>
            
            <!-- Контактный телефон и Электронная почта -->
            <div class="flex flex-col lg:flex-row">
                <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
                    <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Контактный телефон</label>
                    <input type="tel" name="billing_phone" placeholder="8 (***) *** ** **" value="<?php echo esc_attr( $checkout->get_value( 'billing_phone' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full" required>
                    <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Введите номер в формате 8 (ХХХ) ХХХ ХХ ХХ</p>
                </div>
                <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
                    <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Электронная почта</label>
                    <input type="email" name="billing_email" placeholder="example@mail.ru" value="<?php echo esc_attr( $checkout->get_value( 'billing_email' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full" required>
                    <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Адрес электронной почты для получения информации о заказе</p>
                </div>
            </div>
            
            <!-- Реквизиты для выставления счета -->
            <div class="border-b border-t border-[rgba(0,0,0,0.05)] p-3.5 sm:p-4 lg:p-5">
                <h2 class="font-bold text-[16px] sm:text-[18px] lg:text-[20px] text-[#262626] leading-[1.15]">Реквизиты для выставления счета</h2>
            </div>
            
            <!-- ИНН (физ-го лица) -->
            <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5">
                <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">ИНН (физ-го лица)</label>
                <input type="text" name="billing_inn" placeholder="1234567890" value="<?php echo esc_attr( $checkout->get_value( 'billing_inn' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
                <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Число от 10 до 12 цифр</p>
            </div>
            
            <!-- Адрес (по паспорту) и Почтовый индекс -->
            <div class="flex flex-col lg:flex-row">
                <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
                    <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Адрес (по паспорту)</label>
                    <input type="text" name="billing_passport_address" placeholder="Улица Пушкина 56" value="<?php echo esc_attr( $checkout->get_value( 'billing_passport_address' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full" required>
                </div>
                <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
                    <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Почтовый индекс</label>
                    <input type="text" name="billing_postcode_custom" placeholder="000000" value="<?php echo esc_attr( $checkout->get_value( 'billing_postcode_custom' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
                    <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Состоит из 6 цифр</p>
                </div>
            </div>
            
            <!-- Дополнительно -->
            <div class="border-b border-t border-[rgba(0,0,0,0.05)] p-3.5 sm:p-4 lg:p-5">
                <h2 class="font-bold text-[16px] sm:text-[18px] lg:text-[20px] text-[#262626] leading-[1.15]">Дополнительно</h2>
            </div>
            
            <!-- Комментарии к заказу -->
            <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5">
                <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Комментарии к заказу</label>
                <textarea name="order_comments" placeholder="Введите ваш комментарий" rows="5" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.3] resize-none focus:outline-none focus:border-primary transition-colors w-full min-h-[120px] sm:min-h-[140px]"><?php echo esc_textarea( $checkout->get_value( 'order_comments' ) ); ?></textarea>
            </div>
        </div>
    </div>

    <!-- ========================================
         ФОРМА ДЛЯ ИНДИВИДУАЛЬНОГО ПРЕДПРИНИМАТЕЛЯ
         ======================================== -->
    <div class="enotary-form enotary-form-entrepreneur <?php echo $show_entrepreneur ? 'active' : 'hidden'; ?>">
        <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[12px] sm:rounded-[15px] lg:rounded-[20px] overflow-hidden w-full">
            <!-- Контактная информация -->
            <div class="border-b border-[rgba(0,0,0,0.05)] p-3.5 sm:p-4 lg:p-5">
                <h2 class="font-bold text-[16px] sm:text-[18px] lg:text-[20px] text-[#262626] leading-[1.15]">Контактная информация</h2>
            </div>
            
            <!-- ФИО ИП -->
            <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5">
                <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">ФИО ИП</label>
                <input type="text" name="billing_first_name" placeholder="Ваше ФИО *" value="<?php echo esc_attr( $checkout->get_value( 'billing_first_name' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full" required>
                <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Фамилия Имя Отчество</p>
            </div>
            
            <!-- Контактный телефон и Электронная почта -->
            <div class="flex flex-col lg:flex-row">
                <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
                    <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Контактный телефон</label>
                    <input type="tel" name="billing_phone" placeholder="8 (***) *** ** **" value="<?php echo esc_attr( $checkout->get_value( 'billing_phone' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full" required>
                    <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Введите номер в формате 8 (ХХХ) ХХХ ХХ ХХ</p>
                </div>
                <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
                    <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Электронная почта</label>
                    <input type="email" name="billing_email" placeholder="example@mail.ru" value="<?php echo esc_attr( $checkout->get_value( 'billing_email' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full" required>
                    <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Адрес электронной почты для получения информации о заказе</p>
                </div>
            </div>
            
            <!-- Реквизиты для выставления счета -->
            <div class="border-b border-t border-[rgba(0,0,0,0.05)] p-3.5 sm:p-4 lg:p-5">
                <h2 class="font-bold text-[16px] sm:text-[18px] lg:text-[20px] text-[#262626] leading-[1.15]">Реквизиты для выставления счета</h2>
            </div>
            
            <!-- ИНН -->
            <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5">
                <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">ИНН</label>
                <input type="text" name="billing_inn" placeholder="1234567890" value="<?php echo esc_attr( $checkout->get_value( 'billing_inn' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full" required>
                <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Число от 10 до 12 цифр</p>
            </div>
            
            <!-- Адрес (по паспорту) и Почтовый индекс -->
            <div class="flex flex-col lg:flex-row">
                <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
                    <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Адрес (по паспорту)</label>
                    <input type="text" name="billing_passport_address" placeholder="Улица Пушкина 56" value="<?php echo esc_attr( $checkout->get_value( 'billing_passport_address' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full" required>
                </div>
                <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
                    <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Почтовый индекс</label>
                    <input type="text" name="billing_postcode_custom" placeholder="000000" value="<?php echo esc_attr( $checkout->get_value( 'billing_postcode_custom' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
                    <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Состоит из 6 цифр</p>
                </div>
            </div>
            
            <!-- Дополнительно -->
            <div class="border-b border-t border-[rgba(0,0,0,0.05)] p-3.5 sm:p-4 lg:p-5">
                <h2 class="font-bold text-[16px] sm:text-[18px] lg:text-[20px] text-[#262626] leading-[1.15]">Дополнительно</h2>
            </div>
            
            <!-- Комментарии к заказу -->
            <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5">
                <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Комментарии к заказу</label>
                <textarea name="order_comments" placeholder="Введите ваш комментарий" rows="5" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.3] resize-none focus:outline-none focus:border-primary transition-colors w-full min-h-[120px] sm:min-h-[140px]"><?php echo esc_textarea( $checkout->get_value( 'order_comments' ) ); ?></textarea>
            </div>
        </div>
    </div>

    <!-- ========================================
         ФОРМА ДЛЯ ЮРИДИЧЕСКОГО ЛИЦА
         ======================================== -->
    <div class="enotary-form enotary-form-legal <?php echo $show_legal ? 'active' : 'hidden'; ?>">
        <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[12px] sm:rounded-[15px] lg:rounded-[20px] overflow-hidden w-full">
            <!-- Контактная информация -->
            <div class="border-b border-[rgba(0,0,0,0.05)] p-3.5 sm:p-4 lg:p-5">
                <h2 class="font-bold text-[16px] sm:text-[18px] lg:text-[20px] text-[#262626] leading-[1.15]">Контактная информация</h2>
            </div>
            
            <!-- ФИО -->
            <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5">
                <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">ФИО</label>
                <input type="text" name="billing_first_name" placeholder="Ваше ФИО *" value="<?php echo esc_attr( $checkout->get_value( 'billing_first_name' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full" required>
                <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Фамилия Имя Отчество</p>
            </div>
            
            <!-- Контактный телефон и Электронная почта -->
            <div class="flex flex-col lg:flex-row">
                <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
                    <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Контактный телефон</label>
                    <input type="tel" name="billing_phone" placeholder="8 (***) *** ** **" value="<?php echo esc_attr( $checkout->get_value( 'billing_phone' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full" required>
                    <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Введите номер в формате 8 (ХХХ) ХХХ ХХ ХХ</p>
                </div>
                <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
                    <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Электронная почта</label>
                    <input type="email" name="billing_email" placeholder="example@mail.ru" value="<?php echo esc_attr( $checkout->get_value( 'billing_email' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full" required>
                    <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Адрес электронной почты для получения информации о заказе</p>
                </div>
            </div>
            
            <!-- Реквизиты для выставления счета -->
            <div class="border-b border-t border-[rgba(0,0,0,0.05)] p-3.5 sm:p-4 lg:p-5">
                <h2 class="font-bold text-[16px] sm:text-[18px] lg:text-[20px] text-[#262626] leading-[1.15]">Реквизиты для выставления счета</h2>
            </div>
            
            <!-- Наименование юр-го лица и ИНН (юр-го лица) -->
            <div class="flex flex-col lg:flex-row">
                <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
                    <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Наименование юр-го лица</label>
                    <input type="text" name="billing_company_name" placeholder="ООО Компания" value="<?php echo esc_attr( $checkout->get_value( 'billing_company_name' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full" required>
                    <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Минимум 5 символов</p>
                </div>
                <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
                    <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">ИНН (юр-го лица)</label>
                    <input type="text" name="billing_inn" placeholder="1234567890" value="<?php echo esc_attr( $checkout->get_value( 'billing_inn' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full" required>
                    <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Номер от 10 до 12 цифр</p>
                </div>
            </div>
            
            <!-- КПП и ОКПО -->
            <div class="flex flex-col lg:flex-row">
                <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
                    <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">КПП</label>
                    <input type="text" name="billing_kpp" placeholder="123456789" value="<?php echo esc_attr( $checkout->get_value( 'billing_kpp' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full" required>
                    <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Номер из 9 цифр</p>
                </div>
                <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
                    <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">ОКПО</label>
                    <input type="text" name="billing_okpo" placeholder="12345678" value="<?php echo esc_attr( $checkout->get_value( 'billing_okpo' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
                    <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Номер от 8 до 12 цифр</p>
                </div>
            </div>
            
            <!-- Юридический адрес и Почтовый индекс -->
            <div class="flex flex-col lg:flex-row">
                <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
                    <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Юридический адрес</label>
                    <input type="text" name="billing_legal_address" placeholder="Улица Пушкина 56" value="<?php echo esc_attr( $checkout->get_value( 'billing_legal_address' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full" required>
                    <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Минимум 5 символов</p>
                </div>
                <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
                    <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Почтовый индекс</label>
                    <input type="text" name="billing_postcode_custom" placeholder="010000" value="<?php echo esc_attr( $checkout->get_value( 'billing_postcode_custom' ) ); ?>" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
                    <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Состоит из 6 цифр</p>
                </div>
            </div>
            
            <!-- Дополнительно -->
            <div class="border-b border-t border-[rgba(0,0,0,0.05)] p-3.5 sm:p-4 lg:p-5">
                <h2 class="font-bold text-[16px] sm:text-[18px] lg:text-[20px] text-[#262626] leading-[1.15]">Дополнительно</h2>
            </div>
            
            <!-- Комментарии к заказу -->
            <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5">
                <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Комментарии к заказу</label>
                <textarea name="order_comments" placeholder="Введите ваш комментарий" rows="5" class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.3] resize-none focus:outline-none focus:border-primary transition-colors w-full min-h-[120px] sm:min-h-[140px]"><?php echo esc_textarea( $checkout->get_value( 'order_comments' ) ); ?></textarea>
            </div>
        </div>
    </div>

    <?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
</div>

<style>
/* Скрытие/показ форм */
.enotary-form.hidden {
    display: none !important;
}
.enotary-form.active {
    display: block !important;
}
</style>
