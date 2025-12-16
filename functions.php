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

	// Add WooCommerce support
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
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
	
	// Checkout styles for WooCommerce
	if ( is_checkout() || is_cart() ) {
		wp_enqueue_style( 'enotarynew-checkout', get_template_directory_uri() . '/assets/checkout.css', array(), _S_VERSION );
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
	
	// Debug script for checkout (only when ?debug=1 is in URL)
	if ( is_checkout() && isset( $_GET['debug'] ) && $_GET['debug'] == '1' ) {
		wp_enqueue_script( 'enotarynew-checkout-debug', get_template_directory_uri() . '/assets/js/checkout-debug.js', array('jquery'), _S_VERSION, true );
	}

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
	
	// Custom Checkout Forms Handler for different payer types
	require_once get_template_directory() . '/inc/checkout-custom-forms.php';
	
	// PDF Invoices Integration for Legal Entities
	require_once get_template_directory() . '/inc/pdf-invoices.php';
	
	// Admin Panel Customization
	require_once get_template_directory() . '/inc/admin-custom.php';
	
	// Certificate Expiry Notifications System (ТЗ п. 215)
	require_once get_template_directory() . '/inc/notifications.php';
	
	// My Account Customization (ТЗ п. 219, 229, 231)
	require_once get_template_directory() . '/inc/my-account-custom.php';
	
	// Shop Settings Page (ACF Options)
	require_once get_template_directory() . '/inc/admin-settings.php';
	
	// Certificate Help Modal System (ТЗ п. 230)
	require_once get_template_directory() . '/inc/certificate-help-modal.php';
}
add_action( 'init', 'enotarynew_load_woocommerce_files', 20 );

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

/**
 * Регистрация страницы настроек ACF для E-Notary
 */
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Настройки E-Notary',
		'menu_title'	=> 'E-Notary',
		'menu_slug' 	=> 'enotary-settings',
		'capability'	=> 'edit_posts',
		'icon_url'		=> 'dashicons-admin-generic',
		'redirect'		=> false,
		'position'		=> 58,
	));
}

/**
 * Получить типы плательщиков для форм заказа
 * 
 * Эти значения НЕ являются товарами WooCommerce, а статическими элементами формы
 * для выбора типа заказчика услуги.
 * 
 * Значения можно изменить в админке: E-Notary → Типы плательщиков
 * 
 * @return array Массив с типами плательщиков
 */
function get_payer_types_options() {
	// ID товаров для типов плательщиков
	$payer_product_ids = array(
		'legal'        => 283, // Юридическое лицо
		'individual'   => 284, // Физическое лицо
		'entrepreneur' => 285, // ИП
	);
	
	$payer_types = array();
	
	// Проверяем что WooCommerce активен
	if ( ! function_exists( 'wc_get_product' ) ) {
		// Fallback если WooCommerce не активен
		return array(
			'legal' => array(
				'value' => 'legal',
				'label' => 'Юридическое Лицо',
				'price' => 3000,
				'product_id' => 283,
			),
			'individual' => array(
				'value' => 'individual',
				'label' => 'Физическое Лицо',
				'price' => 2000,
				'product_id' => 284,
			),
			'entrepreneur' => array(
				'value' => 'entrepreneur',
				'label' => 'ИП',
				'price' => 2000,
				'product_id' => 285,
			),
		);
	}
	
	// Получаем данные из товаров WooCommerce
	foreach ( $payer_product_ids as $key => $product_id ) {
		$product = wc_get_product( $product_id );
		
		if ( $product ) {
			$payer_types[ $key ] = array(
				'value'      => $key,
				'label'      => $product->get_name(),
				'price'      => floatval( $product->get_price() ),
				'product_id' => $product_id,
			);
		} else {
			// Fallback если товар не найден
			$labels = array(
				'legal'        => 'Юридическое Лицо',
				'individual'   => 'Физическое Лицо',
				'entrepreneur' => 'ИП',
			);
			
			$payer_types[ $key ] = array(
				'value'      => $key,
				'label'      => $labels[ $key ],
				'price'      => 2000,
				'product_id' => $product_id,
			);
		}
	}
	
	return $payer_types;
}

/**
 * ============================================
 * Кастомные страницы входа и регистрации
 * ============================================
 */

/**
 * Переопределение стандартной страницы входа WordPress
 */
function enotary_custom_login_page() {
    // Создаем страницу "Вход" если её нет
    $login_page = get_page_by_path( 'vkhod' );
    
    if ( ! $login_page ) {
        $login_page_id = wp_insert_post( array(
            'post_title'   => 'Вход',
            'post_name'    => 'vkhod',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
            'page_template' => 'template-login.php',
        ) );
    }
}
add_action( 'after_setup_theme', 'enotary_custom_login_page' );

/**
 * Переопределение стандартной страницы регистрации WordPress
 */
function enotary_custom_register_page() {
    // Создаем страницу "Регистрация" если её нет
    $register_page = get_page_by_path( 'registratsiya' );
    
    if ( ! $register_page ) {
        $register_page_id = wp_insert_post( array(
            'post_title'   => 'Регистрация',
            'post_name'    => 'registratsiya',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
            'page_template' => 'template-register.php',
        ) );
    }
}
add_action( 'after_setup_theme', 'enotary_custom_register_page' );

/**
 * Редирект со стандартной страницы входа wp-login.php на кастомную
 */
function enotary_redirect_login_page() {
    $page_viewed = basename( $_SERVER['REQUEST_URI'] );
    
    if ( $page_viewed == 'wp-login.php' && $_SERVER['REQUEST_METHOD'] == 'GET' && ! isset( $_GET['action'] ) ) {
        wp_redirect( home_url( '/vkhod/' ) );
        exit;
    }
}
add_action( 'init', 'enotary_redirect_login_page' );

/**
 * Редирект после выхода на страницу входа
 */
function enotary_logout_redirect() {
    wp_redirect( home_url( '/vkhod/' ) );
    exit;
}
add_action( 'wp_logout', 'enotary_logout_redirect' );

/**
 * Изменение URL страницы входа в WordPress
 */
function enotary_custom_login_url( $login_url ) {
    return home_url( '/vkhod/' );
}
add_filter( 'login_url', 'enotary_custom_login_url' );

/**
 * Изменение URL страницы регистрации в WordPress
 */
function enotary_custom_register_url( $register_url ) {
    return home_url( '/registratsiya/' );
}
add_filter( 'register_url', 'enotary_custom_register_url' );

/**
 * Включить регистрацию пользователей
 */
function enotary_enable_user_registration() {
    update_option( 'users_can_register', 1 );
}
add_action( 'after_setup_theme', 'enotary_enable_user_registration' );

/**
 * "Ядерный вариант" - Полная замена шаблона страницы входа WooCommerce
 * Если пользователь НЕ залогинен на странице "Мой аккаунт" - загружаем template-login.php
 * Это гарантирует 100% идентичность визуала
 */
function enotary_replace_wc_login_template() {
    // Проверяем: это страница "Мой аккаунт" И пользователь НЕ залогинен
    if ( is_account_page() && ! is_user_logged_in() ) {
        // Получаем путь к template-login.php
        $template_login = get_template_directory() . '/template-login.php';
        
        // Если файл существует - загружаем его и останавливаем дальнейшую обработку
        if ( file_exists( $template_login ) ) {
            include( $template_login );
            exit; // ВАЖНО: останавливаем WordPress, чтобы не загружался стандартный шаблон
        }
    }
}
add_action( 'template_redirect', 'enotary_replace_wc_login_template', 1 );
