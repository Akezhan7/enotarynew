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
	
	if ( is_page_template( 'page-products-services.php' ) ) {
		wp_enqueue_style( 'enotarynew-order-ukep', get_template_directory_uri() . '/assets/order-ukep.css', array(), _S_VERSION );
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
	
	// Localize main script with AJAX URL and nonce for contact form and other AJAX actions
	wp_localize_script( 'enotarynew-main-script', 'enotaryAjax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'enotary-ajax-nonce' )
	) );
	
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
 * Настройка количества постов на странице поиска
 */
function enotarynew_search_posts_per_page( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
		$query->set( 'posts_per_page', 9 );
	}
}
add_action( 'pre_get_posts', 'enotarynew_search_posts_per_page' );

/**
 * AJAX обработчик для поиска в блоге
 */
function enotarynew_ajax_blog_search() {
	$search_query = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
	$paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
	
	$args = array(
		'post_type' => 'post',
		'posts_per_page' => 9,
		'orderby' => 'date',
		'order' => 'DESC',
		'paged' => $paged
	);
	
	if (!empty($search_query)) {
		$args['s'] = $search_query;
	}
	
	$blog_query = new WP_Query($args);
	
	ob_start();
	
	if ($blog_query->have_posts()) :
		$delay = 50;
		while ($blog_query->have_posts()) : $blog_query->the_post();
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
							$reading_time = ceil($word_count / 200);
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
			<?php if (!empty($search_query)) : ?>
				<p class="font-semibold text-base text-secondary">По запросу "<?php echo esc_html($search_query); ?>" ничего не найдено</p>
				<button onclick="window.location.reload()" class="inline-block mt-4 font-semibold text-sm text-primary hover:underline cursor-pointer">Показать все статьи</button>
			<?php else : ?>
				<p class="font-semibold text-base text-secondary">Пока нет опубликованных статей</p>
			<?php endif; ?>
		</div>
		<?php
	endif;
	
	$posts_html = ob_get_clean();
	
	// Пагинация
	$pagination_html = '';
	if ($blog_query->max_num_pages > 1) {
		$current_page = max(1, $paged);
		$total_pages = $blog_query->max_num_pages;
		
		ob_start();
		?>
		<div class="pagination-container mt-10 flex justify-center items-center gap-2">
			<?php if ($current_page > 1) : ?>
				<button data-page="<?php echo $current_page - 1; ?>" class="pagination-btn pagination-arrow w-10 h-10 flex items-center justify-center rounded-lg bg-white border border-[rgba(0,0,0,0.05)] hover:bg-[rgba(55,93,116,0.1)] transition-colors">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12.5 15L7.5 10L12.5 5" stroke="#375d74" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</button>
			<?php endif; ?>
			
			<?php
			$range = 2;
			for ($i = 1; $i <= $total_pages; $i++) :
				if ($i == 1 || $i == $total_pages || ($i >= $current_page - $range && $i <= $current_page + $range)) :
					if ($i == $current_page) :
						?>
						<span class="pagination-number w-10 h-10 flex items-center justify-center rounded-lg bg-primary text-white font-bold text-sm"><?php echo $i; ?></span>
						<?php else : ?>
						<button data-page="<?php echo $i; ?>" class="pagination-btn pagination-number w-10 h-10 flex items-center justify-center rounded-lg bg-white border border-[rgba(0,0,0,0.05)] hover:bg-[rgba(55,93,116,0.1)] transition-colors font-semibold text-sm text-dark"><?php echo $i; ?></button>
						<?php endif; ?>
				<?php elseif ($i == $current_page - $range - 1 || $i == $current_page + $range + 1) : ?>
					<span class="pagination-dots text-secondary font-bold">...</span>
				<?php endif; ?>
			<?php endfor; ?>
			
			<?php if ($current_page < $total_pages) : ?>
				<button data-page="<?php echo $current_page + 1; ?>" class="pagination-btn pagination-arrow w-10 h-10 flex items-center justify-center rounded-lg bg-white border border-[rgba(0,0,0,0.05)] hover:bg-[rgba(55,93,116,0.1)] transition-colors">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M7.5 5L12.5 10L7.5 15" stroke="#375d74" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</button>
			<?php endif; ?>
		</div>
		<?php
		$pagination_html = ob_get_clean();
	}
	
	wp_reset_postdata();
	
	wp_send_json_success(array(
		'posts' => $posts_html,
		'pagination' => $pagination_html,
		'found_posts' => $blog_query->found_posts,
		'max_pages' => $blog_query->max_num_pages
	));
}
add_action('wp_ajax_blog_search', 'enotarynew_ajax_blog_search');
add_action('wp_ajax_nopriv_blog_search', 'enotarynew_ajax_blog_search');

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
 * AJAX обработчик формы обратной связи.
 */
require get_template_directory() . '/inc/ajax-contact-form.php';

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
