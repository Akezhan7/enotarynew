<?php
/**
 * The header for our theme
 *
 * @package enotarynew
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Open Sans', 'sans-serif'],
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
        }
    </script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-[#fafafa] font-sans'); ?>>
<?php wp_body_open(); ?>
    <div class="flex flex-col items-center relative w-full">
        <!-- Меню -->
        <header class="backdrop-blur-[10px] backdrop-filter w-full">
            <div class="responsive-container">
                <!-- Верхняя часть -->
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 lg:gap-5 items-start sm:items-center py-4 lg:py-5 border-b border-transparent flex-wrap">
                    <p class="flex-1 font-semibold text-xs sm:text-sm lg:text-base text-secondary leading-[1.15] min-w-[200px]">Сигнал-КОМ	e-Notary Удостоверяющий Центр </p>
                    <a href="https://t.me/SmartTokenPro1" target="_blank" rel="noopener noreferrer" class="hidden lg:flex gap-2 items-center flex-shrink-0 hover:opacity-70 transition-opacity no-underline">
                        <div class="w-5 h-[18px] overflow-hidden relative flex-shrink-0">
                            <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/mingcute_telegram-fill.png" alt="Telegram" class="block max-w-none w-full h-full object-contain">
                        </div>
                        <p class="font-semibold text-xs sm:text-sm lg:text-base text-secondary leading-[1.15] whitespace-nowrap">@SmartTokenPro1 </p>
                    </a>
                    <a href="tel:+74953633093" class="hidden lg:flex gap-2 items-center flex-shrink-0 hover:opacity-70 transition-opacity no-underline">
                        <div class="w-[18px] h-[18px] relative flex-shrink-0">
                            <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/basil_phone-solid.png" alt="Phone" class="block max-w-none w-full h-full object-contain">
                        </div>
                        <p class="font-semibold text-xs sm:text-sm lg:text-base text-secondary leading-[1.15] whitespace-nowrap">+7 (495) 363-30-93</p>
                    </a>
                </div>
                
                <!-- Нижняя часть -->
               <div class="flex gap-3 md:gap-5 items-center pb-4 lg:pb-5 relative">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="h-[40px] sm:h-[44px] lg:h-[46px] w-[135px] sm:w-[150px] lg:w-[165px] relative flex-shrink-0 hover:opacity-80 transition-opacity">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo1.svg" alt="Logo" class="w-full h-full object-contain">
                </a>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="h-[40px] sm:h-[44px] lg:h-[46px] w-[95px] sm:w-[105px] lg:w-[116px] relative flex-shrink-0 hover:opacity-80 transition-opacity">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo2.svg" alt="Logo 2" class="w-full h-full object-contain">
                </a>
                <!-- Мобильная кнопка меню -->
                <button class="mobile-menu-button ml-auto lg:hidden p-2 -mr-2" id="menuToggle" aria-label="Открыть меню">
                    <div class="hamburger" id="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
                <!-- Десктопное меню -->
                <div class="desktop-nav hidden lg:flex flex-1 gap-5 xl:gap-7 items-center justify-end">
                    <nav class="flex gap-5 xl:gap-7 items-center">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'menu-1',
                                'menu_class'     => '',
                                'container'      => false,
                                'fallback_cb'    => '__return_false',
                                'items_wrap'     => '<ul class="flex gap-5 xl:gap-7 items-center list-none m-0 p-0">%3$s</ul>',
                                'link_before'    => '',
                                'link_after'     => '',
                                'walker'         => new class extends Walker_Nav_Menu {
                                    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
                                        $classes = empty($item->classes) ? array() : (array) $item->classes;
                                        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
                                        
                                        $output .= '<li class="' . esc_attr($class_names) . '">';
                                        
                                        $atts = array();
                                        $atts['href'] = !empty($item->url) ? $item->url : '';
                                        $atts['class'] = 'font-bold text-sm xl:text-base text-[#262626] leading-[1.15] whitespace-nowrap hover:text-primary transition-colors no-underline';
                                        
                                        $attributes = '';
                                        foreach ($atts as $attr => $value) {
                                            if (!empty($value)) {
                                                $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
                                            }
                                        }
                                        
                                        $output .= '<a' . $attributes . '>';
                                        $output .= apply_filters('the_title', $item->title, $item->ID);
                                        $output .= '</a>';
                                    }
                                    
                                    function end_el(&$output, $item, $depth = 0, $args = null) {
                                        $output .= "</li>\n";
                                    }
                                },
                            )
                        );
                        ?>
                    </nav>
                </div>
            </div>
            </div>
        </header>

        <!-- Полноэкранное мобильное меню -->
        <div class="mobile-menu" id="mobileMenu">
            <!-- Кнопка закрытия -->
            <button class="mobile-menu-close" id="menuClose" aria-label="Закрыть меню">
                <div class="hamburger active">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
            
            <?php
            // Мобильное меню
            wp_nav_menu(
                array(
                    'theme_location' => 'menu-1',
                    'menu_class'     => '',
                    'container'      => false,
                    'fallback_cb'    => '__return_false',
                    'items_wrap'     => '%3$s',
                    'walker'         => new class extends Walker_Nav_Menu {
                        function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
                            $output .= '<div class="menu-item">';
                            $output .= '<a href="' . esc_url($item->url) . '" class="menu-item-link" onclick="closeMobileMenu()">';
                            $output .= '<p>' . esc_html($item->title) . '</p>';
                            $output .= '</a>';
                            $output .= '</div>';
                        }
                        
                        function end_el(&$output, $item, $depth = 0, $args = null) {
                            // Ничего не добавляем, всё уже в start_el
                        }
                    },
                )
            );
            ?>
            
            <!-- Контактная информация в меню -->
            <div class="menu-item mt-10">
                <div class="flex flex-col gap-4 items-center">
                    <a href="https://t.me/SmartTokenPro1" target="_blank" rel="noopener noreferrer" class="flex gap-2 items-center hover:opacity-70 transition-opacity no-underline">
                        <div class="w-5 h-[18px] overflow-hidden relative flex-shrink-0">
                            <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/mingcute_telegram-fill.png" alt="Telegram" class="block max-w-none w-full h-full object-contain">
                        </div>
                        <p class="font-semibold text-base text-secondary leading-[1.15]">@SmartTokenPro1</p>
                    </a>
                    <a href="tel:+74953633093" class="flex gap-2 items-center hover:opacity-70 transition-opacity no-underline">
                        <div class="w-[18px] h-[18px] relative flex-shrink-0">
                            <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/basil_phone-solid.png" alt="Phone" class="block max-w-none w-full h-full object-contain">
                        </div>
                        <p class="font-semibold text-base text-secondary leading-[1.15]">+7 (495) 363-30-93</p>
                    </a>
                </div>
            </div>
        </div>
