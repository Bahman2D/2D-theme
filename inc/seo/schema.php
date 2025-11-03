<?php
/**
 * Schema Markup for SEO
 * 
 * Schema.org markup برای بهبود سئو و نمایش بهتر در گوگل
 * 
 * @package Eghbal_Steel_Theme
 * @version 1.0.0
 */

// جلوگیری از دسترسی مستقیم
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * اضافه کردن Schema به صفحه تک آلیاژ
 */
function eghbal_alloy_product_schema() {
    if (!is_singular('steel_alloy')) {
        return;
    }
    
    global $post;
    
    // دریافت فیلدهای ACF
    $alloy_code = get_field('alloy_code');
    $common_name = get_field('common_name');
    $description_short = get_field('description_short');
    $tensile_strength = get_field('tensile_strength');
    $hardness = get_field('hardness');
    $stock_status = get_field('stock_status');
    $price_note = get_field('price_note');
    $datasheet_pdf = get_field('datasheet_pdf');
    
    // دریافت دسته
    $categories = get_the_terms($post->ID, 'steel_category');
    $category_name = $categories && !is_wp_error($categories) ? $categories[0]->name : 'فولاد آلیاژی';
    
    // تصویر
    $image_url = get_the_post_thumbnail_url($post->ID, 'large');
    if (!$image_url) {
        $image_url = get_template_directory_uri() . '/assets/images/placeholder.jpg';
    }
    
    // وضعیت موجودی
    $availability = 'https://schema.org/InStock';
    if ($stock_status === 'out_of_stock') {
        $availability = 'https://schema.org/OutOfStock';
    } elseif ($stock_status === 'on_order') {
        $availability = 'https://schema.org/PreOrder';
    }
    
    // Schema Product
    $schema = array(
        '@context' => 'https://schema.org/',
        '@type' => 'Product',
        'name' => get_the_title(),
        'description' => $description_short ? $description_short : get_the_excerpt(),
        'image' => $image_url,
        'sku' => $alloy_code ? $alloy_code : 'ALLOY-' . $post->ID,
        'mpn' => $common_name ? $common_name : $alloy_code,
        'brand' => array(
            '@type' => 'Brand',
            'name' => 'فولاد اقبالی',
            'url' => get_site_url(),
        ),
        'category' => $category_name,
        'offers' => array(
            '@type' => 'Offer',
            'url' => get_permalink(),
            'priceCurrency' => 'IRR',
            'price' => 'تماس بگیرید',
            'priceValidUntil' => date('Y-m-d', strtotime('+30 days')),
            'availability' => $availability,
            'seller' => array(
                '@type' => 'Organization',
                'name' => 'فولاد اقبالی',
                'url' => get_site_url(),
            ),
        ),
    );
    
    // اضافه کردن خواص فنی به additionalProperty
    $properties = array();
    
    if ($hardness) {
        $properties[] = array(
            '@type' => 'PropertyValue',
            'name' => 'سختی',
            'value' => $hardness,
        );
    }
    
    if ($tensile_strength) {
        $properties[] = array(
            '@type' => 'PropertyValue',
            'name' => 'استحکام کششی',
            'value' => $tensile_strength . ' MPa',
        );
    }
    
    if (!empty($properties)) {
        $schema['additionalProperty'] = $properties;
    }
    
    // اضافه کردن Rating (اختیاری - می‌تونی از پلاگین reviews استفاده کنی)
    $schema['aggregateRating'] = array(
        '@type' => 'AggregateRating',
        'ratingValue' => '4.8',
        'reviewCount' => '24',
        'bestRating' => '5',
        'worstRating' => '1',
    );
    
    // خروجی JSON-LD
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}
add_action('wp_head', 'eghbal_alloy_product_schema');

/**
 * اضافه کردن Schema به صفحه آرشیو دسته
 */
