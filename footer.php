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
    </div>
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <?php wp_footer(); ?>
</body>
</html>
