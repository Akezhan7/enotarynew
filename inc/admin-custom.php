<?php
/**
 * Кастомизация админ-панели WooCommerce
 * 
 * Настройка таблицы заказов и дополнительных полей согласно ТЗ (пункты 210-213)
 * 
 * @package enotarynew
 */

// Запретить прямой доступ
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ============================================
 * ЗАДАЧА 1: Мета-бокс "Срок действия сертификата"
 * ============================================
 */

/**
 * Добавить мета-бокс в редактирование заказа
 */
add_action( 'add_meta_boxes', 'enotary_add_certificate_meta_box' );

function enotary_add_certificate_meta_box() {
    // Подключить медиа-загрузчик WordPress
    wp_enqueue_media();
    
    // Поддержка старой системы (CPT)
    add_meta_box(
        'enotary_certificate_data',
        'Данные сертификата',
        'enotary_certificate_meta_box_callback',
        'shop_order',
        'side',
        'default'
    );
    
    // Поддержка новой системы HPOS
    add_meta_box(
        'enotary_certificate_data',
        'Данные сертификата',
        'enotary_certificate_meta_box_callback',
        'woocommerce_page_wc-orders',
        'side',
        'default'
    );
}

/**
 * Вывод содержимого мета-бокса
 */
function enotary_certificate_meta_box_callback( $post_or_order_object ) {
    // Определяем, это пост или объект заказа HPOS
    $order = ( $post_or_order_object instanceof WP_Post ) 
        ? wc_get_order( $post_or_order_object->ID ) 
        : $post_or_order_object;
    
    if ( ! $order ) {
        return;
    }
    
    $order_id = $order->get_id();
    
    // Получить текущие значения
    $certificate_expiry = $order->get_meta( '_certificate_expiry_date', true );
    $certificate_file_id = $order->get_meta( '_certificate_file_id', true );
    
    // Получить URL файла если он есть
    $file_url = '';
    $file_name = '';
    if ( $certificate_file_id ) {
        $file_url = wp_get_attachment_url( $certificate_file_id );
        $file_name = basename( $file_url );
    }
    
    // Nonce для безопасности
    wp_nonce_field( 'enotary_certificate_meta_box', 'enotary_certificate_meta_box_nonce' );
    
    ?>
    <p>
        <label for="certificate_expiry_date" style="display: block; margin-bottom: 5px; font-weight: 600;">
            Срок действия сертификата:
        </label>
        <input 
            type="date" 
            id="certificate_expiry_date" 
            name="certificate_expiry_date" 
            value="<?php echo esc_attr( $certificate_expiry ); ?>" 
            style="width: 100%;"
        />
    </p>
    <p class="description" style="margin-top: -5px; margin-bottom: 15px;">
        Укажите дату окончания действия сертификата клиента.
    </p>
    
    <p>
        <label for="certificate_file_id" style="display: block; margin-bottom: 5px; font-weight: 600;">
            Файл сертификата:
        </label>
        <input 
            type="hidden" 
            id="certificate_file_id" 
            name="certificate_file_id" 
            value="<?php echo esc_attr( $certificate_file_id ); ?>"
        />
        <button type="button" class="button" id="upload_certificate_button">
            <?php echo $certificate_file_id ? 'Изменить файл' : 'Загрузить файл'; ?>
        </button>
        <button type="button" class="button" id="remove_certificate_button" style="<?php echo $certificate_file_id ? '' : 'display:none;'; ?>">
            Удалить
        </button>
    </p>
    
    <div id="certificate_file_preview" style="margin-top: 10px; <?php echo $certificate_file_id ? '' : 'display:none;'; ?>">
        <p style="margin: 0; padding: 8px; background: #f0f0f1; border-radius: 3px;">
            <strong>Прикреплен:</strong><br>
            <a href="<?php echo esc_url( $file_url ); ?>" target="_blank" style="text-decoration: none;">
                📄 <?php echo esc_html( $file_name ); ?>
            </a>
        </p>
    </div>
    
    <hr style="margin: 20px 0;">
    
    <p>
        <label for="software_license_key" style="display: block; margin-bottom: 5px; font-weight: 600;">
            Лицензионный ключ (для ПО):
        </label>
        <?php
        $license_key = $order->get_meta( '_software_license_key', true );
        ?>
        <textarea 
            id="software_license_key" 
            name="software_license_key" 
            rows="4" 
            style="width: 100%; font-family: monospace;"
            placeholder="Введите лицензионные ключи (если применимо)"
        ><?php echo esc_textarea( $license_key ); ?></textarea>
    </p>
    <p class="description" style="margin-top: -5px;">
        Укажите лицензионные ключи для программного обеспечения (КриптоПро, Signal-COM и т.д.). Клиент увидит эти ключи в личном кабинете.
    </p>
    
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        var fileFrame;
        var fileIdInput = $('#certificate_file_id');
        var uploadButton = $('#upload_certificate_button');
        var removeButton = $('#remove_certificate_button');
        var previewDiv = $('#certificate_file_preview');
        
        // Открыть медиа-загрузчик
        uploadButton.on('click', function(e) {
            e.preventDefault();
            
            if (fileFrame) {
                fileFrame.open();
                return;
            }
            
            fileFrame = wp.media({
                title: 'Выберите файл сертификата',
                button: {
                    text: 'Использовать этот файл'
                },
                multiple: false
            });
            
            fileFrame.on('select', function() {
                var attachment = fileFrame.state().get('selection').first().toJSON();
                fileIdInput.val(attachment.id);
                
                // Обновить превью
                previewDiv.html(
                    '<p style="margin: 0; padding: 8px; background: #f0f0f1; border-radius: 3px;">' +
                    '<strong>Прикреплен:</strong><br>' +
                    '<a href="' + attachment.url + '" target="_blank" style="text-decoration: none;">' +
                    '📄 ' + attachment.filename +
                    '</a></p>'
                ).show();
                
                uploadButton.text('Изменить файл');
                removeButton.show();
            });
            
            fileFrame.open();
        });
        
        // Удалить файл
        removeButton.on('click', function(e) {
            e.preventDefault();
            fileIdInput.val('');
            previewDiv.hide();
            uploadButton.text('Загрузить файл');
            removeButton.hide();
        });
    });
    </script>
    <?php
}

