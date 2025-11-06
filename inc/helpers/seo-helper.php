<?php
/**
 * SEO Helper Functions
 * 
 * توابع کمکی برای بهینه‌سازی SEO
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * دریافت عنوان SEO بهینه
 * 
 * @param WP_Post|int|null $post Post object یا ID
 * @return string عنوان SEO
 */
function d_theme_get_seo_title($post = null) {
    if (!$post) {
        global $post;
    }
    
    if (is_numeric($post)) {
        $post = get_post($post);
    }
    
    // اگر meta title وجود داشت
    $meta_title = $post ? get_post_meta($post->ID, '_seo_title', true) : '';
    if (!empty($meta_title)) {
        return $meta_title;
    }
    
    // استفاده از عنوان پست
    if ($post) {
        $title = get_the_title($post->ID);
    } elseif (is_home()) {
        $title = get_bloginfo('name');
    } elseif (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_archive()) {
        $title = get_the_archive_title();
    } elseif (is_search()) {
        $title = 'نتایج جستجو: ' . get_search_query();
    } elseif (is_404()) {
        $title = 'صفحه پیدا نشد - 404';
    } else {
        $title = get_bloginfo('name');
    }
    
    // اضافه کردن نام سایت در انتها (اختیاری)
    $site_name = get_bloginfo('name');
    if (!empty($site_name) && !is_front_page()) {
        $title .= ' | ' . $site_name;
    }
    
    return $title;
}

/**
 * دریافت توضیحات SEO
 * 
 * @param WP_Post|int|null $post Post object یا ID
 * @return string توضیحات SEO
 */
function d_theme_get_seo_description($post = null) {
    if (!$post) {
        global $post;
    }
    
    if (is_numeric($post)) {
        $post = get_post($post);
    }
    
    // اگر meta description وجود داشت
    $meta_desc = $post ? get_post_meta($post->ID, '_seo_description', true) : '';
    if (!empty($meta_desc)) {
        return $meta_desc;
    }
    
    // استفاده از excerpt یا محتوا
    if ($post) {
        $description = $post->post_excerpt;
        
        if (empty($description)) {
            $description = wp_trim_words(strip_shortcodes($post->post_content), 30, '...');
        }
    } elseif (is_category()) {
        $description = category_description();
    } elseif (is_tag()) {
        $description = tag_description();
    } elseif (is_archive()) {
        $description = get_the_archive_description();
    } else {
        $description = get_bloginfo('description');
    }
    
    // محدود کردن به 160 کاراکتر
    if (mb_strlen($description) > 160) {
        $description = mb_substr($description, 0, 157) . '...';
    }
    
    return $description;
}

/**
 * دریافت تصویر OG
 * 
 * @param WP_Post|int|null $post Post object یا ID
 * @return string URL تصویر
 */
function d_theme_get_og_image($post = null) {
    if (!$post) {
        global $post;
    }
    
    if (is_numeric($post)) {
        $post = get_post($post);
    }
    
    // اگر meta image وجود داشت
    $meta_image = $post ? get_post_meta($post->ID, '_og_image', true) : '';
    if (!empty($meta_image)) {
        return esc_url($meta_image);
    }
    
    // استفاده از featured image
    if ($post && has_post_thumbnail($post->ID)) {
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
        if ($image && isset($image[0])) {
            return esc_url($image[0]);
        }
    }
    
    // تصویر پیش‌فرض
    $default_image = get_template_directory_uri() . '/assets/images/og-default.jpg';
    
    return $default_image;
}

/**
 * دریافت URL Canonical
 * 
 * @return string URL canonical
 */
function d_theme_get_canonical_url() {
    global $wp;
    
    // اگر meta canonical وجود داشت
    if (is_singular()) {
        global $post;
        $canonical = get_post_meta($post->ID, '_canonical_url', true);
        if (!empty($canonical)) {
            return esc_url($canonical);
        }
    }
    
    // URL جاری
    $url = home_url(add_query_arg(array(), $wp->request));
    
    // حذف query strings غیرضروری
    $url = strtok($url, '?');
    
    return esc_url($url);
}

