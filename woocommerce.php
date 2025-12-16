<?php
/**
 * The template for displaying all WooCommerce pages
 *
 * @package enotarynew
 */

get_header();
?>

<div id="primary" class="content-area w-full">
	<main id="main" class="site-main w-full">
		<div class="responsive-container py-8 md:py-10 lg:py-12">
			<?php woocommerce_content(); ?>

			<?php if ( is_shop() || is_product_category() || is_product_tag() ) : ?>
				<!-- Кнопка подбора сертификата (ТЗ п.230) -->
				<div class="certificate-help-cta mt-8 md:mt-10 lg:mt-12 text-center">
					<button id="openHelpModal" class="inline-flex items-center gap-3 bg-gradient-to-r from-[#375d74] to-[#2a4a5e] hover:from-[#2a4a5e] hover:to-[#1f3847] text-white font-bold text-base md:text-lg px-6 md:px-8 py-4 md:py-5 rounded-[12px] shadow-[0_4px_20px_rgba(55,93,116,0.3)] hover:shadow-[0_6px_30px_rgba(55,93,116,0.4)] transition-all duration-300 transform hover:scale-105 no-underline">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
						<span>Не нашли нужный сертификат? Поможем подобрать!</span>
					</button>
					<p class="mt-3 text-sm md:text-base text-[#979797]">
						Наши специалисты свяжутся с вами и подберут оптимальное решение
					</p>
				</div>
			<?php endif; ?>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
