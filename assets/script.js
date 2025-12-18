// ===========================
// КОНФИГУРАЦИЯ TAILWIND CSS
// ===========================

tailwind.config = {
    theme: {
        extend: {
            fontFamily: {
                'sans': ['Open Sans', 'sans-serif'],
                'roboto': ['Roboto', 'sans-serif'],
            },
            colors: {
                'primary': '#375d74',
                'secondary': '#979797',
                'dark': '#262626',
                'green-btn': '#19bd7b',
                'blue-btn': '#1ca7f7',
                'purple-icon': '#ca5ac3',
            }
        }
    }
};


// ===========================
// МОБИЛЬНОЕ МЕНЮ
// ===========================

// Инициализация элементов меню
function initMobileMenu() {
    const menuToggle = document.getElementById('menuToggle');
    const menuClose = document.getElementById('menuClose');
    const mobileMenu = document.getElementById('mobileMenu');
    const hamburger = document.getElementById('hamburger');
    const body = document.body;

    if (!menuToggle || !mobileMenu) return;

    // Открытие/закрытие меню
    function toggleMobileMenu() {
        const isActive = mobileMenu.classList.contains('active');
        
        if (isActive) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    }

    function openMobileMenu() {
        mobileMenu.classList.add('active');
        if (hamburger) hamburger.classList.add('active');
        body.classList.add('menu-open');
        body.style.overflow = 'hidden';
        body.style.position = 'fixed';
        body.style.width = '100%';
    }

    window.closeMobileMenu = function() {
        mobileMenu.classList.remove('active');
        if (hamburger) hamburger.classList.remove('active');
        body.classList.remove('menu-open');
        body.style.overflow = '';
        body.style.position = '';
        body.style.width = '';
    }

    // Обработчик клика по кнопке открытия меню
    menuToggle.addEventListener('click', toggleMobileMenu);

    // Обработчик клика по кнопке закрытия в меню
    if (menuClose) {
        menuClose.addEventListener('click', window.closeMobileMenu);
    }

    // Закрытие меню при клике вне его
    mobileMenu.addEventListener('click', function(e) {
        if (e.target === mobileMenu) {
            window.closeMobileMenu();
        }
    });

    // Закрытие меню при нажатии ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
            window.closeMobileMenu();
        }
    });

    // Предотвращение скролла при открытом меню
    mobileMenu.addEventListener('touchmove', function(e) {
        if (e.target === mobileMenu) {
            e.preventDefault();
        }
    }, { passive: false });
}


// ===========================
// ЛИПКАЯ ШАПКА С УМНЫМ СКРОЛЛОМ
// ===========================