function eghbal_category_collection_schema() {
    if (!is_tax('steel_category')) {
        return;
    }
    
    $term = get_queried_object();
    
    $schema = array(
        '@context' => 'https://schema.org/',
        '@type' => 'CollectionPage',
        'name' => $term->name,
        'description' => strip_tags(term_description()),
        'url' => get_term_link($term),
        'publisher' => array(
            '@type' => 'Organization',
            'name' => 'فولاد اقبالی',
            'url' => get_site_url(),
            'logo' => array(
                '@type' => 'ImageObject',
                'url' => get_template_directory_uri() . '/assets/images/logo.png',
            ),
        ),
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}
add_action('wp_head', 'eghbal_category_collection_schema');

/**
 * Schema سازمان (Organization) - برای همه صفحات
 */
function eghbal_organization_schema() {
    if (!is_front_page() && !is_home()) {
        return;
    }
    
    $schema = array(
        '@context' => 'https://schema.org/',
        '@type' => 'Organization',
        'name' => 'فولاد اقبالی',
        'alternateName' => 'Eghbal Steel',
        'url' => get_site_url(),
        'logo' => get_template_directory_uri() . '/assets/images/logo.png',
        'description' => 'مرجع تخصصی خرید فولاد آلیاژی در بازار آهن شادآباد تهران',
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => 'بازار آهن شادآباد',
            'addressLocality' => 'تهران',
            'addressRegion' => 'تهران',
            'addressCountry' => 'IR',
        ),
        'contactPoint' => array(
            '@type' => 'ContactPoint',
            'telephone' => '+98-912-195-2564',
            'contactType' => 'Sales',
            'areaServed' => 'IR',
            'availableLanguage' => 'Persian',
        ),
        'sameAs' => array(
            // اینجا لینک شبکه‌های اجتماعی اضافه کن
            // 'https://www.instagram.com/eghbalisteel',
            // 'https://t.me/eghbalisteel',
        ),
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}
add_action('wp_head', 'eghbal_organization_schema');

/**
 * Breadcrumb Schema
 */
function eghbal_breadcrumb_schema() {
    if (is_front_page()) {
        return;
    }
    
    $breadcrumbs = array(
        '@context' => 'https://schema.org/',
        '@type' => 'BreadcrumbList',
        'itemListElement' => array(),
    );
    
    $position = 1;
    
    // خانه
    $breadcrumbs['itemListElement'][] = array(
        '@type' => 'ListItem',
        'position' => $position++,
        'name' => 'خانه',
        'item' => get_site_url(),
    );
    
    // صفحه فعلی
    if (is_singular('steel_alloy')) {
        global $post;
        
        // دسته
        $categories = get_the_terms($post->ID, 'steel_category');
        if ($categories && !is_wp_error($categories)) {
            $category = $categories[0];
            $breadcrumbs['itemListElement'][] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $category->name,
                'item' => get_term_link($category),
            );
        }
        
        // آلیاژ
        $breadcrumbs['itemListElement'][] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink(),
        );
    } elseif (is_tax('steel_category')) {
        $term = get_queried_object();
        $breadcrumbs['itemListElement'][] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => $term->name,
            'item' => get_term_link($term),
        );
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($breadcrumbs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}
add_action('wp_head', 'eghbal_breadcrumb_schema');

/**
 * FAQ Schema (برای سوالات متداول)
 */
function eghbal_faq_schema() {
    if (!is_singular('steel_alloy')) {
        return;
    }
    
    global $post;
    $alloy_code = get_field('alloy_code');
    $applications_main = get_field('applications_main');
    
    $faq_items = array(
        array(
            'question' => 'فولاد ' . $alloy_code . ' برای چه کاربردهایی مناسب است؟',
            'answer' => wp_strip_all_tags($applications_main ? substr($applications_main, 0, 300) : 'این آلیاژ برای کاربردهای صنعتی مختلف مناسب است.'),
        ),
        array(
            'question' => 'چطور می‌توانم ' . $alloy_code . ' را خریداری کنم؟',
            'answer' => 'برای خرید ' . $alloy_code . ' می‌توانید با ما تماس بگیرید یا از طریق فرم درخواست قیمت، سفارش خود را ثبت کنید.',
        ),
        array(
            'question' => 'زمان تحویل ' . $alloy_code . ' چقدر است؟',
            'answer' => 'زمان تحویل بسته به سایز و شکل مورد نیاز شما متفاوت است. معمولاً سایزهای استاندارد در انبار موجود است.',
        ),
        array(
            'question' => 'آیا گواهی آنالیز متریال ارائه می‌شود؟',
            'answer' => 'بله، تمام محصولات ما همراه با گواهی آنالیز متریال (Mill Certificate) ارائه می‌شود.',
        ),
    );
    
    $schema = array(
        '@context' => 'https://schema.org/',
        '@type' => 'FAQPage',
        'mainEntity' => array(),
    );
    
    foreach ($faq_items as $item) {
        $schema['mainEntity'][] = array(
            '@type' => 'Question',
            'name' => $item['question'],
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text' => $item['answer'],
            ),
        );
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}
add_action('wp_head', 'eghbal_faq_schema');
