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

// اگر post موجود نبود، از queried object استفاده کن
if (!$post) {
    $queried_object = get_queried_object();
    if ($queried_object && isset($queried_object->post_content)) {
        $post = $queried_object;
    } else {
        return;
    }
}

// گرفتن محتوای کامل (شامل headings از template parts)
$content = d_theme_get_full_content_for_toc();

if (empty($content)) {
    return;
}

// بررسی نیاز به TOC
if (!d_theme_needs_toc($content)) {
    return;
}

// تولید TOC HTML
$toc_html = d_theme_generate_toc($content);

if (empty($toc_html)) {
    return;
}

// نمایش TOC
echo $toc_html;