function initStickyHeader() {
    const header = document.querySelector('header');
    if (!header) return;

    let lastScroll = 0;
    let ticking = false;
    const scrollThreshold = 50;
    const hideThreshold = 10;
    
    // Добавляем отступ для контента под фиксированной шапкой
    function setHeaderOffset() {
        const headerHeight = header.offsetHeight;
        
        // Ищем первый контентный элемент после header
        // Исключаем только WordPress админку и служебные элементы
        let mainContent = null;
        
        // Получаем все прямые дочерние элементы body
        const bodyChildren = Array.from(document.body.children);
        
        // Находим первый элемент, который НЕ является:
        // - WordPress админкой (#wpadminbar)
        // - Header'ом
        // - Script/Style
        for (let element of bodyChildren) {
            const tagName = element.tagName.toLowerCase();
            const id = element.id;
            const classes = element.className;
            
            // Пропускаем служебные элементы
            if (id === 'wpadminbar' || 
                tagName === 'script' || 
                tagName === 'style' ||
                tagName === 'header' ||
                classes.includes('nojq')) {
                continue;
            }
            
            // Это наш первый контентный элемент!
            mainContent = element;
            break;
        }
        
        if (mainContent) {
            mainContent.style.paddingTop = headerHeight + 'px';
        }
    }
    
    // Устанавливаем отступ при загрузке и изменении размера окна
    setHeaderOffset();
    window.addEventListener('resize', setHeaderOffset);
    
    // Дополнительная проверка для WooCommerce страниц (они могут загружаться позже)
    if (document.body.classList.contains('woocommerce-account') || 
        document.body.classList.contains('woocommerce-checkout')) {
        setTimeout(setHeaderOffset, 100);
        setTimeout(setHeaderOffset, 300);
    }
    
    function updateHeader() {
        const currentScroll = window.pageYOffset;
        
        // Добавляем/убираем класс scrolled при прокрутке больше порога
        if (currentScroll > scrollThreshold) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
            header.classList.remove('scrolled-down');
            header.classList.remove('scrolled-up');
        }
        
        // Скрываем/показываем шапку при скролле вниз/вверх
        if (currentScroll > scrollThreshold) {
            if (currentScroll > lastScroll && currentScroll - lastScroll > hideThreshold) {
                // Скролл вниз - скрываем шапку
                header.classList.remove('scrolled-up');
                header.classList.add('scrolled-down');
            } else if (currentScroll < lastScroll && lastScroll - currentScroll > hideThreshold) {
                // Скролл вверх - показываем шапку
                header.classList.remove('scrolled-down');
                header.classList.add('scrolled-up');
            }
        }
        
        lastScroll = currentScroll;
        ticking = false;
    }
    
    window.addEventListener('scroll', function() {
        if (!ticking) {
            window.requestAnimationFrame(updateHeader);
            ticking = true;
        }
    });
    
    // Инициализация начального состояния
    updateHeader();
}


// ===========================
// ПОИСК В БЛОГЕ
// ===========================

function initBlogSearch() {
    const searchInput = document.getElementById('blogSearchInput');
    const searchIcon = document.getElementById('searchIcon');
    const clearIcon = document.getElementById('clearIcon');
    const blogGrid = document.querySelector('.blog-grid');

    if (!searchInput || !searchIcon || !clearIcon || !blogGrid) return;

    let currentSearchQuery = '';
    let isSearching = false;

    // Показать/скрыть иконки при наличии текста
    function toggleIcons() {
        if (searchInput.value.length > 0) {
            searchIcon.classList.add('hidden');
            clearIcon.classList.remove('hidden');
        } else {
            searchIcon.classList.remove('hidden');
            clearIcon.classList.add('hidden');
        }
    }

    // Инициализация при загрузке
    toggleIcons();

    // Отслеживание ввода в input
    searchInput.addEventListener('input', toggleIcons);

    // Функция AJAX поиска
    function performSearch(page = 1) {
        if (isSearching) return;
        
        const searchQuery = searchInput.value.trim();
        currentSearchQuery = searchQuery;
        isSearching = true;

        // Показываем loader
        blogGrid.style.opacity = '0.5';
        blogGrid.style.pointerEvents = 'none';

        // AJAX запрос
        fetch(ajaxurl || '/wp-admin/admin-ajax.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'blog_search',
                search: searchQuery,
                paged: page
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Обновляем контент
                blogGrid.innerHTML = data.data.posts;
                
                // Обновляем пагинацию
                const blogSection = blogGrid.closest('section');
                const oldPagination = blogSection.querySelector('.pagination-container');
                
                if (data.data.pagination) {
                    // Если пагинация есть в ответе
                    if (oldPagination) {
                        // Заменяем существующую
                        oldPagination.outerHTML = data.data.pagination;
                    } else {
                        // Добавляем новую после blogGrid
                        blogSection.insertAdjacentHTML('beforeend', data.data.pagination);
                    }
                    // Переинициализируем обработчики пагинации
                    initPaginationHandlers();
                } else {
                    // Если пагинации нет в ответе, удаляем её
                    if (oldPagination) {
                        oldPagination.remove();
                    }
                }
                
                // Скроллим вверх к результатам
                blogGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });
                
                // Восстанавливаем видимость
                blogGrid.style.opacity = '1';
                blogGrid.style.pointerEvents = 'auto';
            }
            isSearching = false;
        })
        .catch(error => {
            console.error('Ошибка поиска:', error);
            blogGrid.style.opacity = '1';
            blogGrid.style.pointerEvents = 'auto';
            isSearching = false;
        });
    }

    // Обработчики пагинации
    function initPaginationHandlers() {
        const paginationBtns = document.querySelectorAll('.pagination-btn');
        paginationBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const page = parseInt(this.getAttribute('data-page'));
                performSearch(page);
            });
        });
    }

    // Поиск по Enter
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            performSearch(1);
        }
    });

    // Поиск по клику на иконку
    searchIcon.addEventListener('click', function() {
        performSearch(1);
    });

    // Очистка поля поиска
    clearIcon.addEventListener('click', function() {
        searchInput.value = '';
        toggleIcons();
        searchInput.focus();
        // Выполняем поиск с пустым запросом (показываем все)
        performSearch(1);
    });

    // Инициализируем обработчики пагинации при загрузке
    initPaginationHandlers();
}


