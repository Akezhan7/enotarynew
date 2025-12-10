<?php
/**
 * The template for displaying the front page
 *
 * @package enotarynew
 */

get_header();
?>

        <!-- Hero секция с градиентным фоном -->
        <div class="hero-section-wrapper w-full">
            <!-- Герой секция -->
            <section class="w-full responsive-container py-[20px] lg:py-[50px] flex items-center justify-between">
                <div class="w-full max-w-[1432px] flex flex-col lg:flex-row gap-8 sm:gap-10 md:gap-12 lg:gap-12 items-center justify-between">
                    <!-- Левая часть: текстовый контент -->
                    <div class="flex flex-col items-start justify-center leading-[1.15] w-full lg:w-1/2" data-aos="fade-right" data-aos-duration="800">
                        <p class="font-extrabold text-[32px] sm:text-[44px] md:text-[56px] lg:text-[64px] xl:text-[72px] text-primary tracking-[-1.5px] sm:tracking-[-2px] lg:tracking-[-2.88px] leading-[1.15]">ВСЁ</p>
                        <p class="font-bold text-[16px] sm:text-[22px] md:text-[28px] lg:text-[32px] xl:text-[36px] text-secondary leading-[1.15]">для работы с</p>
                        <p class="font-extrabold text-[32px] sm:text-[44px] md:text-[56px] lg:text-[64px] xl:text-[72px] text-primary tracking-[-1.5px] sm:tracking-[-2px] lg:tracking-[-2.88px] leading-[1.15]">Электронной подписью</p>
                    </div>
                    
                    <!-- Правая часть: изображение -->
                    <div class="flex items-center justify-center lg:justify-end w-full lg:w-1/2" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner.png" alt="Электронная подпись" class="w-full h-auto object-contain">
                    </div>
                </div>
            </section>

            <!-- Описание и кнопки -->
            <section class="w-full responsive-container py-5 lg:py-6 flex flex-col gap-5 items-center justify-center">
                <p class="font-semibold text-sm md:text-base text-center text-[#262626] w-full max-w-[766px] leading-[1.3]" data-aos="fade-up" data-aos-delay="200">УЦ e-Notary в партнерстве с рядом аккредитованных УЦ изготавливает и обслуживает сертификаты усиленной квалифицированной электронной подписи (УКЭП) для ЮЛ, ФЛ, ИП, для сотрудников ЮЛ и ИП, а также машиночитаемые доверенности (МЧД)</p>
                <div class="flex flex-col sm:flex-row gap-3 md:gap-4 lg:gap-5 w-full max-w-[530px]">
                    <a href="<?php echo enotarynew_get_page_url_by_template('page-order-ukep.php'); ?>" class="bg-primary flex-1 h-[44px] sm:h-[46px] flex items-center justify-center rounded-[10px] px-3 py-2.5 hover:opacity-90 transition-opacity min-w-0 no-underline" data-aos="fade-right" data-aos-delay="300">
                        <p class="font-bold text-sm md:text-base text-white text-center leading-[1.15]">Заказать УКЭП	 </p>
                    </a>
                    <a href="<?php echo enotarynew_get_page_url_by_template('page-order-mchd.php'); ?>" class="bg-green-btn flex-1 h-[44px] sm:h-[46px] flex items-center justify-center rounded-[10px] px-3 py-2.5 hover:opacity-90 transition-opacity min-w-0 no-underline" data-aos="fade-up" data-aos-delay="400">
                        <p class="font-bold text-sm md:text-base text-white text-center leading-[1.15]">Заказать МЧД</p>
                    </a>
                    <a href="<?php echo enotarynew_get_page_url_by_template('page-order-unep.php'); ?>" class="bg-blue-btn flex-1 h-[44px] sm:h-[46px] flex items-center justify-center rounded-[10px] px-3 py-2.5 hover:opacity-90 transition-opacity min-w-0 no-underline" data-aos="fade-left" data-aos-delay="500">
                        <p class="font-bold text-sm md:text-base text-white text-center leading-[1.15]">Заказать УНЭП</p>
                    </a>
                </div>
            </section>

            <!-- Дополнительная информация -->
            <section class="w-full responsive-container py-5 pb-[40px] lg:pb-[50px] flex flex-col gap-5 items-center justify-center">
                <div class="font-semibold text-sm md:text-base text-center text-[#262626] leading-[1.3]" data-aos="fade-up" data-aos-delay="600">
                    <p class="opacity-60 w-full max-w-[806px] mb-5 mx-auto">Сертификаты УКЭП отличаются наличием ряда расширений, позволяющих их владельцам работать на различных государственных и коммерческих ресурсах. <br class="hidden sm:block">При заказе эти расширения включаются в состав базового сертификата, который сам по себе обеспечивает работу пользователей более чем на 52 площадках. (ссылка на список площадок)</p>
                    <p class="opacity-60 w-full max-w-[766px] mx-auto">Схемы получения сертификата зависят от статуса клиента (ЮЛ, ИП, ФЛ), наличия/отсутствия действующего сертификата УКЭП и возможности использования мобильного приложения Госключ для идентификации.</p>
                </div>
            </section>
        </div>

        <!-- УКЭП - схемы получения -->
        <section class="w-full responsive-container py-[30px] md:py-[40px] lg:py-[50px] flex flex-col gap-6 md:gap-8 lg:gap-10 items-center justify-center">
            <h2 class="font-bold text-[24px] sm:text-[32px] md:text-[40px] lg:text-[50px] text-center text-[#262626] tracking-[-1.5px] w-full max-w-[1364px] leading-[1.05]" data-aos="fade-up">Усиленная квалифицированная электронная подпись (УКЭП).<br class="hidden sm:block">Схемы получения</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 lg:gap-5 w-full max-w-[1432px]">
                <!-- Карточка 1 -->
                <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] lg:rounded-[20px] p-4 lg:p-5 flex flex-col gap-4 lg:gap-5 hover:shadow-lg transition-shadow" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex gap-2.5 items-center">
                        <div class="w-[46px] h-[46px] flex-shrink-0">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/1.png" alt="1" class="w-full h-full object-contain">
                        </div>
                        <p class="flex-1 font-bold text-sm lg:text-base text-[#262626] leading-[1.15]">Первичное получение УКЭП руководителем ЮЛ или ИП</p>
                    </div>
                    <ol class="flex-1 font-semibold text-[13px] lg:text-[14px] text-[#262626] opacity-80 leading-[1.4] list-decimal pl-[21px]">
                        <li>Выбор сертификата и необходимых расширений</li>
                        <li>Оплата сертификата, необходимого ПО и дополнительных услуг (по счету, QR-коду)</li>
                        <li>Переход в ЛК УЦ, заполнение заявки</li>
                        <li>Идентификация в партнерском УЦ и получение сертификата УКЭП</li>
                    </ol>
                </div>

                <!-- Карточка 2 -->
                <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] lg:rounded-[20px] p-4 lg:p-5 flex flex-col gap-4 lg:gap-5 hover:shadow-lg transition-shadow" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex gap-2.5 items-center">
                        <div class="w-[46px] h-[46px] flex-shrink-0">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/2.png" alt="2" class="w-full h-full object-contain">
                        </div>
                        <p class="flex-1 font-bold text-sm lg:text-base text-[#262626] leading-[1.15]">Первичное получение УКЭП ФЛ, сотрудниками ЮЛ и ИП</p>
                    </div>
                    <ol class="flex-1 font-semibold text-[13px] lg:text-[14px] text-[#262626] opacity-80 leading-[1.4] list-decimal pl-[21px]">
                        <li>Выбор сертификата и необходимых расширений</li>
                        <li>Оплата сертификата, необходимого ПО и дополнительных услуг (по счету, QR-коду)</li>
                        <li>Установка и настройка ПО</li>
                        <li>Переход в ЛК УЦ, заполнение заявки, генерация ключей и запроса на сертификат</li>
                        <li>Идентификация в УЦ e-Notary и получение сертификата УКЭП</li>
                    </ol>
                </div>

                <!-- Карточка 3 -->
                <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] lg:rounded-[20px] p-4 lg:p-5 flex flex-col gap-4 lg:gap-5 hover:shadow-lg transition-shadow" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex gap-2.5 items-center">
                        <div class="w-[46px] h-[46px] flex-shrink-0">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/3.png" alt="3" class="w-full h-full object-contain">
                        </div>
                        <p class="flex-1 font-bold text-sm lg:text-base text-[#262626] leading-[1.15]">Продление действующего сертификата УКЭП</p>
                    </div>
                    <ol class="flex-1 font-semibold text-[13px] lg:text-[14px] text-[#262626] opacity-80 leading-[1.4] list-decimal pl-[21px]">
                        <li>Выбор сертификата и необходимых расширений</li>
                        <li>Оплата сертификата, необходимого ПО и дополнительных услуг (по счету, QR-коду)</li>
                        <li>Переход в ЛК УЦ, заполнение заявки, генерация ключей, запроса на сертификат, подписанного на старом ключе, и получение сертификата</li>
                    </ol>
                </div>

                <!-- Карточка 4 -->
                <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] lg:rounded-[20px] p-4 lg:p-5 flex flex-col gap-4 lg:gap-5 hover:shadow-lg transition-shadow" data-aos="fade-up" data-aos-delay="400">
                    <div class="flex gap-2.5 items-center">
                        <div class="w-[46px] h-[46px] flex-shrink-0">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/4.png" alt="4" class="w-full h-full object-contain">
                        </div>
                        <p class="flex-1 font-bold text-sm lg:text-base text-[#262626] leading-[1.15]">Получение сертификата УКЭП с помощь МП Госключ</p>
                    </div>
                    <ol class="font-semibold text-[13px] lg:text-[14px] text-[#262626] opacity-80 leading-[1.4] list-decimal pl-[21px]">
                        <li>Выбор сертификата и необходимых расширений</li>
                        <li>Оплата сертификата, необходимого ПО и дополнительных услуг (по счету, QR-коду)</li>
                        <li>Переход в ЛК УЦ, заполнение заявки, генерация ключей, запроса на сертификат, подписанного ключом из МП Госключ, идентификация с помощью биометрического паспорта и телефона с функцией NFC, и получение сертификата</li>
                    </ol>
                </div>
            </div>

            <a href="<?php echo enotarynew_get_page_url_by_template('page-order-ukep.php'); ?>" class="bg-primary h-[44px] sm:h-[46px] w-full max-w-[240px] flex items-center justify-center rounded-[10px] px-3 py-2.5 hover:opacity-90 transition-opacity no-underline" data-aos="zoom-in" data-aos-delay="500">
                <p class="font-bold text-sm md:text-base text-white text-center leading-[1.15]">Заказать УКЭП	 </p>
            </a>
        </section>

        <!-- МЧД - машиночитаемая доверенность -->
        <div class="w-full">
            <section class="responsive-container py-[30px] md:py-[40px] lg:py-[50px] flex flex-col gap-6 md:gap-8 lg:gap-10 items-center justify-center">
            <div class="flex flex-col gap-4 lg:gap-5 items-center text-center text-[#262626]">
                <h2 class="font-bold text-[24px] sm:text-[32px] md:text-[40px] lg:text-[50px] tracking-[-1.5px] w-full max-w-[720px] leading-[1.05]" data-aos="fade-up">МЧД - машиночитаемая доверенность</h2>
                <p class="font-semibold text-sm md:text-base w-full max-w-[882px] leading-[1.3]" data-aos="fade-up" data-aos-delay="100">С 1 сентября 2024 года машиночитаемая доверенность (МЧД) нужна всем сотрудникам, которые подписывают документы от имени компании.<br class="hidden sm:block">МЧД — это электронный файл в формате XML, аналог бумажной доверенности, в котором указана информация о доверителе, уполномоченном лице и полномочиях, которые оно получает.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-5 w-full max-w-[1432px]">
                <!-- Преимущества -->
                <div class="bg-white rounded-[15px] lg:rounded-[20px] p-4 lg:p-5 flex flex-col sm:flex-row gap-4 hover:shadow-lg transition-shadow" data-aos="fade-right" data-aos-delay="200">
                    <div class="w-10 h-10 relative flex-shrink-0">
                        <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/solar_info-square-bold-duotone.png" alt="Info icon" class="block max-w-none w-full h-full object-contain">
                    </div>
                    <div class="flex-1 flex flex-col gap-4 lg:gap-5">
                        <p class="font-bold text-[18px] md:text-[22px] lg:text-[26px] text-[#262626] leading-[1.15]">Преимущества для клиентов:</p>
                        <div class="flex flex-col gap-1.5 font-semibold text-sm md:text-base text-[#262626] leading-[1.3]">
                            <p>МЧД для СФР, ФНС, ФТС или ЭДО (форматы 003, СФР)</p>
                            <p>Подписание МЧД доверителем по уникальной ссылке в один клик</p>
                            <p>Хранение и доступность доверенности 24/7 по той же ссылке</p>
                            <p>Возможность отмены МЧД доверителем</p>
                        </div>
                    </div>
                </div>

                <!-- Для создания МЧД -->
                <div class="bg-white rounded-[15px] lg:rounded-[20px] p-4 lg:p-5 flex flex-col sm:flex-row gap-4 hover:shadow-lg transition-shadow" data-aos="fade-left" data-aos-delay="200">
                    <div class="w-10 h-10 relative flex-shrink-0">
                        <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/solar_info-square-bold-duotone.png" alt="Info icon" class="block max-w-none w-full h-full object-contain">
                    </div>
                    <div class="flex-1 flex flex-col gap-4 lg:gap-5">
                        <p class="font-bold text-[18px] md:text-[22px] lg:text-[26px] text-[#262626] leading-[1.15]">Для создания МЧД необходимо:</p>
                        <div class="flex flex-col gap-1.5 font-semibold text-sm md:text-base text-[#262626] leading-[1.3]">
                            <p>ИНН, СНИЛС и разворот паспорта физ. лица –представителя ЮЛ/ИП;</p>
                            <p>ИНН и наименование организации – доверителя;</p>
                            <p>ИНН, СНИЛС и разворот паспорта руководителя;</p>
                            <p>Наименование площадки/площадок, для которых формируется МЧД.</p>
                            <p>Делегируемые полномочия</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-[20px] lg:gap-[30px] items-center w-full max-w-[1100px]">
                <p class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-center text-[#262626] w-full leading-[1.15]" data-aos="fade-up" data-aos-delay="300">Как работать с машиночитаемой доверенностью</p>
                <div class="flex flex-col gap-4 lg:gap-5 font-semibold text-sm md:text-base text-center text-[#262626]" data-aos="fade-up" data-aos-delay="400">
                    <p class="leading-[1.3] w-full">Сначала ЮЛ или ИП должны заказать в УЦ сертификат УКЭП для своего сотрудника (как физического лица) и оформить МЧД, подписанную руководителем или ИП с использованием своей УКЭП и зарегистрировать ее в распределённом реестре ФНС. Подписание документов от имени ЮЛ или ИП будет осуществляться в связке УКЭП физического лица + МЧД.</p>
                    <p class="leading-[1.3] w-full">По каждой заявке на МЧД создается индивидуальная ссылка для дистанционного выпуска МЧД или для подписания доверенности руководителем или ИП. Эта ссылка не пропадает и, если клиент потерял архив с МЧД, он всегда сможет его заново скачать. Утилита подписания МЧД руководителем встроена внутри СРМ-системы УЦ и подписание происходит по кнопке "Подписать" прямо в ней.</p>
                </div>
            </div>

            <a href="<?php echo enotarynew_get_page_url_by_template('page-order-mchd.php'); ?>" class="bg-green-btn h-[44px] sm:h-[46px] w-full max-w-[240px] flex items-center justify-center rounded-[10px] px-3 py-2.5 hover:opacity-90 transition-opacity no-underline" data-aos="zoom-in" data-aos-delay="500">
                <p class="font-bold text-sm md:text-base text-white text-center leading-[1.15]">Заказать МЧД</p>
            </a>
        </section>
        </div>

        <!-- УНЭП -->
        <section class="w-full responsive-container py-[30px] md:py-[40px] lg:py-[50px] flex flex-col gap-6 md:gap-8 lg:gap-10 items-center justify-center">
            <h2 class="font-bold text-[24px] sm:text-[32px] md:text-[40px] lg:text-[50px] text-center text-[#262626] tracking-[-1.5px] w-full max-w-[918px] leading-[1.05]" data-aos="fade-up">Усиленная неквалифицированная электронная подпись (УНЭП)</h2>
            
            <div class="flex flex-col lg:flex-row gap-5 lg:gap-6 items-start w-full max-w-[1432px]">
                <div class="flex flex-col gap-4 lg:gap-5 font-bold text-sm md:text-base text-[#262626] leading-[1.15] w-full lg:flex-1" data-aos="fade-right" data-aos-delay="100">
                    <p class="w-full">УНЭП, как правило, используется в корпоративных приложениях и системах и может выпускаться на основе индивидуальных регламентов.</p>
                    <p class="w-full">УЦ e-Notary оказывает услуги ФЛ и сотрудникам ЮЛ и ИП по изготовлению и обслуживанию сертификатов УНЭП</p>
                    <p class="w-full">УЦ работает в 2-х режимах: прямая выдача сертификатов и работа в режиме аутсорсинга.</p>
                    <p class="w-full">В первом режиме запрос на сертификат поступает в УЦ и сертифицируется по письменному заявлению от ЮЛ по идентификации конкретного сотрудника или непосредственно от ФЛ</p>
                    <p class="w-full">В режиме аутсорсинга у ЮЛ устанавливается АРМ <a href="https://www.signal-com.ru/products/pki/notary-pro-ra/" class="font-bold text-sm md:text-base text-[#262626] leading-[1.15] underline hover:opacity-70 transition-opacity">Центра Регистрации</a>, Администратор которого отвечает за формирование, подписание и отправку запросов в УЦ и идентификацию пользователей. Выпуск сертификатов УНЭП УЦ e-Notary производит в режиме on line.</p>
                </div>
                <div class="w-full lg:w-auto lg:flex-1 h-[280px] sm:h-[350px] md:h-[400px] lg:h-[450px] max-w-[700px] mx-auto lg:mx-0 overflow-hidden relative rounded-[15px] lg:rounded-[20px] xl:rounded-[30px]" data-aos="fade-left" data-aos-delay="100">
                    <div class="absolute bg-[rgba(55,93,116,0.15)] inset-0 rounded-[15px] lg:rounded-[20px] xl:rounded-[30px]"></div>
                    <div class="absolute inset-0 rounded-[15px] lg:rounded-[20px] overflow-hidden">
                        <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/unep-illustration.png" alt="УНЭП illustration" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <a href="<?php echo enotarynew_get_page_url_by_template('page-order-unep.php'); ?>" class="bg-blue-btn h-[44px] sm:h-[46px] w-full max-w-[240px] flex items-center justify-center rounded-[10px] px-3 py-2.5 hover:opacity-90 transition-opacity no-underline" data-aos="zoom-in" data-aos-delay="200">
                <p class="font-bold text-sm md:text-base text-white text-center leading-[1.15]">Заказать УНЭП</p>
            </a>
        </section>

<?php
get_footer();
