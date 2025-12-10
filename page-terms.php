<?php
/**
 * Template Name: Условия использования
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
                <span class="text-dark">Условия использования</span>
            </div>
        </div>

        <!-- Hero секция -->
        <section class="page-hero-section responsive-container">
            <div class="page-hero-block" data-aos="fade-down">
                <div class="page-hero-vector">
                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/Vector 1.png" alt="" class="block max-w-none w-full h-full object-contain">
                </div>
                <p class="page-hero-title">Условия использования</p>
            </div>
        </section>

        <!-- Основной контент -->
        <section class="w-full responsive-container py-6 sm:py-8 md:py-10">
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] p-6 sm:p-8 md:p-10">
                <div class="prose max-w-none">
                    <?php
                    if (have_posts()) :
                        while (have_posts()) : the_post();
                            the_content();
                        endwhile;
                    else :
                    ?>
                        <p class="font-semibold text-base text-[#262626] leading-[1.6]">
                            Здесь будет размещена информация об условиях использования сервиса.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

<?php
get_footer();
?>