// ===========================
// ЧЕКБОКСЫ
// ===========================

function initCheckboxes() {
    // Простые чекбоксы
    const checkboxes = document.querySelectorAll('.checkbox-custom');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('click', function() {
            this.classList.toggle('checked');
            
            // Обновление количества если есть
            const row = this.closest('div[class*="flex"]');
            if (row) {
                const control = row.querySelector('.quantity-control');
                if (control) {
                    const valueSpan = control.querySelector('.quantity-value');
                    if (valueSpan) {
                        let currentValue = parseInt(valueSpan.textContent);
                        
                        if (this.classList.contains('checked') && currentValue === 0) {
                            valueSpan.textContent = '1';
                        } else if (!this.classList.contains('checked')) {
                            valueSpan.textContent = '0';
                        }
                    }
                }
            }
            
            // Обновить итоговую сумму если функция существует
            if (typeof updateTotal === 'function') {
                updateTotal();
            }
        });
    });

    // Чекбоксы согласия (поддержка множественных чекбоксов на странице)
    const agreeCheckboxes = document.querySelectorAll('.checkbox-custom-agree');
    agreeCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('click', function() {
            this.classList.toggle('checked');
            
            // Синхронизация со скрытым input checkbox
            const parent = this.parentElement;
            const hiddenInput = parent.querySelector('input[type="checkbox"]');
            if (hiddenInput) {
                hiddenInput.checked = this.classList.contains('checked');
            }
        });
    });
}


// ===========================
// УПРАВЛЕНИЕ КОЛИЧЕСТВОМ
// ===========================
// ФУНКЦИЯ ПЕРЕНЕСЕНА В universal-calc.js
// Не использовать здесь, чтобы избежать дублирования обработчиков

/*
function initQuantityControls() {
    const quantityButtons = document.querySelectorAll('.quantity-btn');
    
    // Синхронизация чекбоксов с начальными значениями количества
    document.querySelectorAll('.quantity-control').forEach(control => {
        const valueSpan = control.querySelector('.quantity-value');
        // Поднимаемся выше по DOM дереву чтобы найти родительскую строку
        let row = control.parentElement;
        while (row && !row.querySelector('.checkbox-custom')) {
            row = row.parentElement;
            // Ограничиваем поиск, чтобы не уйти слишком далеко
            if (row && row.tagName === 'SECTION') break;
        }
        const checkbox = row ? row.querySelector('.checkbox-custom') : null;
        const currentValue = parseInt(valueSpan.textContent);
        
        if (checkbox) {
            if (currentValue > 0) {
                checkbox.classList.add('checked');
            } else {
                checkbox.classList.remove('checked');
            }
        }
    });
    
    quantityButtons.forEach(button => {
        button.addEventListener('click', function() {
            const action = this.dataset.action;
            const control = this.closest('.quantity-control');
            const valueSpan = control.querySelector('.quantity-value');
            
            // Поднимаемся выше по DOM дереву чтобы найти родительскую строку
            let row = control.parentElement;
            while (row && !row.querySelector('.checkbox-custom')) {
                row = row.parentElement;
                // Ограничиваем поиск, чтобы не уйти слишком далеко
                if (row && row.tagName === 'SECTION') break;
            }
            const checkbox = row ? row.querySelector('.checkbox-custom') : null;
            let currentValue = parseInt(valueSpan.textContent);
            
            if (action === 'increment') {
                currentValue++;
                if (currentValue > 0 && checkbox) {
                    checkbox.classList.add('checked');
                }
            } else if (action === 'decrement' && currentValue > 0) {
                currentValue--;
                if (currentValue === 0 && checkbox) {
                    checkbox.classList.remove('checked');
                }
            }
            
            valueSpan.textContent = currentValue;
            
            // Обновить итоговую сумму если функция существует
            if (typeof updateTotal === 'function') {
                updateTotal();
            }
        });
    });
}
*/


