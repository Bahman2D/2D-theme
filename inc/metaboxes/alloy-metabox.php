<?php
/**
 * Alloy Metabox
 * 
 * متاباکس برای مشخصات فنی آلیاژها
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * اضافه کردن متاباکس Alloy
 */
function d_theme_add_alloy_metabox() {
    add_meta_box(
        'd_theme_alloy_metabox',
        __('مشخصات فنی آلیاژ', 'd-theme'),
        'd_theme_alloy_metabox_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'd_theme_add_alloy_metabox');

/**
 * Callback متاباکس Alloy
 */
function d_theme_alloy_metabox_callback($post) {
    wp_nonce_field('d_theme_alloy_metabox', 'd_theme_alloy_nonce');
    
    $alloy_specs = get_post_meta($post->ID, 'd_theme_alloy_specs', true);
    if (!is_array($alloy_specs)) {
        $alloy_specs = array();
    }
    
    // فیلدهای پیش‌فرض
    $default_fields = array(
        'composition' => __('ترکیب شیمیایی', 'd-theme'),
        'density' => __('چگالی (g/cm³)', 'd-theme'),
        'melting_point' => __('نقطه ذوب (°C)', 'd-theme'),
        'tensile_strength' => __('استحکام کششی (MPa)', 'd-theme'),
        'yield_strength' => __('استحکام تسلیم (MPa)', 'd-theme'),
        'hardness' => __('سختی (HB)', 'd-theme'),
        'thermal_conductivity' => __('هدایت حرارتی (W/m·K)', 'd-theme'),
        'electrical_conductivity' => __('هدایت الکتریکی (%IACS)', 'd-theme'),
    );
    
    ?>
    <div class="d-theme-alloy-metabox">
        <p class="description">
            <?php _e('مشخصات فنی آلیاژ را وارد کنید. این اطلاعات در جدول مشخصات نمایش داده می‌شوند.', 'd-theme'); ?>
        </p>
        
        <table class="form-table">
            <?php foreach ($default_fields as $key => $label) : ?>
                <tr>
                    <th scope="row">
                        <label for="alloy_<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></label>
                    </th>
                    <td>
                        <?php if ($key === 'composition') : ?>
                            <textarea 
                                id="alloy_<?php echo esc_attr($key); ?>"
                                name="alloy_specs[<?php echo esc_attr($key); ?>]" 
                                rows="3"
                                class="large-text"
                                placeholder="<?php esc_attr_e('مثال: Cu 60%, Zn 40%', 'd-theme'); ?>"
                            ><?php echo isset($alloy_specs[$key]) ? esc_textarea($alloy_specs[$key]) : ''; ?></textarea>
                        <?php else : ?>
                            <input 
                                type="text" 
                                id="alloy_<?php echo esc_attr($key); ?>"
                                name="alloy_specs[<?php echo esc_attr($key); ?>]" 
                                value="<?php echo isset($alloy_specs[$key]) ? esc_attr($alloy_specs[$key]) : ''; ?>"
                                class="regular-text"
                                placeholder="<?php esc_attr_e('مقدار را وارد کنید...', 'd-theme'); ?>"
                            >
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        
        <h3><?php _e('ویژگی‌های اضافی', 'd-theme'); ?></h3>
        <p class="description">
            <?php _e('می‌توانید ویژگی‌های اضافی اضافه کنید:', 'd-theme'); ?>
        </p>
        
        <div id="alloy-extra-specs">
            <?php 
            $extra_specs = isset($alloy_specs['extra']) && is_array($alloy_specs['extra']) ? $alloy_specs['extra'] : array();
            if (!empty($extra_specs)) :
                foreach ($extra_specs as $index => $extra) :
            ?>
                <div class="alloy-extra-item" data-index="<?php echo esc_attr($index); ?>">
                    <p>
                        <input 
                            type="text" 
                            name="alloy_specs[extra][<?php echo esc_attr($index); ?>][label]" 
                            value="<?php echo esc_attr($extra['label']); ?>"
                            placeholder="<?php esc_attr_e('نام ویژگی', 'd-theme'); ?>"
                            class="regular-text"
                        >
                        <input 
                            type="text" 
                            name="alloy_specs[extra][<?php echo esc_attr($index); ?>][value]" 
                            value="<?php echo esc_attr($extra['value']); ?>"
                            placeholder="<?php esc_attr_e('مقدار', 'd-theme'); ?>"
                            class="regular-text"
                        >
                        <button type="button" class="button alloy-extra-remove"><?php _e('حذف', 'd-theme'); ?></button>
                    </p>
                </div>
            <?php 
                endforeach;
            endif;
            ?>
        </div>
        
        <button type="button" id="add-alloy-extra" class="button button-secondary">
            <?php _e('+ افزودن ویژگی جدید', 'd-theme'); ?>
        </button>
    </div>
    
    <style>
    .d-theme-alloy-metabox {
        padding: 10px 0;
    }
    .alloy-extra-item {
        margin-bottom: 10px;
    }
    .alloy-extra-item input {
        margin-left: 5px;
    }
    </style>
    
    <script>
    (function($) {
        var extraIndex = <?php echo count($extra_specs); ?>;
        
        $('#add-alloy-extra').on('click', function() {
            var html = '<div class="alloy-extra-item" data-index="' + extraIndex + '">' +
                '<p>' +
                '<input type="text" name="alloy_specs[extra][' + extraIndex + '][label]" placeholder="<?php echo esc_js(__('نام ویژگی', 'd-theme')); ?>" class="regular-text">' +
                '<input type="text" name="alloy_specs[extra][' + extraIndex + '][value]" placeholder="<?php echo esc_js(__('مقدار', 'd-theme')); ?>" class="regular-text">' +
                '<button type="button" class="button alloy-extra-remove"><?php echo esc_js(__('حذف', 'd-theme')); ?></button>' +
                '</p>' +
                '</div>';
            
            $('#alloy-extra-specs').append(html);
            extraIndex++;
        });
        
        $(document).on('click', '.alloy-extra-remove', function() {
            $(this).closest('.alloy-extra-item').remove();
        });
    })(jQuery);
    </script>
    <?php
}

/**
 * ذخیره متاباکس Alloy
 */
function d_theme_save_alloy_metabox($post_id) {
    // بررسی nonce
    if (!isset($_POST['d_theme_alloy_nonce']) || !wp_verify_nonce($_POST['d_theme_alloy_nonce'], 'd_theme_alloy_metabox')) {
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
    $specs = array();
    
    if (isset($_POST['alloy_specs']) && is_array($_POST['alloy_specs'])) {
        foreach ($_POST['alloy_specs'] as $key => $value) {
            if ($key === 'extra' && is_array($value)) {
                $specs['extra'] = array();
                foreach ($value as $extra) {
                    if (!empty($extra['label']) && !empty($extra['value'])) {
                        $specs['extra'][] = array(
                            'label' => sanitize_text_field($extra['label']),
                            'value' => sanitize_text_field($extra['value']),
                        );
                    }
                }
            } elseif ($key === 'composition') {
                $specs[$key] = sanitize_textarea_field($value);
            } else {
                $specs[$key] = sanitize_text_field($value);
            }
        }
    }
    
    // ذخیره
    if (!empty($specs)) {
        update_post_meta($post_id, 'd_theme_alloy_specs', $specs);
    } else {
        delete_post_meta($post_id, 'd_theme_alloy_specs');
    }
}
add_action('save_post', 'd_theme_save_alloy_metabox');

