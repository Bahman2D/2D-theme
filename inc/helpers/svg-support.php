<?php
/**
 * SVG Support
 * 
 * پشتیبانی از آپلود و نمایش فایل‌های SVG
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// جلوگیری از دسترسی مستقیم
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * اضافه کردن SVG به لیست MIME types مجاز
 */
function d_theme_allow_svg_upload($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'd_theme_allow_svg_upload');

/**
 * بررسی امنیتی فایل SVG
 */
function d_theme_check_svg_file($file) {
    // فقط برای فایل‌های SVG
    if ($file['type'] !== 'image/svg+xml') {
        return $file;
    }
    
    // خواندن محتوای فایل
    $svg_content = file_get_contents($file['tmp_name']);
    
    // لیست تگ‌ها و ویژگی‌های خطرناک
    $dangerous_tags = array(
        '<script',
        'javascript:',
        'onclick',
        'onerror',
        'onload',
        'onmouseover',
        '<iframe',
        '<embed',
        '<object',
    );
    
    // بررسی وجود المان‌های خطرناک
    foreach ($dangerous_tags as $tag) {
        if (stripos($svg_content, $tag) !== false) {
            $file['error'] = __('فایل SVG حاوی کد مخرب است. لطفاً فایل دیگری آپلود کنید.', 'd-theme');
            return $file;
        }
    }
    
    return $file;
}
add_filter('wp_handle_upload_prefilter', 'd_theme_check_svg_file');

/**
 * اضافه کردن پیش‌نمایش SVG در media library
 */
function d_theme_svg_mime_type_fix($data, $file, $filename, $mimes) {
    $filetype = wp_check_filetype($filename, $mimes);
    
    if ($filetype['ext'] === 'svg') {
        $data['ext'] = 'svg';
        $data['type'] = 'image/svg+xml';
    }
    
    return $data;
}
add_filter('wp_check_filetype_and_ext', 'd_theme_svg_mime_type_fix', 10, 4);

/**
 * نمایش پیش‌نمایش SVG در media library
 */
function d_theme_svg_media_thumbnails($response, $attachment, $meta) {
    if ($response['type'] === 'image' && $response['subtype'] === 'svg+xml' && class_exists('SimpleXMLElement')) {
        try {
            // خواندن ابعاد SVG
            $svg = simplexml_load_file(get_attached_file($attachment->ID));
            if ($svg && isset($svg['width']) && isset($svg['height'])) {
                $response['sizes'] = array(
                    'full' => array(
                        'url' => $response['url'],
                        'width' => (int) $svg['width'],
                        'height' => (int) $svg['height'],
                        'orientation' => 'landscape'
                    )
                );
            }
        } catch (Exception $e) {
            // در صورت خطا، چیزی نکن
        }
    }
    
    return $response;
}
add_filter('wp_prepare_attachment_for_js', 'd_theme_svg_media_thumbnails', 10, 3);

/**
 * نمایش SVG در ستون thumbnails
 */
function d_theme_svg_admin_thumb_filter($html, $post_id) {
    $mime = get_post_mime_type($post_id);
    
    if ($mime === 'image/svg+xml') {
        $src = wp_get_attachment_url($post_id);
        if ($src) {
            $html = '<img src="' . esc_url($src) . '" style="width: 60px; height: auto;" />';
        }
    }
    
    return $html;
}
add_filter('wp_get_attachment_image_src', 'd_theme_svg_admin_thumb_filter', 10, 2);

/**
 * اضافه کردن class برای SVG images
 */
function d_theme_svg_image_class($classes, $id, $size, $align, $icon) {
    $mime = get_post_mime_type($id);
    
    if ($mime === 'image/svg+xml') {
        $classes[] = 'svg-image';
    }
    
    return $classes;
}
add_filter('get_image_tag_class', 'd_theme_svg_image_class', 10, 5);

/**
 * ثبت custom field برای آیکون‌های SVG در customizer
 */
function d_theme_svg_icon_customizer($wp_customize) {
    // اضافه کردن section برای آیکون‌های SVG
    $wp_customize->add_section('d_theme_svg_icons', array(
        'title' => __('آیکون‌های SVG', 'd-theme'),
        'description' => __('آپلود آیکون‌های SVG برای استفاده در سایت', 'd-theme'),
        'panel' => 'd_theme_options',
        'priority' => 50,
    ));
    
    // آیکون تلفن
    $wp_customize->add_setting('icon_phone', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'icon_phone', array(
        'label' => __('آیکون تلفن', 'd-theme'),
        'section' => 'd_theme_svg_icons',
        'mime_type' => 'image',
    )));
    
    // آیکون ایمیل
    $wp_customize->add_setting('icon_email', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'icon_email', array(
        'label' => __('آیکون ایمیل', 'd-theme'),
        'section' => 'd_theme_svg_icons',
        'mime_type' => 'image',
    )));
    
    // آیکون موقعیت مکانی
    $wp_customize->add_setting('icon_location', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'icon_location', array(
        'label' => __('آیکون موقعیت مکانی', 'd-theme'),
        'section' => 'd_theme_svg_icons',
        'mime_type' => 'image',
    )));
}
add_action('customize_register', 'd_theme_svg_icon_customizer');

/**
 * تابع کمکی برای دریافت SVG icon
 */
function d_theme_get_svg_icon($icon_name, $class = '') {
    $icon_id = get_theme_mod("icon_{$icon_name}");
    
    if ($icon_id) {
        $icon_url = wp_get_attachment_url($icon_id);
        if ($icon_url) {
            $classes = $class ? ' class="' . esc_attr($class) . '"' : '';
            return '<img src="' . esc_url($icon_url) . '" alt="' . esc_attr($icon_name) . '"' . $classes . ' />';
        }
    }
    
    return '';
}

/**
 * استایل برای SVG images
 */
function d_theme_svg_styles() {
    ?>
    <style>
        .svg-image {
            width: auto;
            height: auto;
            max-width: 100%;
        }
        
        .icon-svg {
            width: 24px;
            height: 24px;
            display: inline-block;
            vertical-align: middle;
        }
    </style>
    <?php
}
add_action('wp_head', 'd_theme_svg_styles');