// ===========================
// КАРТОЧКИ ВЫБОРА ТИПА ЛИЦА
// ===========================

function initEntityCards() {
    const entityCards = document.querySelectorAll('.entity-card');
    
    if (entityCards.length === 0) return;

    // Функция применения стилей для неактивной карточки
    function setInactiveStyles(card) {
        card.classList.remove('entity-card-active', 'bg-primary');
        card.classList.add('bg-white');
        
        const label = card.querySelector('.entity-card-label');
        const priceBox = card.querySelector('.entity-card-price-box');
        const priceText = card.querySelector('.entity-card-price-text');
        
        if (label) {
            label.classList.remove('text-white');
            label.classList.add('text-[#262626]');
        }
        if (priceBox) {
            priceBox.classList.remove('bg-white');
            priceBox.classList.add('bg-secondary');
        }
        if (priceText) {
            priceText.classList.remove('text-[#262626]', 'text-black');
            priceText.classList.add('text-white');
        }
    }
    
    // Функция применения стилей для активной карточки
    function setActiveStyles(card) {
        card.classList.remove('bg-white');
        card.classList.add('entity-card-active', 'bg-primary');
        
        const label = card.querySelector('.entity-card-label');
        const priceBox = card.querySelector('.entity-card-price-box');
        const priceText = card.querySelector('.entity-card-price-text');
        
        if (label) {
            label.classList.remove('text-[#262626]');
            label.classList.add('text-white');
        }
        if (priceBox) {
            priceBox.classList.remove('bg-secondary');
            priceBox.classList.add('bg-white');
        }
        if (priceText) {
            priceText.classList.remove('text-white');
            priceText.classList.add('text-[#262626]', 'text-black');
        }
    }
    
    // Применяем правильные стили при загрузке страницы
    entityCards.forEach(card => {
        if (card.classList.contains('entity-card-active')) {
            setActiveStyles(card);
        } else {
            setInactiveStyles(card);
        }
    });

    // Обработчик клика
    entityCards.forEach(card => {
        card.addEventListener('click', function() {
            // Сбрасываем все карточки
            entityCards.forEach(c => setInactiveStyles(c));
            
            // Активируем выбранную
            setActiveStyles(this);
            
            // Обновить итоговую сумму если функция существует
            if (typeof updateTotal === 'function') {
                updateTotal();
            }
        });
    });
}


// ===========================
// ПОДСЧЕТ ОБЩЕЙ СУММЫ
// ===========================

