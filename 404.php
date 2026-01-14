<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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
        <span class="text-dark">Ошибка 404</span>
    </div>
</div>

<!-- 404 секция -->
<section class="w-full responsive-container py-8 md:py-12 lg:py-16">
    <div class="max-w-[800px] mx-auto text-center">
        
        <!-- Большая цифра 404 -->
        <div class="mb-6 md:mb-8" data-aos="fade-down">
            <h1 class="font-extrabold text-[120px] sm:text-[160px] md:text-[200px] lg:text-[240px] text-primary leading-none tracking-tight opacity-20">
                404
            </h1>
        </div>
        
        <!-- Заголовок -->
        <div class="mb-4 md:mb-6" data-aos="fade-up" data-aos-delay="100">
            <h2 class="font-bold text-[24px] sm:text-[28px] md:text-[32px] lg:text-[36px] text-dark leading-[1.2]">
                Страница не найдена
            </h2>
        </div>
        
        <!-- Описание -->
        <div class="mb-8 md:mb-10" data-aos="fade-up" data-aos-delay="200">
            <p class="font-semibold text-[14px] sm:text-[15px] md:text-base text-secondary leading-[1.4] max-w-[600px] mx-auto">
                К сожалению, запрашиваемая страница не существует или была удалена. 
                Возможно, вы перешли по устаревшей ссылке или ошиблись при вводе адреса.
            </p>
        </div>
        
        <!-- Кнопки действий -->
        <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center items-center mb-10 md:mb-12" data-aos="fade-up" data-aos-delay="300">
            <a href="<?php echo home_url(); ?>" 
               class="bg-primary w-full sm:w-auto min-w-[200px] h-[46px] flex items-center justify-center rounded-[10px] px-6 py-2.5 hover:opacity-90 transition-opacity no-underline">
                <span class="font-bold text-[15px] text-white">На главную</span>
            </a>
        </div>
        
      
        
    </div>
</section>

<?php
get_footer();
