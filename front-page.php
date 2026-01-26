<?php
/**
 * The template for displaying the front page
 *
 * @package enotarynew
 */

get_header();

// Получаем все поля ACF
$hero_title_big_1 = get_field('hero_title_big_1') ?: 'ВСЁ';
$hero_title_small = get_field('hero_title_small') ?: 'для работы с';
$hero_title_big_2 = get_field('hero_title_big_2') ?: 'Электронной подписью';
$hero_image = get_field('hero_image') ?: get_template_directory_uri() . '/assets/images/banner.png';
$hero_description = get_field('hero_description') ?: 'УЦ e-Notary в партнерстве с рядом аккредитованных УЦ изготавливает и обслуживает сертификаты усиленной квалифицированной электронной подписи (УКЭП) для ЮЛ, ФЛ, ИП, для сотрудников ЮЛ и ИП, а также машиночитаемые доверенности (МЧД)';
$hero_info_text_1 = get_field('hero_info_text_1') ?: '';
$hero_info_text_2 = get_field('hero_info_text_2') ?: '';

$ukep_section_title = get_field('ukep_section_title') ?: 'Усиленная квалифицированная электронная подпись (УКЭП).<br class="hidden sm:block">Схемы получения';
$ukep_cards = get_field('ukep_cards') ?: array();

$mchd_title = get_field('mchd_title') ?: 'МЧД - машиночитаемая доверенность';
$mchd_description = get_field('mchd_description') ?: '';
$mchd_advantages_title = get_field('mchd_advantages_title') ?: 'Преимущества для клиентов:';
$mchd_requirements_title = get_field('mchd_requirements_title') ?: 'Для создания МЧД необходимо:';
$mchd_advantages_items = get_field('mchd_advantages_items') ?: '';
$mchd_requirements_items = get_field('mchd_requirements_items') ?: '';
$mchd_how_title = get_field('mchd_how_title') ?: 'Как работать с машиночитаемой доверенностью';
$mchd_how_text_1 = get_field('mchd_how_text_1') ?: '';
$mchd_how_text_2 = get_field('mchd_how_text_2') ?: '';

$unep_title = get_field('unep_title') ?: 'Усиленная неквалифицированная электронная подпись (УНЭП)';
$unep_paragraphs = get_field('unep_paragraphs') ?: '';
$unep_image = get_field('unep_image') ?: get_template_directory_uri() . '/figma-downloads/unep-illustration.png';
?>

        <!-- Hero секция с градиентным фоном -->
        <div class="hero-section-wrapper w-full overflow-hidden">
            <!-- Герой секция -->
