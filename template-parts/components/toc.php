<?php
/**
 * Template Part: Table of Contents
 * 
 * فهرست مطالب - Responsive با sticky sidebar در دسکتاپ
 * 
 * @package D_Theme
 * @version 1.0.0
 */

global $post;

if (!$post) {
    return;
}

$content = apply_filters('the_content', $post->post_content);

// بررسی نیاز به TOC
if (!d_theme_needs_toc($content)) {
    return;
}

// استخراج headings
$headings = d_theme_extract_headings($content);

if (empty($headings)) {
    return;
}

// تولید TOC HTML
$toc_html = d_theme_generate_toc($content);

if (!$toc_html) {
    return;
}

// نمایش TOC
echo $toc_html;

