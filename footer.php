        <!-- Футер -->
        <footer class="w-full responsive-container pb-0 pt-[30px] md:pt-[40px] overflow-hidden flex flex-col gap-[30px] md:gap-[40px] lg:gap-[50px]">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 xl:gap-10 w-full">
                <!-- Главная -->
                <div class="flex flex-col gap-4 lg:gap-5">
                    <p class="font-bold text-sm md:text-base text-[#262626] leading-[1.15]">Главная</p>
                    <div class="flex flex-col gap-2.5 font-semibold text-sm md:text-base text-secondary leading-[1.15]">
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">О нас</p>
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">Новости</p>
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">Контакты</p>
                    </div>
                </div>

                <!-- Информация -->
                <div class="flex flex-col gap-4 lg:gap-5">
                    <p class="font-bold text-sm md:text-base text-[#262626] leading-[1.15]">Информация</p>
                    <div class="flex flex-col gap-2.5 font-semibold text-sm md:text-base text-secondary leading-[1.15]">
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">Лицензии и сертификаты</p>
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">Перечень требуемых документов</p>
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">Договор оферты</p>
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">Регламент УЦ</p>
                    </div>
                </div>

                <!-- Услуги -->
                <div class="flex flex-col gap-4 lg:gap-5">
                    <p class="font-bold text-sm md:text-base text-[#262626] leading-[1.15]">Услуги</p>
                    <div class="flex flex-col gap-2.5 font-semibold text-sm md:text-base text-secondary leading-[1.15]">
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">Проверка электронной подписи</p>
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">Сервер штампов времени</p>
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">Облачная подпись</p>
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">Справочник сертификатов</p>
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">Справочник квалифицированных сертификатов</p>
                    </div>
                </div>

                <!-- Цены -->
                <div class="flex flex-col gap-4 lg:gap-5">
                    <p class="font-bold text-sm md:text-base text-[#262626] leading-[1.15]">Цены на сертификаты электронной подписи</p>
                    <div class="flex flex-col gap-2.5 font-semibold text-sm md:text-base text-secondary leading-[1.15]">
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">Квалифицированная электронная подпись (КЭП)</p>
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">Электронная подпись для госуслуг</p>
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">Электронная подпись для торгов</p>
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">ЭЦП для портала поставщиков Москва</p>
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">ЭЦП для налоговой</p>
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">ЭЦП для юридических лиц</p>
                        <p class="cursor-pointer hover:opacity-70 transition-opacity">ЭЦП для физических лиц</p>
                    </div>
                </div>
            </div>

            <!-- Копирайт -->
            <div class="bg-[#333333] flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4 p-4 sm:p-5 rounded-tl-[15px] sm:rounded-tl-[20px] rounded-tr-[15px] sm:rounded-tr-[20px] font-semibold text-sm md:text-base text-white leading-[1.15]">
                <p class="whitespace-nowrap">2025 © ООО «Енот»</p>
                <a href="<?php echo enotarynew_get_page_url_by_template('page-politic.php'); ?>" class="text-center sm:text-right cursor-pointer hover:opacity-70 transition-opacity no-underline text-white">Политика конфиденциальности</a>
            </div>
        </footer>

        <!-- Модальное окно подбора сертификата (ТЗ п.230) -->
        <div class="certificate-help-modal" id="certificateHelpModal">
            <div class="modal-overlay"></div>
            <div class="modal-container">
                <div class="modal-content">
                    <!-- Кнопка закрытия -->
                    <button class="modal-close" id="closeHelpModal" aria-label="Закрыть">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    <!-- Заголовок -->
                    <div class="modal-header">
                        <div class="icon-wrapper">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 17H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 7V12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3>Не нашли нужный сертификат?</h3>
                        <p>Оставьте заявку, и наши специалисты помогут подобрать подходящее решение</p>
                    </div>

                    <!-- Форма -->
                    <form id="certificateHelpForm" class="help-form">
                        <div class="form-group">
                            <label for="help_name">Ваше имя <span class="required">*</span></label>
                            <input type="text" id="help_name" name="help_name" required placeholder="Иван Иванов">
                        </div>

                        <div class="form-group">
                            <label for="help_phone">Телефон <span class="required">*</span></label>
                            <input type="tel" id="help_phone" name="help_phone" required placeholder="+7 (___) ___-__-__">
                        </div>

                        <div class="form-group">
                            <label for="help_comment">Комментарий (необязательно)</label>
                            <textarea id="help_comment" name="help_comment" rows="4" placeholder="Опишите, какой сертификат вам нужен или для каких целей..."></textarea>
                        </div>

                        <div class="form-message" id="helpFormMessage"></div>

                        <button type="submit" class="submit-btn">
                            <span class="btn-text">Отправить заявку</span>
                            <span class="btn-loader" style="display: none;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" opacity="0.25"/>
                                    <path d="M12 2C6.47715 2 2 6.47715 2 12" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                                </svg>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <?php wp_footer(); ?>
</body>
</html>
