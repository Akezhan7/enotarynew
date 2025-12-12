/**
 * Debug Helper для проверки сессии WooCommerce
 * 
 * Временный скрипт для тестирования работы механизма типа лица
 * УДАЛИТЬ после завершения тестирования!
 */

jQuery(document).ready(function($) {
    'use strict';
    
    // Проверка на странице чекаута
    if ($('body').hasClass('woocommerce-checkout')) {
        console.log('=== ENOTARY CHECKOUT DEBUG ===');
        
        // Добавить кнопку дебага (только для разработки)
        if (window.location.search.indexOf('debug=1') !== -1) {
            $('body').append('<div id="enotary-debug" style="position:fixed;bottom:20px;right:20px;background:#375d74;color:white;padding:15px;border-radius:10px;z-index:99999;max-width:300px;"><strong>Debug Info:</strong><br><small>Проверьте консоль браузера</small></div>');
            
            // Вывести доступные методы оплаты
            console.log('Доступные методы оплаты:', $('.wc_payment_methods li').length);
            $('.wc_payment_methods li').each(function() {
                var method = $(this).find('input[type="radio"]').val();
                var label = $(this).find('label').text().trim();
                console.log('  - ' + method + ': ' + label);
            });
            
            // Вывести кастомные поля
            console.log('Кастомные поля чекаута:');
            $('[class*="enotary-field"]').each(function() {
                var fieldClass = $(this).attr('class');
                var fieldName = $(this).find('input').attr('name');
                console.log('  - ' + fieldName + ' (класс: ' + fieldClass + ')');
            });
        }
    }
});
