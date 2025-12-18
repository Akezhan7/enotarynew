<?php
/**
 * Template Name: Документы
 * 
 * @package enotarynew
 */

get_header();

// Получаем документы из ACF
$documents = get_field('documents_list');
?>

        <!-- Хлебные крошки -->
        <div class="w-full responsive-container pb-3 lg:pb-4">
            <div class="flex items-center gap-2 font-semibold text-sm text-secondary">
                <a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors">Главная</a>
                <span>/</span>
                <span class="text-dark">Документы</span>
            </div>
        </div>

        <!-- Hero секция - Документы -->
        <section class="page-hero-section responsive-container">
            <div class="page-hero-block" data-aos="fade-down">
                <!-- Декоративный вектор (позади текста) -->
                <div class="page-hero-vector">
                    <img src="<?php echo get_template_directory_uri(); ?>/figma-downloads/Vector 1.png" alt="" class="block max-w-none w-full h-full object-contain">
                </div>
                <!-- Заголовок поверх вектора -->
                <p class="page-hero-title">Документы</p>
            </div>
        </section>

        <!-- Документы секция -->
        <section class="w-full documents-container py-4 sm:py-5">
            <div class="documents-grid">
                <?php 
                if (!empty($documents)) :
                    $delay = 50;
                    foreach ($documents as $index => $doc) :
                        $icon = $doc['icon'] ?? get_template_directory_uri() . '/assets/images/pdf.png';
                        $subtitle = $doc['subtitle'] ?? '';
                        $title = $doc['title'] ?? '';
                        $doc_type = $doc['document_type'] ?? 'single';
                        $single_file = $doc['single_file'] ?? null;
                        $files = $doc['files'] ?? array();
                        
                        // Определяем действие при клике
                        if ($doc_type === 'single' && $single_file) {
                            $click_action = 'onclick="event.stopPropagation(); window.open(\'' . esc_url($single_file['url']) . '\', \'_blank\'); return false;"';
                            $data_type = 'data-doc-type="single"';
                        } elseif ($doc_type === 'multiple' && !empty($files)) {
                            $click_action = 'onclick="event.stopPropagation(); openModal(' . $index . '); return false;"';
                            $data_type = 'data-doc-type="multiple"';
                        } else {
                            $click_action = '';
                            $data_type = '';
                        }
                ?>
                <!-- Документ -->
                <div class="document-card bg-white rounded-[15px] lg:rounded-[20px] shadow-[0px_0px_15px_0px_rgba(161,161,161,0.1)] p-4 lg:p-5 flex flex-col gap-4 lg:gap-5 justify-between min-h-[170px] sm:min-h-[180px] lg:min-h-[191px] hover:shadow-lg transition-shadow cursor-pointer" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>" <?php echo $data_type; ?> <?php echo $click_action; ?>>
                    <div class="w-[46px] h-[46px] flex-shrink-0">
                        <img src="<?php echo esc_url($icon); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col gap-[6px] leading-[1.15]">
                        <?php if ($subtitle) : ?>
                        <p class="font-semibold text-[13px] lg:text-[14px] text-secondary"><?php echo esc_html($subtitle); ?></p>
                        <?php endif; ?>
                        <p class="font-bold text-[18px] lg:text-[20px] text-dark"><?php echo esc_html($title); ?></p>
                    </div>
                </div>
                <?php 
                    $delay += 50;
                    endforeach;
                endif;
                ?>
            </div>
        </section>

        <!-- Модальное окно -->
        <div class="modal-overlay" id="documentModal">
            <div class="modal-content bg-white flex flex-col rounded-[20px] overflow-hidden w-full max-w-[494px] mx-4">
                <!-- Шапка модалки -->
                <div class="border-b border-[rgba(0,0,0,0.05)] flex gap-2.5 items-start p-5">
                    <div class="flex flex-col gap-4 flex-1 text-dark leading-[1.15]">
                        <p class="font-bold text-[20px]">Документы</p>
                        <p class="font-semibold text-[14px]" id="modalDocumentTitle"></p>
                    </div>
                    <button class="bg-[rgba(0,0,0,0.05)] p-2.5 rounded-[10px] flex items-center justify-center flex-shrink-0 hover:bg-[rgba(0,0,0,0.1)] transition-colors" onclick="closeModal()" aria-label="Закрыть">
                        <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 4L4 12M4 4L12 12" stroke="#262626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
                
                <!-- Контент модалки -->
                <div class="flex flex-col gap-2.5 p-5" id="modalFilesContainer">
                    <!-- Динамически заполняется из JS -->
                </div>
            </div>
        </div>

        <script>
        // Данные документов для модального окна
        const documentsData = <?php echo json_encode($documents ?: array()); ?>;
        
        function openModal(index) {
            const doc = documentsData[index];
            if (!doc || doc.document_type !== 'multiple' || !doc.files || doc.files.length === 0) {
                return;
            }
            
            // Устанавливаем заголовок
            document.getElementById('modalDocumentTitle').textContent = doc.title || '';
            
            // Очищаем контейнер
            const container = document.getElementById('modalFilesContainer');
            container.innerHTML = '';
            
            // Добавляем карточки файлов
            doc.files.forEach(file => {
                const card = document.createElement('a');
                card.href = file.file.url;
                card.target = '_blank';
                card.className = 'bg-white border border-[rgba(0,0,0,0.05)] rounded-[20px] p-5 flex flex-col gap-5 justify-between min-h-[190px] hover:shadow-lg transition-shadow cursor-pointer no-underline';
                
                card.innerHTML = `
                    <div class="w-[46px] h-[46px] flex-shrink-0">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/docs.png" alt="Документ" class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col gap-2.5 leading-[1.15]">
                        <p class="font-bold text-base text-dark text-center">${file.title || ''}</p>
                        ${file.description ? `<p class="font-semibold text-[14px] text-secondary">${file.description}</p>` : ''}
                    </div>
                `;
                
                container.appendChild(card);
            });
            
            // Показываем модалку
            document.getElementById('documentModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeModal() {
            document.getElementById('documentModal').classList.remove('active');
            document.body.style.overflow = '';
        }
        
        // Закрытие по клику на overlay
        document.getElementById('documentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        // Закрытие по ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
        </script>

<?php
get_footer();
?>