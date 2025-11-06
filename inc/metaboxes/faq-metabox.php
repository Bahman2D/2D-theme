<?php
/**
 * FAQ Metabox
 * 
 * متاباکس برای افزودن سوالات متداول به صفحات و نوشته‌ها
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * اضافه کردن متاباکس FAQ
 */
function d_theme_add_faq_metabox() {
    $post_types = array('post', 'page');
    
    foreach ($post_types as $post_type) {
        add_meta_box(
            'd_theme_faq_metabox',
            __('سوالات متداول (FAQ)', 'd-theme'),
            'd_theme_faq_metabox_callback',
            $post_type,
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'd_theme_add_faq_metabox');

/**
 * Callback متاباکس FAQ
 */
function d_theme_faq_metabox_callback($post) {
    wp_nonce_field('d_theme_faq_metabox', 'd_theme_faq_nonce');
    
    $faqs = get_post_meta($post->ID, 'd_theme_faq_items', true);
    if (!is_array($faqs)) {
        $faqs = array();
    }
    
    ?>
    <div class="d-theme-faq-metabox">
        <p class="description">
            <?php _e('سوالات و جواب‌های متداول را اضافه کنید. این FAQ ها با Schema markup نمایش داده می‌شوند.', 'd-theme'); ?>
        </p>
        
        <div id="faq-items-container">
            <?php if (!empty($faqs)) : ?>
                <?php foreach ($faqs as $index => $faq) : ?>
                    <div class="faq-item" data-index="<?php echo esc_attr($index); ?>">
                        <div class="faq-item-header">
                            <span class="faq-item-number"><?php echo esc_html($index + 1); ?></span>
                            <button type="button" class="faq-item-remove button-link-delete" aria-label="<?php esc_attr_e('حذف', 'd-theme'); ?>"><?php _e('حذف', 'd-theme'); ?></button>
                        </div>
                        <div class="faq-item-content">
                            <p>
                                <label for="faq_question_<?php echo esc_attr($index); ?>">
                                    <strong><?php _e('سوال:', 'd-theme'); ?></strong>
                                </label>
                                <input 
                                    type="text" 
                                    id="faq_question_<?php echo esc_attr($index); ?>"
                                    name="faq_items[<?php echo esc_attr($index); ?>][question]" 
                                    value="<?php echo esc_attr($faq['question']); ?>"
                                    class="widefat"
                                    placeholder="<?php esc_attr_e('متن سوال را وارد کنید...', 'd-theme'); ?>"
                                >
                            </p>
                            <p>
                                <label for="faq_answer_<?php echo esc_attr($index); ?>">
                                    <strong><?php _e('جواب:', 'd-theme'); ?></strong>
                                </label>
                                <textarea 
                                    id="faq_answer_<?php echo esc_attr($index); ?>"
                                    name="faq_items[<?php echo esc_attr($index); ?>][answer]" 
                                    rows="4"
                                    class="widefat"
                                    placeholder="<?php esc_attr_e('متن جواب را وارد کنید...', 'd-theme'); ?>"
                                ><?php echo esc_textarea($faq['answer']); ?></textarea>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <button type="button" id="add-faq-item" class="button button-secondary">
            <?php _e('+ افزودن سوال جدید', 'd-theme'); ?>
        </button>
    </div>
    
    <style>
    .d-theme-faq-metabox {
        padding: 10px 0;
    }
    .faq-item {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 15px;
        margin-bottom: 15px;
        background: #fff;
    }
    .faq-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    .faq-item-number {
        font-weight: bold;
        color: #2271b1;
    }
    .faq-item-content p {
        margin: 10px 0;
    }
    .faq-item-content label {
        display: block;
        margin-bottom: 5px;
    }
    </style>
    
    <script>
    (function($) {
        var faqIndex = <?php echo count($faqs); ?>;
        
        $('#add-faq-item').on('click', function() {
            var html = '<div class="faq-item" data-index="' + faqIndex + '">' +
                '<div class="faq-item-header">' +
                '<span class="faq-item-number">' + (faqIndex + 1) + '</span>' +
                '<button type="button" class="faq-item-remove button-link-delete"><?php echo esc_js(__('حذف', 'd-theme')); ?></button>' +
                '</div>' +
                '<div class="faq-item-content">' +
                '<p><label><strong><?php echo esc_js(__('سوال:', 'd-theme')); ?></strong></label>' +
                '<input type="text" name="faq_items[' + faqIndex + '][question]" class="widefat" placeholder="<?php echo esc_js(__('متن سوال را وارد کنید...', 'd-theme')); ?>"></p>' +
                '<p><label><strong><?php echo esc_js(__('جواب:', 'd-theme')); ?></strong></label>' +
                '<textarea name="faq_items[' + faqIndex + '][answer]" rows="4" class="widefat" placeholder="<?php echo esc_js(__('متن جواب را وارد کنید...', 'd-theme')); ?>"></textarea></p>' +
                '</div>' +
                '</div>';
            
            $('#faq-items-container').append(html);
            faqIndex++;
        });
        
        $(document).on('click', '.faq-item-remove', function() {
            $(this).closest('.faq-item').remove();
            updateFaqNumbers();
        });
        
        function updateFaqNumbers() {
            $('#faq-items-container .faq-item').each(function(index) {
                $(this).find('.faq-item-number').text(index + 1);
            });
        }
    })(jQuery);
    </script>
    <?php
}

/**
 * ذخیره متاباکس FAQ
 */
function d_theme_save_faq_metabox($post_id) {
    // بررسی nonce
    if (!isset($_POST['d_theme_faq_nonce']) || !wp_verify_nonce($_POST['d_theme_faq_nonce'], 'd_theme_faq_metabox')) {
        return;
    }
    
    // بررسی autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // بررسی permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // دریافت و sanitize داده‌ها
    $faqs = array();
    
    if (isset($_POST['faq_items']) && is_array($_POST['faq_items'])) {
        foreach ($_POST['faq_items'] as $faq) {
            $question = isset($faq['question']) ? sanitize_text_field($faq['question']) : '';
            $answer = isset($faq['answer']) ? sanitize_textarea_field($faq['answer']) : '';
            
            if (!empty($question) && !empty($answer)) {
                $faqs[] = array(
                    'question' => $question,
                    'answer' => $answer,
                );
            }
        }
    }
    
    // ذخیره
    if (!empty($faqs)) {
        update_post_meta($post_id, 'd_theme_faq_items', $faqs);
    } else {
        delete_post_meta($post_id, 'd_theme_faq_items');
    }
}
add_action('save_post', 'd_theme_save_faq_metabox');

