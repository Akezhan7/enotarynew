<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package enotarynew
 */

get_header();
?>

<?php
while ( have_posts() ) :
	the_post();
	
	// Get post date
	$post_date = get_the_date('d.m.y');
	
	// Get categories
	$categories = get_the_category();
	$category_name = !empty($categories) ? $categories[0]->name : 'Статья';
	
	// Get reading time (estimate based on content length)
	$content = get_the_content();
	$word_count = str_word_count(strip_tags($content));
	$reading_time = ceil($word_count / 200); // Assuming 200 words per minute
	
	// Get blog page URL (find page with page-blog.php template)
	$blog_page = get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'page-blog.php',
		'number' => 1
	));
	$blog_url = !empty($blog_page) ? get_permalink($blog_page[0]->ID) : home_url('/blog/');
	?>

	<!-- Хлебные крошки -->
	<div class="w-full responsive-container pb-3 lg:pb-4">
		<div class="flex items-center gap-2 font-semibold text-sm text-secondary">
			<a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary transition-colors">Главная</a>
			<span>/</span>
			<a href="<?php echo esc_url($blog_url); ?>" class="hover:text-primary transition-colors">Блог</a>
			<span>/</span>
			<span class="text-dark">Статья</span>
		</div>
	</div>

	<!-- Заголовок статьи с фоном -->
	<section class="w-full post-container">
		<div class="post-header-block bg-[rgba(55,93,116,0.15)] flex flex-col items-center justify-center overflow-hidden rounded-[30px] relative py-[20px] px-[20px]" data-aos="fade-down">
			<!-- Контейнер для текста -->
			<div class="flex flex-col items-center justify-center gap-[10px] relative z-10">
				<!-- Заголовок -->
				<p class="post-title font-bold text-[32px] text-center text-dark leading-[1.15] w-full max-w-[996px]"><?php the_title(); ?></p>
				
				<!-- Дата -->
				<p class="font-semibold text-[14px] text-center text-dark leading-[1.15]">Новость от <?php echo $post_date; ?></p>
			</div>
			
			<!-- Декоративный вектор (позади всего) -->
			<div class="post-header-vector absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-[1446.5px] h-[332.959px] pointer-events-none">
				<img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/Vector 1.png" alt="" class="block max-w-none w-full h-full object-contain">
			</div>
		</div>
	</section>

	<!-- Основной контент с сайдбаром -->
	<section class="w-full post-container py-5">
		<div class="post-main-wrapper w-full">
			<!-- Основной контент -->
			<div class="flex-1 flex flex-col gap-5 text-dark" data-aos="fade-right">
				<p class="post-content-title font-bold text-[20px] leading-[1.15]"><?php the_title(); ?></p>
				
				<div class="post-content font-semibold text-base leading-[1.15]">
					<?php the_content(); ?>
				</div>
			</div>

			<!-- Сайдбар с другими новостями -->
			<aside class="post-sidebar w-[340px] flex-shrink-0" data-aos="fade-left">
				<p class="font-bold text-[20px] text-dark leading-[1.15] mb-5">Другие новости</p>
				
				<div class="post-sidebar-grid flex flex-col gap-5">
					<?php
					// Get 2 recent posts excluding current post
					$related_posts = new WP_Query(array(
						'post_type' => 'post',
						'posts_per_page' => 2,
						'post__not_in' => array(get_the_ID()),
						'orderby' => 'date',
						'order' => 'DESC'
					));
					
					if ($related_posts->have_posts()) :
						while ($related_posts->have_posts()) : $related_posts->the_post();
							// Get post data
							$post_categories = get_the_category();
							$post_category = !empty($post_categories) ? $post_categories[0]->name : 'Статья';
							$post_content = get_the_content();
							$post_word_count = str_word_count(strip_tags($post_content));
							$post_reading_time = ceil($post_word_count / 200);
							?>
							
							<a href="<?php the_permalink(); ?>" class="post-sidebar-card bg-white rounded-[30px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-2.5 flex flex-col gap-2.5 cursor-pointer hover:shadow-xl transition-shadow">
								<div class="h-[200px] relative rounded-[20px] overflow-hidden">
									<?php if (has_post_thumbnail()) : ?>
										<?php the_post_thumbnail('medium', array('class' => 'absolute inset-0 w-full h-full object-cover rounded-[20px]')); ?>
									<?php else : ?>
										<div class="absolute bg-[#d9d9d9] inset-0 rounded-[20px]"></div>
										<img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog-image-1.png" alt="Blog Image" class="absolute inset-0 w-full h-full object-cover rounded-[20px]">
									<?php endif; ?>
								</div>
								<div class="p-2.5 flex flex-col gap-2.5">
									<div class="flex flex-col gap-2.5">
										<p class="font-semibold text-[14px] text-secondary leading-[1.15]"><?php echo esc_html($post_category); ?></p>
										<p class="post-sidebar-card-title font-bold text-[20px] text-dark leading-[1.15]"><?php the_title(); ?></p>
										<p class="post-sidebar-card-description font-semibold text-base text-dark opacity-80 leading-[1.15]"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
									</div>
									<div class="flex gap-2.5 items-center flex-wrap">
										<p class="font-semibold text-[14px] text-secondary leading-[1.15] whitespace-nowrap"><?php echo get_the_date('d F Y г.'); ?></p>
										<div class="flex gap-[6px] items-center">
											<div class="overflow-clip relative w-5 h-5 flex-shrink-0">
												<img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/blog-clock.svg" alt="Time" class="block w-full h-full object-contain">
											</div>
											<p class="font-semibold text-[14px] text-secondary leading-[1.15] whitespace-nowrap"><?php echo $post_reading_time; ?> минут чтения</p>
										</div>
									</div>
								</div>
							</a>
							
						<?php endwhile;
						wp_reset_postdata();
					endif;
					?>
				</div>
			</aside>
		</div>
	</section>

<?php endwhile; ?>

<?php
get_footer();
