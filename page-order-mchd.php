<?php
/**
 * Template Name: Заказать МЧД
 * 
 * @package enotarynew
 */

get_header();

// Получаем СТАТИЧЕСКИЕ данные для кнопок типа плательщика
// Это НЕ товары WooCommerce, а элементы формы для выбора типа заказчика
$payer_types = get_payer_types_options();
?>

        <!-- Хлебные крошки -->
        <div class="w-full responsive-container pb-3 lg:pb-4">
            <div class="flex items-center gap-2 font-semibold text-sm text-secondary">
                <a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors">Главная</a>
                <span>/</span>
                <span class="text-dark">Заказать МЧД</span>
            </div>
        </div>

        <!-- Hero секция - Заказать МЧД -->
          <section class="page-hero-section responsive-container">
            <div class="page-hero-block" data-aos="fade-down">
                <!-- Декоративный вектор (позади текста) -->
                <div class="page-hero-vector">
                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/Vector 1.png" alt="" class="block max-w-none w-full h-full object-contain">
                </div>
                <!-- Заголовок поверх вектора -->
                <p class="page-hero-title">Заказать МЧД</p>
            </div>
        </section>

        <!-- Выбор типа лица -->
        <section class="w-full responsive-container py-6 sm:py-8 md:py-10 flex flex-col md:flex-row gap-3 sm:gap-4 md:gap-5 lg:gap-10" data-aos="fade-up" data-aos-delay="100">
            <!-- Юридическое Лицо -->
            <div class="entity-card border border-[rgba(0,0,0,0.05)] bg-white rounded-[15px] sm:rounded-[20px] p-4 sm:p-5 flex-1 flex flex-row items-center justify-center gap-2 sm:gap-2.5 cursor-pointer shadow-md hover:shadow-lg transition-shadow min-h-[60px] sm:min-h-[76px]">
                <input 
                    type="radio" 
                    name="payer_type" 
                    value="<?php echo esc_attr( $payer_types['legal']['value'] ); ?>" 
                    class="hidden"
                    data-base-price="<?php echo esc_attr( $payer_types['legal']['price'] ); ?>"
                >
                <p class="entity-card-label font-bold text-sm sm:text-base text-center leading-[1.15] whitespace-nowrap"><?php echo esc_html( $payer_types['legal']['label'] ); ?></p>
                <div class="entity-card-price-box rounded-[8px] sm:rounded-[10px] px-2 sm:px-2.5 py-2 sm:py-2.5 flex items-center justify-center">
                    <p class="entity-card-price-text font-bold text-sm sm:text-base text-center leading-[1.15] whitespace-nowrap"><?php echo esc_html( number_format( $payer_types['legal']['price'], 0, ',', ' ' ) ); ?> руб.</p>
                </div>
            </div>
            
            <!-- Физическое Лицо -->
            <div class="entity-card border border-[rgba(0,0,0,0.05)] bg-white rounded-[15px] sm:rounded-[20px] p-4 sm:p-5 flex-1 flex flex-row items-center justify-center gap-2 sm:gap-2.5 cursor-pointer shadow-md hover:shadow-lg transition-shadow min-h-[60px] sm:min-h-[76px]">
                <input 
                    type="radio" 
                    name="payer_type" 
                    value="<?php echo esc_attr( $payer_types['individual']['value'] ); ?>" 
                    class="hidden"
                    data-base-price="<?php echo esc_attr( $payer_types['individual']['price'] ); ?>"
                >
                <p class="entity-card-label font-bold text-sm sm:text-base text-center leading-[1.15] whitespace-nowrap"><?php echo esc_html( $payer_types['individual']['label'] ); ?></p>
                <div class="entity-card-price-box rounded-[8px] sm:rounded-[10px] px-2 sm:px-2.5 py-2 sm:py-2.5 flex items-center justify-center">
                    <p class="entity-card-price-text font-bold text-sm sm:text-base text-center leading-[1.15] whitespace-nowrap"><?php echo esc_html( number_format( $payer_types['individual']['price'], 0, ',', ' ' ) ); ?> руб.</p>
                </div>
            </div>
            
            <!-- ИП -->
            <div class="entity-card entity-card-active border border-[rgba(0,0,0,0.05)] bg-primary rounded-[15px] sm:rounded-[20px] p-4 sm:p-5 flex-1 flex flex-row items-center justify-center gap-2 sm:gap-2.5 cursor-pointer shadow-lg min-h-[60px] sm:min-h-[76px]">
                <input 
                    type="radio" 
                    name="payer_type" 
                    value="<?php echo esc_attr( $payer_types['entrepreneur']['value'] ); ?>" 
                    class="hidden"
                    checked
                    data-base-price="<?php echo esc_attr( $payer_types['entrepreneur']['price'] ); ?>"
                >
                <p class="entity-card-label font-bold text-sm sm:text-base text-center leading-[1.15] whitespace-nowrap"><?php echo esc_html( $payer_types['entrepreneur']['label'] ); ?></p>
                <div class="entity-card-price-box rounded-[8px] sm:rounded-[10px] px-2 sm:px-2.5 py-2 sm:py-2.5 flex items-center justify-center">
                    <p class="entity-card-price-text font-bold text-sm sm:text-base text-center leading-[1.15] whitespace-nowrap"><?php echo esc_html( number_format( $payer_types['entrepreneur']['price'], 0, ',', ' ' ) ); ?> руб.</p>
                </div>
            </div>
        </section>

        <!-- Формат -->
        <?php render_checklist_by_category( 'format', 'Формат', array(), false ); ?>

        <!-- Всего -->
        <section class="obhs w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5 mb-6 sm:mb-8 md:mb-10">
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Всего</h2>
            
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full flex flex-col">
                <div class="flex items-center justify-between gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)] w-full">
                    <p class="font-bold text-base sm:text-lg text-[#262626] leading-[1.15]">Всего</p>
                    <p class="font-bold text-base sm:text-lg text-[#262626] leading-[1.15] whitespace-nowrap flex-shrink-0 total-price">0₽</p>
                </div>
                <div class="flex items-center justify-end gap-2 sm:gap-2.5 p-4 sm:p-5 w-full">
                    <button type="button" class="submit-order-btn bg-primary rounded-[8px] sm:rounded-[10px] px-2.5 py-2.5 flex items-center justify-center h-[44px] sm:h-[46px] w-full sm:w-[200px] hover:opacity-90 transition-opacity cursor-pointer border-0">
                        <p class="font-bold text-sm sm:text-base text-center text-white leading-[1.15] m-0">Оформить заказ</p>
                    </button>
                </div>
            </div>
        </section>

<?php
// Кнопка помощи в подборе сертификата (ТЗ п.230)
if ( function_exists( 'enotary_certificate_help_button_html' ) ) {
    enotary_certificate_help_button_html( 'Заказ МЧД' );
}

get_footer();
?>