/**
 * Сохранение данных мета-бокса (старая система CPT)
 */
add_action( 'save_post_shop_order', 'enotary_save_certificate_meta_box_data' );

function enotary_save_certificate_meta_box_data( $post_id ) {
    // Проверка nonce
    if ( ! isset( $_POST['enotary_certificate_meta_box_nonce'] ) ) {
        return;
    }
    
    if ( ! wp_verify_nonce( $_POST['enotary_certificate_meta_box_nonce'], 'enotary_certificate_meta_box' ) ) {
        return;
    }
    
    // Проверка автосохранения
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    // Проверка прав доступа
    if ( ! current_user_can( 'edit_shop_order', $post_id ) ) {
        return;
    }
    
    // Сохранение данных
    $order = wc_get_order( $post_id );
    if ( $order ) {
        // Сохранить дату
        if ( isset( $_POST['certificate_expiry_date'] ) ) {
            $certificate_date = sanitize_text_field( $_POST['certificate_expiry_date'] );
            $order->update_meta_data( '_certificate_expiry_date', $certificate_date );
        }
        
        // Сохранить файл
        if ( isset( $_POST['certificate_file_id'] ) ) {
            $file_id = intval( $_POST['certificate_file_id'] );
            if ( $file_id > 0 ) {
                $order->update_meta_data( '_certificate_file_id', $file_id );
            } else {
                $order->delete_meta_data( '_certificate_file_id' );
            }
        }
        
        // Сохранить лицензионный ключ
        if ( isset( $_POST['software_license_key'] ) ) {
            $license_key = sanitize_textarea_field( $_POST['software_license_key'] );
            $order->update_meta_data( '_software_license_key', $license_key );
        }
        
        $order->save();
    }
}

/**
 * Сохранение данных мета-бокса (новая система HPOS)
 */
