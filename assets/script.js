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
        const mainContent = document.querySelector('body > .flex:first-child');
        if (mainContent) {
            mainContent.style.paddingTop = headerHeight + 'px';
        }
    }
    
    // Устанавливаем отступ при загрузке и изменении размера окна
    setHeaderOffset();
    window.addEventListener('resize', setHeaderOffset);
    
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

    if (!searchInput || !searchIcon || !clearIcon) return;

    // Отслеживание ввода в input
    searchInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            searchIcon.classList.add('hidden');
            clearIcon.classList.remove('hidden');
        } else {
            searchIcon.classList.remove('hidden');
            clearIcon.classList.add('hidden');
        }
    });

    // Очистка поля поиска
    clearIcon.addEventListener('click', function() {
        searchInput.value = '';
        searchIcon.classList.remove('hidden');
        clearIcon.classList.add('hidden');
        searchInput.focus();
    });
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

    // Чекбоксы согласия
    const agreeCheckbox = document.querySelector('.checkbox-custom-agree');
    if (agreeCheckbox) {
        agreeCheckbox.addEventListener('click', function() {
            this.classList.toggle('checked');
        });
    }
}


// ===========================
// УПРАВЛЕНИЕ КОЛИЧЕСТВОМ
// ===========================

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


// ===========================
// КАРТОЧКИ ВЫБОРА ТИПА ЛИЦА
// ===========================

function initEntityCards() {
    const entityCards = document.querySelectorAll('.entity-card');
    
    if (entityCards.length === 0) return;

    entityCards.forEach(card => {
        card.addEventListener('click', function() {
            // Сбрасываем все карточки к неактивному состоянию
            entityCards.forEach(c => {
                c.classList.remove('entity-card-active', 'bg-primary');
                c.classList.add('bg-white');
                
                const text = c.querySelector('p:first-child');
                const priceBox = c.querySelector('div');
                const priceText = priceBox ? priceBox.querySelector('p') : null;
                
                // Неактивная карточка: черный текст, серый фон цены с белым текстом
                if (text) {
                    text.classList.remove('text-white');
                    text.classList.add('text-[#262626]');
                }
                if (priceBox) {
                    priceBox.classList.remove('bg-white');
                    priceBox.classList.add('bg-secondary');
                }
                if (priceText) {
                    priceText.classList.remove('text-[#262626]');
                    priceText.classList.add('text-white');
                }
            });
            
            // Активируем выбранную карточку
            this.classList.remove('bg-white');
            this.classList.add('entity-card-active', 'bg-primary');
            
            const text = this.querySelector('p:first-child');
            const priceBox = this.querySelector('div');
            const priceText = priceBox ? priceBox.querySelector('p') : null;
            
            // Активная карточка: белый текст, белый фон цены с черным текстом
            if (text) {
                text.classList.remove('text-[#262626]');
                text.classList.add('text-white');
            }
            if (priceBox) {
                priceBox.classList.remove('bg-secondary');
                priceBox.classList.add('bg-white');
            }
            if (priceText) {
                priceText.classList.remove('text-white');
                priceText.classList.add('text-[#262626]');
            }
            
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
    
    // Открытие модалки при клике на карточку документа
    documentCards.forEach(card => {
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
    initQuantityControls();
    initEntityCards();
    initDocumentModal();
    initDropdownMenu();
    
    // Инициализация AOS анимаций
    initAOS();
    
    // Первоначальный расчет итоговой суммы
    if (document.getElementById('totalPrice')) {
        updateTotal();
    }
});