function updateTotal() {
    const totalPriceElement = document.getElementById('totalPrice');
    if (!totalPriceElement) return;

    let total = 0;
    
    // 1. Добавляем стоимость выбранного типа лица (entity-card-active)
    const activeEntityCard = document.querySelector('.entity-card-active');
    if (activeEntityCard && activeEntityCard.dataset.price) {
        const entityPrice = parseInt(activeEntityCard.dataset.price);
        if (!isNaN(entityPrice)) {
            total += entityPrice;
        }
    }
    
    // 2. Проходим по всем строкам с товарами в секциях
    const productSections = document.querySelectorAll('section .bg-white.border');
    
    productSections.forEach(section => {
        // Ищем все прямые дочерние div элементы секции (это строки товаров)
        const rows = section.querySelectorAll(':scope > div');
        
        rows.forEach(row => {
            const quantityControl = row.querySelector('.quantity-control');
            const checkbox = row.querySelector('.checkbox-custom');
            
            // Ищем элемент цены - последний <p> с ценой в строке
            const priceElements = row.querySelectorAll('p');
            let priceElement = null;
            
            // Находим элемент с ценой (содержит ₽)
            for (let i = priceElements.length - 1; i >= 0; i--) {
                if (priceElements[i].textContent.includes('₽')) {
                    priceElement = priceElements[i];
                    break;
                }
            }
            
            if (!priceElement) return;
            
            const priceText = priceElement.textContent.replace(/[^\d]/g, '');
            const price = parseInt(priceText);
            
            if (isNaN(price)) return;
            
            if (quantityControl) {
                // Если есть контроль количества
                const quantityValue = quantityControl.querySelector('.quantity-value');
                if (quantityValue) {
                    const quantity = parseInt(quantityValue.textContent);
                    if (!isNaN(quantity) && quantity > 0) {
                        total += quantity * price;
                    }
                }
            } else if (checkbox && checkbox.classList.contains('checked')) {
                // Если только чекбокс без количества
                total += price;
            }
        });
    });
    
    // Обновляем отображение общей суммы
    totalPriceElement.textContent = total.toLocaleString('ru-RU') + '₽';
}


// ===========================
// МОДАЛЬНОЕ ОКНО ДОКУМЕНТОВ
// ===========================

function initDocumentModal() {
    const documentModal = document.getElementById('documentModal');
    const modalDocumentTitle = document.getElementById('modalDocumentTitle');
    const documentCards = document.querySelectorAll('.document-card');
    const body = document.body;

    if (!documentModal) return;
    
    // Открытие модалки при клике на карточку документа (только для карточек без data-doc-type)
    documentCards.forEach(card => {
        // Пропускаем карточки с ACF управлением (те, у которых есть data-doc-type)
        if (card.hasAttribute('data-doc-type')) {
            return;
        }
        
        card.addEventListener('click', function() {
            const title = this.querySelector('.font-bold.text-\\[18px\\], .font-bold.text-\\[20px\\]');
            if (title && modalDocumentTitle) {
                modalDocumentTitle.textContent = title.textContent;
            }
            openModal();
        });
    });
    
    function openModal() {
        documentModal.classList.add('active');
        body.classList.add('modal-open');
    }
    
    window.closeModal = function() {
        documentModal.classList.remove('active');
        body.classList.remove('modal-open');
    }
    
    // Закрытие модалки при клике вне её
    documentModal.addEventListener('click', function(e) {
        if (e.target === documentModal) {
            window.closeModal();
        }
    });
    
    // Закрытие модалки при нажатии ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && documentModal.classList.contains('active')) {
            window.closeModal();
        }
    });
}


// ===========================
// ВЫПАДАЮЩЕЕ ПОДМЕНЮ
// ===========================

// Функция для управления мобильным подменю
function toggleMobileSubmenu(event) {
    event.stopPropagation();
    const menuItemWithSubmenu = event.currentTarget.closest('.menu-item-with-submenu');
    
    if (menuItemWithSubmenu) {
        menuItemWithSubmenu.classList.toggle('active');
    }
}

// Инициализация десктопного выпадающего меню
function initDropdownMenu() {
    const navItemWithDropdown = document.querySelector('.nav-item-with-dropdown');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    
    if (!navItemWithDropdown || !dropdownMenu) return;
    
    let timeoutId;
    
    // При наведении показываем меню
    navItemWithDropdown.addEventListener('mouseenter', function() {
        clearTimeout(timeoutId);
    });
    
    // При уходе курсора скрываем меню с небольшой задержкой
    navItemWithDropdown.addEventListener('mouseleave', function() {
        timeoutId = setTimeout(function() {
            // Меню скроется через CSS
        }, 100);
    });
    
    // Добавляем обработчики для элементов подменю
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    dropdownItems.forEach(item => {
        item.addEventListener('click', function() {
            // Здесь можно добавить навигацию или другие действия
            console.log('Clicked:', this.querySelector('p').textContent);
        });
    });
}


// ===========================
// ИНИЦИАЛИЗАЦИЯ AOS АНИМАЦИЙ
// ===========================

