<?php
/**
 * Страница настроек магазина (ACF Options Page)
 * 
 * Управление инструкциями и ссылками на ПО для личного кабинета
 * 
 * @package enotarynew
 */

// Запретить прямой доступ
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Регистрация страницы опций ACF
 */
if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => 'Настройки магазина',
        'menu_title'    => 'Настройки магазина',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'icon_url'      => 'dashicons-admin-generic',
        'position'      => 58,
        'redirect'      => false
    ));
    
}
