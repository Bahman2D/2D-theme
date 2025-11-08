<?php
/**
 * Table of Contents Helper
 * 
 * توابع کمکی برای تولید فهرست مطالب
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * تولید ID برای heading بر اساس متن
 * 
 * این تابع ID را به همان روشی که در d_theme_extract_headings تولید می‌شود، تولید می‌کند
 * 
 * @param string $text متن heading
 * @param int $counter شمارنده (اختیاری)
 * @return string ID تولید شده
 */
function d_theme_get_heading_id($text, $counter = 0) {
    return 'toc-' . sanitize_title($text) . '-' . $counter;
}

/**
 * بررسی نیاز به TOC
 * 
 * @param string $content محتوای صفحه (با headings از template parts)
 * @return bool true اگر حداقل 3 heading وجود دارد
 */
function d_theme_needs_toc($content = '') {
    if (empty($content)) {
        global $post;
        if (!$post) {
            return false;
        }
        
        // ساخت محتوای کامل شامل headings از template parts
        $content = d_theme_get_full_content_for_toc();
    }
    
    // استخراج headings از محتوای HTML
    preg_match_all('/<h[2-4][^>]*>(.*?)<\/h[2-4]>/i', $content, $matches);
    
    // حداقل 3 heading لازم است
    return isset($matches[0]) && count($matches[0]) >= 3;
}

/**
 * گرفتن محتوای کامل برای TOC (شامل headings از template parts)
 * 
 * @return string محتوای کامل
 */
function d_theme_get_full_content_for_toc() {
    global $post;
    
    if (!$post) {
        return '';
    }
    
    $content = '';
    
    // محتوای اصلی
    if (!empty($post->post_content)) {
        $content = apply_filters('the_content', $post->post_content);
    }
    
    // برای صفحه آلیاژها، headings از template را اضافه کن
    if (is_page_template('page-alloy.php')) {
        // H1 از alloy-title (اختیاری - می‌توانیم skip کنیم چون H1 است)
        // H2 از alloy-specs-title
        $alloy_specs = get_post_meta($post->ID, 'd_theme_alloy_specs', true);
        if (!empty($alloy_specs) && is_array($alloy_specs)) {
            $content .= '<h2 class="alloy-specs-title">مشخصات فنی</h2>';
        }
    }
    
    // اضافه کردن H2 از FAQ section (برای همه صفحات و پست‌ها)
    $faqs = get_post_meta($post->ID, 'd_theme_faq_items', true);
    if (!empty($faqs) && is_array($faqs)) {
        $content .= '<h2 class="faq-title">سوالات متداول</h2>';
    }
    
    // اضافه کردن H2 از Comments section
    if (comments_open() || get_comments_number()) {
        $comments_count = get_comments_number();
        if ($comments_count > 0) {
            $content .= '<h2 class="comments-title">' . ($comments_count === 1 ? 'یک نظر' : sprintf('%s نظر', number_format_i18n($comments_count))) . '</h2>';
        } else {
            $content .= '<h2 class="comments-title">دیدگاه‌ها</h2>';
        }
    }
    
    return $content;
}

/**
 * استخراج headings از محتوا
 * 
 * @param string $content محتوای صفحه
 * @return array آرایه headings با اطلاعات
 */
