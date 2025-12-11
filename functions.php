<?php
/**
 * enotarynew functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package enotarynew
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function enotarynew_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on enotarynew, use a find and replace
		* to change 'enotarynew' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'enotarynew', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'enotarynew' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'enotarynew_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'enotarynew_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function enotarynew_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'enotarynew_content_width', 640 );
}
add_action( 'after_setup_theme', 'enotarynew_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function enotarynew_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'enotarynew' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'enotarynew' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'enotarynew_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function enotarynew_scripts() {
	// Main theme stylesheet from assets
	wp_enqueue_style( 'enotarynew-main-style', get_template_directory_uri() . '/assets/style.css', array(), _S_VERSION );
	
	// Animations CSS
	wp_enqueue_style( 'enotarynew-animations', get_template_directory_uri() . '/assets/animations.css', array(), _S_VERSION );
	
	// WordPress default stylesheet (ОТКЛЮЧЕН - конфликтует с кастомными стилями)
	// wp_enqueue_style( 'enotarynew-style', get_stylesheet_uri(), array(), _S_VERSION );
	// wp_style_add_data( 'enotarynew-style', 'rtl', 'replace' );

	// Conditional styles for specific page templates
	if ( is_page_template( 'page-order-ukep.php' ) || is_page_template( 'page-order-mchd.php' ) || is_page_template( 'page-order-unep.php' ) ) {
		wp_enqueue_style( 'enotarynew-order-ukep', get_template_directory_uri() . '/assets/order-ukep.css', array(), _S_VERSION );
	}
	
	if ( is_page_template( 'page-blog.php' ) || is_home() || is_archive() ) {
		wp_enqueue_style( 'enotarynew-blog', get_template_directory_uri() . '/assets/blog.css', array(), _S_VERSION );
	}
	
	if ( is_single() ) {
		wp_enqueue_style( 'enotarynew-blog-post', get_template_directory_uri() . '/assets/blog-post.css', array(), _S_VERSION );
	}
	
	if ( is_page_template( 'page-contacts.php' ) ) {
		wp_enqueue_style( 'enotarynew-contacts', get_template_directory_uri() . '/assets/contacts.css', array(), _S_VERSION );
	}
	
	if ( is_page_template( 'page-documents.php' ) ) {
		wp_enqueue_style( 'enotarynew-documents', get_template_directory_uri() . '/assets/documents.css', array(), _S_VERSION );
	}
	
	if ( is_page_template( 'page-terms.php' ) || is_page_template( 'page-politic.php' ) ) {
		wp_enqueue_style( 'enotarynew-terms', get_template_directory_uri() . '/assets/terms.css', array(), _S_VERSION );
	}

	// Enqueue jQuery (if not already loaded)
	wp_enqueue_script( 'jquery' );
	
	// Main script.js
	wp_enqueue_script( 'enotarynew-main-script', get_template_directory_uri() . '/assets/script.js', array('jquery'), _S_VERSION, true );
	
	// Universal Calculator for order pages (UKEP, MCHD, UNEP)
	if ( is_page_template( 'page-order-ukep.php' ) || is_page_template( 'page-order-mchd.php' ) || is_page_template( 'page-order-unep.php' ) ) {
		wp_enqueue_script( 'enotarynew-universal-calc', get_template_directory_uri() . '/assets/js/universal-calc.js', array('jquery'), _S_VERSION, true );
		
		// Localize script with AJAX URL and nonce for bundle operations
		wp_localize_script( 'enotarynew-universal-calc', 'enotaryBundleAjax', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'enotary_bundle_nonce' )
		) );
	}
	
	// Custom order script for WooCommerce integration (legacy - can be removed if not used)
	if ( is_page_template( 'page-order-ukep.php' ) || is_page_template( 'page-order-mchd.php' ) || is_page_template( 'page-order-unep.php' ) ) {
		wp_enqueue_script( 'enotarynew-custom-order', get_template_directory_uri() . '/assets/js/custom-order.js', array('jquery'), _S_VERSION, true );
		
		// Localize script with AJAX URL and nonce
		wp_localize_script( 'enotarynew-custom-order', 'enotaryAjax', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'enotary_cart_nonce' )
		) );
	}
	
	// Navigation script
	wp_enqueue_script( 'enotarynew-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'enotarynew_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce-dependent files after WooCommerce is fully loaded
 */
function enotarynew_load_woocommerce_files() {
	// Проверяем, что WooCommerce активен
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}
	
	// Product Helper Functions for WooCommerce
	require_once get_template_directory() . '/inc/product-helpers.php';
	
	// AJAX Bundle Handler for WooCommerce
	require_once get_template_directory() . '/inc/ajax-handler.php';
	
	// AJAX Cart Handler for WooCommerce
	require_once get_template_directory() . '/inc/ajax-cart.php';
}
add_action( 'woocommerce_init', 'enotarynew_load_woocommerce_files' );

/**
 * Get page URL by template name
 * 
 * @param string $template Template name (e.g., 'page-order-ukep.php')
 * @return string Page URL or home URL if not found
 */
function enotarynew_get_page_url_by_template( $template ) {
	$pages = get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => $template
	));
	
	if ( ! empty( $pages ) ) {
		return get_permalink( $pages[0]->ID );
	}
	
	return home_url();
}
