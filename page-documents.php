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

        <!-- Основной контент страницы -->
        <section class="w-full responsive-container py-6 sm:py-8 md:py-10">
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden">
                <!-- Документ 1 -->
                <div class="p-6 sm:p-8 border-b border-[rgba(0,0,0,0.05)]">
                    <h3 class="font-bold text-lg text-[#262626] mb-3">Лицензии и сертификаты</h3>
                    <p class="font-semibold text-sm text-secondary mb-4">Документы, подтверждающие наше право на деятельность</p>
                    <a href="#" class="inline-flex items-center gap-2 font-bold text-sm text-primary hover:opacity-70 transition-opacity">
                        Скачать документ
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 11L4 7L5.4 5.6L7 7.2V1H9V7.2L10.6 5.6L12 7L8 11Z" fill="currentColor"/>
                            <path d="M2 13H14V15H2V13Z" fill="currentColor"/>
                        </svg>
                    </a>
                </div>

                <!-- Документ 2 -->
                <div class="p-6 sm:p-8 border-b border-[rgba(0,0,0,0.05)]">
                    <h3 class="font-bold text-lg text-[#262626] mb-3">Перечень требуемых документов</h3>
                    <p class="font-semibold text-sm text-secondary mb-4">Список документов для получения ЭЦП</p>
                    <a href="#" class="inline-flex items-center gap-2 font-bold text-sm text-primary hover:opacity-70 transition-opacity">
                        Скачать документ
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 11L4 7L5.4 5.6L7 7.2V1H9V7.2L10.6 5.6L12 7L8 11Z" fill="currentColor"/>
                            <path d="M2 13H14V15H2V13Z" fill="currentColor"/>
                        </svg>
                    </a>
                </div>

                <!-- Документ 3 -->
                <div class="p-6 sm:p-8 border-b border-[rgba(0,0,0,0.05)]">
                    <h3 class="font-bold text-lg text-[#262626] mb-3">Договор оферты</h3>
                    <p class="font-semibold text-sm text-secondary mb-4">Условия предоставления услуг</p>
                    <a href="#" class="inline-flex items-center gap-2 font-bold text-sm text-primary hover:opacity-70 transition-opacity">
                        Скачать документ
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 11L4 7L5.4 5.6L7 7.2V1H9V7.2L10.6 5.6L12 7L8 11Z" fill="currentColor"/>
                            <path d="M2 13H14V15H2V13Z" fill="currentColor"/>
                        </svg>
                    </a>
                </div>

                <!-- Документ 4 -->
                <div class="p-6 sm:p-8">
                    <h3 class="font-bold text-lg text-[#262626] mb-3">Регламент УЦ</h3>
                    <p class="font-semibold text-sm text-secondary mb-4">Регламент работы Удостоверяющего Центра</p>
                    <a href="#" class="inline-flex items-center gap-2 font-bold text-sm text-primary hover:opacity-70 transition-opacity">
                        Скачать документ
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 11L4 7L5.4 5.6L7 7.2V1H9V7.2L10.6 5.6L12 7L8 11Z" fill="currentColor"/>
                            <path d="M2 13H14V15H2V13Z" fill="currentColor"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

<?php
get_footer();
?>
