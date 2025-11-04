<?php
/**
 * Color Helper Functions
 * 
 * توابع کمکی برای مدیریت رنگ‌های دسته‌ها
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// جلوگیری از دسترسی مستقیم
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * دریافت تمام رنگ‌های دسته‌ها
 * 
 * @return array آرایه‌ای از رنگ‌های دسته‌بندی‌ها
 */
function d_theme_get_category_colors() {
    return apply_filters('d_theme_category_colors', array(
        'bearing-steel' => array(
            'accent' => '#2563eb', // آبی فولادی
            'name' => 'فولاد بلبرینگ',
            'slug' => 'bearing-steel',
        ),
        'spring-steel' => array(
            'accent' => '#16a34a', // سبز
            'name' => 'فولاد فنر',
            'slug' => 'spring-steel',
        ),
        'nitriding-steel' => array(
            'accent' => '#9333ea', // بنفش
            'name' => 'فولاد نیتراته',
            'slug' => 'nitriding-steel',
        ),
        'heat-resistant-steel' => array(
            'accent' => '#dc2626', // قرمز
            'name' => 'فولاد مقاوم به حرارت',
            'slug' => 'heat-resistant-steel',
        ),
        'other-alloys' => array(
            'accent' => '#64748b', // خاکستری
            'name' => 'سایر آلیاژها',
            'slug' => 'other-alloys',
        ),
    ));
}

/**
 * دریافت رنگ accent دسته
 * 
 * @param string $category_slug اسلاگ دسته (مثلاً: bearing-steel)
 * @return string کد رنگ Hex
 */
function d_theme_get_category_color($category_slug) {
    $colors = d_theme_get_category_colors();
    
    if (isset($colors[$category_slug]['accent'])) {
        return $colors[$category_slug]['accent'];
    }
    
    // رنگ پیش‌فرض از Customizer یا ثابت
    return get_theme_mod('primary_color', '#3b82f6');
}

/**
 * دریافت نام دسته به فارسی
 * 
 * @param string $category_slug اسلاگ دسته
 * @return string نام فارسی دسته
 */
function d_theme_get_category_name($category_slug) {
    $colors = d_theme_get_category_colors();
    
    if (isset($colors[$category_slug]['name'])) {
        return $colors[$category_slug]['name'];
    }
    
    // تبدیل slug به نام خوانا
    return ucwords(str_replace('-', ' ', $category_slug));
}

/**
 * تشخیص دسته صفحه فعلی
 * 
 * @return string|false slug دسته یا false
 */
function d_theme_get_current_category_slug() {
    if (!is_page()) {
        return false;
    }
    
    global $post;
    $colors = d_theme_get_category_colors();
    
    // اگر خود صفحه یک دسته است
    if (isset($colors[$post->post_name])) {
        return $post->post_name;
    }
    
    // اگر صفحه parent دارد
    if ($post->post_parent) {
        $parent = get_post($post->post_parent);
        if ($parent && isset($colors[$parent->post_name])) {
            return $parent->post_name;
        }
    }
    
    return false;
}

/**
 * اضافه کردن متغیرهای CSS رنگ دسته به head
 */
function d_theme_category_colors_css() {
    $category_slug = d_theme_get_current_category_slug();
    
    if (!$category_slug) {
        return;
    }
    
    $accent = d_theme_get_category_color($category_slug);
    
    // تبدیل hex به RGB برای استفاده در rgba
    $rgb = d_theme_hex_to_rgb($accent);
    
    ?>
    <style id="category-colors">
        :root {
            --category-accent: <?php echo esc_attr($accent); ?>;
            --category-accent-rgb: <?php echo esc_attr($rgb); ?>;
        }
        
        /* اعمال خودکار رنگ دسته */
        .category-page .page-title,
        .category-badge {
            color: var(--category-accent);
        }
        
        .category-header {
            border-top: 3px solid var(--category-accent);
        }
    </style>
    <?php
}
add_action('wp_head', 'd_theme_category_colors_css');

/**
 * تبدیل Hex به RGB
 * 
 * @param string $hex کد رنگ hex
 * @return string مقدار RGB (مثلاً: "59, 130, 246")
 */
function d_theme_hex_to_rgb($hex) {
    // حذف # اگر وجود داشت
    $hex = ltrim($hex, '#');
    
    // تبدیل 3 کاراکتری به 6 کاراکتری
    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    
    // تبدیل به RGB
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    return "$r, $g, $b";
}

/**
 * روشن یا تیره کردن رنگ
 * 
 * @param string $hex کد رنگ hex
 * @param int $percent درصد تغییر (مثبت = روشن، منفی = تیره)
 * @return string کد رنگ hex جدید
 */
function d_theme_adjust_brightness($hex, $percent) {
    $hex = ltrim($hex, '#');
    
    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    $r = max(0, min(255, $r + ($r * $percent / 100)));
    $g = max(0, min(255, $g + ($g * $percent / 100)));
    $b = max(0, min(255, $b + ($b * $percent / 100)));
    
    return '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT)
               . str_pad(dechex($g), 2, '0', STR_PAD_LEFT)
               . str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
}

/**
 * دریافت badge HTML برای دسته
 * 
 * @param string $category_slug slug دسته
 * @return string کد HTML badge
 */
function d_theme_get_category_badge($category_slug) {
    $name = d_theme_get_category_name($category_slug);
    $color = d_theme_get_category_color($category_slug);
    
    $style = sprintf(
        'background: %s; color: %s; border-color: %s;',
        d_theme_adjust_brightness($color, 90),
        $color,
        $color
    );
    
    return sprintf(
        '<span class="badge category-badge" style="%s">%s</span>',
        esc_attr($style),
        esc_html($name)
    );
}

/**
 * نمایش badge دسته
 * 
 * @param string $category_slug slug دسته
 */
function d_theme_category_badge($category_slug) {
    echo d_theme_get_category_badge($category_slug);
}
