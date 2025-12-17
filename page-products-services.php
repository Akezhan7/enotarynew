<?php
/**
 * Template Name: ПО, токены и услуги
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
                <span class="text-dark">ПО&Токены&Услуги</span>
            </div>
        </div>

        <!-- Главный контент -->
        <main class="w-full responsive-container">
            <!-- Заголовок страницы -->
            <section class="flex flex-col gap-5 items-center text-center py-10">
                <h1 class="font-bold text-[28px] sm:text-[32px] md:text-[40px] text-[#262626] leading-[1.05] tracking-[-0.03em] max-w-[831px]" data-aos="fade-down">ПО, токены и услуги для работы с электронной подписью</h1>
                <p class="font-semibold text-base text-[#262626] leading-[1.15] max-w-full" data-aos="fade-up" data-aos-delay="100">
                    УЦ e-Notary входит в состав <span class="text-primary underline">АО «Сигнал-КОМ»</span> (разработчика средств криптографической защиты, защищённых приложений и сервисов) и предлагает клиентам сертифицированное программное обеспечение, программные и аппаратные токены, а также услуги, необходимые для работы с электронной подписью.
                </p>
            </section>

            <!-- Программное обеспечение -->
            <section class="flex flex-col gap-5 py-5">
                <div class="flex items-center justify-between" data-aos="fade-right" data-aos-delay="150">
                    <h2 class="font-bold text-[24px] sm:text-[28px] md:text-[32px] text-[#262626] leading-[1.15]">Программное обеспечение</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Карточка 1 -->
                    <a href="<?php echo enotarynew_get_page_url_by_template('page-order-ukep.php'); ?>" class="card-hover bg-white rounded-[30px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-2.5 flex gap-2.5 items-center cursor-pointer no-underline" data-aos="zoom-in" data-aos-delay="200">
                        <div class="w-[68px] h-[100px] rounded-[20px] overflow-hidden flex-shrink-0">
                            <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/signal-com-csp.png" alt="Signal-COM CSP" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col gap-2.5 flex-1 p-2.5">
                            <h3 class="font-bold text-[18px] sm:text-[20px] text-[#262626] leading-[1.15]">Криптопровайдер Signal-COM CSP</h3>
                            <p class="font-semibold text-base text-[#262626] leading-[1.15] opacity-80">Cредства криптографической защиты сообщений</p>
                        </div>
                    </a>
                    
                    <!-- Карточка 2 -->
                    <a href="<?php echo enotarynew_get_page_url_by_template('page-order-ukep.php'); ?>" class="card-hover bg-white rounded-[30px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-2.5 flex gap-2.5 items-center cursor-pointer no-underline" data-aos="zoom-in" data-aos-delay="250">
                        <div class="w-[68px] h-[100px] rounded-[20px] overflow-hidden flex-shrink-0">
                            <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/multi-installer.png" alt="Мульти-Инсталлятор" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col gap-2.5 flex-1 p-2.5">
                            <div class="flex items-center gap-2.5">
                                <h3 class="font-bold text-[18px] sm:text-[20px] text-[#262626] leading-[1.15]">Мульти-Инсталлятор УКЭП</h3>
                                <div class="w-5 h-5 overflow-hidden flex-shrink-0">
                                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/solar_info-square-bold-duotone.png" alt="Info" class="w-full h-full object-contain">
                                </div>
                            </div>
                            <p class="font-semibold text-base text-[#262626] leading-[1.15] opacity-80">Автоматическая установка и настройка: </p>
                        </div>
                    </a>
                </div>
            </section>

            <!-- Токены -->
            <section class="flex flex-col gap-5 py-5">
                <div class="flex items-center justify-between" data-aos="fade-right" data-aos-delay="300">
                    <h2 class="font-bold text-[24px] sm:text-[28px] md:text-[32px] text-[#262626] leading-[1.15]">Токены</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Карточка 1 -->
                    <a href="<?php echo enotarynew_get_page_url_by_template('page-order-ukep.php'); ?>" class="card-hover bg-white rounded-[30px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-2.5 flex gap-2.5 items-center cursor-pointer no-underline" data-aos="zoom-in" data-aos-delay="350">
                        <div class="w-[100px] h-[100px] rounded-[20px] overflow-hidden flex-shrink-0">
                            <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/smarttoken-pro.png" alt="SmartToken-PRO" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col gap-2.5 flex-1 p-2.5">
                            <h3 class="font-bold text-[18px] sm:text-[20px] text-[#262626] leading-[1.15]"> Мобильное приложение SmartToken-PRO</h3>
                            <p class="font-semibold text-base text-[#262626] leading-[1.15] opacity-80 text-clamp-3">СКЗИ SmartToken-PRO — это мобильное приложение, работающее как в режиме криптографического токена, при взаимодействии с приложениями на стационарных ПК с поддержкой криптопровайдеров, криптобиблиотек и криптоплагинов, так и в качестве автономного средства ЭП при взаимодействии с приложениями на мобильном устройстве в режиме «поделиться».</p>
                        </div>
                    </a>
                    
                    <!-- Карточка 2 -->
                    <a href="<?php echo enotarynew_get_page_url_by_template('page-order-ukep.php'); ?>" class="card-hover bg-white rounded-[30px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-2.5 flex gap-2.5 items-center cursor-pointer no-underline" data-aos="zoom-in" data-aos-delay="400">
                        <div class="w-[130px] h-[100px] rounded-[20px] overflow-hidden flex-shrink-0">
                            <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/rutoken.png" alt="Рутокен" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col gap-2.5 flex-1 p-2.5">
                            <h3 class="font-bold text-[18px] sm:text-[20px] text-[#262626] leading-[1.15]">USB-ключи Рутокен компании «Актив»</h3>
                            <p class="font-semibold text-base text-[#262626] leading-[1.15] opacity-80 text-clamp-3">Рутокен — это криптографический USB-токен, обеспечивающий надежную защиту ключей ЭП и аутентификации. Надежность Рутокен подтверждена его многолетней эксплуатацией в сетях массового обслуживания.</p>
                        </div>
                    </a>
                </div>
            </section>

            <!-- Услуги -->
            <section class="flex flex-col gap-5 py-5">
                <div class="flex items-center justify-between" data-aos="fade-right" data-aos-delay="450">
                    <h2 class="font-bold text-[24px] sm:text-[28px] md:text-[32px] text-[#262626] leading-[1.15]">Услуги</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <!-- Карточка 1 -->
                    <a href="<?php echo enotarynew_get_page_url_by_template('page-order-ukep.php'); ?>" class="card-hover bg-white rounded-[30px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-2.5 flex gap-2.5 items-center cursor-pointer no-underline" data-aos="zoom-in" data-aos-delay="500">
                        <div class="w-[100px] h-[100px] rounded-[20px] overflow-hidden flex-shrink-0">
                            <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/settings-icon.png" alt="Настройка" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col gap-2.5 flex-1 p-2.5">
                            <h3 class="font-bold text-[18px] sm:text-[20px] text-[#262626] leading-[1.15]">Настройка рабочего места пользователя при работе с УКЭП</h3>
                            <p class="font-semibold text-base text-[#262626] leading-[1.15] opacity-80">Cредства криптографической защиты сообщений</p>
                        </div>
                    </a>
                    
                    <!-- Карточка 2 -->
                    <a href="<?php echo enotarynew_get_page_url_by_template('page-order-ukep.php'); ?>" class="card-hover bg-white rounded-[30px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-2.5 flex gap-2.5 items-center cursor-pointer no-underline" data-aos="zoom-in" data-aos-delay="550">
                        <div class="w-[100px] h-[100px] rounded-[20px] overflow-hidden flex-shrink-0">
                            <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/multi-installer.png" alt="Штампы времени" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col gap-2.5 flex-1 p-2.5">
                            <h3 class="font-bold text-[18px] sm:text-[20px] text-[#262626] leading-[1.15]">Сервис штампов времени </h3>
                            <p class="font-semibold text-base text-[#262626] leading-[1.15] opacity-80">Cредства криптографической защиты сообщений</p>
                        </div>
                    </a>
                    
                    <!-- Карточка 3 - Локальная проверка УКЭП (открывает модальное окно) -->
                    <div class="card-hover bg-white rounded-[30px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-2.5 flex gap-2.5 items-center cursor-pointer" data-aos="zoom-in" data-aos-delay="600" id="openVerificationModal">
                        <div class="w-[100px] h-[100px] rounded-[20px] overflow-hidden flex-shrink-0">
                            <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/verification-icon.png" alt="Проверка" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col gap-2.5 flex-1 p-2.5">
                            <div class="flex items-center gap-2.5">
                                <h3 class="font-bold text-[18px] sm:text-[20px] text-[#262626] leading-[1.15]">Локальная проверка УКЭП</h3>
                                <div class="w-5 h-5 overflow-hidden flex-shrink-0">
                                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/solar_info-square-bold-duotone.png" alt="Info" class="w-full h-full object-contain">
                                </div>
                            </div>
                            <p class="font-semibold text-base text-[#262626] leading-[1.15] opacity-80">Cредства криптографической защиты сообщений</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Модальное окно проверки УКЭП -->
        <div class="certificate-help-modal" id="verificationModal">
            <div class="modal-overlay"></div>
            <div class="modal-container">
                <div class="modal-content">
                    <!-- Кнопка закрытия -->
                    <button class="modal-close" id="closeVerificationModal" aria-label="Закрыть">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    <!-- Заголовок -->
                    <div class="modal-header">
                        <div class="icon-wrapper">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h2 class="font-bold text-[20px] sm:text-[24px] text-[#262626] leading-[1.15] text-center">Локальная проверка УКЭП</h2>
                        <p class="font-semibold text-sm sm:text-base text-secondary leading-[1.15] text-center">Инструкция по проверке электронной подписи</p>
                    </div>

                    <!-- Содержимое -->
                    <div class="modal-body">
                        <div class="instruction-content" style="padding: 20px 0;">
                            <div class="text-content" style="display: flex; flex-direction: column; gap: 20px;">
                                <p class="font-semibold text-base text-[#262626] leading-[1.6]">
                                    Для проверки УКЭП под любым документом можно воспользоваться мобильным приложением SmartToken-PRO.
                                </p>

                                <p class="font-semibold text-base text-[#262626] leading-[1.6]">
                                    Для этого через любое приложение (мессенджеры, e-mail...) загрузите документ с УКЭП на свой смартфон и с помощью функции "Поделиться" переправьте документ в приложение SmartToken-PRO для проверки.
                                </p>

                                <p class="font-semibold text-base text-[#262626] leading-[1.6]">
                                    Если документ с УКЭП уже существует на смартфоне, просто загрузите его в приложение.
                                </p>
                            </div>

                            <div class="contact-info" style="margin-top: 30px; text-align: center;">
                                <p class="font-semibold text-sm text-secondary leading-[1.4]">
                                    Нужна помощь? Свяжитесь с нами: <a href="tel:+74953633093" class="text-primary underline">+7 (495) 363-30-93</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
get_footer();
