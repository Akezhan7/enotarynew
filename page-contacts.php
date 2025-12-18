<?php
/**
 * Template Name: Контакты
 * 
 * @package enotarynew
 */

get_header();
?>

<!-- Хлебные крошки -->
<div class="w-full responsive-container pb-3 lg:pb-4">
    <div class="flex items-center gap-2 font-semibold text-sm text-secondary">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary transition-colors">Главная</a>
        <span>/</span>
        <span class="text-dark">Контакты</span>
    </div>
</div>

<!-- Заголовок блока с фоном -->
<section class="page-hero-section responsive-container">
    <div class="page-hero-block" data-aos="fade-down">
        <!-- Декоративный вектор (позади текста) -->
        <div class="page-hero-vector">
            <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/Vector 1.png" alt="" class="block max-w-none w-full h-full object-contain">
        </div>
        <!-- Заголовок поверх вектора -->
        <p class="page-hero-title">Контакты</p>
    </div>
</section>

<!-- Основной контент контактов -->
<section class="w-full responsive-container py-5">
    <div class="flex flex-col gap-5">
        <!-- АО и ООО -->
        <?php
        $legal_info = get_theme_option('company_legal_info', array());
        if (!empty($legal_info)) :
        ?>
        <div class="company-info-row flex gap-[10px] items-center justify-center flex-wrap" data-aos="fade-up" data-aos-delay="100">
            <?php foreach ($legal_info as $index => $company) : ?>
                <?php if ($index > 0) : ?>
                <div class="company-separator w-1 h-1 relative">
                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/schema.png" alt="" class="block max-w-none w-full h-full">
                </div>
                <?php endif; ?>
                <div class="flex gap-[10px] items-center">
                    <p class="font-bold text-base text-secondary leading-[1.15]"><?php echo esc_html($company['name']); ?></p>
                    <p class="font-semibold text-base text-secondary leading-[1.15]">(ИНН <?php echo esc_html($company['inn']); ?>)</p>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Адреса -->
        <?php
        $addresses = get_theme_option('office_addresses', array());
        if (!empty($addresses)) :
        ?>
        <div class="addresses-row flex gap-5 flex-wrap">
            <?php foreach ($addresses as $index => $addr) : ?>
            <div class="address-card bg-container-bg flex-1 min-w-[280px] rounded-[20px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-5 flex flex-col gap-[30px]" data-aos="fade-up" data-aos-delay="<?php echo 150 + ($index * 50); ?>">
                <div class="w-[46px] h-[46px] flex-shrink-0">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/location.png" alt="Location" class="w-full h-full object-contain">
                </div>
                <div class="address-card-content flex flex-col gap-[10px]">
                    <p class="font-bold text-base text-secondary leading-[1.15]"><?php echo esc_html($addr['type']); ?></p>
                    <p class="font-bold text-base text-dark leading-[1.15]"><?php echo nl2br(esc_html($addr['address'])); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Контактная информация -->
        <div class="flex flex-col gap-5">
            <p class="contact-title font-bold text-[32px] text-dark leading-[1.15]" data-aos="fade-up" data-aos-delay="300">Контактная информация</p>
            
            <div class="contact-info-columns flex gap-[23px] flex-wrap">
                <!-- Левая колонка с телефонами -->
                <?php
                $phones = get_theme_option('contact_phones', array());
                if (!empty($phones)) :
                ?>
                <div class="contact-column contact-card bg-container-bg flex-1 min-w-[300px] rounded-[20px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-5 flex flex-col gap-5" data-aos="fade-right" data-aos-delay="350">
                    <?php foreach ($phones as $index => $phone) : ?>
                        <?php if ($index > 0) : ?>
                        <div class="contact-divider h-px bg-[rgba(0,0,0,0.05)] ml-[50px]"></div>
                        <?php endif; ?>
                        <div class="flex gap-[10px] items-start">
                            <div class="contact-icon-wrapper bg-container-bg p-2.5 rounded-[10px] w-10 h-10 flex items-center justify-center flex-shrink-0">
                                <div class="contact-icon w-5 h-5 relative">
                                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/phone-contact.png" alt="Phone" class="block max-w-none w-full h-full">
                                </div>
                            </div>
                            <div class="flex flex-col gap-[6px]">
                                <p class="contact-label font-semibold text-[14px] text-secondary leading-[1.15]"><?php echo esc_html($phone['label']); ?></p>
                                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone['number'])); ?>" class="contact-value font-bold text-base text-dark leading-[1.15] hover:text-primary transition-colors"><?php echo esc_html($phone['number']); ?></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Правая колонка с email и часами работы -->
                <div class="contact-column flex-1 min-w-[300px] flex flex-col gap-5" data-aos="fade-left" data-aos-delay="350">
                    <!-- Email -->
                    <?php
                    $email = get_theme_option('contact_email_main', get_company_email());
                    if ($email) :
                    ?>
                    <div class="contact-card bg-container-bg rounded-[20px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-5 flex items-center">
                        <div class="flex gap-[10px] items-start">
                            <div class="contact-icon-wrapper bg-container-bg p-2.5 rounded-[10px] w-10 h-10 flex items-center justify-center flex-shrink-0">
                                <div class="contact-icon w-5 h-5 relative">
                                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/majesticons_mail.png" alt="Email" class="block max-w-none w-full h-full">
                                </div>
                            </div>
                            <div class="flex flex-col gap-[6px]">
                                <p class="contact-label font-semibold text-[14px] text-secondary leading-[1.15]">Электронная почта</p>
                                <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-value font-bold text-base text-dark leading-[1.15] hover:text-primary transition-colors"><?php echo esc_html($email); ?></a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Часы работы -->
                    <?php
                    $office_hours = get_theme_option('office_hours', '');
                    $reception_hours = get_theme_option('reception_hours', '');
                    if ($office_hours || $reception_hours) :
                    ?>
                    <div class="contact-card bg-container-bg rounded-[20px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-5 flex flex-col gap-5">
                        <?php if ($office_hours) : ?>
                        <div class="flex gap-[10px] items-start">
                            <div class="contact-icon-wrapper bg-container-bg p-2.5 rounded-[10px] w-10 h-10 flex items-center justify-center flex-shrink-0">
                                <div class="contact-icon w-5 h-5 overflow-hidden relative">
                                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/clock.png" alt="Time" class="block max-w-none w-full h-full">
                                </div>
                            </div>
                            <div class="flex flex-col gap-[6px]">
                                <p class="contact-label font-semibold text-[14px] text-secondary leading-[1.15]">Часы работы офиса:</p>
                                <?php 
                                $hours_lines = explode("\n", $office_hours);
                                foreach ($hours_lines as $line) :
                                ?>
                                <p class="contact-value font-bold text-base text-dark leading-[1.15]"><?php echo esc_html(trim($line)); ?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($office_hours && $reception_hours) : ?>
                        <div class="contact-divider h-px bg-[rgba(0,0,0,0.05)] ml-[50px]"></div>
                        <?php endif; ?>
                        
                        <?php if ($reception_hours) : ?>
                        <div class="flex gap-[10px] items-start">
                            <div class="contact-icon-wrapper bg-container-bg p-2.5 rounded-[10px] w-10 h-10 flex items-center justify-center flex-shrink-0">
                                <div class="contact-icon w-5 h-5 overflow-hidden relative">
                                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/clock.png" alt="Time" class="block max-w-none w-full h-full">
                                </div>
                            </div>
                            <div class="flex flex-col gap-[6px]">
                                <p class="contact-label font-semibold text-[14px] text-secondary leading-[1.15]">Часы приема клиентов УЦ:</p>
                                <?php 
                                $reception_lines = explode("\n", $reception_hours);
                                foreach ($reception_lines as $line) :
                                ?>
                                <p class="contact-value font-bold text-base text-dark leading-[1.15]"><?php echo esc_html(trim($line)); ?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Проезд к офису -->
        <?php
        $route = get_theme_option('office_route', '');
        if ($route) :
            $route_parts = explode('|', $route);
        ?>
        <div class="flex flex-col gap-[10px] items-center" data-aos="fade-up" data-aos-delay="400">
            <p class="font-bold text-base text-dark leading-[1.15]">Проезд к офису «<?php echo esc_html(get_company_name()); ?>»</p>
            <div class="route-info-row flex gap-[10px] items-center flex-wrap justify-center">
                <?php foreach ($route_parts as $index => $part) : ?>
                    <?php if ($index > 0) : ?>
                    <div class="route-separator w-1 h-1 relative">
                        <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/schema.png" alt="" class="block max-w-none w-full h-full">
                    </div>
                    <?php endif; ?>
                    <p class="font-semibold text-base text-secondary leading-[1.15]"><?php echo esc_html(trim($part)); ?></p>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Внимание блок -->
        <?php
        $access_warning = get_theme_option('office_access_warning', '');
        if ($access_warning) :
        ?>
        <div class="attention-block rounded-[20px] px-5 py-4 flex flex-col gap-[10px] text-center bg-[rgba(55,93,116,0.05)]" data-aos="zoom-in" data-aos-delay="450">
            <p class="attention-title font-bold text-[20px] text-primary leading-[1.15]">Внимание!</p>
            <div class="attention-text font-semibold text-base text-dark leading-[1.15]">
                <?php echo wp_kses_post($access_warning); ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Подробная схема проезда -->
        <?php
        $route_file = get_field('office_route_file', 'option');
        if ($route_file) :
        ?>
        <div class="route-scheme-card bg-bg-main rounded-[20px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-5 w-full max-w-[390px] mx-auto" data-aos="fade-up" data-aos-delay="500">
            <a href="<?php echo esc_url($route_file['url']); ?>" download class="flex gap-[10px] items-center justify-center hover:opacity-80 transition-opacity no-underline">
                <div class="w-[46px] h-[46px] relative flex-shrink-0">
                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/schema.png" alt="Icon" class="block max-w-none w-full h-full">
                </div>
                <div class="flex-1 flex flex-col gap-[10px]">
                    <p class="font-bold text-base text-primary leading-[1.15]">Подробная схема проезда</p>
                    <p class="font-semibold text-base text-dark leading-[1.15]">Можно скачать и распечатать</p>
                </div>
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Задать вопрос с картой -->
<section class="w-full responsive-container pb-5">
    <div class="form-map-container bg-container-bg rounded-[20px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] overflow-hidden flex flex-col lg:flex-row" data-aos="fade-up" data-aos-delay="500">
        <!-- Левая часть - форма -->
        <div class="form-section flex-1 p-[30px] flex flex-col gap-5 items-center justify-center">
            <!-- Заголовок -->
            <div class="flex flex-col gap-[10px] items-center">
                <p class="form-title font-bold text-[32px] text-dark leading-[1.15]">Задать вопрос</p>
                <div class="form-underline bg-primary h-0.5 w-[120px] rounded-[9px]"></div>
            </div>

            <!-- Форма -->
            <form class="flex flex-col gap-[10px] w-full" id="contactForm">
                <input 
                    type="text" 
                    name="contact_name" 
                    placeholder="Ваше имя *" 
                    required
                    class="form-input bg-container-bg border border-[rgba(0,0,0,0.05)] rounded-[10px] p-[10px] h-[46px] flex items-center font-semibold text-base text-dark placeholder:text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors"
                />
                <input 
                    type="email" 
                    name="contact_email" 
                    placeholder="Ваш email *" 
                    required
                    class="form-input bg-container-bg border border-[rgba(0,0,0,0.05)] rounded-[10px] p-[10px] h-[46px] flex items-center font-semibold text-base text-dark placeholder:text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors"
                />
                <textarea 
                    name="contact_message" 
                    placeholder="Ваше сообщение" 
                    class="form-input form-textarea bg-container-bg border border-[rgba(0,0,0,0.05)] rounded-[10px] p-[10px] h-[188px] flex items-start font-semibold text-base text-dark placeholder:text-secondary leading-[1.15] focus:outline-none focus:border-primary transition-colors resize-none"
                ></textarea>
            
                <!-- Чекбокс -->
                <div class="flex gap-[10px] items-center w-full">
                    <input 
                        type="checkbox" 
                        id="agreeCheckbox" 
                        name="agree"
                        class="hidden"
                        checked
                    />
                    <label for="agreeCheckbox" class="checkbox-custom checked"></label>
                    <label for="agreeCheckbox" class="form-checkbox-text flex-1 font-semibold text-[14px] text-dark leading-[1.15] cursor-pointer">Я даю свое согласие на обработку и использование моих персональных данных</label>
                </div>

                <!-- Сообщения формы -->
                <div id="contactFormMessage" class="hidden"></div>

                <!-- Кнопка -->
                <button type="submit" class="form-button bg-primary rounded-[10px] px-[10px] py-[10px] h-[46px] w-[120px] flex items-center justify-center hover:opacity-90 transition-opacity">
                    <p class="font-bold text-base text-white leading-[1.15]">Отправить</p>
                </button>
            </form>
        </div>

        <!-- Правая часть - карта -->
        <?php
        $map_iframe = get_field('office_map_iframe', 'option');
        if ($map_iframe) :
        ?>
        <div class="map-section flex-1 h-[400px] lg:h-[535px] relative overflow-hidden">
            <div class="absolute inset-0 w-full h-full">
                <?php 
                // Добавляем классы к iframe если их нет
                if (strpos($map_iframe, 'class=') === false) {
                    $map_iframe = str_replace('<iframe', '<iframe class="w-full h-full"', $map_iframe);
                }
                // Убираем атрибуты width и height если они есть, заменяем на 100%
                $map_iframe = preg_replace('/width="[^"]*"/', 'width="100%"', $map_iframe);
                $map_iframe = preg_replace('/height="[^"]*"/', 'height="100%"', $map_iframe);
                echo $map_iframe; 
                ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php
get_footer();
