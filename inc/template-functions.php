<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package enotarynew
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function enotarynew_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'enotarynew_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function enotarynew_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'enotarynew_pingback_header' );

/**
 * Helper функции для получения ACF настроек темы
 */

/**
 * Получить ACF опцию из настроек темы
 *
 * @param string $field_name Имя поля ACF
 * @param mixed  $default    Значение по умолчанию
 * @return mixed
 */
function get_theme_option( $field_name, $default = '' ) {
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $field_name, 'option' );
		return $value ? $value : $default;
	}
	return $default;
}

/**
 * Вывести ACF опцию из настроек темы
 *
 * @param string $field_name Имя поля ACF
 * @param mixed  $default    Значение по умолчанию
 * @param bool   $escape     Экранировать HTML
 */
function the_theme_option( $field_name, $default = '', $escape = true ) {
	$value = get_theme_option( $field_name, $default );
	if ( $escape ) {
		echo esc_html( $value );
	} else {
		echo $value;
	}
}

/**
 * Получить логотип сайта
 *
 * @param string $type 'main' или 'secondary'
 * @return string URL логотипа
 */
function get_site_logo( $type = 'main' ) {
	$field_name = $type === 'secondary' ? 'logo_secondary' : 'logo_main';
	$logo_url = get_theme_option( $field_name );
	
	// Fallback на дефолтные логотипы
	if ( empty( $logo_url ) ) {
		$default_logos = array(
			'main'      => get_template_directory_uri() . '/assets/images/logo1.svg',
			'secondary' => get_template_directory_uri() . '/assets/images/logo2.svg',
		);
		return $default_logos[ $type ];
	}
	
	return $logo_url;
}

/**
 * Получить телефон компании
 *
 * @param bool $clean Вернуть очищенный номер для tel:
 * @return string
 */
function get_company_phone( $clean = false ) {
	if ( $clean ) {
		return get_theme_option( 'company_phone_clean', '+74953633093' );
	}
	return get_theme_option( 'company_phone', '+7 (495) 363-30-93' );
}

/**
 * Получить Telegram компании
 *
 * @param bool $link Вернуть ссылку вместо username
 * @return string
 */
function get_company_telegram( $link = false ) {
	if ( $link ) {
		return get_theme_option( 'company_telegram_link', 'https://t.me/SmartTokenPro1' );
	}
	return get_theme_option( 'company_telegram', '@SmartTokenPro1' );
}

/**
 * Получить email компании
 *
 * @return string
 */
function get_company_email() {
	return get_theme_option( 'company_email', '' );
}

/**
 * Получить название компании
 *
 * @return string
 */
function get_company_name() {
	return get_theme_option( 'company_name', 'Сигнал-КОМ e-Notary Удостоверяющий Центр' );
}

/**
 * Получить текст копирайта
 *
 * @return string
 */
function get_copyright_text() {
	$year = date( 'Y' );
	$text = get_theme_option( 'copyright_text', $year . ' © ООО «Енот»' );
	// Автозамена года
	return str_replace( array( '2025', '{year}' ), $year, $text );
}

/**
 * Получить меню футера по номеру колонки
 *
 * @param int $column Номер колонки (1-4)
 * @return array
 */
function get_footer_menu( $column = 1 ) {
	$field_name = 'footer_menu_' . $column;
	$menu = get_theme_option( $field_name, array() );
	return is_array( $menu ) ? $menu : array();
}