add_action( 'woocommerce_process_shop_order_meta', 'enotary_save_certificate_hpos_data', 10, 2 );

function enotary_save_certificate_hpos_data( $order_id, $order ) {
    // Проверка nonce
    if ( ! isset( $_POST['enotary_certificate_meta_box_nonce'] ) ) {
        return;
    }
    
    if ( ! wp_verify_nonce( $_POST['enotary_certificate_meta_box_nonce'], 'enotary_certificate_meta_box' ) ) {
        return;
    }
    
    // Сохранить дату
    if ( isset( $_POST['certificate_expiry_date'] ) ) {
        $certificate_date = sanitize_text_field( $_POST['certificate_expiry_date'] );
        $order->update_meta_data( '_certificate_expiry_date', $certificate_date );
    }
    
    // Сохранить файл
    if ( isset( $_POST['certificate_file_id'] ) ) {
        $file_id = intval( $_POST['certificate_file_id'] );
        if ( $file_id > 0 ) {
            $order->update_meta_data( '_certificate_file_id', $file_id );
        } else {
            $order->delete_meta_data( '_certificate_file_id' );
        }
    }
    
    // Сохранить лицензионный ключ
    if ( isset( $_POST['software_license_key'] ) ) {
        $license_key = sanitize_textarea_field( $_POST['software_license_key'] );
        $order->update_meta_data( '_software_license_key', $license_key );
    }
    
    $order->save();
}

/**
 * ============================================
 * ЗАДАЧА 2: Кастомизация таблицы заказов
 * ============================================
 */

/**
 * Настройка колонок таблицы заказов (старая система CPT)
 */
add_filter( 'manage_edit-shop_order_columns', 'enotary_custom_shop_order_columns', 999 );

/**
 * Настройка колонок таблицы заказов (новая система HPOS)
 */
add_filter( 'manage_woocommerce_page_wc-orders_columns', 'enotary_custom_shop_order_columns', 999 );

function enotary_custom_shop_order_columns( $columns ) {
    // Полностью перестраиваем колонки в нужном порядке
    $new_columns = array();
    
    // Чекбокс (если есть)
    if ( isset( $columns['cb'] ) ) {
        $new_columns['cb'] = $columns['cb'];
    }
    
    // Номер заказа
    if ( isset( $columns['order_number'] ) ) {
        $new_columns['order_number'] = $columns['order_number'];
    }
    
    // Дата
    if ( isset( $columns['order_date'] ) ) {
        $new_columns['order_date'] = $columns['order_date'];
    }
    
    // Статус
    if ( isset( $columns['order_status'] ) ) {
        $new_columns['order_status'] = $columns['order_status'];
    }
    
    // КАСТОМНЫЕ КОЛОНКИ
    $new_columns['payer_info'] = 'Заказчик / Тип';
    $new_columns['company_details'] = 'Реквизиты (ЮЛ)';
    $new_columns['customer_address'] = 'Адрес';
    
    // Сумма заказа
    if ( isset( $columns['order_total'] ) ) {
        $new_columns['order_total'] = $columns['order_total'];
    }
    
    // Продолжение кастомных колонок
    $new_columns['contacts_info'] = 'Контакты';
    $new_columns['cert_expiry'] = 'Срок действия';
    $new_columns['order_notes'] = 'Примечание';
    $new_columns['invoice_link'] = 'Счет';
    
    // Остальные стандартные колонки (если есть)
    if ( isset( $columns['wc_actions'] ) ) {
        $new_columns['wc_actions'] = $columns['wc_actions'];
    }
    
    return $new_columns;
}

/**
 * Заполнение кастомных колонок данными (старая система CPT)
 */
add_action( 'manage_shop_order_posts_custom_column', 'enotary_custom_shop_order_column_content', 20, 2 );

/**
 * Заполнение кастомных колонок данными (новая система HPOS)
 */
add_action( 'manage_woocommerce_page_wc-orders_custom_column', 'enotary_custom_shop_order_column_content', 20, 2 );

