<?php
/**
 * Template Name: Заказать УКЭП
 * 
 * @package enotarynew
 */

get_header();

// Получаем данные товаров для кнопок типа плательщика (только если WooCommerce активен)
$ukep_ul = array( 'id' => 0, 'name' => 'Юридическое Лицо', 'price' => 3000 );
$ukep_fl = array( 'id' => 0, 'name' => 'Физическое Лицо', 'price' => 2000 );
$ukep_ip = array( 'id' => 0, 'name' => 'ИП', 'price' => 2000 );

if ( function_exists( 'get_product_data_by_sku' ) ) {
    $ukep_ul_data = get_product_data_by_sku( 'ukep_cert_ul' );
    $ukep_fl_data = get_product_data_by_sku( 'ukep_cert_fl' );
    $ukep_ip_data = get_product_data_by_sku( 'ukep_cert_ip' );
    
    if ( $ukep_ul_data ) {
        $ukep_ul = $ukep_ul_data;
    }
    if ( $ukep_fl_data ) {
        $ukep_fl = $ukep_fl_data;
    }
    if ( $ukep_ip_data ) {
        $ukep_ip = $ukep_ip_data;
    }
}
?>

        <!-- Хлебные крошки -->
        <div class="w-full responsive-container pb-3 lg:pb-4">
            <div class="flex items-center gap-2 font-semibold text-sm text-secondary">
                <a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors">Главная</a>
                <span>/</span>
                <span class="text-dark">Заказать УКЭП</span>
            </div>
        </div>

        <!-- Hero секция - Заказать УКЭП -->
        <!-- Заголовок блока с фоном -->
        <section class="page-hero-section responsive-container">
            <div class="page-hero-block" data-aos="fade-down">
                <!-- Декоративный вектор (позади текста) -->
                <div class="page-hero-vector">
                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/Vector 1.png" alt="" class="block max-w-none w-full h-full object-contain">
                </div>
                <!-- Заголовок поверх вектора -->
                <p class="page-hero-title">Заказать УКЭП</p>
            </div>
        </section>

        <!-- Выбор типа лица -->
        <section class="w-full responsive-container py-6 sm:py-8 md:py-10 flex flex-col md:flex-row gap-3 sm:gap-4 md:gap-5 lg:gap-10" data-aos="fade-up" data-aos-delay="100">
            <!-- Юридическое лицо -->
            <div class="entity-card border border-[rgba(0,0,0,0.05)] bg-white rounded-[15px] sm:rounded-[20px] p-4 sm:p-5 flex-1 flex flex-row items-center justify-center gap-2 sm:gap-2.5 cursor-pointer shadow-md hover:shadow-lg transition-shadow min-h-[60px] sm:min-h-[76px]">
                <input 
                    type="radio" 
                    name="payer_type" 
                    value="ul" 
                    class="hidden"
                    data-base-price="<?php echo esc_attr( $ukep_ul['price'] ); ?>"
                    data-base-id="<?php echo esc_attr( $ukep_ul['id'] ); ?>"
                >
                <p class="font-bold text-sm sm:text-base text-center text-[#262626] leading-[1.15] whitespace-nowrap"><?php echo esc_html( $ukep_ul['name'] ); ?></p>
                <div class="bg-secondary rounded-[8px] sm:rounded-[10px] px-2 sm:px-2.5 py-2 sm:py-2.5 flex items-center justify-center">
                    <p class="font-bold text-sm sm:text-base text-center text-white leading-[1.15] whitespace-nowrap"><?php echo esc_html( number_format( $ukep_ul['price'], 0, ',', ' ' ) ); ?> руб.</p>
                </div>
            </div>
            
            <!-- Физическое лицо -->
            <div class="entity-card border border-[rgba(0,0,0,0.05)] bg-white rounded-[15px] sm:rounded-[20px] p-4 sm:p-5 flex-1 flex flex-row items-center justify-center gap-2 sm:gap-2.5 cursor-pointer shadow-md hover:shadow-lg transition-shadow min-h-[60px] sm:min-h-[76px]">
                <input 
                    type="radio" 
                    name="payer_type" 
                    value="fl" 
                    class="hidden"
                    data-base-price="<?php echo esc_attr( $ukep_fl['price'] ); ?>"
                    data-base-id="<?php echo esc_attr( $ukep_fl['id'] ); ?>"
                >
                <p class="font-bold text-sm sm:text-base text-center text-[#262626] leading-[1.15] whitespace-nowrap"><?php echo esc_html( $ukep_fl['name'] ); ?></p>
                <div class="bg-secondary rounded-[8px] sm:rounded-[10px] px-2 sm:px-2.5 py-2 sm:py-2.5 flex items-center justify-center">
                    <p class="font-bold text-sm sm:text-base text-center text-white leading-[1.15] whitespace-nowrap"><?php echo esc_html( number_format( $ukep_fl['price'], 0, ',', ' ' ) ); ?> руб.</p>
                </div>
            </div>
            
            <!-- Индивидуальный предприниматель -->
            <div class="entity-card entity-card-active border border-[rgba(0,0,0,0.05)] bg-primary rounded-[15px] sm:rounded-[20px] p-4 sm:p-5 flex-1 flex flex-row items-center justify-center gap-2 sm:gap-2.5 cursor-pointer shadow-lg min-h-[60px] sm:min-h-[76px]">
                <input 
                    type="radio" 
                    name="payer_type" 
                    value="ip" 
                    class="hidden"
                    checked
                    data-base-price="<?php echo esc_attr( $ukep_ip['price'] ); ?>"
                    data-base-id="<?php echo esc_attr( $ukep_ip['id'] ); ?>"
                >
                <p class="font-bold text-sm sm:text-base text-center text-white leading-[1.15] whitespace-nowrap"><?php echo esc_html( $ukep_ip['name'] ); ?></p>
                <div class="bg-white rounded-[8px] sm:rounded-[10px] px-2 sm:px-2.5 py-2 sm:py-2.5 flex items-center justify-center">
                    <p class="font-bold text-sm sm:text-base text-center text-[#262626] leading-[1.15] whitespace-nowrap"><?php echo esc_html( number_format( $ukep_ip['price'], 0, ',', ' ' ) ); ?> руб.</p>
                </div>
            </div>
        </section>

        <!-- Квалифицированные сертификаты -->
        <section class="w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5">
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Квалифицированные сертификаты:</h2>
            
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full">
                <?php 
                if ( function_exists( 'render_checklist_by_category' ) ) {
                    render_checklist_by_category( 'kvalificzirovannye-sertifikaty' );
                } else {
                    echo '<!-- WooCommerce функции не загружены -->';
                }
                ?>
            </div>
        </section>

        <!-- Платные расширения для сертификатов -->
        <section class="w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5">
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Платные расширения для сертификатов:</h2>
            
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full">
                <?php 
                if ( function_exists( 'render_checklist_by_category' ) ) {
                    render_checklist_by_category( 'platnye-rasshireniya-dlya-sertifikatov' );
                } else {
                    echo '<!-- WooCommerce функции не загружены -->';
                }
                ?>
            </div>
        </section>

        <!-- Машиночитаемая доверенность -->
        <section class="w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5">
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Машиночитаемая доверенность</h2>
            
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full">
                <?php 
                if ( function_exists( 'render_checklist_by_category' ) ) {
                    render_checklist_by_category( 'mashinochitaemaya-doverennost' );
                } else {
                    echo '<!-- WooCommerce функции не загружены -->';
                }
                ?>
            </div>
        </section>

        <!-- Криптопровайдеры -->
        <section class="w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5">
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Криптопровайдеры</h2>
            
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full">
                <?php 
                if ( function_exists( 'render_checklist_by_category' ) ) {
                    render_checklist_by_category( 'kriptoprovajdery' );
                } else {
                    echo '<!-- WooCommerce функции не загружены -->';
                }
                ?>
            </div>
        </section>

        <!-- Носители ключей (Токен) -->
        <section class="w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5">
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Носители ключей (Токен)</h2>
            
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full">
                <?php 
                if ( function_exists( 'render_checklist_by_category' ) ) {
                    render_checklist_by_category( 'nositeli-klyuchej-token' );
                } else {
                    echo '<!-- WooCommerce функции не загружены -->';
                }
                ?>
            </div>
        </section>

        <!-- Дополнительные услуги -->
        <section class="w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5">
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Дополнительные услуги</h2>
            
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full">
                <?php 
                if ( function_exists( 'render_checklist_by_category' ) ) {
                    render_checklist_by_category( 'dopolnitelnye-uslugi' );
                } else {
                    echo '<!-- WooCommerce функции не загружены -->';
                }
                ?>
            </div>
        </section>

        <!-- Всего -->
        <section class="obhs w-full responsive-container py-4 sm:py-5 flex flex-col gap-4 sm:gap-5 mb-6 sm:mb-8 md:mb-10">
            <h2 class="font-bold text-[20px] sm:text-[24px] md:text-[28px] lg:text-[32px] text-[#262626] leading-[1.15]">Всего</h2>
            
            <div class="bg-white border border-[rgba(0,0,0,0.05)] rounded-[15px] sm:rounded-[20px] overflow-hidden w-full flex flex-col">
                <div class="flex items-center justify-between gap-2 sm:gap-2.5 p-4 sm:p-5 border-b border-[rgba(0,0,0,0.05)] w-full">
                    <p class="font-bold text-base sm:text-lg text-[#262626] leading-[1.15]">Всего</p>
                    <p class="font-bold text-base sm:text-lg text-[#262626] leading-[1.15] whitespace-nowrap flex-shrink-0 total-price">0₽</p>
                </div>
                <div class="flex items-center justify-end gap-2 sm:gap-2.5 p-4 sm:p-5 w-full">
                    <button type="button" class="submit-order-btn bg-primary rounded-[8px] sm:rounded-[10px] px-2.5 py-2.5 flex items-center justify-center h-[44px] sm:h-[46px] w-full sm:w-[160px] hover:opacity-90 transition-opacity cursor-pointer border-0">
                        <p class="font-bold text-sm sm:text-base text-center text-white leading-[1.15] m-0">Дальше</p>
                    </button>
                </div>
            </div>
        </section>

<?php
get_footer();
?>

