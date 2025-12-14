<?php
/**
 * The template for displaying all WooCommerce pages
 *
 * @package enotarynew
 */

get_header();
?>

<div id="primary w-full" class="content-area">
	<main id="main w-full" class="site-main">
		<?php woocommerce_content(); ?>
	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
