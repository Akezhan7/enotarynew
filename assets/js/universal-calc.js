/**
 * Universal Calculator for UKEP, UNEP, MCHD Pages
 * 
 * Универсальный калькулятор для расчета стоимости заказа
 * 
 * @package enotarynew
 */

(function($) {
    'use strict';

    // Инициализация при загрузке страницы
    $(document).ready(function() {
        
        // Переменные для хранения данных
        let basePrice = 0;
        let baseProductId = 0;
        let currentPayerType = '';
        
        /**
         * Инициализация калькулятора
         */
        function initCalculator() {
            // Получаем активную кнопку типа плательщика при загрузке
            const activePayerBtn = $('input[name="payer_type"]:checked');
            if (activePayerBtn.length > 0) {
                updateBasePrice(activePayerBtn);
            }
            
            // Обновляем общую сумму
            updateTotalPrice();
        }
        
        /**
         * Обновить базовую цену при выборе типа плательщика
         */
        function updateBasePrice($element) {
            basePrice = parseFloat($element.attr('data-base-price')) || 0;
            baseProductId = parseInt($element.attr('data-base-id')) || 0;
            currentPayerType = $element.val() || '';
            
            console.log('Базовая цена обновлена:', basePrice, 'ID товара:', baseProductId, 'Тип:', currentPayerType);
            
            updateTotalPrice();
        }
        
        /**
         * Рассчитать стоимость дополнительных услуг (чекбоксы)
         */
        function calculateExtrasPrice() {
            let extrasTotal = 0;
            
            // Проходим по всем чекбоксам с классом service-checkbox
            $('.service-checkbox:checked').each(function() {
                const price = parseFloat($(this).val()) || 0;
                
                // Находим главный контейнер для этого чекбокса
                const $mainContainer = $(this).closest('.flex');
                const $quantityControl = $mainContainer.find('.quantity-value');
                
                // Если контрол количества есть, берем его значение, иначе используем 1
                let quantity = 1;
                if ($quantityControl.length > 0) {
                    quantity = parseInt($quantityControl.text()) || 1;
                }
                
                // Добавляем к сумме цену * количество
                extrasTotal += price * quantity;
            });
            
            return extrasTotal;
        }
        
        /**
         * Обновить общую стоимость
         */
        function updateTotalPrice() {
            const extrasPrice = calculateExtrasPrice();
            const totalPrice = basePrice + extrasPrice;
            
            // Обновляем отображение цены
            $('.total-price').text(formatPrice(totalPrice) + '₽');
            
            console.log('Итого:', totalPrice, '(База:', basePrice, '+ Допы:', extrasPrice + ')');
        }
        
        /**
         * Форматировать цену (добавить пробелы)
         */
        function formatPrice(price) {
            return Math.round(price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
        }
        
        /**
         * Собрать данные для отправки в корзину
         */
        function collectCartData() {
            const items = [];
            
            // Добавляем базовый товар
            if (baseProductId > 0) {
                items.push({
                    id: baseProductId,
                    quantity: 1
                });
            }
            
            // Добавляем выбранные дополнительные товары с количеством
            $('.service-checkbox:checked').each(function() {
                const productId = parseInt($(this).attr('data-product-id')) || 0;
                
                // Находим главный контейнер для этого чекбокса
                const $mainContainer = $(this).closest('.flex');
                const $quantityControl = $mainContainer.find('.quantity-value');
                
                // Если контрол количества есть, берем его значение, иначе используем 1
                let quantity = 1;
                if ($quantityControl.length > 0) {
                    quantity = parseInt($quantityControl.text()) || 1;
                }
                
                if (productId > 0 && quantity > 0) {
                    items.push({
                        id: productId,
                        quantity: quantity
                    });
                }
            });
            
            return {
                items: items,
                payer_type: currentPayerType,
                base_product_id: baseProductId
            };
        }
        
        /**
         * Отправить данные в корзину через AJAX
         */
        function sendToCart() {
            const cartData = collectCartData();
            
            // Проверка что есть базовый товар
            if (cartData.items.length === 0) {
                alert('Пожалуйста, выберите тип плательщика');
                return;
            }
            
            // Показываем индикатор загрузки
            const $submitBtn = $('.submit-order-btn');
            const originalText = $submitBtn.text();
            $submitBtn.prop('disabled', true).text('Обработка...');
            
            // Отправляем AJAX запрос
            $.ajax({
                url: enotaryBundleAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'add_custom_bundle_to_cart',
                    nonce: enotaryBundleAjax.nonce,
                    items: JSON.stringify(cartData.items),
                    payer_type: cartData.payer_type,
                    base_product_id: cartData.base_product_id
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Товары добавлены в корзину:', response.data);
                        
                        // Редирект на страницу оформления заказа
                        window.location.href = response.data.redirect_url;
                    } else {
                        alert(response.data.message || 'Произошла ошибка при добавлении товаров в корзину');
                        $submitBtn.prop('disabled', false).text(originalText);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('Произошла ошибка при отправке данных. Попробуйте еще раз.');
                    $submitBtn.prop('disabled', false).text(originalText);
                }
            });
        }
        
        // ========== СОБЫТИЯ ==========
        
        /**
         * Изменение типа плательщика (радио-кнопки)
         */
        $(document).on('change', 'input[name="payer_type"]', function() {
            updateBasePrice($(this));
        });
        
        /**
         * Изменение чекбоксов (дополнительные услуги)
         */
        $(document).on('change', '.service-checkbox', function() {
            updateTotalPrice();
        });
        
        /**
         * Клик на кастомный чекбокс (визуальный элемент)
         */
        $(document).on('click', '.checkbox-custom', function() {
            const $checkboxCustom = $(this);
            const $checkbox = $(this).siblings('.service-checkbox');
            
            if ($checkbox.length > 0) {
                // Переключаем состояние
                const newState = !$checkbox.prop('checked');
                $checkbox.prop('checked', newState);
                
                // Синхронизируем визуальное состояние
                if (newState) {
                    $checkboxCustom.addClass('checked');
                } else {
                    $checkboxCustom.removeClass('checked');
                }
                
                // Обновляем итоговую цену
                updateTotalPrice();
            }
        });
        
        /**
         * Обработка кнопок количества (+ и -)
         */
        $(document).on('click', '.quantity-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const action = $(this).data('action');
            const $quantityValue = $(this).siblings('.quantity-value');
            
            // Находим главный родительский контейнер (поднимаемся выше к корневому .flex)
            // Структура: button находится в .quantity-control -> .flex -> главный .flex
            const $mainContainer = $(this).closest('.quantity-control').parent().parent();
            const $checkbox = $mainContainer.find('.service-checkbox');
            const $checkboxCustom = $mainContainer.find('.checkbox-custom');
            
            let currentValue = parseInt($quantityValue.text()) || 0;
            
            if (action === 'increment') {
                currentValue++;
                $quantityValue.text(currentValue);
                
                // Автоматически ставим галочку если количество > 0
                if (currentValue > 0) {
                    $checkbox.prop('checked', true);
                    $checkboxCustom.addClass('checked');
                }
            } else if (action === 'decrement' && currentValue > 0) {
                currentValue--;
                $quantityValue.text(currentValue);
                
                // Снимаем галочку если количество = 0
                if (currentValue === 0) {
                    $checkbox.prop('checked', false);
                    $checkboxCustom.removeClass('checked');
                }
            }
            
            // Обновляем итоговую цену
            updateTotalPrice();
        });
        
        /**
         * Кнопка "Оформить заказ"
         */
        $(document).on('click', '.submit-order-btn', function(e) {
            e.preventDefault();
            sendToCart();
        });
        
        /**
         * Обработка старых entity-card кнопок (если они есть)
         */
        $(document).on('click', '.entity-card', function() {
            // Убираем активный класс у всех
            $('.entity-card').removeClass('entity-card-active');
            // Добавляем активный класс текущей
            $(this).addClass('entity-card-active');
            
            // Находим скрытую радио-кнопку и активируем её
            const $radio = $(this).find('input[name="payer_type"]');
            if ($radio.length > 0) {
                $radio.prop('checked', true).trigger('change');
            }
        });
        
        // Инициализация при загрузке
        initCalculator();
        
        console.log('Universal Calculator initialized');
    });

})(jQuery);
