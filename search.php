<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package enotarynew
 */

get_header();

// Получаем поисковый запрос
$search_query = get_search_query();

// WordPress автоматически создает query для search, используем глобальный $wp_query
global $wp_query;
?>

        <!-- Хлебные крошки -->
        <div class="w-full responsive-container pb-3 lg:pb-4">
            <div class="flex items-center gap-2 font-semibold text-sm text-secondary">
                <a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors">Главная</a>
                <span>/</span>
                <span class="text-dark">Поиск</span>
            </div>
        </div>

        <!-- Заголовок блока с фоном и поиском -->
        <section class="w-full blog-container">
            <div class="blog-header-block bg-[rgba(55,93,116,0.15)] flex flex-col items-center justify-between overflow-hidden rounded-[30px] relative py-[60px] px-[20px] pb-[30px]" data-aos="fade-down">
                <!-- Заголовок -->
                <p class="blog-title font-bold text-[32px] text-center text-dark leading-[1.15] relative z-10">Результаты поиска</p>
                
                <!-- Поиск -->
                <div class="blog-search bg-white flex gap-[10px] items-center justify-between px-3 py-2.5 rounded-[10px] shadow-[0px_0px_5px_0px_rgba(0,0,0,0.06)] w-[382px] max-w-full relative z-10" data-aos="fade-up" data-aos-delay="100">
                    <input 
                        type="text" 
                        id="blogSearchInput" 
                        placeholder="Поиск" 
                        value="<?php echo esc_attr($search_query); ?>"
                        class="flex-1 font-semibold text-base text-dark leading-[1.15] outline-none bg-transparent placeholder:text-secondary"
                    >
                    <!-- Иконка поиска -->
                    <div id="searchIcon" class="overflow-clip relative w-5 h-5 flex-shrink-0 transition-opacity cursor-pointer">
                        <div class="absolute inset-[12.5%]">
                            <div class="absolute inset-[-5%]">
                                <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/blog-search.svg" alt="Search" class="block max-w-none w-full h-full">
                            </div>
                        </div>
                    </div>
                    <!-- Крестик для очистки -->
                    <div id="clearIcon" class="w-5 h-5 flex-shrink-0 transition-opacity cursor-pointer hidden">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 5L5 15M5 5L15 15" stroke="#979797" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Декоративный вектор (позади всего) -->
                <div class="blog-header-vector absolute left-1/2 top-1/2 -translate-x-1/2 translate-y-[-50%] w-[1446.5px] h-[332.959px] pointer-events-none">
                    <div class="flex-none rotate-180 scale-y-[-100%] w-full h-full">
                        <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/Vector 1.png" alt="" class="block max-w-none w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </section>

        <!-- Блоги секция -->
        <section class="w-full blog-container py-5">
            <div class="blog-grid">
                <?php
                if (have_posts()) :
                    $delay = 50;
                    while (have_posts()) : the_post();
                ?>
                    <a href="<?php the_permalink(); ?>" class="blog-card bg-white rounded-[30px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-2.5 flex flex-col gap-2.5 no-underline hover:shadow-xl transition-shadow" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                        <div class="blog-card-image h-[200px] relative rounded-[20px] overflow-hidden">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="absolute bg-[#d9d9d9] inset-0 rounded-[20px]"></div>
                                <?php the_post_thumbnail('medium_large', array('class' => 'absolute inset-0 w-full h-full object-cover rounded-[20px]')); ?>
                            <?php else : ?>
                                <div class="absolute bg-[#d9d9d9] inset-0 rounded-[20px] flex items-center justify-center">
                                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M45 50H15C13.9391 50 12.9217 49.5786 12.1716 48.8284C11.4214 48.0783 11 47.0609 11 46V14C11 12.9391 11.4214 11.9217 12.1716 11.1716C12.9217 10.4214 13.9391 10 15 10H45C46.0609 10 47.0783 10.4214 47.8284 11.1716C48.5786 11.9217 49 12.9391 49 14V46C49 47.0609 48.5786 48.0783 47.8284 48.8284C47.0783 49.5786 46.0609 50 45 50ZM45 14H15V46H45V14Z" fill="#979797"/>
                                        <path d="M20 34L30 24L45 39" stroke="#979797" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="23" cy="23" r="3" fill="#979797"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-2.5 flex flex-col gap-2.5 flex-1">
                            <div class="blog-card-content flex flex-col gap-2.5">
                                <p class="blog-card-category font-semibold text-[14px] text-secondary leading-[1.15]">
                                    <?php 
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        echo esc_html($categories[0]->name);
                                    } else {
                                        echo 'Статья';
                                    }
                                    ?>
                                </p>
                                <p class="blog-card-title font-bold text-[20px] text-dark leading-[1.15]"><?php the_title(); ?></p>
                                <p class="blog-card-description font-semibold text-base text-dark opacity-80 leading-[1.15]">
                                    <?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?>
                                </p>
                            </div>
                            <div class="blog-card-meta flex gap-2.5 items-center flex-wrap">
                                <p class="font-semibold text-[14px] text-secondary leading-[1.15] whitespace-nowrap"><?php echo get_the_date('j F Y г.'); ?></p>
                                <div class="w-[6px] h-[6px] flex-shrink-0">
                                    <div class="w-full h-full bg-secondary rounded-full"></div>
                                </div>
                                <div class="flex gap-[6px] items-center">
                                    <div class="overflow-clip relative w-5 h-5 flex-shrink-0">
                                        <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/blog-clock.svg" alt="Time" class="block w-full h-full object-contain">
                                    </div>
                                    <p class="font-semibold text-[14px] text-secondary leading-[1.15] whitespace-nowrap">
                                        <?php
                                        $content = get_the_content();
                                        $word_count = str_word_count(strip_tags($content));
                                        $reading_time = ceil($word_count / 200); // ~200 слов в минуту
                                        echo $reading_time . ' ' . _n('минута', 'минут', $reading_time, 'enotarynew') . ' чтения';
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php
                        $delay += 50;
                    endwhile;
                else :
                ?>
                    <div class="col-span-full bg-white border border-[rgba(0,0,0,0.05)] rounded-[30px] p-8 text-center">
                        <p class="font-semibold text-base text-secondary mb-4">По запросу "<?php echo esc_html($search_query); ?>" ничего не найдено</p>
                        <p class="font-normal text-sm text-secondary mb-4">Попробуйте изменить запрос или</p>
                        <a href="<?php echo get_permalink(get_page_by_path('blog')); ?>" class="inline-block font-semibold text-sm text-primary hover:underline">Показать все статьи блога</a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($wp_query->max_num_pages > 1) : ?>
            <!-- Пагинация -->
            <div class="pagination-container mt-10 flex justify-center items-center gap-2">
                <?php
                $current_page = max(1, get_query_var('paged'));
                $total_pages = $wp_query->max_num_pages;
                
                // Предыдущая страница
                if ($current_page > 1) :
                    $prev_link = get_search_link($search_query);
                    if ($current_page > 2) {
                        $prev_link = add_query_arg('paged', $current_page - 1, $prev_link);
                    }
                ?>
                    <a href="<?php echo esc_url($prev_link); ?>" class="pagination-arrow w-10 h-10 flex items-center justify-center rounded-lg bg-white border border-[rgba(0,0,0,0.05)] hover:bg-[rgba(55,93,116,0.1)] transition-colors">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.5 15L7.5 10L12.5 5" stroke="#375d74" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                <?php endif; ?>

                <?php
                // Логика отображения страниц
                $range = 2; // Сколько страниц показывать слева и справа от текущей
                
                for ($i = 1; $i <= $total_pages; $i++) :
                    if ($i == 1 || $i == $total_pages || ($i >= $current_page - $range && $i <= $current_page + $range)) :
                        $page_link = get_search_link($search_query);
                        if ($i > 1) {
                            $page_link = add_query_arg('paged', $i, $page_link);
                        }
                        
                        if ($i == $current_page) :
                ?>
                            <span class="pagination-number w-10 h-10 flex items-center justify-center rounded-lg bg-primary text-white font-bold text-sm"><?php echo $i; ?></span>
                        <?php else : ?>
                            <a href="<?php echo esc_url($page_link); ?>" class="pagination-number w-10 h-10 flex items-center justify-center rounded-lg bg-white border border-[rgba(0,0,0,0.05)] hover:bg-[rgba(55,93,116,0.1)] transition-colors font-semibold text-sm text-dark"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php elseif ($i == $current_page - $range - 1 || $i == $current_page + $range + 1) : ?>
                        <span class="pagination-dots text-secondary font-bold">...</span>
                    <?php endif; ?>
                <?php endfor; ?>

                <!-- Следующая страница -->
                <?php if ($current_page < $total_pages) :
                    $next_link = add_query_arg('paged', $current_page + 1, get_search_link($search_query));
                ?>
                    <a href="<?php echo esc_url($next_link); ?>" class="pagination-arrow w-10 h-10 flex items-center justify-center rounded-lg bg-white border border-[rgba(0,0,0,0.05)] hover:bg-[rgba(55,93,116,0.1)] transition-colors">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.5 5L12.5 10L7.5 15" stroke="#375d74" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </section>

<?php
get_footer();
?>