function d_theme_extract_headings($content = '') {
    if (empty($content)) {
        global $post;
        if ($post) {
            // استفاده از محتوای پردازش شده
            $raw_content = $post->post_content;
            if (!empty($raw_content)) {
                $content = apply_filters('the_content', $raw_content);
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    $headings = array();
    $counter = 0;
    
    // استخراج H2, H3, H4 از محتوای HTML
    preg_match_all('/<h([2-4])[^>]*>(.*?)<\/h[2-4]>/i', $content, $matches, PREG_SET_ORDER);
    
    if (empty($matches)) {
        return array();
    }
    
    // استفاده از map برای جلوگیری از duplicate ID ها
    $id_map = array();
    
    foreach ($matches as $match) {
        $level = (int) $match[1];
        $text = strip_tags($match[2]);
        $text = trim($text);
        
        if (empty($text)) {
            continue;
        }
        
        // ایجاد ID منحصر به فرد بر اساس متن
        $base_id = 'toc-' . sanitize_title($text);
        
        // اگر این ID قبلاً استفاده شده، counter اضافه کن
        if (isset($id_map[$base_id])) {
            $id_map[$base_id]++;
            $id = $base_id . '-' . $id_map[$base_id];
        } else {
            $id_map[$base_id] = 0;
            $id = $base_id . '-0';
        }
        
        $headings[] = array(
            'level' => $level,
            'text' => $text,
            'id' => $id,
            'anchor' => '#' . $id,
        );
    }
    
    return $headings;
}

/**
 * اضافه کردن anchor به headings در محتوا
 * 
 * @param string $content محتوای صفحه
 * @return string محتوای با anchor
 */
function d_theme_add_toc_anchors($content = '') {
    if (empty($content)) {
        return $content;
    }
    
    $headings = d_theme_extract_headings($content);
    
    if (empty($headings)) {
        return $content;
    }
    
    // ایجاد یک map از headings بر اساس level و text
    $headings_map = array();
    foreach ($headings as $heading) {
        $key = $heading['level'] . '|' . md5($heading['text']);
        $headings_map[$key] = $heading;
    }
    
    // اضافه کردن id به همه headings با استفاده از preg_replace_callback
    $content = preg_replace_callback(
        '/(<h([2-4]))([^>]*>)(.*?)(<\/h[2-4]>)/is',
        function($matches) use ($headings_map) {
            $level = (int) $matches[2];
            $text = strip_tags($matches[4]);
            $text = trim($text);
            
            if (empty($text)) {
                return $matches[0];
            }
            
            $key = $level . '|' . md5($text);
            
            // بررسی اینکه آیا این heading در لیست ماست
            if (!isset($headings_map[$key])) {
                return $matches[0];
            }
            
            $heading = $headings_map[$key];
            
            // بررسی وجود id
            if (strpos($matches[3], 'id=') !== false) {
                return $matches[0]; // id موجود است
            }
            
            // اضافه کردن id
            return $matches[1] . ' id="' . esc_attr($heading['id']) . '"' . $matches[3] . $matches[4] . $matches[5];
        },
        $content
    );
    
    return $content;
}

/**
 * تولید HTML فهرست مطالب
 * 
 * @param string $content محتوای صفحه
 * @return string|false HTML فهرست مطالب یا false
 */
function d_theme_generate_toc($content = '') {
    $headings = d_theme_extract_headings($content);
    
    if (empty($headings)) {
        return false;
    }
    
    $output = '<nav class="table-of-contents" id="toc" aria-label="فهرست مطالب">';
    $output .= '<div class="toc-header">';
    $output .= '<h2 class="toc-title">فهرست مطالب</h2>';
    $output .= '<button class="toc-toggle" aria-label="بستن/باز کردن فهرست" aria-expanded="true">';
    $output .= '<span class="toc-toggle-icon">▼</span>';
    $output .= '</button>';
    $output .= '</div>';
    $output .= '<ul class="toc-list">';
    
    $current_level = 0;
    $open_lists = array();
    
    foreach ($headings as $heading) {
        $level = $heading['level'];
        
        // بستن لیست‌های باز شده
        while ($current_level >= $level && !empty($open_lists)) {
            $output .= '</ul>';
            array_pop($open_lists);
            $current_level--;
        }
        
        // باز کردن لیست جدید اگر لازم باشد
        if ($level > $current_level) {
            while ($current_level < $level) {
                $output .= '<ul class="toc-sublist toc-level-' . ($current_level + 1) . '">';
                $open_lists[] = $current_level + 1;
                $current_level++;
            }
        }
        
        // اضافه کردن آیتم
        $output .= '<li class="toc-item toc-level-' . $level . '">';
        $output .= '<a href="' . esc_url($heading['anchor']) . '" class="toc-link" data-target="' . esc_attr($heading['id']) . '">';
        $output .= esc_html($heading['text']);
        $output .= '</a>';
        $output .= '</li>';
    }
    
    // بستن همه لیست‌های باز
    while (!empty($open_lists)) {
        $output .= '</ul>';
        array_pop($open_lists);
    }
    
    $output .= '</ul>';
    $output .= '</nav>';
    
    return $output;
}

/**
 * فیلتر محتوا برای اضافه کردن anchor
 */
function d_theme_filter_content_toc($content) {
    if (!is_singular() || !d_theme_needs_toc($content)) {
        return $content;
    }
    
    return d_theme_add_toc_anchors($content);
}
add_filter('the_content', 'd_theme_filter_content_toc', 20);

