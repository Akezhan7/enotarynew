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
         * ВАЖНО: Базовая цена НЕ добавляется автоматически в итог!
         * Она добавится только если чекбокс типа плательщика будет отмечен
         */
        function updateBasePrice($element) {
            // Сохраняем данные, но НЕ добавляем в basePrice
            basePrice = 0; // Базовая цена = 0, цена добавится только через чекбокс
            baseProductId = parseInt($element.attr('data-base-id')) || 0;
            currentPayerType = $element.val() || '';
            
            console.log('Тип плательщика выбран:', currentPayerType, 'ID товара:', baseProductId, '(цена НЕ добавлена автоматически)');
            
            // Фильтруем товары по типу плательщика
            filterProductsByPayerType(currentPayerType);
            
            updateTotalPrice();
        }
        
        /**
         * Фильтрация товаров по типу плательщика
         * Показывает/скрывает товары с атрибутом data-payer-filter
         */
        function filterProductsByPayerType(payerType) {
            console.log('=== НАЧАЛО ФИЛЬТРАЦИИ ===');
            console.log('Выбранный тип плательщика:', payerType);
            
            // Если тип плательщика не выбран - показываем все товары
            if (!payerType) {
                console.log('Тип не выбран, показываем все товары');
                $('.service-checkbox').closest('.flex').show();
                return;
            }
            
            // Правила скрытия товаров по названиям (для УКЭП)
            const hideRules = {
                'individual': [ // Физ лицо - скрыть:
                    'ЭП руководителей организаций',
                    'ЭП Индивидуальных предпринимателей',
                    'ЭП физического лица для сотрудника организаций и Индивидуальных предпринимателей'
                ],
                'legal': [ // Юр лицо - скрыть:
                    'ЭП Индивидуальных предпринимателей'
                ],
                'entrepreneur': [ // ИП - скрыть:
                    'ЭП руководителей организаций'
                ]
            };
            
            // Получаем список товаров для скрытия
            const productsToHide = hideRules[payerType] || [];
            
            // Проходим по всем товарам (и с атрибутом data-payer-filter, и без него)
            $('.service-checkbox').each(function() {
                const $checkbox = $(this);
                const $item = $checkbox.closest('.flex');
                const itemFilter = $item.attr('data-payer-filter');
                const productName = $item.find('.service-name').text().trim() || 'Без названия';
                
                console.log('---');
                console.log('Товар:', productName);
                console.log('Атрибут фильтра:', itemFilter);
                
                let shouldHide = false;
                
                // ПРОВЕРКА 1: Скрытие по названию (приоритет)
                for (let i = 0; i < productsToHide.length; i++) {
                    if (productName.includes(productsToHide[i])) {
                        shouldHide = true;
                        console.log('→ СКРЫВАЕМ по названию (правило для', payerType + ')');
                        break;
                    }
                }
                
                // ПРОВЕРКА 2: Если не скрыт по названию, проверяем атрибут data-payer-filter
                if (!shouldHide && itemFilter) {
                    const filterLower = itemFilter.toLowerCase();
                    console.log('Фильтр (lowercase):', filterLower);
                    
                    let shouldShow = false;
                    
                    if (payerType === 'individual' && (filterLower.includes('fiz') || filterLower.includes('физ') || filterLower.includes('individual'))) {
                        shouldShow = true;
                        console.log('→ Совпадение с individual (содержит fiz/физ/individual)');
                    } else if (payerType === 'entrepreneur' && (filterLower.includes('ip') || filterLower.includes('ип') || filterLower.includes('entrepreneur'))) {
                        shouldShow = true;
                        console.log('→ Совпадение с entrepreneur (содержит ip/ип/entrepreneur)');
                    } else if (payerType === 'legal' && (filterLower.includes('yur') || filterLower.includes('юр') || filterLower.includes('legal'))) {
                        shouldShow = true;
                        console.log('→ Совпадение с legal (содержит yur/юр/legal)');
                    } else {
                        console.log('→ НЕ совпадает с типом', payerType);
                    }
                    
                    if (!shouldShow) {
                        shouldHide = true;
                        console.log('→ СКРЫВАЕМ по атрибуту');
                    }
                }
                
                // Применяем скрытие или показ
                if (shouldHide) {
                    console.log('→ ИТОГ: СКРЫВАЕМ товар');
                    $item.hide();
                    
                    // Снимаем галочку и сбрасываем количество
                    if ($checkbox.is(':checked')) {
                        $checkbox.prop('checked', false);
                        $item.find('.checkbox-custom').removeClass('checked');
                        const $quantity = $item.find('.quantity-value');
                        if ($quantity.length > 0) {
                            $quantity.text('0');
                        }
                    }
                } else {
                    console.log('→ ИТОГ: ПОКАЗЫВАЕМ товар');
                    $item.show();
                }
            });
            
            console.log('=== КОНЕЦ ФИЛЬТРАЦИИ ===');
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
         * Теперь ВСЯ стоимость идет только из выбранных чекбоксов (включая тип плательщика)
         */
        function updateTotalPrice() {
            const extrasPrice = calculateExtrasPrice();
            const totalPrice = extrasPrice; // Базовая цена = 0, все через чекбоксы
            
            // Обновляем отображение цены
            $('.total-price').text(formatPrice(totalPrice) + '₽');
            
            console.log('Итого:', totalPrice, '(Выбранные товары)');
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
            
            // НЕ добавляем базовый товар в items, он добавится на сервере через payer_type
            // baseProductId используется только для валидации и передается отдельно
            
            // Добавляем выбранные дополнительные товары с количеством
            // ИСКЛЮЧАЕМ чекбокс типа плательщика (он идентифицируется по baseProductId)
            $('.service-checkbox:checked').each(function() {
                const productId = parseInt($(this).attr('data-product-id')) || 0;
                
                // ВАЖНО: Пропускаем товар типа плательщика, чтобы не было дублирования
                if (productId === baseProductId) {
                    console.log('Пропускаем товар типа плательщика (добавится на сервере):', productId);
                    return; // continue
                }
                
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
            
            // Получаем название услуги из data-атрибута секции
            const serviceName = $('section[data-service-name]').attr('data-service-name') || 'УКЭП';
            
            return {
                items: items,
                payer_type: currentPayerType,
                base_product_id: baseProductId,
                service_name: serviceName
            };
        }
        
        /**
         * Отправить данные в корзину через AJAX
         */
        function sendToCart() {
            const cartData = collectCartData();
            
            console.log('Отправка в корзину:', cartData);
            
            // Проверка 1: Обязательно должен быть выбран тип плательщика
            if (!cartData.payer_type || cartData.base_product_id <= 0) {
                console.error('Валидация не прошла:', {
                    payer_type: cartData.payer_type,
                    base_product_id: cartData.base_product_id
                });
                alert('Пожалуйста, выберите тип плательщика (Физическое лицо / ИП / Юридическое лицо)');
                return;
            }
            
            // Проверка 2: Должен быть выбран хотя бы один товар/услуга (кроме типа плательщика)
            // Считаем чекбоксы, исключая тип плательщика
            const selectedItemsCount = $('.service-checkbox:checked').filter(function() {
                const productId = parseInt($(this).attr('data-product-id')) || 0;
                return productId !== cartData.base_product_id;
            }).length;
            
            if (selectedItemsCount === 0) {
                alert('Пожалуйста, выберите хотя бы один сертификат или дополнительную услугу');
                return;
            }
            
            // Показываем индикатор загрузки
            const $submitBtn = $('.submit-order-btn');
            const originalText = $submitBtn.text();
            $submitBtn.prop('disabled', true).text('Обработка...').addClass('text-white');
            
            // Отправляем AJAX запрос
            $.ajax({
                url: enotaryBundleAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'add_custom_bundle_to_cart',
                    nonce: enotaryBundleAjax.nonce,
                    items: JSON.stringify(cartData.items),
                    payer_type: cartData.payer_type,
                    base_product_id: cartData.base_product_id,
                    service_name: cartData.service_name
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
