<?php
/**
 * Checkout billing information form (ТОЧНАЯ копия HTML верстки)
 */

defined( 'ABSPATH' ) || exit;

$checkout = WC()->checkout();
$payer_type = WC()->session->get( 'active_payer_type', 'individual' );
?>

<!-- ФОРМА ФИЗИЧЕСКОГО ЛИЦА -->
<?php if ( $payer_type === 'individual' ) : ?>
<div id="individual-form" class="payer-form-section">
    
    <!-- Заголовок формы (вне белого блока) -->
    <h1 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Физическое лицо</h1>
    <p class="font-semibold text-[13px] sm:text-sm text-secondary leading-[1.15] mb-4 sm:mb-5">Необходимо заполнить реквизиты и контактные данные заказчика</p>
    
    <!-- Белый блок с формой -->
    <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[12px] sm:rounded-[15px] lg:rounded-[20px] overflow-hidden w-full">

    <!-- Контактная информация -->
    <div class="border-b border-[rgba(0,0,0,0.05)] p-3.5 sm:p-4 lg:p-5">
        <h2 class="font-bold text-[16px] sm:text-[18px] lg:text-[20px] text-[#262626] leading-[1.15]">Контактная информация</h2>
    </div>
    
    <!-- ФИО -->
    <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5">
        <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">ФИО</label>
        <input type="text" 
               name="billing_first_name" 
               id="billing_first_name" 
               placeholder="Ваше ФИО *" 
               value="<?php echo esc_attr( $checkout->get_value( 'billing_first_name' ) ); ?>"
               class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
        <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Фамилия Имя Отчество</p>
    </div>
    
    <!-- Контактный телефон и Электронная почта -->
    <div class="flex flex-col lg:flex-row">
        <div class="sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
            <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Контактный телефон</label>
            <input type="tel" 
                   name="billing_phone" 
                   id="billing_phone_individual" 
                   placeholder="8 (***) *** ** **" 
                   value="<?php echo esc_attr( $checkout->get_value( 'billing_phone' ) ); ?>"
                   class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
            <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Введите номер в формате 8 (ХХХ) ХХХ ХХ ХХ</p>
        </div>
        <div class="sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
            <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Электронная почта</label>
            <input type="email" 
                   name="billing_email" 
                   id="billing_email_individual" 
                   placeholder="example@mail.ru" 
                   value="<?php echo esc_attr( $checkout->get_value( 'billing_email' ) ); ?>"
                   class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
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
        <input type="text" 
               name="billing_inn" 
               id="billing_inn_individual" 
               placeholder="1234567890" 
               value="<?php echo esc_attr( $checkout->get_value( 'billing_inn' ) ); ?>"
               class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
        <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Число от 10 до 12 цифр</p>
    </div>
    
    <!-- Адрес (по паспорту) и Почтовый индекс -->
    <div class="flex flex-col lg:flex-row">
        <div class="sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
            <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Адрес (по паспорту)</label>
            <input type="text" 
                   name="billing_passport_address" 
                   id="billing_passport_address" 
                   placeholder="Улица Пушкина 56" 
                   value="<?php echo esc_attr( $checkout->get_value( 'billing_passport_address' ) ); ?>"
                   class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
        </div>
        <div class="sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
            <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Почтовый индекс</label>
            <input type="text" 
                   name="billing_postcode_custom" 
                   id="billing_postcode_custom_individual" 
                   placeholder="000000" 
                   value="<?php echo esc_attr( $checkout->get_value( 'billing_postcode_custom' ) ); ?>"
                   class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
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
        <textarea name="order_comments" 
                  id="order_comments_individual" 
                  placeholder="Введите ваш комментарий" 
                  rows="5" 
                  class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.3] resize-none focus:outline-none focus:border-primary transition-colors w-full min-h-[120px] sm:min-h-[140px]"></textarea>
    </div>
    
    <!-- Согласие на обработку персональных данных -->
    <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5">
        <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Согласие на обработку персональных данных</label>
        <div class="agreement-box border border-[rgba(0,0,0,0.05)] rounded-[12px] sm:rounded-[15px] lg:rounded-[20px] p-3.5 sm:p-4 lg:p-5 flex flex-wrap sm:flex-nowrap items-center gap-2.5">
            <div class="checkbox-custom-agree border-2 border-primary checked flex-shrink-0"></div>
            <input type="checkbox" name="personal_data_consent" id="personal_data_consent_individual" value="1" checked style="display:none;">
            <div class="flex flex-wrap items-center gap-x-1.5 gap-y-1">
                <p class="font-bold text-[14px] sm:text-[15px] lg:text-base text-[#262626] leading-[1.15]">Я согласен(-на)</p>
                <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">на обработку персональных данных</p>
            </div>
        </div>
    </div>
    
    </div><!-- Закрытие белого блока -->