function initAOS() {
    // Проверяем, подключена ли библиотека AOS
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800, // Длительность анимации
            easing: 'ease-out-cubic', // Плавность
            once: true, // Анимация срабатывает один раз
            offset: 50, // Отступ для срабатывания (px)
            delay: 0, // Базовая задержка
            disable: false, // Отключение на мобильных: false = работает везде
            anchorPlacement: 'top-bottom', // Точка срабатывания
            mirror: false, // Повтор при обратном скролле
        });
    }
}


// ===========================
// ИНИЦИАЛИЗАЦИЯ ПРИ ЗАГРУЗКЕ
// ===========================

document.addEventListener('DOMContentLoaded', function() {
    // Инициализация всех компонентов
    initMobileMenu();
    initStickyHeader();
    initBlogSearch();
    initCheckboxes();
    // initQuantityControls(); // ОТКЛЮЧЕНО - теперь в universal-calc.js
    initEntityCards();
    initDocumentModal();
    initDropdownMenu();
    initCertificateHelpModal(); // Модальное окно подбора сертификата (ТЗ п.230)
    initVerificationModal(); // Модальное окно проверки УКЭП (страница ПО&Токены&Услуги)
    initCustomCheckbox(); // Кастомный чекбокс на странице контактов
    initContactForm(); // Форма обратной связи на странице контактов
    
    // Инициализация AOS анимаций
    initAOS();
    
    // Первоначальный расчет итоговой суммы
    if (document.getElementById('totalPrice')) {
        updateTotal();
    }
});

// ===========================
// МОДАЛЬНОЕ ОКНО ПОДБОРА СЕРТИФИКАТА (ТЗ П.230)
// ===========================

function initCertificateHelpModal() {
    const modal = document.getElementById('certificateHelpModal');
    const openBtn = document.getElementById('openHelpModal');
    const closeBtn = document.getElementById('closeHelpModal');
    const form = document.getElementById('certificateHelpForm');
    const messageDiv = document.getElementById('helpFormMessage');
    
    if (!modal || !form) return;
    
    // Открытие модалки
    if (openBtn) {
        openBtn.addEventListener('click', function() {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }
    
    // Закрытие модалки
    function closeModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
        form.reset();
        messageDiv.innerHTML = '';
        messageDiv.className = 'form-message';
    }
    
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }
    
    // Закрытие при клике на overlay
    modal.addEventListener('click', function(e) {
        if (e.target === modal || e.target.classList.contains('modal-overlay')) {
            closeModal();
        }
    });
    
    // Закрытие по ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });
    
    // Маска для телефона
    const phoneInput = document.getElementById('help_phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            let formatted = '';
            
            if (value.length > 0) {
                formatted = '+7 ';
                if (value.length > 1) {
                    formatted += '(' + value.substring(1, 4);
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
            }
            
            e.target.value = formatted;
        });
    }
    
    // Отправка формы
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = form.querySelector('.submit-btn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoader = submitBtn.querySelector('.btn-loader');
        
        // Получаем данные формы
        const formData = new FormData();
        formData.append('action', 'submit_certificate_help');
        formData.append('nonce', certificateHelpData.nonce);
        formData.append('name', document.getElementById('help_name').value);
        formData.append('phone', document.getElementById('help_phone').value);
        formData.append('comment', document.getElementById('help_comment').value);
        
        // Показываем загрузчик
        submitBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoader.style.display = 'inline-block';
        messageDiv.innerHTML = '';
        messageDiv.className = 'form-message';
        
        // Отправляем AJAX запрос
        fetch(certificateHelpData.ajaxUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoader.style.display = 'none';
            
            if (data.success) {
                messageDiv.className = 'form-message success';
                messageDiv.innerHTML = data.data.message;
                form.reset();
                
                // Закрываем модалку через 3 секунды
                setTimeout(closeModal, 3000);
            } else {
                messageDiv.className = 'form-message error';
                messageDiv.innerHTML = data.data.message;
            }
        })
        .catch(error => {
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoader.style.display = 'none';
            
            messageDiv.className = 'form-message error';
            messageDiv.innerHTML = 'Произошла ошибка. Пожалуйста, попробуйте позже.';
        });
    });
}

