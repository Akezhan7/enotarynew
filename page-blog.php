<?php
/**
 * Template Name: Блог
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
                <span class="text-dark">Блог</span>
            </div>
        </div>

        <!-- Hero секция - Блог -->
        <section class="page-hero-section responsive-container">
            <div class="page-hero-block" data-aos="fade-down">
                <!-- Декоративный вектор (позади текста) -->
                <div class="page-hero-vector">
                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/Vector 1.png" alt="" class="block max-w-none w-full h-full object-contain">
                </div>
                <!-- Заголовок поверх вектора -->
                <p class="page-hero-title">Блог</p>
            </div>
        </section>

        <!-- Список постов блога -->
        <section class="w-full responsive-container py-6 sm:py-8 md:py-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <?php
                // Получаем посты
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 9,
                    'orderby' => 'date',
                    'order' => 'DESC'
                );
                $blog_query = new WP_Query($args);

                if ($blog_query->have_posts()) :
                    while ($blog_query->have_posts()) : $blog_query->the_post();
                ?>
                    <article class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden hover:shadow-lg transition-shadow">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="w-full h-[200px] overflow-hidden">
                                <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover')); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="font-semibold text-xs text-secondary"><?php echo get_the_date(); ?></span>
                            </div>
                            
                            <h3 class="font-bold text-lg text-[#262626] mb-3 leading-[1.3]">
                                <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            
                            <p class="font-semibold text-sm text-secondary mb-4 leading-[1.4]">
                                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                            </p>
                            
                            <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 font-bold text-sm text-primary hover:opacity-70 transition-opacity">
                                Читать далее
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 4L12 8L8 12L6.6 10.6L8.2 9H4V7H8.2L6.6 5.4L8 4Z" fill="currentColor"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <div class="col-span-full bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] p-8 text-center">
                        <p class="font-semibold text-base text-secondary">Пока нет опубликованных статей</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

<?php
get_footer();
?>
