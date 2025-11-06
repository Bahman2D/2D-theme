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
 * بررسی نیاز به TOC
 * 
 * @param string $content محتوای صفحه
 * @return bool true اگر حداقل 3 heading وجود دارد
 */
function d_theme_needs_toc($content = '') {
    if (empty($content)) {
        global $post;
        if ($post) {
            $content = $post->post_content;
        } else {
            return false;
        }
    }
    
    // استخراج headings
    preg_match_all('/<h[2-4][^>]*>(.*?)<\/h[2-4]>/i', $content, $matches);
    
    // حداقل 3 heading لازم است
    return count($matches[0]) >= 3;
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
            $content = apply_filters('the_content', $post->post_content);
        } else {
            return array();
        }
    }
    
    $headings = array();
    $counter = 0;
    
    // استخراج H2, H3, H4
    preg_match_all('/<h([2-4])[^>]*>(.*?)<\/h[2-4]>/i', $content, $matches, PREG_SET_ORDER);
    
    foreach ($matches as $match) {
        $level = (int) $match[1];
        $text = strip_tags($match[2]);
        $text = trim($text);
        
        if (empty($text)) {
            continue;
        }
        
        // ایجاد ID منحصر به فرد
        $id = 'toc-' . sanitize_title($text) . '-' . $counter;
        $counter++;
        
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
    
    $counter = 0;
    
    // اضافه کردن id به هر heading
    foreach ($headings as $heading) {
        $pattern = '/<h' . $heading['level'] . '[^>]*>' . preg_quote($heading['text'], '/') . '<\/h' . $heading['level'] . '>/i';
        
        // اگر id وجود نداشت، اضافه کن
        $replacement = '<h' . $heading['level'] . ' id="' . esc_attr($heading['id']) . '">' . $heading['text'] . '</h' . $heading['level'] . '>';
        
        $content = preg_replace(
            '/(<h' . $heading['level'] . ')([^>]*>)(.*?)(<\/h' . $heading['level'] . '>)/is',
            function($matches) use ($heading) {
                // بررسی وجود id
                if (strpos($matches[2], 'id=') !== false) {
                    return $matches[0]; // id موجود است
                }
                return $matches[1] . ' id="' . esc_attr($heading['id']) . '"' . $matches[2] . $matches[3] . $matches[4];
            },
            $content,
            1
        );
    }
    
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