</div><!-- Закрытие #individual-form -->
<?php endif; ?>

<!-- ФОРМА ИНДИВИДУАЛЬНОГО ПРЕДПРИНИМАТЕЛЯ -->
<?php if ( $payer_type === 'entrepreneur' ) : ?>
<div id="entrepreneur-form" class="payer-form-section">
    
    <!-- Заголовок формы (вне белого блока) -->
    <h1 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Индивидуальный предприниматель</h1>
    <p class="font-semibold text-[13px] sm:text-sm text-secondary leading-[1.15] mb-4 sm:mb-5">Необходимо заполнить реквизиты и контактные данные заказчика</p>
    
    <!-- Белый блок с формой -->
    <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[12px] sm:rounded-[15px] lg:rounded-[20px] overflow-hidden w-full">

    <!-- Контактная информация -->
    <div class="border-b border-[rgba(0,0,0,0.05)] p-3.5 sm:p-4 lg:p-5">
        <h2 class="font-bold text-[16px] sm:text-[18px] lg:text-[20px] text-[#262626] leading-[1.15]">Контактная информация</h2>
    </div>
    
    <!-- ФИО ИП -->
    <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5">
        <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">ФИО ИП</label>
        <input type="text" 
               name="billing_first_name" 
               id="billing_first_name_entrepreneur" 
               placeholder="Ваше ФИО *" 
               value="<?php echo esc_attr( $checkout->get_value( 'billing_first_name' ) ); ?>"
               class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
        <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Фамилия Имя Отчество</p>
    </div>
    
    <!-- Контактный телефон и Электронная почта -->
    <div class="flex flex-col lg:flex-row">
        <div class="sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
            <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Контактный телефон</label>
            <input type="tel" 
                   name="billing_phone" 
                   id="billing_phone_entrepreneur" 
                   placeholder="8 (***) *** ** **" 
                   value="<?php echo esc_attr( $checkout->get_value( 'billing_phone' ) ); ?>"
                   class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
            <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Введите номер в формате 8 (ХХХ) ХХХ ХХ ХХ</p>
        </div>
        <div class="sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
            <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Электронная почта</label>
            <input type="email" 
                   name="billing_email" 
                   id="billing_email_entrepreneur" 
                   placeholder="example@mail.ru" 
                   value="<?php echo esc_attr( $checkout->get_value( 'billing_email' ) ); ?>"
                   class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
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
        <input type="text" 
               name="billing_inn" 
               id="billing_inn_entrepreneur" 
               placeholder="1234567890" 
               value="<?php echo esc_attr( $checkout->get_value( 'billing_inn' ) ); ?>"
               class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
        <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Число от 10 до 12 цифр</p>
    </div>
    
    <!-- Адрес (по паспорту) и Почтовый индекс -->
    <div class="flex flex-col lg:flex-row">
        <div class="sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
            <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Адрес (по паспорту)</label>
            <input type="text" 
                   name="billing_passport_address" 
                   id="billing_passport_address_entrepreneur" 
                   placeholder="Улица Пушкина 56" 
                   value="<?php echo esc_attr( $checkout->get_value( 'billing_passport_address' ) ); ?>"
                   class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
        </div>
        <div class="sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
            <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Почтовый индекс</label>
            <input type="text" 
                   name="billing_postcode_custom" 
                   id="billing_postcode_custom_entrepreneur" 
                   placeholder="000000" 
                   value="<?php echo esc_attr( $checkout->get_value( 'billing_postcode_custom' ) ); ?>"
                   class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
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
        <textarea name="order_comments" 
                  id="order_comments_entrepreneur" 
                  placeholder="Введите ваш комментарий" 
                  rows="5" 
                  class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.3] resize-none focus:outline-none focus:border-primary transition-colors w-full min-h-[120px] sm:min-h-[140px]"></textarea>
    </div>
    
    <!-- Согласие на обработку персональных данных -->
    <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5">
        <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Согласие на обработку персональных данных</label>
        <div class="agreement-box border border-[rgba(0,0,0,0.05)] rounded-[12px] sm:rounded-[15px] lg:rounded-[20px] p-3.5 sm:p-4 lg:p-5 flex flex-wrap sm:flex-nowrap items-center gap-2.5">
            <div class="checkbox-custom-agree border-2 border-primary checked flex-shrink-0"></div>
            <input type="checkbox" name="personal_data_consent" id="personal_data_consent_entrepreneur" value="1" checked style="display:none;">
            <div class="flex flex-wrap items-center gap-x-1.5 gap-y-1">
                <p class="font-bold text-[14px] sm:text-[15px] lg:text-base text-[#262626] leading-[1.15]">Я согласен(-на)</p>
                <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">на обработку персональных данных</p>
            </div>
        </div>
    </div>
    
    </div><!-- Закрытие белого блока -->

