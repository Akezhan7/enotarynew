<?php
/**
 * Template Name: ПО, токены и услуги
 * 
 * @package enotarynew
 */

get_header();

// Получаем данные из ACF
$intro_title = get_field('ps_intro_title') ?: 'ПО, токены и услуги для работы с электронной подписью';
$intro_text = get_field('ps_intro_text') ?: 'УЦ e-Notary входит в состав <span class="text-primary underline">АО «Сигнал-КОМ»</span>...';
$software_items = get_field('ps_software_section') ?: [];
$tokens_items = get_field('ps_tokens_section') ?: [];
$services_items = get_field('ps_services_section') ?: [];
?>

        <!-- Хлебные крошки -->
        <div class="w-full responsive-container pb-3 lg:pb-4">
            <div class="flex items-center gap-2 font-semibold text-sm text-secondary">
                <a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors">Главная</a>
                <span>/</span>
                <span class="text-dark">ПО&Токены&Услуги</span>
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
                <p class="page-hero-title"><?php echo esc_html($intro_title); ?></p>
            </div>
        </section>

        <!-- Главный контент -->
        <main class="w-full responsive-container">
            <!-- Вступительный текст -->
            <section class="flex flex-col gap-5 items-center text-center py-10">
                <div class="font-semibold text-base text-[#262626] leading-[1.15] max-w-full" data-aos="fade-up" data-aos-delay="100">
                    <?php echo wp_kses_post($intro_text); ?>
                </div>
            </section>

            <!-- Программное обеспечение -->
            <?php if ($software_items) : ?>
            <section id="csp" class="flex flex-col gap-5 py-5">
                <div class="flex items-center justify-between" data-aos="fade-right" data-aos-delay="150">
                    <h2 class="font-bold text-[24px] sm:text-[28px] md:text-[32px] text-[#262626] leading-[1.15]">Программное обеспечение</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <?php 
                    $modal_counter = 0;
                    foreach ($software_items as $index => $item) : 
                        $delay = 200 + ($index * 50);
                        $is_modal = ($item['link_type'] === 'modal');
                        $unique_id = 'software_modal_' . $index;
                    ?>
                    <?php if ($is_modal) : ?>
                    <div class="card-hover bg-white rounded-[30px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-2.5 flex gap-2.5 items-center cursor-pointer" data-aos="zoom-in" data-aos-delay="<?php echo $delay; ?>" data-modal-trigger="<?php echo $unique_id; ?>">
                    <?php else : ?>
                    <a href="<?php echo esc_url($item['external_url']); ?>" target="_blank" class="card-hover bg-white rounded-[30px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-2.5 flex gap-2.5 items-center cursor-pointer no-underline" data-aos="zoom-in" data-aos-delay="<?php echo $delay; ?>">
                    <?php endif; ?>
                        <div class="w-[68px] h-[100px] rounded-[20px] overflow-hidden flex-shrink-0">
                            <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col gap-2.5 flex-1 p-2.5">
                            <div class="flex items-center gap-2.5">
                                <h3 class="font-bold text-[18px] sm:text-[20px] text-[#262626] leading-[1.15]"><?php echo esc_html($item['title']); ?></h3>
                                <?php if ($item['show_info_icon']) : ?>
                                <div class="w-5 h-5 overflow-hidden flex-shrink-0">
                                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/solar_info-square-bold-duotone.png" alt="Info" class="w-full h-full object-contain">
                                </div>
                                <?php endif; ?>
                            </div>
                            <p class="font-semibold text-base text-[#262626] leading-[1.15] opacity-80"><?php echo esc_html($item['description']); ?></p>
                        </div>
                    <?php echo $is_modal ? '</div>' : '</a>'; ?>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <!-- Токены -->
            <?php if ($tokens_items) : ?>
            <section id="smarttoken" class="flex flex-col gap-5 py-5">
                <div class="flex items-center justify-between" data-aos="fade-right" data-aos-delay="300">
                    <h2 class="font-bold text-[24px] sm:text-[28px] md:text-[32px] text-[#262626] leading-[1.15]">Токены</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <?php foreach ($tokens_items as $index => $item) : 
                        $delay = 350 + ($index * 50);
                        $is_modal = ($item['link_type'] === 'modal');
                        $unique_id = 'tokens_modal_' . $index;
                    ?>
                    <?php if ($is_modal) : ?>
                    <div class="card-hover bg-white rounded-[30px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-2.5 flex gap-2.5 items-center cursor-pointer" data-aos="zoom-in" data-aos-delay="<?php echo $delay; ?>" data-modal-trigger="<?php echo $unique_id; ?>">
                    <?php else : ?>
                    <a href="<?php echo esc_url($item['external_url']); ?>" target="_blank" class="card-hover bg-white rounded-[30px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-2.5 flex gap-2.5 items-center cursor-pointer no-underline" data-aos="zoom-in" data-aos-delay="<?php echo $delay; ?>">
                    <?php endif; ?>
                        <div class="w-[100px] h-[100px] rounded-[20px] overflow-hidden flex-shrink-0">
                            <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col gap-2.5 flex-1 p-2.5">
                            <div class="flex items-center gap-2.5">
                                <h3 class="font-bold text-[18px] sm:text-[20px] text-[#262626] leading-[1.15]"><?php echo esc_html($item['title']); ?></h3>
                                <?php if ($item['show_info_icon']) : ?>
                                <div class="w-5 h-5 overflow-hidden flex-shrink-0">
                                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/solar_info-square-bold-duotone.png" alt="Info" class="w-full h-full object-contain">
                                </div>
                                <?php endif; ?>
                            </div>
                            <p class="font-semibold text-base text-[#262626] leading-[1.15] opacity-80 text-clamp-3"><?php echo esc_html($item['description']); ?></p>
                        </div>
                    <?php echo $is_modal ? '</div>' : '</a>'; ?>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <!-- Услуги -->
            <?php if ($services_items) : ?>
            <section class="flex flex-col gap-5 py-5">
                <div class="flex items-center justify-between" data-aos="fade-right" data-aos-delay="450">
                    <h2 class="font-bold text-[24px] sm:text-[28px] md:text-[32px] text-[#262626] leading-[1.15]">Услуги</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <?php foreach ($services_items as $index => $item) : 
                        $delay = 500 + ($index * 50);
                        $is_modal = ($item['link_type'] === 'modal');
                        $unique_id = 'services_modal_' . $index;
                    ?>
                    <?php if ($is_modal) : ?>
                    <div class="card-hover bg-white rounded-[30px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-2.5 flex gap-2.5 items-center cursor-pointer" data-aos="zoom-in" data-aos-delay="<?php echo $delay; ?>" data-modal-trigger="<?php echo $unique_id; ?>">
                    <?php else : ?>
                    <a href="<?php echo esc_url($item['external_url']); ?>" target="_blank" class="card-hover bg-white rounded-[30px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-2.5 flex gap-2.5 items-center cursor-pointer no-underline" data-aos="zoom-in" data-aos-delay="<?php echo $delay; ?>">
                    <?php endif; ?>
                        <div class="w-[80px] h-[80px] rounded-[20px] overflow-hidden flex-shrink-0 flex items-center justify-center">
                            <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>" class="w-full h-full object-contain">
                        </div>
                        <div class="flex flex-col gap-2.5 flex-1 p-2.5">
                            <div class="flex items-center gap-2.5">
                                <h3 class="font-bold text-[18px] sm:text-[20px] text-[#262626] leading-[1.15]"><?php echo esc_html($item['title']); ?></h3>
                                <?php if ($item['show_info_icon']) : ?>
                                <div class="w-5 h-5 overflow-hidden flex-shrink-0">
                                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/solar_info-square-bold-duotone.png" alt="Info" class="w-full h-full object-contain">
                                </div>
                                <?php endif; ?>
                            </div>
                            <p class="font-semibold text-base text-[#262626] leading-[1.15] opacity-80"><?php echo esc_html($item['description']); ?></p>
                        </div>
                    <?php echo $is_modal ? '</div>' : '</a>'; ?>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
        </main>

        <!-- Модальные окна -->
        <?php
        // Собираем все модальные окна
        $all_modals = [];
        
        if ($software_items) {
            foreach ($software_items as $index => $item) {
                if ($item['link_type'] === 'modal') {
                    $all_modals[] = [
                        'id' => 'software_modal_' . $index,
                        'title' => $item['title'],
                        'content' => $item['modal_content']
                    ];
                }
            }
        }
        
        if ($tokens_items) {
            foreach ($tokens_items as $index => $item) {
                if ($item['link_type'] === 'modal') {
                    $all_modals[] = [
                        'id' => 'tokens_modal_' . $index,
                        'title' => $item['title'],
                        'content' => $item['modal_content']
                    ];
                }
            }
        }
        
        if ($services_items) {
            foreach ($services_items as $index => $item) {
                if ($item['link_type'] === 'modal') {
                    $all_modals[] = [
                        'id' => 'services_modal_' . $index,
                        'title' => $item['title'],
                        'content' => $item['modal_content']
                    ];
                }
            }
        }
        
        // Выводим модальные окна
        foreach ($all_modals as $modal) :
        ?>
        <div class="certificate-help-modal" id="<?php echo esc_attr($modal['id']); ?>" data-modal-id="<?php echo esc_attr($modal['id']); ?>">
            <div class="modal-overlay"></div>
            <div class="modal-container">
                <div class="modal-content">
                    <!-- Кнопка закрытия -->
                    <button class="modal-close" aria-label="Закрыть">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    <!-- Заголовок -->
                    <div class="modal-header">
                        <div class="icon-wrapper">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h2 class="font-bold text-[20px] sm:text-[24px] text-[#262626] leading-[1.15] text-center"><?php echo esc_html($modal['title']); ?></h2>
                    </div>

                    <!-- Содержимое -->
                    <div class="modal-body">
                        <div class="instruction-content" style="padding: 20px 0;">
                            <?php echo wp_kses_post($modal['content']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- JavaScript для модальных окон -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Обработчики для открытия модальных окон
            document.querySelectorAll('[data-modal-trigger]').forEach(function(trigger) {
                trigger.addEventListener('click', function() {
                    const modalId = this.getAttribute('data-modal-trigger');
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.add('active');
                        document.body.style.overflow = 'hidden';
                    }
                });
            });
            
            // Обработчики для закрытия модальных окон
            document.querySelectorAll('.certificate-help-modal').forEach(function(modal) {
                const closeBtn = modal.querySelector('.modal-close');
                const overlay = modal.querySelector('.modal-overlay');
                
                if (closeBtn) {
                    closeBtn.addEventListener('click', function() {
                        modal.classList.remove('active');
                        document.body.style.overflow = '';
                    });
                }
                
                if (overlay) {
                    overlay.addEventListener('click', function() {
                        modal.classList.remove('active');
                        document.body.style.overflow = '';
                    });
                }
            });
            
            // Закрытие по Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.certificate-help-modal.active').forEach(function(modal) {
                        modal.classList.remove('active');
                        document.body.style.overflow = '';
                    });
                }
            });
        });
        </script>

<?php
get_footer();