/**
 * دریافت نوع OG
 * 
 * @param WP_Post|int|null $post Post object یا ID
 * @return string نوع OG
 */
function d_theme_get_og_type($post = null) {
    if (!$post) {
        global $post;
    }
    
    if (is_numeric($post)) {
        $post = get_post($post);
    }
    
    if (is_front_page()) {
        return 'website';
    } elseif (is_singular('post')) {
        return 'article';
    } elseif (is_singular('page')) {
        // بررسی template
        $template = get_page_template_slug($post->ID);
        if ($template === 'page-alloy.php') {
            return 'product';
        }
        return 'website';
    } elseif (is_archive()) {
        return 'website';
    } else {
        return 'website';
    }
}

/**
 * اضافه کردن Schema Markup
 * 
 * @param WP_Post|int|null $post Post object یا ID
 * @param string $type نوع Schema (Article, Product, Blog, etc.)
 * @return void
 */
function d_theme_add_schema_markup($post = null, $type = 'Article') {
    if (!$post) {
        global $post;
    }
    
    if (is_numeric($post)) {
        $post = get_post($post);
    }
    
    if (!$post) {
        return;
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => $type,
    );
    
    // اطلاعات پایه
    $schema['headline'] = get_the_title($post->ID);
    $schema['description'] = d_theme_get_seo_description($post);
    $schema['url'] = get_permalink($post->ID);
    
    // تصویر
    $image = d_theme_get_og_image($post);
    if ($image) {
        $schema['image'] = array(
            '@type' => 'ImageObject',
            'url' => $image,
        );
    }
    
    // تاریخ‌ها
    $schema['datePublished'] = get_the_date('c', $post->ID);
    $schema['dateModified'] = get_the_modified_date('c', $post->ID);
    
    // نویسنده
    $author = get_userdata($post->post_author);
    if ($author) {
        $schema['author'] = array(
            '@type' => 'Person',
            'name' => $author->display_name,
            'url' => get_author_posts_url($author->ID),
        );
    }
    
    // Publisher
    $schema['publisher'] = array(
        '@type' => 'Organization',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
    );
    
    // Logo
    $logo = d_theme_get_cached_logo_urls();
    if ($logo && !empty($logo['dark'])) {
        $schema['publisher']['logo'] = array(
            '@type' => 'ImageObject',
            'url' => $logo['dark'],
        );
    }
    
    // خروجی JSON-LD
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}

/**
 * اضافه کردن Meta Tags به head
 */
function d_theme_add_seo_meta_tags() {
    global $post;
    
    // Title
    $title = d_theme_get_seo_title($post);
    echo '<title>' . esc_html($title) . '</title>' . "\n";
    
    // Description
    $description = d_theme_get_seo_description($post);
    if (!empty($description)) {
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    }
    
    // Canonical
    $canonical = d_theme_get_canonical_url();
    echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";
    
    // Robots
    $robots = 'index, follow';
    if (is_singular()) {
        $noindex = get_post_meta($post->ID, '_noindex', true);
        if ($noindex) {
            $robots = 'noindex, nofollow';
        }
    }
    echo '<meta name="robots" content="' . esc_attr($robots) . '">' . "\n";
    
    // Open Graph
    $og_type = d_theme_get_og_type($post);
    $og_title = d_theme_get_seo_title($post);
    $og_description = d_theme_get_seo_description($post);
    $og_image = d_theme_get_og_image($post);
    $og_url = d_theme_get_canonical_url();
    
    echo '<meta property="og:type" content="' . esc_attr($og_type) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($og_title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($og_description) . '">' . "\n";
    echo '<meta property="og:image" content="' . esc_url($og_image) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($og_url) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
    echo '<meta property="og:locale" content="fa_IR">' . "\n";
    
    // Twitter Card
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($og_title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($og_description) . '">' . "\n";
    echo '<meta name="twitter:image" content="' . esc_url($og_image) . '">' . "\n";
}
add_action('wp_head', 'd_theme_add_seo_meta_tags', 1);