</div><!-- Закрытие #entrepreneur-form -->
<?php endif; ?>

<!-- ФОРМА ЮРИДИЧЕСКОГО ЛИЦА -->
<?php if ( $payer_type === 'legal' ) : ?>
<div id="legal-form" class="payer-form-section
<!-- ФОРМА ЮРИДИЧЕСКОГО ЛИЦА -->
<div id="legal-form" class="payer-form-section" style="<?php echo ( $payer_type !== 'legal' ) ? 'display:none;' : ''; ?>">
    
    <!-- Заголовок формы (вне белого блока) -->
    <h1 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Юридическое лицо</h1>
    <p class="font-semibold text-[13px] sm:text-sm text-secondary leading-[1.15] mb-4 sm:mb-5">Необходимо заполнить реквизиты и контактные данные заказчика</p>
    
    <!-- Белый блок с формой -->
    <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[12px] sm:rounded-[15px] lg:rounded-[20px] overflow-hidden w-full">

    <!-- Контактная информация -->
    <div class="border-b border-[rgba(0,0,0,0.05)] p-3.5 sm:p-4 lg:p-5">
        <h2 class="font-bold text-[16px] sm:text-[18px] lg:text-[20px] text-[#262626] leading-[1.15]">Контактная информация</h2>
    </div>
    
    <!-- ФИО -->
    <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5">
        <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">ФИО</label>
        <input type="text" 
               name="billing_first_name" 
               id="billing_first_name_legal" 
               placeholder="Ваше ФИО *" 
               value="<?php echo esc_attr( $checkout->get_value( 'billing_first_name' ) ); ?>"
               class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
        <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Фамилия Имя Отчество</p>
    </div>
    
    <!-- Контактный телефон и Электронная почта -->
    <div class="flex flex-col lg:flex-row">
        <div class="sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
            <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Контактный телефон</label>
            <input type="tel" 
                   name="billing_phone" 
                   id="billing_phone_legal" 
                   placeholder="8 (***) *** ** **" 
                   value="<?php echo esc_attr( $checkout->get_value( 'billing_phone' ) ); ?>"
                   class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
            <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Введите номер в формате 8 (ХХХ) ХХХ ХХ ХХ</p>
        </div>
        <div class="sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
            <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Электронная почта</label>
            <input type="email" 
                   name="billing_email" 
                   id="billing_email_legal" 
                   placeholder="example@mail.ru" 
                   value="<?php echo esc_attr( $checkout->get_value( 'billing_email' ) ); ?>"
                   class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
            <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Адрес электронной почты для получения информации о заказе</p>
        </div>
    </div>
    
    <!-- Реквизиты для выставления счета -->
    <div class="border-b border-t border-[rgba(0,0,0,0.05)] p-3.5 sm:p-4 lg:p-5">
        <h2 class="font-bold text-[16px] sm:text-[18px] lg:text-[20px] text-[#262626] leading-[1.15]">Реквизиты для выставления счета</h2>
    </div>
    
    <!-- Наименование юр-го лица и ИНН (юр-го лица) -->
    <div class="flex flex-col lg:flex-row">
        <div class="sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
            <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Наименование юр-го лица</label>
            <input type="text" 
                   name="billing_company" 
                   id="billing_company" 
                   placeholder="ООО Компания" 
                   value="<?php echo esc_attr( $checkout->get_value( 'billing_company' ) ); ?>"
                   class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
            <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Минимум 5 символов</p>
        </div>
        <div class="sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
            <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">ИНН (юр-го лица)</label>
            <input type="text" 
                   name="billing_inn" 
                   id="billing_inn_legal" 
                   placeholder="1234567890" 
                   value="<?php echo esc_attr( $checkout->get_value( 'billing_inn' ) ); ?>"
                   class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
            <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Номер от 10 до 12 цифр</p>
        </div>
    </div>
    
    <!-- КПП и ОКПО -->
    <div class="flex flex-col lg:flex-row">
        <div class="sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
            <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">КПП</label>
            <input type="text" 
                   name="billing_kpp" 
                   id="billing_kpp" 
                   placeholder="123456789" 
                   value="<?php echo esc_attr( $checkout->get_value( 'billing_kpp' ) ); ?>"
                   class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
            <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Номер из 9 цифр</p>
        </div>
        <div class="sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
            <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">ОКПО</label>
            <input type="text" 
                   name="billing_okpo" 
                   id="billing_okpo" 
                   placeholder="12345678" 
                   value="<?php echo esc_attr( $checkout->get_value( 'billing_okpo' ) ); ?>"
                   class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
            <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Номер от 8 до 12 цифр</p>
        </div>
    </div>
    
    <!-- Юридический адрес и Почтовый индекс -->
    <div class="flex flex-col lg:flex-row">
        <div class="sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
            <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Юридический адрес</label>
            <input type="text" 
                   name="billing_legal_address" 
                   id="billing_legal_address" 
                   placeholder="Улица Пушкина 56" 
                   value="<?php echo esc_attr( $checkout->get_value( 'billing_legal_address' ) ); ?>"
                   class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
            <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">Минимум 5 символов</p>
        </div>
        <div class="sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5 flex-1">
            <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Почтовый индекс</label>
            <input type="text" 
                   name="billing_postcode_custom" 
                   id="billing_postcode_custom_legal" 
                   placeholder="010000" 
                   value="<?php echo esc_attr( $checkout->get_value( 'billing_postcode_custom' ) ); ?>"
                   class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 min-h-[44px] sm:min-h-[46px] lg:h-[46px] font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors w-full">
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
        <textarea name="order_comments" 
                  id="order_comments_legal" 
                  placeholder="Введите ваш комментарий" 
                  rows="5" 
                  class="form-input bg-white border border-[rgba(0,0,0,0.05)] rounded-[8px] sm:rounded-[10px] px-3 sm:px-3.5 lg:px-2.5 py-3 sm:py-2.5 font-semibold text-[14px] sm:text-[15px] lg:text-base text-secondary leading-[1.3] resize-none focus:outline-none focus:border-primary transition-colors w-full min-h-[120px] sm:min-h-[140px]"></textarea>
    </div>
    
    <!-- Согласие на обработку персональных данных -->
    <div class="p-3.5 sm:p-4 lg:p-5 flex flex-col gap-2 sm:gap-2.5">
        <label class="font-semibold text-[14px] sm:text-[15px] lg:text-base text-black leading-[1.15]">Согласие на обработку персональных данных</label>
        <div class="agreement-box border border-[rgba(0,0,0,0.05)] rounded-[12px] sm:rounded-[15px] lg:rounded-[20px] p-3.5 sm:p-4 lg:p-5 flex flex-wrap sm:flex-nowrap items-center gap-2.5">
            <div class="checkbox-custom-agree border-2 border-primary checked flex-shrink-0"></div>
            <input type="checkbox" name="personal_data_consent" id="personal_data_consent_legal" value="1" checked style="display:none;">
            <div class="flex flex-wrap items-center gap-x-1.5 gap-y-1">
                <p class="font-bold text-[14px] sm:text-[15px] lg:text-base text-[#262626] leading-[1.15]">Я согласен(-на)</p>
                <p class="font-semibold text-[12px] sm:text-[13px] lg:text-sm text-secondary leading-[1.15]">на обработку персональных данных</p>
            </div>
        </div>
    </div>
    
    </div><!-- Закрытие белого блока -->

</div><!-- Закрытие #legal-form -->
<?php endif; ?>

<!-- Скрытые поля для инициализации WooCommerce checkout -->
<div style="display: none;">
    <?php
    foreach ( $checkout->get_checkout_fields( 'billing' ) as $key => $field ) {
        if ( ! isset( $field['type'] ) ) {
            $field['type'] = 'text';
        }
        woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
    }
    ?>
</div>

