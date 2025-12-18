/**
 * Валидация форм чекаута E-Notary
 * 
 * Клиентская валидация для трех типов плательщиков:
 * - Физическое лицо
 * - ИП
 * - Юридическое лицо
 * 
 * @package enotarynew
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        
        /**
         * ============================================
         * ПРАВИЛА ВАЛИДАЦИИ ДЛЯ РАЗНЫХ ПОЛЕЙ
         * ============================================
         */
        
        const validationRules = {
            // ФИО - минимум 3 слова (Фамилия Имя Отчество)
            fullName: {
                validate: function(value) {
                    const trimmed = value.trim();
                    const words = trimmed.split(/\s+/).filter(w => w.length > 0);
                    return words.length >= 2 && trimmed.length >= 5;
                },
                message: 'Введите ФИО полностью (минимум 2 слова)'
            },
            
            // Email стандартная проверка
            email: {
                validate: function(value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return emailRegex.test(value);
                },
                message: 'Введите корректный email адрес'
            },
            
            // Телефон - должен содержать 11 цифр
            phone: {
                validate: function(value) {
                    const digitsOnly = value.replace(/\D/g, '');
                    return digitsOnly.length === 11;
                },
                message: 'Введите номер телефона полностью (11 цифр)'
            },
            
            // ИНН физ лица - 10 или 12 цифр
            innIndividual: {
                validate: function(value) {
                    const digitsOnly = value.replace(/\D/g, '');
                    return digitsOnly.length === 10 || digitsOnly.length === 12;
                },
                message: 'ИНН должен содержать 10 или 12 цифр'
            },
            
            // ИНН юр лица - 10 цифр
            innLegal: {
                validate: function(value) {
                    const digitsOnly = value.replace(/\D/g, '');
                    return digitsOnly.length === 10;
                },
                message: 'ИНН юридического лица должен содержать 10 цифр'
            },
            
            // КПП - 9 цифр
            kpp: {
                validate: function(value) {
                    const digitsOnly = value.replace(/\D/g, '');
                    return digitsOnly.length === 9;
                },
                message: 'КПП должен содержать 9 цифр'
            },
            
            // ОКПО - от 8 до 14 цифр
            okpo: {
                validate: function(value) {
                    const digitsOnly = value.replace(/\D/g, '');
                    return digitsOnly.length >= 8 && digitsOnly.length <= 14;
                },
                message: 'ОКПО должен содержать от 8 до 14 цифр'
            },
            
            // Почтовый индекс - 6 цифр
            postcode: {
                validate: function(value) {
                    const digitsOnly = value.replace(/\D/g, '');
                    return digitsOnly.length === 6;
                },
                message: 'Почтовый индекс должен содержать 6 цифр'
            },
            
            // Адрес - минимум 5 символов
            address: {
                validate: function(value) {
                    return value.trim().length >= 5;
                },
                message: 'Адрес должен содержать минимум 5 символов'
            },
            
            // Название компании - минимум 3 символа
            companyName: {
                validate: function(value) {
                    return value.trim().length >= 3;
                },
                message: 'Название компании должно содержать минимум 3 символа'
            }
        };
        
        /**
         * ============================================
         * ВИЗУАЛЬНАЯ ОБРАТНАЯ СВЯЗЬ
         * ============================================
         */
        
        /**
         * Показать ошибку для поля
         */
        function showFieldError($field, message) {
            // Убираем предыдущую ошибку
            hideFieldError($field);
            
            // Добавляем класс ошибки
            $field.addClass('error-field').css({
                'border-color': '#ef4444',
                'border-width': '2px'
            });
            
            // Находим контейнер родителя
            const $container = $field.closest('.flex.flex-col');
            
            // Добавляем сообщение об ошибке
            $container.append(
                '<p class="validation-error text-red-500 text-xs sm:text-sm font-semibold mt-1">' + 
                message + 
                '</p>'
            );
        }
        
        /**
         * Убрать ошибку с поля
         */
        function hideFieldError($field) {
            $field.removeClass('error-field').css({
                'border-color': '',
                'border-width': ''
            });
            
            const $container = $field.closest('.flex.flex-col');
            $container.find('.validation-error').remove();
        }
        
        /**
         * ============================================
         * ВАЛИДАЦИЯ В РЕАЛЬНОМ ВРЕМЕНИ
         * ============================================
         */
        
        /**
         * Валидация ФИО
         */
        $('input[name="billing_first_name"]').on('blur', function() {
            const $field = $(this);
            const value = $field.val();
            
            if (value.length === 0) return; // Пропускаем пустые поля (проверится при отправке)
            
            if (!validationRules.fullName.validate(value)) {
                showFieldError($field, validationRules.fullName.message);
            } else {
                hideFieldError($field);
            }
        });
        
        /**
         * Валидация Email
         */
        $('input[name="billing_email"]').on('blur', function() {
            const $field = $(this);
            const value = $field.val();
            
            if (value.length === 0) return;
            
            if (!validationRules.email.validate(value)) {
                showFieldError($field, validationRules.email.message);
            } else {
                hideFieldError($field);
            }
        });
        
        /**
         * Валидация телефона
         */
        $('input[name="billing_phone"]').on('blur', function() {
            const $field = $(this);
            const value = $field.val();
            
            if (value.length === 0) return;
            
            if (!validationRules.phone.validate(value)) {
                showFieldError($field, validationRules.phone.message);
            } else {
                hideFieldError($field);
            }
        });
        
        /**
         * Валидация ИНН (разные правила для ФЛ/ИП и ЮЛ)
         */
        $('input[name="billing_inn"]').on('blur', function() {
            const $field = $(this);
            const value = $field.val();
            const fieldId = $field.attr('id');
            
            if (value.length === 0) return;
            
            // Определяем тип плательщика по ID поля
            const isLegal = fieldId === 'billing_inn_legal';
            const rule = isLegal ? validationRules.innLegal : validationRules.innIndividual;
            
            if (!rule.validate(value)) {
                showFieldError($field, rule.message);
            } else {
                hideFieldError($field);
            }
        });
        
        /**
         * Валидация КПП (только для ЮЛ)
         */
        $('input[name="billing_kpp"]').on('blur', function() {
            const $field = $(this);
            const value = $field.val();
            
            if (value.length === 0) return;
            
            if (!validationRules.kpp.validate(value)) {
                showFieldError($field, validationRules.kpp.message);
            } else {
                hideFieldError($field);
            }
        });
        
        /**
         * Валидация ОКПО (только для ЮЛ)
         */
        $('input[name="billing_okpo"]').on('blur', function() {
            const $field = $(this);
            const value = $field.val();
            
            if (value.length === 0) return;
            
            if (!validationRules.okpo.validate(value)) {
                showFieldError($field, validationRules.okpo.message);
            } else {
                hideFieldError($field);
            }
        });
        
        /**
         * Валидация почтового индекса
         */
        $('input[name="billing_postcode_custom"]').on('blur', function() {
            const $field = $(this);
            const value = $field.val();
            
            if (value.length === 0) return;
            
            if (!validationRules.postcode.validate(value)) {
                showFieldError($field, validationRules.postcode.message);
            } else {
                hideFieldError($field);
            }
        });
        
        /**
         * Валидация адресов
         */
        $('input[name="billing_passport_address"], input[name="billing_legal_address"]').on('blur', function() {
            const $field = $(this);
            const value = $field.val();
            
            if (value.length === 0) return;
            
            if (!validationRules.address.validate(value)) {
                showFieldError($field, validationRules.address.message);
            } else {
                hideFieldError($field);
            }
        });
        
        /**
         * Валидация названия компании
         */
        $('input[name="billing_company"]').on('blur', function() {
            const $field = $(this);
            const value = $field.val();
            
            if (value.length === 0) return;
            
            if (!validationRules.companyName.validate(value)) {
                showFieldError($field, validationRules.companyName.message);
            } else {
                hideFieldError($field);
            }
        });
        
        /**
         * ============================================
         * ВАЛИДАЦИЯ ПРИ ОТПРАВКЕ ФОРМЫ
         * ============================================
         */
        
        /**
         * Проверка всех обязательных полей перед отправкой
         */
        $('form.checkout').on('checkout_place_order', function() {
            let hasErrors = false;
            
            // Получаем видимую форму (active payer type)
            const $activeForm = $('.payer-form-section:visible');
            
            if ($activeForm.length === 0) {
                console.warn('Не найдена активная форма плательщика');
                return true; // Разрешаем отправку, если форма не найдена
            }
            
            // Определяем тип плательщика по ID формы
            const formId = $activeForm.attr('id');
            const isIndividual = formId === 'individual-form';
            const isEntrepreneur = formId === 'entrepreneur-form';
            const isLegal = formId === 'legal-form';
            
            // Список обязательных полей для всех форм
            let requiredFields = [
                'billing_first_name',
                'billing_email',
                'billing_phone'
            ];
            
            // Добавляем специфичные обязательные поля для каждого типа
            if (isIndividual) {
                requiredFields.push('billing_inn', 'billing_passport_address', 'billing_postcode_custom');
            } else if (isEntrepreneur) {
                requiredFields.push('billing_inn', 'billing_postcode_custom');
            } else if (isLegal) {
                requiredFields.push('billing_company', 'billing_inn', 'billing_kpp', 'billing_legal_address', 'billing_postcode_custom');
            }
            
            // Проверяем обязательные поля
            requiredFields.forEach(function(fieldName) {
                const $field = $activeForm.find('input[name="' + fieldName + '"]');
                
                if ($field.length > 0) {
                    const value = $field.val().trim();
                    
                    if (value.length === 0) {
                        showFieldError($field, 'Это поле обязательно для заполнения');
                        hasErrors = true;
                    }
                }
            });
            
            // Проверяем чекбокс согласия на обработку данных
            const $consentCheckbox = $activeForm.find('input[name="personal_data_consent"]');
            if ($consentCheckbox.length > 0 && !$consentCheckbox.is(':checked')) {
                const $agreementBox = $consentCheckbox.closest('.agreement-box');
                $agreementBox.css({
                    'border-color': '#ef4444',
                    'border-width': '2px',
                    'background-color': '#fef2f2'
                });
                
                // Прокручиваем к чекбоксу
                $('html, body').animate({
                    scrollTop: $agreementBox.offset().top - 100
                }, 500);
                
                alert('Пожалуйста, дайте согласие на обработку персональных данных');
                hasErrors = true;
            } else {
                // Убираем ошибку если была
                const $agreementBox = $consentCheckbox.closest('.agreement-box');
                $agreementBox.css({
                    'border-color': '',
                    'border-width': '',
                    'background-color': ''
                });
            }
            
            // Если есть ошибки, прокручиваем к первой
            if (hasErrors) {
                const $firstError = $('.error-field').first();
                if ($firstError.length > 0) {
                    $('html, body').animate({
                        scrollTop: $firstError.offset().top - 100
                    }, 500);
                }
                
                return false; // Останавливаем отправку формы
            }
            
            return true; // Разрешаем отправку
        });
        
        /**
         * ============================================
         * ОБРАБОТКА КАСТОМНОГО ЧЕКБОКСА СОГЛАСИЯ
         * ============================================
         */
        
        /**
         * Переключение визуального чекбокса согласия
         * Обрабатывает клики как на сам чекбокс, так и на весь блок согласия
         */
        $(document).on('click', '.checkbox-custom-agree, .agreement-box', function(e) {
            // Находим нужные элементы в зависимости от того, на что кликнули
            let $visual, $checkbox, $agreementBox;
            
            if ($(this).hasClass('checkbox-custom-agree')) {
                // Клик непосредственно на визуальный чекбокс
                $visual = $(this);
                $checkbox = $visual.siblings('input[name="personal_data_consent"]');
                $agreementBox = $visual.closest('.agreement-box');
            } else {
                // Клик на контейнер .agreement-box
                $agreementBox = $(this);
                $visual = $agreementBox.find('.checkbox-custom-agree');
                $checkbox = $agreementBox.find('input[name="personal_data_consent"]');
            }
            
            if ($checkbox.length > 0) {
                const newState = !$checkbox.is(':checked');
                $checkbox.prop('checked', newState);
                
                if (newState) {
                    $visual.addClass('checked');
                } else {
                    $visual.removeClass('checked');
                }
                
                // Убираем ошибку если была
                $agreementBox.css({
                    'border-color': '',
                    'border-width': '',
                    'background-color': ''
                });
            }
        });
        
        /**
         * ============================================
         * АВТО-ФОРМАТИРОВАНИЕ ПОЛЕЙ
         * ============================================
         */
        
        /**
         * Форматирование телефона 8 (XXX) XXX-XX-XX
         */
        $('input[name="billing_phone"]').on('input', function() {
            let value = $(this).val().replace(/\D/g, '');
            
            if (value.length > 0) {
                if (value[0] === '7') value = '8' + value.substring(1);
                if (value[0] !== '8') value = '8' + value;
            }
            
            let formatted = '';
            
            if (value.length > 0) {
                formatted = value[0];
            }
            if (value.length > 1) {
                formatted += ' (' + value.substring(1, 4);
            }
            if (value.length >= 4) {
                formatted += ') ' + value.substring(4, 7);
            }
            if (value.length >= 7) {
                formatted += '-' + value.substring(7, 9);
            }
            if (value.length >= 9) {
                formatted += '-' + value.substring(9, 11);
            }
            
            $(this).val(formatted);
        });
        
        /**
         * Форматирование почтового индекса (только цифры)
         */
        $('input[name="billing_postcode_custom"]').on('input', function() {
            const value = $(this).val().replace(/\D/g, '').substring(0, 6);
            $(this).val(value);
        });
        
        /**
         * Форматирование ИНН (только цифры)
         */
        $('input[name="billing_inn"]').on('input', function() {
            const value = $(this).val().replace(/\D/g, '').substring(0, 12);
            $(this).val(value);
        });
        
        /**
         * Форматирование КПП (только цифры)
         */
        $('input[name="billing_kpp"]').on('input', function() {
            const value = $(this).val().replace(/\D/g, '').substring(0, 9);
            $(this).val(value);
        });
        
        /**
         * Форматирование ОКПО (только цифры)
         */
        $('input[name="billing_okpo"]').on('input', function() {
            const value = $(this).val().replace(/\D/g, '').substring(0, 14);
            $(this).val(value);
        });
        
        console.log('✓ Валидация форм чекаута инициализирована');
    });

})(jQuery);