function enotary_custom_shop_order_column_content( $column, $post_id ) {
    $order = wc_get_order( $post_id );
    
    if ( ! $order ) {
        return;
    }
    
    switch ( $column ) {
        case 'payer_info':
            // Имя Фамилия (жирным) + Тип лица
            $first_name = $order->get_billing_first_name();
            $last_name = $order->get_billing_last_name();
            $payer_type = $order->get_meta( '_active_payer_type' );
            
            // Преобразование типа в читаемый формат
            $payer_type_labels = array(
                'individual' => 'ФЛ (Физическое лицо)',
                'entrepreneur' => 'ИП (Индивидуальный предприниматель)',
                'legal' => 'ЮЛ (Юридическое лицо)'
            );
            
            $payer_type_display = isset( $payer_type_labels[ $payer_type ] ) 
                ? $payer_type_labels[ $payer_type ] 
                : 'Не указано';
            
            echo '<strong>' . esc_html( $first_name . ' ' . $last_name ) . '</strong><br>';
            echo '<span style="color: #666; font-size: 12px;">' . esc_html( $payer_type_display ) . '</span>';
            break;
        
        case 'company_details':
            // Реквизиты юридического лица
            $payer_type = $order->get_meta( '_active_payer_type' );
            
            if ( $payer_type === 'legal' ) {
                $company = $order->get_billing_company();
                $inn = $order->get_meta( '_billing_inn' );
                $kpp = $order->get_meta( '_billing_kpp' );
                $okpo = $order->get_meta( '_billing_okpo' );
                $legal_address = $order->get_meta( '_billing_legal_address' );
                
                if ( $company ) {
                    echo '<strong>' . esc_html( $company ) . '</strong><br>';
                }
                
                echo '<div style="font-size: 11px; line-height: 1.6; color: #555;">';
                if ( $inn ) {
                    echo 'ИНН: ' . esc_html( $inn ) . '<br>';
                }
                if ( $kpp ) {
                    echo 'КПП: ' . esc_html( $kpp ) . '<br>';
                }
                if ( $okpo ) {
                    echo 'ОКПО: ' . esc_html( $okpo ) . '<br>';
                }
                if ( $legal_address ) {
                    echo 'Юр. Адрес: ' . esc_html( $legal_address );
                }
                echo '</div>';
            } else {
                echo '<span style="color: #999;">—</span>';
            }
            break;
        
        case 'customer_address':
            // Адрес: Город, Улица, Дом
            $city = $order->get_billing_city();
            $address_1 = $order->get_billing_address_1();
            $address_2 = $order->get_billing_address_2();
            $passport_address = $order->get_meta( '_billing_passport_address' );
            
            // Всегда выводим что-то, даже если данных нет (для отладки)
            if ( ! empty( $passport_address ) ) {
                echo '<div style="font-size: 12px; line-height: 1.4; color: #333;">';
                echo esc_html( $passport_address );
                echo '</div>';
            } elseif ( $city || $address_1 || $address_2 ) {
                $address_parts = array_filter( array( $city, $address_1, $address_2 ) );
                echo '<div style="font-size: 12px; line-height: 1.4; color: #333;">';
                echo esc_html( implode( ', ', $address_parts ) );
                echo '</div>';
            } else {
                echo '<span style="color: #999; font-size: 12px;">Не указан</span>';
            }
            break;
        
        case 'contacts_info':
            // Телефон и Email
            $phone = $order->get_billing_phone();
            $email = $order->get_billing_email();
            
            if ( $phone ) {
                echo '<a href="tel:' . esc_attr( $phone ) . '" style="text-decoration: none;">📞 ' . esc_html( $phone ) . '</a><br>';
            }
            if ( $email ) {
                echo '<a href="mailto:' . esc_attr( $email ) . '" style="text-decoration: none;">✉️ ' . esc_html( $email ) . '</a>';
            }
            break;
        
        case 'cert_expiry':
            // Срок действия сертификата с цветовой индикацией
            $cert_date = $order->get_meta( '_certificate_expiry_date', true );
            
            if ( $cert_date ) {
                $today = new DateTime();
                $expiry = new DateTime( $cert_date );
                $interval = $today->diff( $expiry );
                $days_remaining = (int) $interval->format( '%r%a' );
                
                // Определение цвета в зависимости от срока
                $color = '#000'; // По умолчанию черный
                $bg_color = 'transparent';
                
                if ( $days_remaining < 0 ) {
                    // Истек - красный
                    $color = '#fff';
                    $bg_color = '#dc3232';
                    $status_text = 'ИСТЁК';
                } elseif ( $days_remaining <= 30 ) {
                    // Менее 30 дней - желтый
                    $color = '#000';
                    $bg_color = '#ffb900';
                    $status_text = $days_remaining . ' дн.';
                } else {
                    $status_text = '';
                }
                
                $formatted_date = date_i18n( 'd.m.Y', strtotime( $cert_date ) );
                
                echo '<div style="background: ' . esc_attr( $bg_color ) . '; color: ' . esc_attr( $color ) . '; padding: 4px 8px; border-radius: 3px; display: inline-block;">';
                echo esc_html( $formatted_date );
                if ( $status_text ) {
                    echo '<br><strong>' . esc_html( $status_text ) . '</strong>';
                }
                echo '</div>';
            } else {
                echo '<span style="color: #999;">Не указан</span>';
            }
            break;
        
        case 'order_notes':
            // Примечание - комментарий клиента к заказу (customer_note)
            $customer_note = $order->get_customer_note();
            
            if ( ! empty( $customer_note ) ) {
                // Обрезаем длинные комментарии до 100 символов
                $note_short = mb_strlen( $customer_note ) > 100 
                    ? mb_substr( $customer_note, 0, 100 ) . '...' 
                    : $customer_note;
                
                echo '<div style="font-size: 12px; line-height: 1.4; max-width: 200px;" title="' . esc_attr( $customer_note ) . '">';
                echo esc_html( $note_short );
                echo '</div>';
            } else {
                echo '<span style="color: #999;">—</span>';
            }
            break;
        
        case 'invoice_link':
            // Ссылка на PDF счет (для метода оплаты bacs)
            $payment_method = $order->get_payment_method();
            
            if ( $payment_method === 'bacs' ) {
                // Проверяем, установлен ли плагин WooCommerce PDF Invoices & Packing Slips
                if ( function_exists( 'wcpdf_get_invoice' ) || class_exists( 'WPO_WCPDF' ) ) {
                    $invoice_url = wp_nonce_url(
                        admin_url( 'admin-ajax.php?action=generate_wpo_wcpdf&document_type=invoice&order_ids=' . $order->get_id() ),
                        'generate_wpo_wcpdf'
                    );
                    
                    echo '<a href="' . esc_url( $invoice_url ) . '" class="button button-small" target="_blank" style="background: #375d74; color: #fff; border: none;">📄 PDF</a>';
                } else {
                    echo '<span style="color: #999;">Плагин не установлен</span>';
                }
            } else {
                echo '<span style="color: #999;">—</span>';
            }
            break;
    }
}

/**
 * Сделать колонку "Срок действия" сортируемой (старая система)
 */
add_filter( 'manage_edit-shop_order_sortable_columns', 'enotary_sortable_shop_order_columns' );

/**
 * Сделать колонку "Срок действия" сортируемой (новая система HPOS)
 */
add_filter( 'manage_woocommerce_page_wc-orders_sortable_columns', 'enotary_sortable_shop_order_columns' );

function enotary_sortable_shop_order_columns( $columns ) {
    $columns['cert_expiry'] = 'certificate_expiry_date';
    return $columns;
}

/**
 * Настройка сортировки для колонки "Срок действия"
 */
add_action( 'pre_get_posts', 'enotary_shop_order_orderby' );

function enotary_shop_order_orderby( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }
    
    if ( 'certificate_expiry_date' === $query->get( 'orderby' ) ) {
        $query->set( 'meta_key', '_certificate_expiry_date' );
        $query->set( 'orderby', 'meta_value' );
    }
}
