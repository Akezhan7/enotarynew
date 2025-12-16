<?php
/**
 * Template Name: Документы
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
                <span class="text-dark">Документы</span>
            </div>
        </div>

        <!-- Hero секция - Документы -->
        <section class="page-hero-section responsive-container">
            <div class="page-hero-block" data-aos="fade-down">
                <!-- Декоративный вектор (позади текста) -->
                <div class="page-hero-vector">
                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/Vector 1.png" alt="" class="block max-w-none w-full h-full object-contain">
                </div>
                <!-- Заголовок поверх вектора -->
                <p class="page-hero-title">Документы</p>
            </div>
        </section>

        <!-- Документы секция -->
        <section class="w-full documents-container py-4 sm:py-5">
            <div class="documents-grid">
                <!-- Документ 1 -->
                <div class="document-card bg-white rounded-[15px] lg:rounded-[20px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-4 lg:p-5 flex flex-col gap-4 lg:gap-5 justify-between min-h-[170px] sm:min-h-[180px] lg:min-h-[191px] hover:shadow-lg transition-shadow cursor-pointer" data-aos="fade-up" data-aos-delay="50">
                    <div class="w-[46px] h-[46px] flex-shrink-0">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/pdf.png" alt="PDF" class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col gap-[6px] leading-[1.15]">
                        <p class="font-semibold text-[13px] lg:text-[14px] text-secondary">Набор документов для ознакомления с работой УЦ<br>и помощи клиентам</p>
                        <p class="font-bold text-[18px] lg:text-[20px] text-dark">Регламент УЦ по выпуску УКЭП</p>
                    </div>
                </div>

                <!-- Документ 2 -->
                <div class="document-card bg-white rounded-[15px] lg:rounded-[20px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-4 lg:p-5 flex flex-col gap-4 lg:gap-5 justify-between min-h-[170px] sm:min-h-[180px] lg:min-h-[191px] hover:shadow-lg transition-shadow cursor-pointer" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-[46px] h-[46px] flex-shrink-0">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/pdf.png" alt="PDF" class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col gap-[6px] leading-[1.15]">
                        <p class="font-semibold text-[13px] lg:text-[14px] text-secondary">Набор документов для ознакомления с работой УЦ<br>и помощи клиентам</p>
                        <p class="font-bold text-[18px] lg:text-[20px] text-dark">Регламент УЦ по выпуску УНЭП</p>
                    </div>
                </div>

                <!-- Документ 3 -->
                <div class="document-card bg-white rounded-[15px] lg:rounded-[20px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-4 lg:p-5 flex flex-col gap-4 lg:gap-5 justify-between min-h-[170px] sm:min-h-[180px] lg:min-h-[191px] hover:shadow-lg transition-shadow cursor-pointer" data-aos="fade-up" data-aos-delay="150">
                    <div class="w-[46px] h-[46px] flex-shrink-0">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/pdf.png" alt="PDF" class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col gap-[6px] leading-[1.15]">
                        <p class="font-semibold text-[13px] lg:text-[14px] text-secondary">Набор документов для ознакомления с работой УЦ<br>и помощи клиентам</p>
                        <p class="font-bold text-[18px] lg:text-[20px] text-dark">Инструкция по заказу МЧД</p>
                    </div>
                </div>

                <!-- Документ 4 -->
                <div class="document-card bg-white rounded-[15px] lg:rounded-[20px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-4 lg:p-5 flex flex-col gap-4 lg:gap-5 justify-between min-h-[170px] sm:min-h-[180px] lg:min-h-[190px] hover:shadow-lg transition-shadow cursor-pointer" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-[46px] h-[46px] flex-shrink-0">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/pdf.png" alt="PDF" class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col gap-[6px] leading-[1.15]">
                        <p class="font-semibold text-[13px] lg:text-[14px] text-secondary">Набор документов для ознакомления с работой УЦ<br>и помощи клиентам</p>
                        <p class="font-bold text-[18px] lg:text-[20px] text-dark">Инструкция по работе<br>Мульти-Инсталлятора</p>
                    </div>
                </div>

                <!-- Документ 5 -->
                <div class="document-card bg-white rounded-[15px] lg:rounded-[20px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-4 lg:p-5 flex flex-col gap-4 lg:gap-5 justify-between min-h-[170px] sm:min-h-[180px] lg:min-h-[190px] hover:shadow-lg transition-shadow cursor-pointer" data-aos="fade-up" data-aos-delay="250">
                    <div class="w-[46px] h-[46px] flex-shrink-0">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/pdf.png" alt="PDF" class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col gap-[6px] leading-[1.15]">
                        <p class="font-semibold text-[13px] lg:text-[14px] text-secondary">Набор документов для ознакомления с работой УЦ<br>и помощи клиентам</p>
                        <p class="font-bold text-[18px] lg:text-[20px] text-dark">Договор оферты</p>
                    </div>
                </div>

                <!-- Документ 6 -->
                <div class="document-card bg-white rounded-[15px] lg:rounded-[20px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-4 lg:p-5 flex flex-col gap-4 lg:gap-5 justify-between min-h-[170px] sm:min-h-[180px] lg:min-h-[190px] hover:shadow-lg transition-shadow cursor-pointer" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-[46px] h-[46px] flex-shrink-0">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/pdf.png" alt="PDF" class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col gap-[6px] leading-[1.15]">
                        <p class="font-semibold text-[13px] lg:text-[14px] text-secondary">Набор документов для ознакомления с работой УЦ<br>и помощи клиентам</p>
                        <p class="font-bold text-[18px] lg:text-[20px] text-dark">Законодательство</p>
                    </div>
                </div>

                <!-- Документ 7 -->
                <div class="document-card bg-white rounded-[15px] lg:rounded-[20px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-4 lg:p-5 flex flex-col gap-4 lg:gap-5 justify-between min-h-[170px] sm:min-h-[180px] lg:min-h-[190px] hover:shadow-lg transition-shadow cursor-pointer" data-aos="fade-up" data-aos-delay="350">
                    <div class="w-[46px] h-[46px] flex-shrink-0">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/pdf.png" alt="PDF" class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col gap-[6px] leading-[1.15]">
                        <p class="font-semibold text-[13px] lg:text-[14px] text-secondary">Набор документов для ознакомления с работой УЦ<br>и помощи клиентам</p>
                        <p class="font-bold text-[18px] lg:text-[20px] text-dark">Перечень необходимых документов при заказе УКЭП/УНЭП</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Модальное окно -->
        <div class="modal-overlay" id="documentModal">
            <div class="modal-content bg-white flex flex-col rounded-[20px] overflow-hidden w-full max-w-[494px] mx-4">
                <!-- Шапка модалки -->
                <div class="border-b border-[rgba(0,0,0,0.05)] flex gap-2.5 items-start p-5">
                    <div class="flex flex-col gap-4 flex-1 text-dark leading-[1.15]">
                        <p class="font-bold text-[20px]">Документы</p>
                        <p class="font-semibold text-[14px]" id="modalDocumentTitle">Регламент УЦ по выпуску УКЭП</p>
                    </div>
                    <button class="bg-[rgba(0,0,0,0.05)] p-2.5 rounded-[10px] flex items-center justify-center flex-shrink-0 hover:bg-[rgba(0,0,0,0.1)] transition-colors" onclick="closeModal()" aria-label="Закрыть">
                        <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 4L4 12M4 4L12 12" stroke="#262626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
                
                <!-- Контент модалки -->
                <div class="flex flex-col gap-2.5 p-5">
                    <!-- Карточка 1 - Аккредитованный УЦ -->
                    <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[20px] p-5 flex flex-col gap-5 justify-between min-h-[190px] hover:shadow-lg transition-shadow cursor-pointer">
                        <div class="w-[46px] h-[46px] flex-shrink-0">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/docs.png" alt="Документ" class="w-full h-full object-contain">
                        </div>
                        <div class="flex flex-col gap-2.5 leading-[1.15]">
                            <p class="font-bold text-base text-dark text-center">Аккредитованный УЦ</p>
                            <p class="font-semibold text-[14px] text-secondary">Порядок реализации функций аккредитованного удостоверяющего центра и исполнения его обязанностей. Регламент</p>
                        </div>
                    </div>

                    <!-- Карточка 2 - Неаккредитованный УЦ -->
                    <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[20px] p-5 flex flex-col gap-5 justify-between min-h-[190px] hover:shadow-lg transition-shadow cursor-pointer">
                        <div class="w-[46px] h-[46px] flex-shrink-0">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/docs.png" alt="Документ" class="w-full h-full object-contain">
                        </div>
                        <div class="flex flex-col gap-2.5 leading-[1.15]">
                            <p class="font-bold text-base text-dark text-center">Неаккредитованный УЦ</p>
                            <p class="font-semibold text-[14px] text-secondary">Порядок реализации функций аккредитованного удостоверяющего центра и исполнения его обязанностей. Регламент</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
get_footer();
?>