<section class="w-full responsive-container py-[30px] lg:py-[60px] flex items-center justify-between">
                <div class="w-full max-w-[1440px] mx-auto flex flex-col lg:flex-row gap-8 sm:gap-10 lg:gap-6 items-center justify-between">
                    
                    <div class="flex flex-col items-start justify-center leading-[1.1] w-full lg:w-[42%] z-10" data-aos="fade-right" data-aos-duration="800">
                        <p class="font-extrabold text-[40px] sm:text-[50px] md:text-[60px] lg:text-[68px] xl:text-[80px] text-primary tracking-[-1px] sm:tracking-[-2px] leading-[1] mb-1 sm:mb-2">
                            <?php echo esc_html($hero_title_big_1); ?>
                        </p>
                        <p class="font-bold text-[18px] sm:text-[24px] md:text-[30px] lg:text-[34px] xl:text-[40px] text-secondary leading-[1.2] mb-1 sm:mb-2 ml-1">
                            <?php echo esc_html($hero_title_small); ?>
                        </p>
                        <p class="font-extrabold text-[32px] sm:text-[44px] md:text-[54px] lg:text-[60px] xl:text-[72px] text-primary tracking-[-1px] sm:tracking-[-2px] leading-[1]">
                            <?php echo esc_html($hero_title_big_2); ?>
                        </p>
                    </div>
                    
                    <div class="flex items-center justify-center lg:justify-end w-full lg:w-[58%] relative" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                        <img src="<?php echo esc_url($hero_image); ?>" 
                             alt="Экосистема электронной подписи" 
                             class="w-full h-auto object-contain max-w-[600px] lg:max-w-none transform lg:scale-105 origin-right">
                    </div>
                </div>
            </section>

            <!-- Описание и кнопки -->
            <section class="w-full responsive-container py-5 lg:py-6 flex flex-col gap-5 items-center justify-center">
                <p class="font-semibold text-sm md:text-base text-center text-[#262626] w-full max-w-[766px] leading-[1.3]" data-aos="fade-up" data-aos-delay="200"><?php echo wp_kses_post($hero_description); ?></p>
                <div class="flex flex-col sm:flex-row gap-3 md:gap-4 lg:gap-5 w-full max-w-[530px]">
                    <a href="<?php echo enotarynew_get_page_url_by_template('page-order-ukep.php'); ?>" class="bg-primary flex-1 h-[44px] sm:h-[46px] flex items-center justify-center rounded-[10px] px-3 py-2.5 hover:opacity-90 transition-opacity min-w-0 no-underline" data-aos="fade-right" data-aos-delay="300">
                        <p class="font-bold text-sm md:text-base text-white text-center leading-[1.15]">Заказать УКЭП	 </p>
                    </a>
                    <a href="<?php echo enotarynew_get_page_url_by_template('page-order-mchd.php'); ?>" class="bg-green-btn flex-1 h-[44px] sm:h-[46px] flex items-center justify-center rounded-[10px] px-3 py-2.5 hover:opacity-90 transition-opacity min-w-0 no-underline" data-aos="fade-up" data-aos-delay="400">
                        <p class="font-bold text-sm md:text-base text-white text-center leading-[1.15]">Заказать МЧД</p>
                    </a>
                    <a href="<?php echo enotarynew_get_page_url_by_template('page-order-unep.php'); ?>" class="bg-blue-btn flex-1 h-[44px] sm:h-[46px] flex items-center justify-center rounded-[10px] px-3 py-2.5 hover:opacity-90 transition-opacity min-w-0 no-underline" data-aos="fade-left" data-aos-delay="500">
                        <p class="font-bold text-sm md:text-base text-white text-center leading-[1.15]">Заказать УНЭП</p>
                    </a>
                </div>
            </section>

            <!-- Дополнительная информация -->
            <?php if ($hero_info_text_1 || $hero_info_text_2) : ?>
            <section class="w-full responsive-container py-5 pb-[40px] lg:pb-[50px] flex flex-col gap-5 items-center justify-center">
                <div class="font-semibold text-sm md:text-base text-center text-[#262626] leading-[1.3]" data-aos="fade-up" data-aos-delay="600">
                    <?php if ($hero_info_text_1) : ?>
                        <p class="opacity-60 w-full max-w-[806px] mb-5 mx-auto"><?php echo wp_kses_post($hero_info_text_1); ?></p>
                    <?php endif; ?>
                    <?php if ($hero_info_text_2) : ?>
                        <p class="opacity-60 w-full max-w-[766px] mx-auto"><?php echo wp_kses_post($hero_info_text_2); ?></p>
                    <?php endif; ?>
                </div>
            </section>
            <?php endif; ?>
        </div>

        <!-- УКЭП - схемы получения -->
        <section class="w-full responsive-container py-[30px] md:py-[40px] lg:py-[50px] flex flex-col gap-6 md:gap-8 lg:gap-10 items-center justify-center">
            <h2 class="font-bold text-[24px] sm:text-[32px] md:text-[40px] lg:text-[50px] text-center text-[#262626] tracking-[-1.5px] w-full max-w-[1364px] leading-[1.05]" data-aos="fade-up"><?php echo wp_kses_post($ukep_section_title); ?></h2>
            
            <?php if (!empty($ukep_cards)) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 lg:gap-5 w-full max-w-[1432px]">
                <?php 
                $delay = 100;
                foreach ($ukep_cards as $card) : 
                    $icon = $card['icon'] ?? '';
                    $title = $card['title'] ?? '';
                    $steps = $card['steps'] ?? array();
                ?>
                <!-- Карточка -->
                <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] lg:rounded-[20px] p-4 lg:p-5 flex flex-col gap-4 lg:gap-5 hover:shadow-lg transition-shadow" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                    <div class="flex gap-2.5 items-center">
                        <?php if ($icon) : ?>
                        <div class="w-[46px] h-[46px] flex-shrink-0">
                            <img src="<?php echo esc_url($icon); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-contain">
                        </div>
                        <?php endif; ?>
                        <p class="flex-1 font-bold text-sm lg:text-base text-[#262626] leading-[1.15]"><?php echo esc_html($title); ?></p>
                    </div>
                    <?php if (!empty($steps)) : ?>
                    <ol class="flex-1 font-semibold text-[13px] lg:text-[14px] text-[#262626] opacity-80 leading-[1.4] list-decimal pl-[21px]">
                        <?php foreach ($steps as $step) : 
                            $step_text = $step['text'] ?? '';
                            $step_link = $step['link'] ?? '';
                        ?>
                            <li>
                                <?php if ($step_link) : ?>
                                    <a href="<?php echo esc_url($step_link); ?>" class="hover:text-primary hover:underline transition-colors"><?php echo esc_html($step_text); ?></a>
                                <?php else : ?>
                                    <?php echo esc_html($step_text); ?>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                    <?php endif; ?>
                </div>
                <?php 
                $delay += 100;
                endforeach; 
                ?>
            </div>
            <?php endif; ?>

            <a href="<?php echo enotarynew_get_page_url_by_template('page-order-ukep.php'); ?>" class="bg-primary h-[44px] sm:h-[46px] w-full max-w-[240px] flex items-center justify-center rounded-[10px] px-3 py-2.5 hover:opacity-90 transition-opacity no-underline" data-aos="zoom-in" data-aos-delay="500">
                <p class="font-bold text-sm md:text-base text-white text-center leading-[1.15]">Заказать УКЭП </p>
            </a>
        </section>

        <!-- МЧД - машиночитаемая доверенность -->
        <div class="w-full">
            <section class="responsive-container py-[30px] md:py-[40px] lg:py-[50px] flex flex-col gap-6 md:gap-8 lg:gap-10 items-center justify-center">
            <div class="flex flex-col gap-4 lg:gap-5 items-center text-center text-[#262626]">
                <h2 class="font-bold text-[24px] sm:text-[32px] md:text-[40px] lg:text-[50px] tracking-[-1.5px] w-full max-w-[720px] leading-[1.05]" data-aos="fade-up"><?php echo esc_html($mchd_title); ?></h2>
                <?php if ($mchd_description) : ?>
                <p class="font-semibold text-sm md:text-base w-full max-w-[882px] leading-[1.3]" data-aos="fade-up" data-aos-delay="100"><?php echo wp_kses_post($mchd_description); ?></p>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-5 w-full max-w-[1432px]">
                <!-- Преимущества -->
                <div class="bg-white rounded-[15px] lg:rounded-[20px] p-4 lg:p-5 flex flex-col sm:flex-row gap-4 hover:shadow-lg transition-shadow" data-aos="fade-right" data-aos-delay="200">
                    <div class="w-10 h-10 relative flex-shrink-0">
                        <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/solar_info-square-bold-duotone.png" alt="Info icon" class="block max-w-none w-full h-full object-contain">
                    </div>
                    <div class="flex-1 flex flex-col gap-4 lg:gap-5">
                        <p class="font-bold text-[18px] md:text-[22px] lg:text-[26px] text-[#262626] leading-[1.15]"><?php echo esc_html($mchd_advantages_title); ?></p>
                        <?php 
                        $advantages = array_filter(explode("\n", $mchd_advantages_items));
                        if (!empty($advantages)) : 
                        ?>
                        <div class="flex flex-col gap-1.5 font-semibold text-sm md:text-base text-[#262626] leading-[1.3]">
                            <?php foreach ($advantages as $advantage) : ?>
                                <p><?php echo esc_html(trim($advantage)); ?></p>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Для создания МЧД -->
                <div class="bg-white rounded-[15px] lg:rounded-[20px] p-4 lg:p-5 flex flex-col sm:flex-row gap-4 hover:shadow-lg transition-shadow" data-aos="fade-left" data-aos-delay="200">
                    <div class="w-10 h-10 relative flex-shrink-0">
                        <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/solar_info-square-bold-duotone.png" alt="Info icon" class="block max-w-none w-full h-full object-contain">
                    </div>
                    <div class="flex-1 flex flex-col gap-4 lg:gap-5">
                        <p class="font-bold text-[18px] md:text-[22px] lg:text-[26px] text-[#262626] leading-[1.15]"><?php echo esc_html($mchd_requirements_title); ?></p>
                        <?php 
                        $requirements = array_filter(explode("\n", $mchd_requirements_items));
                        if (!empty($requirements)) : 
                        ?>
                        <div class="flex flex-col gap-1.5 font-semibold text-sm md:text-base text-[#262626] leading-[1.3]">
                            <?php foreach ($requirements as $requirement) : ?>
                                <p><?php echo esc_html(trim($requirement)); ?></p>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if ($mchd_how_title && ($mchd_how_text_1 || $mchd_how_text_2)) : ?>
            <div class="flex flex-col gap-[20px] lg:gap-[30px] items-center w-full max-w-[1100px]">
                <p class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-center text-[#262626] w-full leading-[1.15]" data-aos="fade-up" data-aos-delay="300"><?php echo esc_html($mchd_how_title); ?></p>
                <div class="flex flex-col gap-4 lg:gap-5 font-semibold text-sm md:text-base text-center text-[#262626]" data-aos="fade-up" data-aos-delay="400">
                    <?php if ($mchd_how_text_1) : ?>
                    <p class="leading-[1.3] w-full"><?php echo esc_html($mchd_how_text_1); ?></p>
                    <?php endif; ?>
                    <?php if ($mchd_how_text_2) : ?>
                    <p class="leading-[1.3] w-full"><?php echo esc_html($mchd_how_text_2); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <a href="<?php echo enotarynew_get_page_url_by_template('page-order-mchd.php'); ?>" class="bg-green-btn h-[44px] sm:h-[46px] w-full max-w-[240px] flex items-center justify-center rounded-[10px] px-3 py-2.5 hover:opacity-90 transition-opacity no-underline" data-aos="zoom-in" data-aos-delay="500">
                <p class="font-bold text-sm md:text-base text-white text-center leading-[1.15]">Заказать МЧД</p>
            </a>
        </section>
        </div>

        <!-- УНЭП -->
        <section class="w-full responsive-container py-[30px] md:py-[40px] lg:py-[50px] flex flex-col gap-6 md:gap-8 lg:gap-10 items-center justify-center">
            <h2 class="font-bold text-[24px] sm:text-[32px] md:text-[40px] lg:text-[50px] text-center text-[#262626] tracking-[-1.5px] w-full max-w-[918px] leading-[1.05]" data-aos="fade-up"><?php echo esc_html($unep_title); ?></h2>
            
            <div class="flex flex-col lg:flex-row gap-5 lg:gap-6 items-start w-full max-w-[1432px]">
                <?php 
                $paragraphs = array_filter(explode("\n", $unep_paragraphs));
                if (!empty($paragraphs)) : 
                ?>
                <div class="flex flex-col gap-4 lg:gap-5 font-bold text-sm md:text-base text-[#262626] leading-[1.15] w-full lg:flex-1" data-aos="fade-right" data-aos-delay="100">
                    <?php foreach ($paragraphs as $paragraph) : ?>
                        <p class="w-full"><?php echo wp_kses_post(trim($paragraph)); ?></p>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <div class="w-full lg:w-auto lg:flex-1 h-[280px] sm:h-[350px] md:h-[400px] lg:h-[450px] max-w-[700px] mx-auto lg:mx-0 overflow-hidden relative rounded-[15px] lg:rounded-[20px] xl:rounded-[30px]" data-aos="fade-left" data-aos-delay="100">
                    <div class="absolute bg-[rgba(55,93,116,0.15)] inset-0 rounded-[15px] lg:rounded-[20px] xl:rounded-[30px]"></div>
                    <div class="absolute inset-0 rounded-[15px] lg:rounded-[20px] overflow-hidden">
                        <img src="<?php echo esc_url($unep_image); ?>" alt="УНЭП illustration" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <a href="<?php echo enotarynew_get_page_url_by_template('page-order-unep.php'); ?>" class="bg-blue-btn h-[44px] sm:h-[46px] w-full max-w-[240px] flex items-center justify-center rounded-[10px] px-3 py-2.5 hover:opacity-90 transition-opacity no-underline" data-aos="zoom-in" data-aos-delay="200">
                <p class="font-bold text-sm md:text-base text-white text-center leading-[1.15]">Заказать УНЭП</p>
            </a>
        </section>

<?php
get_footer();
