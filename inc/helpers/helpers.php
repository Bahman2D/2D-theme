<?php
/**
 * Helper Functions
 * 
 * توابع کمکی عمومی قالب
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// جلوگیری از دسترسی مستقیم
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * دریافت URL فایل Asset
 * 
 * @param string $path مسیر نسبی فایل
 * @return string URL کامل
 */
function d_theme_asset($path) {
    return get_template_directory_uri() . '/' . ltrim($path, '/');
}

/**
 * نمایش SVG Icon
 * 
 * @param string $name نام آیکون
 * @param string $class کلاس CSS (اختیاری)
 * @return string کد SVG
 */
function d_theme_svg_icon($name, $class = '') {
    $icons = array(
        'search' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="' . esc_attr($class) . '" aria-hidden="true"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>',
        'menu' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="' . esc_attr($class) . '" aria-hidden="true"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>',
        'close' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="' . esc_attr($class) . '" aria-hidden="true"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>',
        'arrow-left' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="' . esc_attr($class) . '" aria-hidden="true"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>',
        'arrow-right' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="' . esc_attr($class) . '" aria-hidden="true"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>',
        'home' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="' . esc_attr($class) . '" aria-hidden="true"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>',
        'check' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="' . esc_attr($class) . '" aria-hidden="true"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>',
    );
    
    return isset($icons[$name]) ? $icons[$name] : '';
}

/**
 * Calculate reading time
 * 
 * @param string|int $content Post content or post ID
 * @return int Estimated time in minutes
 */
function d_theme_reading_time($content = '') {
    if (empty($content)) {
        $content = get_the_content();
    } elseif (is_numeric($content)) {
        $post = get_post(absint($content));
        $content = $post ? $post->post_content : '';
    }
    
    if (empty($content)) {
        return 1;
    }
    
    $word_count = str_word_count(strip_tags($content));
    $minutes = ceil($word_count / 200); // Assume: 200 words per minute
    
    return max(1, $minutes); // Minimum 1 minute
}

/**
 * Sanitize ورودی‌های کاربر
 * 
 * @param string $input ورودی
 * @return string خروجی تمیز شده
 */
function d_theme_sanitize_input($input) {
    return sanitize_text_field(trim($input));
}

/**
 * فرمت کردن قیمت به تومان
 * 
 * @param int|float $price قیمت
 * @return string قیمت فرمت شده
 */
function d_theme_format_price($price) {
    return number_format($price) . ' تومان';
}

/**
 * دریافت تصویر پیش‌فرض
 * 
 * @return string URL تصویر پیش‌فرض
 */
function d_theme_default_thumbnail() {
    return get_template_directory_uri() . '/assets/images/placeholder.jpg';
}

/**
 * نمایش پیغام هشدار
 * 
 * @param string $message پیغام
 * @param string $type نوع (success, error, warning, info)
 * @return string کد HTML
 */
function d_theme_alert($message, $type = 'info') {
    $class = 'alert alert-' . esc_attr($type);
    $icons = array(
        'success' => '✓',
        'error' => '✕',
        'warning' => '⚠',
        'info' => 'ℹ'
    );
    $icon = isset($icons[$type]) ? $icons[$type] : $icons['info'];
    
    return '<div class="' . $class . '" role="alert">' . $icon . ' ' . esc_html($message) . '</div>';
}

/**
 * کوتاه کردن متن
 * 
 * @param string $text متن
 * @param int $length طول مورد نظر
 * @param string $more متن ادامه
 * @return string متن کوتاه شده
 */
function d_theme_truncate($text, $length = 100, $more = '...') {
    $text = strip_tags($text);
    
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    
    $truncated = mb_substr($text, 0, $length);
    
    // برش در آخرین فاصله
    $last_space = mb_strrpos($truncated, ' ');
    if ($last_space !== false) {
        $truncated = mb_substr($truncated, 0, $last_space);
    }
    
    return $truncated . $more;
}

/**
 * دریافت خلاصه مطلب با طول سفارشی
 * 
 * @param int $length طول کلمه
 * @param int|null $post_id شناسه پست (null برای پست جاری)
 * @return string خلاصه مطلب
 */
function d_theme_get_excerpt($length = 30, $post_id = null) {
    $post = get_post($post_id);
    
    if (!$post) {
        return '';
    }
    
    // اگر excerpt دستی وجود داشت
    if ($post->post_excerpt) {
        return wp_trim_words($post->post_excerpt, $length, '...');
    }
    
    // وگرنه از محتوا استخراج کن
    $content = strip_shortcodes($post->post_content);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    
    return wp_trim_words($content, $length, '...');
}

/**
 * چک کردن فعال بودن Sidebar
 * 
 * @param string $sidebar_id شناسه sidebar
 * @return bool
 */
function d_theme_has_sidebar($sidebar_id = 'sidebar-main') {
    return is_active_sidebar($sidebar_id) && !is_page_template('page-full-width.php');
}

/**
 * دریافت URL شبکه اجتماعی
 * 
 * @param string $network نام شبکه
 * @return string|false URL یا false
 */
function d_theme_get_social_url($network) {
    $socials = array(
        'telegram' => get_theme_mod('social_telegram', ''),
        'instagram' => get_theme_mod('social_instagram', ''),
        'whatsapp' => get_theme_mod('social_whatsapp', ''),
        'linkedin' => get_theme_mod('social_linkedin', ''),
        'twitter' => get_theme_mod('social_twitter', ''),
    );
    
    return isset($socials[$network]) && !empty($socials[$network]) 
        ? esc_url($socials[$network]) 
        : false;
}

/**
 * تبدیل عدد به فارسی
 * 
 * @param string|int $number عدد
 * @return string عدد فارسی
 */
function d_theme_persian_numbers($number) {
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $english = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    
    return str_replace($english, $persian, $number);
}

/**
 * دریافت زمان نسبی (مثلاً: 2 روز پیش)
 * 
 * @param int|string $time تایم استمپ یا تاریخ
 * @return string زمان نسبی
 */
function d_theme_time_ago($time) {
    if (!is_numeric($time)) {
        $time = strtotime($time);
    }
    
    return human_time_diff($time, current_time('timestamp')) . ' پیش';
}

/**
 * چک کردن اینکه آیا محیط توسعه است
 * 
 * @return bool
 */
function d_theme_is_dev() {
    return defined('WP_DEBUG') && WP_DEBUG === true;
}
