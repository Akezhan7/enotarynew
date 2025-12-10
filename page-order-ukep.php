<?php
/**
 * Template Name: Заказать УКЭП
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
                <span class="text-dark">Заказать УКЭП</span>
            </div>
        </div>

        <!-- Hero секция - Заказать УКЭП -->
        <!-- Заголовок блока с фоном -->
        <section class="page-hero-section responsive-container">
            <div class="page-hero-block" data-aos="fade-down">
                <!-- Декоративный вектор (позади текста) -->
                <div class="page-hero-vector">
                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/Vector 1.png" alt="" class="block max-w-none w-full h-full object-contain">
                </div>
                <!-- Заголовок поверх вектора -->
                <p class="page-hero-title">Заказать УКЭП</p>
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

        <!-- Квалифицированные сертификаты -->
        <section class="w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5">
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Квалифицированные сертификаты:</h2>
            
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full">
                <!-- Пример 1 -->
                <div class="flex items-center gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">ЭП руководителей организаций</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full">
                        <div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">3000₽</p>
                    </div>
                </div>

                <!-- Пример 2 -->
                <div class="flex items-center gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom"></div>
                    <p class="flex-1 font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">ЭП Индивидуальных предпринимателей</p>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">1</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">3000₽</p>
                    </div>
                </div>

                <!-- Пример 3 -->
                <div class="flex items-start gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom mt-0.5"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">ЭП физического лица для сотрудника организаций и Индивидуальных предпринимателей</p>
                        <p class="font-semibold text-xs sm:text-sm text-secondary leading-[1.15]">Для представления интересов компании в информационных системах, сдачи отчетности, работы в ЭДО, участия в торгах</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">3000₽</p>
                    </div>
                </div>

                <!-- Пример 4 -->
                <div class="flex items-start gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom mt-0.5"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">ЭП физического лица для Индивидуальных предпринимателей</p>
                        <p class="font-semibold text-xs sm:text-sm text-secondary leading-[1.15]">Для представления интересов компании в информационных системах, сдачи отчетности, работы в ЭДО, участия в торгах</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">2</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">3000₽</p>
                    </div>
                </div>

                <!-- Пример 5 -->
                <div class="flex items-center gap-2 sm:gap-2.5 p-4 sm:p-5">
                    <div class="checkbox-custom"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">ЭП физического лица</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">1</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">2000₽</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Платные расширения для сертификатов -->
        <section class="w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5">
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Платные расширения для сертификатов:</h2>
            
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full">
                <!-- Расширение 1 -->
                <div class="flex items-center gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Для использования на портале Росреестр</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">600₽</p>
                    </div>
                </div>

                <!-- Расширение 2 -->
                <div class="flex items-start gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom mt-0.5 sm:mt-1"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Для использования на площадке Федресурса и порталах по раскрытию информации</p>
                        <div class="font-semibold text-xs sm:text-sm text-secondary leading-[1.15]">
                            <p class="mb-1 sm:mb-2">Список поддерживаемых площадок:</p>
                            <p class="mb-0.5 sm:mb-1">1. <a href="#" class="underline hover:opacity-70">Федресурс (ГП Интерфакс)</a></p>
                            <p class="mb-0.5 sm:mb-1">2. <a href="#" class="underline hover:opacity-70">ЕФРСБ</a></p>
                            <p class="mb-0.5 sm:mb-1">3. <a href="#" class="underline hover:opacity-70">Интерфакс-ЦРКИ</a></p>
                            <p class="mb-0.5 sm:mb-1">4. <a href="#" class="underline hover:opacity-70">СКРИН</a></p>
                            <p class="mb-0.5 sm:mb-1">5. <a href="#" class="underline hover:opacity-70">Система раскрытия информации АК&М</a></p>
                            <p class="mb-0.5 sm:mb-1">6. <a href="#" class="underline hover:opacity-70">АЭИ «ПРАЙМ»</a></p>
                            <p>7. <a href="#" class="underline hover:opacity-70">ИА «АЗИПИ - Информ»</a></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">200₽</p>
                    </div>
                </div>

                <!-- Расширение 3 -->
                <div class="flex items-center gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Для использования на ЭТП B2B</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">3500₽</p>
                    </div>
                </div>

                <!-- Расширение 4 -->
                <div class="flex items-center gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Для использования на ЭТП Fabrikant.ru</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">3200₽</p>
                    </div>
                </div>

                <!-- Расширение 5 -->
                <div class="flex items-center gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Для использования на площадке ЦДТ (как участник)</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">6500₽</p>
                    </div>
                </div>

                <!-- Расширение 6 -->
                <div class="flex items-center gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Для использования на площадке Электронные системы Поволжья</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">1700₽</p>
                    </div>
                </div>

                <!-- Расширение 7 -->
                <div class="flex items-center gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Для использования в Уральская ЭТП</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">3500₽</p>
                    </div>
                </div>

                <!-- Расширение 8 -->
                <div class="flex items-center gap-2 sm:gap-2.5 p-4 sm:p-5">
                    <div class="checkbox-custom"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Для использования на площадке Аукционный тендерный центр</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">1700₽</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Машиночитаемая доверенность -->
        <section class="w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5">
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Машиночитаемая доверенность</h2>
            
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full">
                <!-- МЧД 1 -->
                <div class="flex items-start gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom mt-0.5 sm:mt-1"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Формат 003</p>
                        <p class="font-semibold text-xs sm:text-sm text-secondary leading-[1.15]">Универсальный формат, применяется для взаимодействия с ФНС, Росстатом, СФР, банками, контрагентами и в системах ЭДО. С марта 2025 года это единственный формат, который ФНС принимает к регистрации.</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">2000₽</p>
                    </div>
                </div>

                <!-- МЧД 2 -->
                <div class="flex items-start gap-2 sm:gap-2.5 p-4 sm:p-5">
                    <div class="checkbox-custom mt-0.5 sm:mt-1"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Собственный формат СФР.</p>
                        <p class="font-semibold text-xs sm:text-sm text-secondary leading-[1.15]">Для обмена документами с СФР нужно создавать специальные МЧД</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">2000₽</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Криптопровайдеры -->
        <section class="w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5">
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Криптопровайдеры</h2>
            
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full">
                <div class="flex items-start gap-2 sm:gap-2.5 p-4 sm:p-5">
                    <div class="checkbox-custom mt-0.5 sm:mt-1"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Бессрочная лицензия на криптопровайдер Signal-COM CSP (Windows 7/8.1/10)</p>
                        <p class="font-semibold text-xs sm:text-sm text-secondary leading-[1.15]">*при заказе сертификата</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">2000₽</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Носители ключей (Токен) -->
        <section class="w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5">
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Носители ключей (Токен)</h2>
            
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full">
                <!-- Токен 1 -->
                <div class="flex items-center gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Лицензия на мобильное приложение SmartToken-PRO (телефон в качестве токена), сертификат ФСБ</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">820₽</p>
                    </div>
                </div>

                <!-- Токен 2 -->
                <div class="flex items-center gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Рутокен ЭЦП 3.0 3120, сертификат ФСБ</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">2680₽</p>
                    </div>
                </div>

                <!-- Токен 3 -->
                <div class="flex items-center gap-2 sm:gap-2.5 p-4 sm:p-5">
                    <div class="checkbox-custom"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Рутокен Lite, сертификат ФСТЭК</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">2130₽</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Дополнительные услуги -->
        <section class="w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5">
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Дополнительные услуги</h2>
            
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full">
                <!-- Услуга 1 -->
                <div class="flex items-center gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Настройка компьютера в ОС Windows для работы с квалифицированным сертификатом ЭП (без выезда к заказчику)</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">1000₽</p>
                    </div>
                </div>

                <!-- Услуга 2 -->
                <div class="flex items-center gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Ускоренный выпуск сертификата электронной подписи</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">3500₽</p>
                    </div>
                </div>

                <!-- Услуга 3 -->
                <div class="flex items-center gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Резервное копирование ключей (для носителей с извлекаемыми данными).</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">2000₽</p>
                    </div>
                </div>

                <!-- Услуга 4 -->
                <div class="flex items-center gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)]">
                    <div class="checkbox-custom"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Оказание помощи в аккредитации на ЭТП (одна площадка)</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">5000₽</p>
                    </div>
                </div>

                <!-- Услуга 5 -->
                <div class="flex items-center gap-2 sm:gap-2.5 p-4 sm:p-5">
                    <div class="checkbox-custom"></div>
                    <div class="flex-1 flex flex-col gap-2 sm:gap-2.5">
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15]">Очная идентификация ФЛ в пределах МКАД</p>
                    </div>
                    <div class="flex items-center gap-2 md:gap-2.5 max-md:justify-between max-md:w-full"><div class="quantity-control">
                            <button class="quantity-btn" data-action="decrement"></button>
                            <span class="quantity-value">0</span>
                            <button class="quantity-btn" data-action="increment"></button>
                        </div>
                        <p class="font-bold text-sm sm:text-base text-[#262626] leading-[1.15] text-right">3000₽</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Всего -->
        <section class="obhs w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5 mb-6 sm:mb-8 md:mb-10">
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Всего</h2>
            
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full flex flex-col">
                <div class="flex items-center justify-between gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)] w-full">
                    <p class="font-bold text-base sm:text-lg text-[#262626] leading-[1.15]">Всего</p>
                    <p class="font-bold text-base sm:text-lg text-[#262626] leading-[1.15] whitespace-nowrap flex-shrink-0" id="totalPrice">1000₽</p>
                </div>
                <div class="flex items-center justify-end gap-2 sm:gap-2.5 p-4 sm:p-5 w-full">
                    <a href="#" class="bg-primary rounded-[8px] sm:rounded-[10px] px-2.5 py-2.5 flex items-center justify-center h-[44px] sm:h-[46px] w-full sm:w-[160px] hover:opacity-90 transition-opacity no-underline">
                        <p class="font-bold text-sm sm:text-base text-center text-white leading-[1.15]">Дальше</p>
                    </a>
                </div>
            </div>
        </section>

<?php
get_footer();
?>

