<?php
/**
 * Template Name: Заказать УНЭП
 * 
 * @package enotarynew
 */

get_header();
?>

        <!-- Хлебные крошки -->
        <div class="w-full responsive-container pb-3 lg:pb-4">
            <div class="flex items-center gap-2 font-semibold text-sm text-secondary">
                <a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors">Главная</a>
                <span>/</span>
                <span class="text-dark">Заказать УНЭП</span>
            </div>
        </div>

        <!-- Hero секция - Заказать УНЭП -->
        <section class="page-hero-section responsive-container">
            <div class="page-hero-block" data-aos="fade-down">
                <!-- Декоративный вектор (позади текста) -->
                <div class="page-hero-vector">
                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/Vector 1.png" alt="" class="block max-w-none w-full h-full object-contain">
                </div>
                <!-- Заголовок поверх вектора -->
                <p class="page-hero-title">Заказать УНЭП</p>
            </div>
        </section>

        <!-- Выбор типа лица -->
        <section class="w-full responsive-container py-6 sm:py-8 md:py-10 flex flex-col md:flex-row gap-3 sm:gap-4 md:gap-5 lg:gap-10" data-aos="fade-up" data-aos-delay="100">
            <div class="entity-card border border-[rgba(0,0,0,0.05)] bg-white rounded-[15px] sm:rounded-[20px] p-4 sm:p-5 flex-1 flex flex-row items-center justify-center gap-2 sm:gap-2.5 cursor-pointer shadow-md hover:shadow-lg transition-shadow min-h-[60px] sm:min-h-[76px]" data-price="3000">
                <p class="font-bold text-sm sm:text-base text-center text-[#262626] leading-[1.15] whitespace-nowrap">Юридическое Лицо</p>
                <div class="bg-secondary rounded-[8px] sm:rounded-[10px] px-2 sm:px-2.5 py-2 sm:py-2.5 flex items-center justify-center">
                    <p class="font-bold text-sm sm:text-base text-center text-white leading-[1.15] whitespace-nowrap">3000 руб.</p>
                </div>
            </div>
            <div class="entity-card border border-[rgba(0,0,0,0.05)] bg-white rounded-[15px] sm:rounded-[20px] p-4 sm:p-5 flex-1 flex flex-row items-center justify-center gap-2 sm:gap-2.5 cursor-pointer shadow-md hover:shadow-lg transition-shadow min-h-[60px] sm:min-h-[76px]" data-price="2000">
                <p class="font-bold text-sm sm:text-base text-center text-[#262626] leading-[1.15] whitespace-nowrap">Физическое Лицо</p>
                <div class="bg-secondary rounded-[8px] sm:rounded-[10px] px-2 sm:px-2.5 py-2 sm:py-2.5 flex items-center justify-center">
                    <p class="font-bold text-sm sm:text-base text-center text-white leading-[1.15] whitespace-nowrap">2000 руб.</p>
                </div>
            </div>
            <div class="entity-card entity-card-active border border-[rgba(0,0,0,0.05)] bg-primary rounded-[15px] sm:rounded-[20px] p-4 sm:p-5 flex-1 flex flex-row items-center justify-center gap-2 sm:gap-2.5 cursor-pointer shadow-lg min-h-[60px] sm:min-h-[76px]" data-price="2000">
                <p class="font-bold text-sm sm:text-base text-center text-white leading-[1.15] whitespace-nowrap">ИП</p>
                <div class="bg-white rounded-[8px] sm:rounded-[10px] px-2 sm:px-2.5 py-2 sm:py-2.5 flex items-center justify-center">
                    <p class="font-bold text-sm sm:text-base text-center text-[#262626] leading-[1.15] whitespace-nowrap">2000 руб.</p>
                </div>
            </div>
        </section>

        <!-- Усиленный неквалифицированный сертификат -->
        <section class="ibsh w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5">
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Усиленный неквалифицированный сертификат</h2>
            
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full">
                <!-- УНЭП (Годовой) Юридическое лицо -->
                <div class="flex items-start gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom mt-0.5 sm:mt-1"></div>
                    <div class="flex-1">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Усиленный неквалифицированный сертификат (Годовой) Юридическое лицо</p>
                    </div>
                    <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right flex-shrink-0">3000₽</p>
                </div>

                <!-- УНЭП (Годовой) Юридическое лицо -->
                <div class="flex items-start gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom mt-0.5 sm:mt-1"></div>
                    <div class="flex-1">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Усиленный неквалифицированный сертификат (Годовой) Юридическое лицо</p>
                    </div>
                    <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right flex-shrink-0">3000₽</p>
                </div>

                <!-- УНЭП (Годовой) Индивидуальный предприниматель -->
                <div class="flex items-start gap-2 sm:gap-2.5 p-4 sm:p-5">
                    <div class="checkbox-custom mt-0.5 sm:mt-1"></div>
                    <div class="flex-1">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Усиленный неквалифицированный сертификат (Годовой) Индивидуальный предприниматель</p>
                    </div>
                    <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right flex-shrink-0">2000₽</p>
                </div>
            </div>
        </section>

        <!-- Аутсорсинг услуг Удостоверяющего Центра -->
        <section class="ibsh w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5">
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Аутсорсинг услуг Удостоверяющего Центра</h2>
            
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full">
                <!-- УНЭП (Годовой) -->
                <div class="flex items-start gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom mt-0.5 sm:mt-1"></div>
                    <div class="flex-1">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Усиленный неквалифицированный сертификат (Годовой)</p>
                    </div>
                    <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right flex-shrink-0">800₽</p>
                </div>

                <!-- Центр регистрации Notary-Pro RA -->
                <div class="flex items-start gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom mt-0.5 sm:mt-1"></div>
                    <div class="flex-1">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Центр регистрации Notary-Pro RA</p>
                    </div>
                    <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right flex-shrink-0">25000₽</p>
                </div>

                <!-- Квартальный платеж -->
                <div class="flex items-start gap-2 sm:gap-2.5 p-4 sm:p-5">
                    <div class="checkbox-custom mt-0.5 sm:mt-1"></div>
                    <div class="flex-1">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Квартальный платеж</p>
                    </div>
                    <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right flex-shrink-0">3000₽</p>
                </div>
            </div>
        </section>

        <!-- Всего -->
        <section class="obhs ibsh w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5 mb-6 sm:mb-8 md:mb-10">
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Всего</h2>
            
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full flex flex-col">
                <!-- Центр регистрации Notary-Pro RA (в секции Всего) -->
                <div class="flex items-start gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)] w-full">
                    <div class="checkbox-custom mt-0.5 sm:mt-1"></div>
                    <div class="flex-1">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Центр регистрации Notary-Pro RA</p>
                    </div>
                    <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] whitespace-nowrap flex-shrink-0">25000₽</p>
                </div>
                
                <!-- Итого -->
                <div class="flex items-center justify-between gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)] w-full">
                    <p class="font-bold text-base sm:text-lg text-[#262626] leading-[1.15]">Итого</p>
                    <p class="font-bold text-base sm:text-lg text-[#262626] leading-[1.15] whitespace-nowrap flex-shrink-0" id="totalPrice">2000₽</p>
                </div>
                
                <!-- Кнопка Дальше -->
                <div class="flex items-center justify-end gap-2 sm:gap-2.5 p-4 sm:p-5 w-full">
                    <button type="button" data-product-id="86" class="order-next-btn bg-primary rounded-[8px] sm:rounded-[10px] px-2.5 py-2.5 flex items-center justify-center h-[44px] sm:h-[46px] w-full sm:w-[160px] hover:opacity-90 transition-opacity cursor-pointer border-0">
                        <p class="font-bold text-sm sm:text-base text-center text-white leading-[1.15] m-0">Дальше</p>
                    </button>
                </div>
            </div>
        </section>

<?php
get_footer();
?>

