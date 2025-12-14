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
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
