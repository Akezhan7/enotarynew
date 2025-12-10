/**
 * Custom Order Handler для e-Notary
 * Обработка заказов с калькулятора и добавление в корзину WooCommerce
 * 
 * @package enotarynew
 */

(function($) {
    'use strict';

    /**
     * Инициализация обработчиков при загрузке DOM
     */
    $(document).ready(function() {
        initOrderButtons();
    });

    /**
     * Инициализация обработчиков для кнопок заказа
     */
    function initOrderButtons() {
        $('.order-next-btn[data-product-id]').on('click', function(e) {
            e.preventDefault();
            
            const $button = $(this);
            const productId = $button.data('product-id');
            
            // Блокировка кнопки во время обработки
            if ($button.prop('disabled')) {
                return;
            }
            
            $button.prop('disabled', true);
            $button.css('opacity', '0.6');
            
            // Сбор данных с калькулятора
            const orderData = collectOrderData(productId);
            
            // Валидация данных
            if (!validateOrderData(orderData)) {
                $button.prop('disabled', false);
                $button.css('opacity', '1');
                return;
            }
            
            // Отправка AJAX запроса
            sendOrderToCart(orderData, $button);
        });
    }

    /**
     * Сбор данных заказа со страницы
     * 
     * @param {number} productId ID товара
     * @returns {Object} Объект с данными заказа
     */
    function collectOrderData(productId) {
        // 1. ID товара
        const data = {
            product_id: productId
        };

        // 2. Итоговая цена
        const totalPriceElement = $('#totalPrice');
        if (totalPriceElement.length) {
            const totalPriceText = totalPriceElement.text().replace(/[^\d]/g, '');
            data.total_price = parseInt(totalPriceText) || 0;
        } else {
            data.total_price = 0;
        }

        // 3. Тип плательщика (активная карточка entity-card)
        const activeEntityCard = $('.entity-card-active');
        if (activeEntityCard.length) {
            const payerTypeText = activeEntityCard.find('p').first().text().trim();
            data.payer_type = payerTypeText;
            
            // Получаем цену типа лица
            const entityPrice = activeEntityCard.data('price');
            if (entityPrice) {
                data.entity_price = parseInt(entityPrice);
            }
        } else {
            data.payer_type = '';
        }

        // 4. Собираем выбранные опции (чекбоксы и количества)
        data.selected_options = collectSelectedOptions();

        return data;
    }

    /**
     * Сбор выбранных опций (товаров) с калькулятора
     * 
     * @returns {Array} Массив выбранных опций
     */
    function collectSelectedOptions() {
        const options = [];

        // Проходим по всем секциям с товарами
        $('.bg-white.border').each(function() {
            const $section = $(this);
            
            // Проходим по всем строкам товаров
            $section.find('> div').each(function() {
                const $row = $(this);
                const $checkbox = $row.find('.checkbox-custom');
                const $quantityControl = $row.find('.quantity-control');
                
                // Находим элемент с названием товара
                const $nameElement = $row.find('p.font-bold').first();
                const name = $nameElement.text().trim();
                
                // Находим элемент с ценой (содержит ₽)
                let price = 0;
                $row.find('p').each(function() {
                    const text = $(this).text();
                    if (text.includes('₽')) {
                        price = parseInt(text.replace(/[^\d]/g, '')) || 0;
                        return false; // Прерываем each
                    }
                });
                
                // Если есть контроль количества
                if ($quantityControl.length) {
                    const quantity = parseInt($quantityControl.find('.quantity-value').text()) || 0;
                    
                    if (quantity > 0 && price > 0 && name) {
                        options.push({
                            name: name,
                            price: price,
                            quantity: quantity,
                            total: price * quantity
                        });
                    }
                }
                // Если только чекбокс (без количества)
                else if ($checkbox.length && $checkbox.hasClass('checked') && price > 0 && name) {
                    options.push({
                        name: name,
                        price: price,
                        quantity: 1,
                        total: price
                    });
                }
            });
        });

        return options;
    }

    /**
     * Валидация данных заказа
     * 
     * @param {Object} orderData Данные заказа
     * @returns {boolean} true если данные валидны
     */
    function validateOrderData(orderData) {
        // Проверка наличия цены
        if (!orderData.total_price || orderData.total_price <= 0) {
            showNotification('Ошибка', 'Пожалуйста, выберите хотя бы одну опцию', 'error');
            return false;
        }

        // Проверка наличия типа плательщика
        if (!orderData.payer_type) {
            showNotification('Ошибка', 'Пожалуйста, выберите тип плательщика', 'error');
            return false;
        }

        return true;
    }

    /**
     * Отправка данных заказа на сервер через AJAX
     * 
     * @param {Object} orderData Данные заказа
     * @param {jQuery} $button Кнопка, которая была нажата
     */
    function sendOrderToCart(orderData, $button) {
        $.ajax({
            url: enotaryAjax.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'enotary_add_to_cart',
                nonce: enotaryAjax.nonce,
                product_id: orderData.product_id,
                total_price: orderData.total_price,
                payer_type: orderData.payer_type,
                selected_options: JSON.stringify(orderData.selected_options)
            },
            success: function(response) {
                if (response.success) {
                    // Показываем уведомление об успехе
                    showNotification('Успешно', 'Товар добавлен в корзину. Перенаправление...', 'success');
                    
                    // Перенаправление на страницу оформления заказа
                    setTimeout(function() {
                        window.location.href = response.data.redirect_url;
                    }, 500);
                } else {
                    // Показываем ошибку
                    const message = response.data && response.data.message ? response.data.message : 'Произошла ошибка при добавлении товара в корзину';
                    showNotification('Ошибка', message, 'error');
                    
                    // Разблокируем кнопку
                    $button.prop('disabled', false);
                    $button.css('opacity', '1');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                showNotification('Ошибка', 'Произошла ошибка соединения. Пожалуйста, попробуйте позже.', 'error');
                
                // Разблокируем кнопку
                $button.prop('disabled', false);
                $button.css('opacity', '1');
            }
        });
    }

    /**
     * Показать уведомление пользователю
     * 
     * @param {string} title Заголовок
     * @param {string} message Сообщение
     * @param {string} type Тип уведомления (success, error, info)
     */
    function showNotification(title, message, type) {
        // Простое уведомление через alert (можно заменить на более красивое решение)
        const icon = type === 'success' ? '✓' : (type === 'error' ? '✗' : 'ℹ');
        alert(icon + ' ' + title + '\n\n' + message);
        
        // TODO: В будущем можно заменить на toast-уведомления
        // Например, используя библиотеку toastr или создав собственный компонент
    }

})(jQuery);
