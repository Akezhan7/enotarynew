<?php
/**
 * Template Name: Контакты
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
                <span class="text-dark">Контакты</span>
            </div>
        </div>

        <!-- Hero секция - Контакты -->
        <section class="page-hero-section responsive-container">
            <div class="page-hero-block" data-aos="fade-down">
                <!-- Декоративный вектор (позади текста) -->
                <div class="page-hero-vector">
                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/Vector 1.png" alt="" class="block max-w-none w-full h-full object-contain">
                </div>
                <!-- Заголовок поверх вектора -->
                <p class="page-hero-title">Контакты</p>
            </div>
        </section>

        <!-- Основной контент страницы -->
        <section class="w-full responsive-container py-6 sm:py-8 md:py-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                <!-- Контактная информация -->
                <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] p-6 sm:p-8">
                    <h2 class="font-bold text-[20px] sm:text-[24px] text-[#262626] leading-[1.15] mb-6">Наши контакты</h2>
                    
                    <div class="flex flex-col gap-4">
                        <div>
                            <p class="font-semibold text-sm text-secondary mb-2">Телефон:</p>
                            <a href="tel:+74953633093" class="font-bold text-base text-[#262626] hover:text-primary transition-colors">+7 (495) 363-30-93</a>
                        </div>
                        
                        <div>
                            <p class="font-semibold text-sm text-secondary mb-2">Telegram:</p>
                            <a href="https://t.me/SmartTokenPro1" target="_blank" class="font-bold text-base text-[#262626] hover:text-primary transition-colors">@SmartTokenPro1</a>
                        </div>
                        
                        <div>
                            <p class="font-semibold text-sm text-secondary mb-2">Email:</p>
                            <a href="mailto:info@e-notary.ru" class="font-bold text-base text-[#262626] hover:text-primary transition-colors">info@e-notary.ru</a>
                        </div>
                    </div>
                </div>

                <!-- Карта или дополнительная информация -->
                <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] p-6 sm:p-8">
                    <h2 class="font-bold text-[20px] sm:text-[24px] text-[#262626] leading-[1.15] mb-6">Режим работы</h2>
                    
                    <div class="flex flex-col gap-3">
                        <p class="font-semibold text-base text-[#262626]">
                            <span class="text-secondary">Пн-Пт:</span> 9:00 - 18:00
                        </p>
                        <p class="font-semibold text-base text-[#262626]">
                            <span class="text-secondary">Сб-Вс:</span> Выходной
                        </p>
                    </div>
                </div>
            </div>
        </section>

<?php
get_footer();
?>