// ===========================
// MODALNOE OKNO PROVERKI UKEP (Stranitsa PO&Tokeny&Uslugi)
// ===========================

function initVerificationModal() {
    const modal = document.getElementById('verificationModal');
    const openBtn = document.getElementById('openVerificationModal');
    const closeBtn = document.getElementById('closeVerificationModal');
    
    if (!modal) return;
    
    // Otkrytie modalki
    if (openBtn) {
        openBtn.addEventListener('click', function(e) {
            e.preventDefault();
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }
    
    // Zakrytie modalki
    function closeModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }
    
    // Zakrytie pri klike na overlay
    modal.addEventListener('click', function(e) {
        if (e.target === modal || e.target.classList.contains('modal-overlay')) {
            closeModal();
        }
    });
    
    // Zakrytie po ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });
}

// ===========================
// КАСТОМНЫЙ ЧЕКБОКС
// ===========================

function initCustomCheckbox() {
    const checkbox = document.getElementById('agreeCheckbox');
    const customCheckbox = document.querySelector('.checkbox-custom');
    
    if (!checkbox || !customCheckbox) return;
    
    // Sync visual state with checkbox state on page load
    if (checkbox.checked) {
        customCheckbox.classList.add('checked');
    }
    
    // Click on custom checkbox toggles real checkbox
    customCheckbox.addEventListener('click', function(e) {
        e.preventDefault();
        checkbox.checked = !checkbox.checked;
        
        if (checkbox.checked) {
            customCheckbox.classList.add('checked');
        } else {
            customCheckbox.classList.remove('checked');
        }
    });
}

// ===========================
// ФОРМА ОБРАТНОЙ СВЯЗИ НА СТРАНИЦЕ КОНТАКТЫ
// ===========================

function initContactForm() {
    const form = document.getElementById('contactForm');
    if (!form) return;
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const submitBtn = form.querySelector('button[type="submit"]');
        const messageDiv = document.getElementById('contactFormMessage');
        const btnText = submitBtn.querySelector('p');
        const originalText = btnText.textContent;
        
        // Validation
        const name = form.querySelector('[name="contact_name"]').value.trim();
        const email = form.querySelector('[name="contact_email"]').value.trim();
        const agree = form.querySelector('[name="agree"]').checked;
        
        if (!name || !email) {
            showMessage(messageDiv, 'Пожалуйста, заполните все обязательные поля', 'error');
            return;
        }
        
        if (!validateEmail(email)) {
            showMessage(messageDiv, 'Пожалуйста, введите корректный email', 'error');
            return;
        }
        
        if (!agree) {
            showMessage(messageDiv, 'Необходимо согласие на обработку персональных данных', 'error');
            return;
        }
        
        // Disable button
        submitBtn.disabled = true;
        btnText.textContent = 'Отправка...';
        
        try {
            const formData = new FormData(form);
            formData.append('action', 'contact_form_submit');
            formData.append('nonce', enotaryAjax.nonce);
            
            const response = await fetch(enotaryAjax.ajaxurl, {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                showMessage(messageDiv, data.data.message || 'Сообщение успешно отправлено!', 'success');
                form.reset();
                // Reset custom checkbox
                const customCheckbox = document.querySelector('.checkbox-custom');
                if (customCheckbox) {
                    customCheckbox.classList.remove('checked');
                }
            } else {
                showMessage(messageDiv, data.data.message || 'Произошла ошибка при отправке', 'error');
            }
        } catch (error) {
            showMessage(messageDiv, 'Ошибка соединения. Попробуйте позже', 'error');
        } finally {
            submitBtn.disabled = false;
            btnText.textContent = originalText;
        }
    });
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function showMessage(element, text, type) {
    element.textContent = text;
    element.className = `form-message ${type}`;
    element.classList.remove('hidden');
    
    setTimeout(() => {
        element.classList.add('hidden');
    }, 5000);
}