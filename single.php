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

	<?php while ( have_posts() ) : the_post(); ?>

		<!-- Хлебные крошки -->
		<div class="w-full responsive-container pb-3 lg:pb-4">
			<div class="flex items-center gap-2 font-semibold text-sm text-secondary">
				<a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors">Главная</a>
				<span>/</span>
				<a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="hover:text-primary transition-colors">Блог</a>
				<span>/</span>
				<span class="text-dark"><?php the_title(); ?></span>
			</div>
		</div>

		<!-- Основной контент статьи -->
		<article id="post-<?php the_ID(); ?>" <?php post_class('w-full responsive-container py-6 sm:py-8 md:py-10'); ?>>
			<div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden">
				
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="w-full h-[300px] sm:h-[400px] md:h-[500px] overflow-hidden">
						<?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover')); ?>
					</div>
				<?php endif; ?>

				<div class="p-6 sm:p-8 md:p-10">
					<div class="flex items-center gap-4 mb-6">
						<span class="font-semibold text-sm text-secondary"><?php echo get_the_date(); ?></span>
						<?php
						$categories = get_the_category();
						if ( ! empty( $categories ) ) :
							foreach ( $categories as $category ) :
						?>
							<span class="bg-primary bg-opacity-10 text-primary font-semibold text-xs px-3 py-1 rounded-full">
								<?php echo esc_html( $category->name ); ?>
							</span>
						<?php
							endforeach;
						endif;
						?>
					</div>

					<h1 class="font-bold text-[28px] sm:text-[32px] md:text-[36px] text-[#262626] leading-[1.2] mb-6">
						<?php the_title(); ?>
					</h1>

					<div class="prose max-w-none font-semibold text-base text-[#262626] leading-[1.6]">
						<?php the_content(); ?>
					</div>

					<?php
					wp_link_pages(
						array(
							'before' => '<div class="page-links mt-8 pt-8 border-t border-[rgba(0,0,0,0.05)]">' . esc_html__( 'Pages:', 'enotarynew' ),
							'after'  => '</div>',
						)
					);
					?>
				</div>
			</div>

			<!-- Навигация между постами -->
			<div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
				<?php
				$prev_post = get_previous_post();
				$next_post = get_next_post();
				
				if ( $prev_post ) :
				?>
					<a href="<?php echo get_permalink( $prev_post->ID ); ?>" class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] p-6 hover:shadow-lg transition-shadow">
						<p class="font-semibold text-xs text-secondary mb-2">← Предыдущая статья</p>
						<p class="font-bold text-base text-[#262626]"><?php echo get_the_title( $prev_post->ID ); ?></p>
					</a>
				<?php endif; ?>

				<?php if ( $next_post ) : ?>
					<a href="<?php echo get_permalink( $next_post->ID ); ?>" class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] p-6 hover:shadow-lg transition-shadow text-right">
						<p class="font-semibold text-xs text-secondary mb-2">Следующая статья →</p>
						<p class="font-bold text-base text-[#262626]"><?php echo get_the_title( $next_post->ID ); ?></p>
					</a>
				<?php endif; ?>
			</div>
		</article>

	<?php endwhile; ?>

<?php
get_footer();
