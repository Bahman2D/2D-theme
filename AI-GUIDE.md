# 🤖 راهنمای AI برای قالب D-Theme

> **PROMPT برای AI Agents:**
> "هنگام کار با این قالب، تمام تغییرات را در این فایل ثبت کن. ساختار قالب، توابع کمکی، و کانونشن‌های نام‌گذاری را رعایت کن. هر فایل جدیدی که می‌سازی باید مطابق با استانداردها و ساختار موجود باشد."

---

## 📋 فهرست مطالب
1. [ساختار کلی قالب](#-ساختار-کلی-قالب)
2. [سیستم فایل‌ها](#-سیستم-فایلها)
3. [توابع کمکی مهم](#-توابع-کمکی-مهم)
4. [کانونشن‌های نامگذاری](#-کانونشنهای-نامگذاری)
5. [سیستم Caching](#-سیستم-caching)
6. [تمپلیت‌ها](#-تمپلیتها)
7. [Customizer](#-customizer)
8. [امنیت](#-امنیت)
9. [SEO](#-seo)
10. [بهینه‌سازی Performance](#-بهینهسازی-performance)

---

## 📁 ساختار کلی قالب

```
D-theme/
├── assets/
│   ├── css/                    # فایل‌های CSS
│   │   ├── variables.css       # CSS Variables (رنگ‌ها، فاصله‌ها)
│   │   ├── main.css            # استایل‌های اصلی
│   │   ├── components.css      # کامپوننت‌ها
│   │   ├── header.css          # هدر
│   │   ├── footer.css          # فوتر
│   │   ├── hero.css            # Hero slider
│   │   ├── taxonomy.css        # [جدید] Taxonomy pages
│   │   ├── alloy.css           # [جدید] آلیاژها
│   │   ├── blog.css            # [جدید] بلاگ
│   │   ├── single.css          # [جدید] نوشته‌ها
│   │   ├── toc.css             # [جدید] فهرست مطالب
│   │   ├── faq.css             # [جدید] FAQ
│   │   └── comments.css        # [جدید] کامنت‌ها
│   ├── js/                     # فایل‌های JavaScript
│   │   ├── main.js             # اسکریپت اصلی
│   │   ├── menu.js             # منوی موبایل
│   │   ├── search.js           # جستجو
│   │   ├── toggle.js           # حالت تاریک/روشن
│   │   ├── hero-slider.js      # اسلایدر hero
│   │   ├── toc.js              # [جدید] فهرست مطالب
│   │   └── faq.js              # [جدید] FAQ
│   ├── fonts/                  # فونت‌های فارسی
│   └── images/                 # تصاویر
├── inc/                        # فایل‌های PHP کمکی
│   ├── customizer/             # تنظیمات Customizer
│   │   ├── customizer.php      # تنظیمات اصلی
│   │   ├── colors.php          # رنگ‌ها
│   │   ├── logo.php            # لوگو
│   │   └── hero.php            # Hero slider
│   ├── helpers/                # توابع کمکی
│   │   ├── helpers.php         # توابع عمومی
│   │   ├── color-helper.php    # کمک‌کننده رنگ
│   │   ├── schema.php          # Schema markup
│   │   ├── svg-support.php     # پشتیبانی SVG
│   │   ├── performance.php     # بهینه‌سازی
│   │   ├── toc-helper.php      # [جدید] فهرست مطالب
│   │   └── seo-helper.php      # [جدید] SEO helpers
│   ├── menus/                  # منوها
│   │   ├── menu-setup.php      # تنظیمات منو
│   │   └── menu-walker.php     # Walker سفارشی
│   ├── metaboxes/              # متاباکس‌ها
│   │   ├── faq-metabox.php     # [جدید] متاباکس FAQ
│   │   └── alloy-metabox.php   # [جدید] متاباکس آلیاژ
│   ├── taxonomies/             # [جدید] Taxonomy ها
│   │   └── page-category.php   # Taxonomy صفحات
│   └── persian-date.php        # تاریخ شمسی
├── template-parts/             # بخش‌های تمپلیت
│   ├── home/
│   │   ├── hero-slider.php     # اسلایدر صفحه اصلی
│   │   └── breadcrumbs.php     # مسیر یابی
│   └── components/             # [جدید] کامپوننت‌ها
│       ├── toc.php             # فهرست مطالب
│       └── faq.php             # سوالات متداول
├── functions.php               # توابع اصلی قالب
├── style.css                   # فایل اصلی استایل (meta info)
├── header.php                  # هدر
├── footer.php                  # فوتر
├── front-page.php              # صفحه اصلی
├── index.php                   # صفحه پیش‌فرض
├── single.php                  # [جدید] تمپلیت نوشته‌ها
├── page-blog.php               # [جدید] تمپلیت بلاگ
├── page-alloy.php              # [جدید] تمپلیت آلیاژها
├── taxonomy-page_category.php  # [جدید] تمپلیت کتگوری صفحات
├── comments.php                # [جدید] کامنت‌ها
└── AI-GUIDE.md                 # همین فایل!
```

---

## 🗂️ سیستم فایل‌ها

### فایل‌های اصلی

#### `functions.php`
فایل اصلی قالب که شامل:
- `d_theme_setup()` - تنظیمات اولیه
- `d_theme_enqueue_assets()` - بارگذاری CSS/JS
- `d_theme_widgets_init()` - ثبت sidebar ها
- Cache management functions

#### `header.php`
شامل:
- HTML head با resource hints
- منوی اصلی و موبایل
- جستجوی مدال
- لوگوی کش شده

#### `footer.php`
شامل:
- فوتر دسکتاپ 4 ستونی
- منوی چسبان موبایل
- سال کش شده

### تمپلیت‌ها

#### موجود:
- `front-page.php` - صفحه اصلی
- `index.php` - صفحه پیش‌فرض

#### موجود (جدید):
- `single.php` - تمپلیت نوشته‌ها با TOC و FAQ
- `page-blog.php` - تمپلیت بلاگ
- `page-alloy.php` - تمپلیت آلیاژها
- `taxonomy-page_category.php` - تمپلیت کتگوری صفحات
- `comments.php` - سیستم کامنت سفارشی

#### نیاز به ساخت (اختیاری):
- `archive.php` - آرشیو
- `search.php` - نتایج جستجو
- `404.php` - صفحه خطا

---

## 🛠️ توابع کمکی مهم

### Caching Functions (inc/helpers/helpers.php)

```php
// گرفتن مقدار کش شده با callback
d_theme_get_cached($key, $callback, $expiration);

// تنظیم کش
d_theme_set_cached($key, $value, $expiration);

// حذف کش
d_theme_delete_cached($key);

// پاک کردن همه کش‌های قالب
d_theme_clear_all_cache();

// سال جاری کش شده
d_theme_get_current_year();

// URL های لوگو کش شده
d_theme_get_cached_logo_urls();
```

### Theme Mod Helpers

```php
// گرفتن theme mod کش شده
d_theme_get_cached_mod($key, $default);
```

### Sanitization Functions

```php
// Sanitize ورودی با انواع مختلف
d_theme_sanitize_input($input, $type = 'text');
// Types: text, email, url, int, float, textarea, html

// اعتبارسنجی URL
d_theme_validate_url($url);

// بررسی nonce
d_theme_verify_nonce($action, $nonce);
```

### Utility Functions

```php
// محاسبه زمان مطالعه
d_theme_reading_time($content);

// کوتاه کردن متن
d_theme_truncate($text, $length, $more);

// دریافت excerpt سفارشی
d_theme_get_excerpt($length, $post_id);

// تبدیل اعداد به فارسی
d_theme_persian_numbers($number);

// زمان نسبی
d_theme_time_ago($time);
```

### TOC Functions (inc/helpers/toc-helper.php)

```php
// تولید فهرست مطالب از محتوا
d_theme_generate_toc($content);

// اضافه کردن anchor به headings
d_theme_add_toc_anchors($content);

// بررسی نیاز به TOC (حداقل 3 heading)
d_theme_needs_toc($content);
```

### SEO Functions (inc/helpers/seo-helper.php)

```php
// عنوان SEO بهینه
d_theme_get_seo_title($post);

// توضیحات SEO
d_theme_get_seo_description($post);

// تصویر OG
d_theme_get_og_image($post);

// URL canonical
d_theme_get_canonical_url();

// نوع OG (article, website, product, etc.)
d_theme_get_og_type();

// اضافه کردن Schema markup
d_theme_add_schema_markup($post, $type);
```

---

## 📝 کانونشن‌های نامگذاری

### PHP Functions
- **Prefix**: همه توابع با `d_theme_` شروع می‌شوند
- **Format**: `d_theme_action_subject()`
- مثال: `d_theme_get_cached_logo()`, `d_theme_add_schema()`

### CSS Classes
- **BEM style**: `block__element--modifier`
- **Prefix**: برای کلاس‌های خاص قالب از prefix استفاده نشود
- مثال: `hero-slide`, `mobile-menu`, `footer-col`

### JavaScript
- **IIFE pattern**: همه فایل‌های JS در IIFE
- **Namespace**: `window.dTheme` برای API عمومی
- **camelCase**: برای نام توابع

### CSS Variables
```css
:root {
    --primary: #3b82f6;
    --secondary: #64748b;
    --accent: #ff8800;
    --space-1: 0.25rem;
    /* ... */
}
```

### Taxonomy
- **Prefix**: `page_category` برای taxonomy صفحات
- **Slug**: `page-cat`
- **Hierarchical**: بله (سلسله مراتبی)

### Metabox Fields
- **Prefix**: `d_theme_` برای فیلدهای سفارشی
- مثال: `d_theme_faq_items`, `d_theme_alloy_specs`

---

## 💾 سیستم Caching

### مکانیزم کش
قالب از WordPress Transients API استفاده می‌کند:

```php
// کش برای 1 ساعت
$data = d_theme_get_cached('my_key', function() {
    return expensive_operation();
}, HOUR_IN_SECONDS);
```

### موارد کش شده:
- سال جاری (`current_year`) - 1 روز
- URL های لوگو (`logo_urls`) - 1 روز
- اسلایدهای فعال hero (`hero_active_slides`) - 1 ساعت
- پیشنهادات جستجو (`search_suggestions`) - 1 ساعت

### پاک کردن خودکار کش:
- بعد از ذخیره Customizer
- بعد از تغییر theme options

---

## 🎨 Customizer

### ساختار Panel
```
d_theme_options (Panel اصلی)
├── d_theme_general (تنظیمات عمومی)
├── d_theme_colors (رنگ‌ها)
├── d_theme_hero (Hero Slider)
└── d_theme_social (شبکه‌های اجتماعی)
```

### اضافه کردن Setting جدید

```php
// در inc/customizer/
$wp_customize->add_setting('setting_key', array(
    'default' => 'default_value',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'refresh', // یا 'postMessage' برای live preview
));

$wp_customize->add_control('setting_key', array(
    'label' => __('عنوان', 'd-theme'),
    'section' => 'd_theme_section',
    'type' => 'text',
));
```

---

## 🔒 امنیت

### Escaping Output
```php
esc_html($text);           // برای متن ساده
esc_attr($attr);           // برای attributes
esc_url($url);             // برای URL ها
esc_js($string);           // برای JavaScript
wp_kses_post($html);       // برای HTML امن
```

### Sanitizing Input
```php
sanitize_text_field($input);
sanitize_textarea_field($input);
sanitize_email($email);
absint($number);
```

### Nonces
```php
// ایجاد
wp_create_nonce('action_name');

// بررسی
wp_verify_nonce($nonce, 'action_name');

// استفاده در فرم
wp_nonce_field('action_name', 'nonce_field_name');
```

### امنیت SVG
فایل `inc/helpers/svg-support.php` محتوای SVG را بررسی می‌کند:
- جلوگیری از `<script>`
- جلوگیری از `javascript:`
- جلوگیری از event handlers

---

## 🎯 SEO - راهنمای کامل

### Meta Tags (در header.php):
همه صفحات شامل:
- Title (optimized با `d_theme_get_seo_title()`)
- Description (با `d_theme_get_seo_description()`)
- Canonical URL (با `d_theme_get_canonical_url()`)
- Robots meta
- Open Graph tags (og:title, og:description, og:image, og:url, og:type)
- Twitter Card tags

### Schema Types:
- **صفحه اصلی**: WebSite + Organization
- **نوشته**: Article یا BlogPosting
- **صفحه**: WebPage
- **آلیاژ**: Product
- **بلاگ**: Blog + ItemList
- **کتگوری**: CollectionPage
- **FAQ**: FAQPage (در صورت وجود)
- **Breadcrumb**: BreadcrumbList (همه صفحات)
- **Comments**: Comment (در صورت وجود)

### Schema Markup
از `inc/helpers/schema.php` و `seo-helper.php` استفاده کنید:

```php
// Schema برای مقاله
d_theme_article_schema($post_id);

// Schema برای breadcrumb
d_theme_breadcrumb_schema();

// Schema برای سازمان
d_theme_organization_schema();

// Schema عمومی
d_theme_add_schema_markup($post, 'Article');
```

### Breadcrumbs
```php
d_theme_breadcrumb(); // با schema markup
```

### Image Optimization:
- Alt text اجباری
- Width & height attributes
- Lazy loading
- Responsive images (srcset)
- WebP support

### Content SEO:
- Heading hierarchy صحیح (H1 → H2 → H3)
- Internal linking
- External links با `rel="noopener"`
- زمان مطالعه
- تاریخ انتشار و بروزرسانی

### Performance SEO:
- Core Web Vitals
- Mobile-first
- Fast loading (<3s)
- No layout shift (CLS)

## 📑 فهرست مطالب (TOC)

### قوانین نمایش TOC:
- حداقل 3 heading (H2, H3, H4) لازم است
- فقط H2, H3, H4 استخراج می‌شود
- H1 استفاده نمی‌شود (عنوان صفحه)

### Responsive Behavior:
- **موبایل (<768px)**: Accordion در بالای محتوا، قابل جمع شدن
- **دسکتاپ (>=768px)**: Sticky sidebar، همیشه visible
- **تبلت (768-1024px)**: مانند دسکتاپ اما فونت کوچکتر

### JavaScript Features:
- Smooth scroll با offset برای fixed header
- Highlight active section on scroll
- LocalStorage برای ذخیره وضعیت باز/بسته
- Intersection Observer برای تشخیص active section

### استفاده:
```php
<?php 
$content = get_the_content();
if (d_theme_needs_toc($content)) : 
    get_template_part('template-parts/components/toc');
endif; 
?>
```

## ❓ سوالات متداول (FAQ)

### متاباکس FAQ:
در admin panel، متاباکس FAQ در تمام post types موجود است:
- افزودن سوال و جواب
- ترتیب‌دهی با drag & drop
- فعال/غیرفعال سازی

### Schema Markup:
تمام FAQ ها با schema FAQPage مارک می‌شوند:
```json
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [{
    "@type": "Question",
    "name": "سوال",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "جواب"
    }
  }]
}
```

### استفاده:
```php
<?php 
$faqs = get_post_meta($post->ID, 'd_theme_faq_items', true);
if (!empty($faqs)) {
    get_template_part('template-parts/components/faq');
}
?>
```

## 🏗️ ساخت Taxonomy برای صفحات

### ثبت Taxonomy:
```php
register_taxonomy('page_category', 'page', [
    'hierarchical' => true,
    'label' => 'دسته‌بندی صفحات',
    'show_in_rest' => true,
    'rewrite' => ['slug' => 'page-cat'],
]);
```

### استفاده:
```php
// گرفتن دسته‌های یک صفحه
$terms = get_the_terms($post->ID, 'page_category');

// نمایش صفحات یک دسته
// از taxonomy-page_category.php استفاده می‌شود
```

## 💬 سیستم Comments

### ویژگی‌ها:
- Nested comments (تا 3 سطح)
- طراحی سفارشی فارسی
- تاریخ شمسی
- آواتار Gravatar
- Schema Comment markup
- AJAX loading (optional)

### فعال‌سازی:
```php
<?php
if (comments_open() || get_comments_number()) {
    comments_template();
}
?>
```

### CSS Classes:
- `.comments-area`
- `.comment-list`
- `.comment-item`
- `.comment-author`
- `.comment-content`
- `.comment-reply`

---

## ⚡ بهینه‌سازی Performance

### بهینه‌سازی‌های فعال:

1. **Asset Loading**
   - Conditional loading (فقط در صفحات مورد نیاز)
   - Defer برای JavaScript
   - Preload برای فونت‌ها
   - Resource hints (dns-prefetch, preconnect)

2. **Database**
   - کش theme_mods
   - کش query های سنگین
   - Transient API

3. **Images**
   - Lazy loading خودکار
   - Responsive images (srcset)
   - WebP support

4. **Scripts غیرضروری**
   - حذف Emoji scripts
   - حذف Embed scripts
   - حذف jQuery Migrate
   - حذف Dashicons برای non-logged-in users

5. **Heartbeat API**
   - کاهش فرکانس
   - غیرفعال در frontend

---

## 📱 Responsive Design

### Breakpoints
```css
/* Mobile First */
/* Default: 0-767px */

/* Tablet */
@media (min-width: 768px) { }

/* Desktop */
@media (min-width: 1024px) { }

/* Large Desktop */
@media (min-width: 1400px) { }
```

### منوی موبایل
- منوی کشویی در موبایل
- منوی sticky در پایین
- 5 آیتم: خانه، محصولات، منو، بلاگ، تماس

### TOC Responsive:
- موبایل: accordion در بالا، collapsed به صورت پیش‌فرض
- تبلت: sidebar راست، sticky
- دسکتاپ: sidebar راست، sticky با scroll

### Comments Responsive:
- موبایل: stack vertically
- دسکتاپ: nested layout

---

## 🔄 تغییرات اخیر

### ✅ انجام شده (2025-01-06):
1. بهینه‌سازی performance
2. اضافه کردن سیستم caching
3. رفع N+1 query در menu walker
4. بهبود امنیت با validation بهتر
5. رفع باگ hero customizer

### ✅ در حال انجام (2025-01-06):
1. اضافه کردن taxonomy برای صفحات
2. ساخت تمپلیت‌های کامل با TOC و FAQ
3. سیستم SEO جامع
4. Schema markup برای همه صفحات
5. کامپوننت‌های قابل استفاده مجدد

### 📝 فایل‌های جدید:

**PHP**:
- `inc/taxonomies/page-category.php` - Taxonomy صفحات
- `inc/helpers/toc-helper.php` - فهرست مطالب
- `inc/helpers/seo-helper.php` - SEO helpers
- `inc/metaboxes/faq-metabox.php` - متاباکس FAQ
- `inc/metaboxes/alloy-metabox.php` - متاباکس آلیاژ
- `template-parts/components/toc.php` - کامپوننت TOC
- `template-parts/components/faq.php` - کامپوننت FAQ
- `taxonomy-page_category.php` - تمپلیت کتگوری
- `page-alloy.php` - تمپلیت آلیاژها
- `page-blog.php` - تمپلیت بلاگ
- `single.php` - تمپلیت نوشته‌ها
- `comments.php` - سیستم کامنت

**CSS**:
- `assets/css/taxonomy.css`
- `assets/css/alloy.css`
- `assets/css/blog.css`
- `assets/css/single.css`
- `assets/css/toc.css`
- `assets/css/faq.css`
- `assets/css/comments.css`

**JavaScript**:
- `assets/js/toc.js`
- `assets/js/faq.js`

---

## 🎯 دستورالعمل‌های ساخت تمپلیت جدید

### الگوی استاندارد تمپلیت:

```php
<?php
/**
 * Template Name: نام تمپلیت
 * Description: توضیحات تمپلیت
 * 
 * @package D_Theme
 * @version 1.0.0
 */

get_header(); ?>

<main class="site-main" id="main" role="main">
    
    <!-- Breadcrumbs -->
    <?php d_theme_breadcrumb(); ?>
    
    <div class="container">
        <?php
        while (have_posts()) : the_post();
            // محتوای تمپلیت
        endwhile;
        ?>
    </div>
    
</main>

<?php get_footer(); ?>
```

### ویژگی‌های ضروری هر تمپلیت:
1. ✅ Breadcrumbs با schema
2. ✅ Responsive design
3. ✅ Semantic HTML
4. ✅ Accessibility (ARIA labels)
5. ✅ SEO optimized
6. ✅ Schema markup
7. ✅ Meta tags مناسب
8. ✅ Comments (در صورت نیاز)
9. ✅ FAQ section (در صورت نیاز)
10. ✅ TOC (برای محتوای طولانی)

---

## 📞 Hooks و Filters

### Theme Hooks:
```php
do_action('d_theme_before_header');
do_action('d_theme_after_header');
do_action('d_theme_before_footer');
do_action('d_theme_after_footer');
```

### فیلترهای مهم:
```php
apply_filters('d_theme_excerpt_length', 30);
apply_filters('d_theme_excerpt_more', '...');
```

---

## 🧪 تست

### قبل از commit:
1. ✅ بررسی linter errors
2. ✅ تست در مرورگرهای مختلف
3. ✅ تست responsive
4. ✅ بررسی accessibility
5. ✅ تست عملکرد customizer
6. ✅ بررسی cache
7. ✅ تست SEO tags

---

## 📚 منابع

- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- [Theme Handbook](https://developer.wordpress.org/themes/)
- [Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/)
- [Transients API](https://developer.wordpress.org/apis/handbook/transients/)

---

**آخرین بروزرسانی**: 2025-01-06
**نسخه قالب**: 1.0.0

---

## 📋 Checklist هر تمپلیت

قبل از تکمیل هر تمپلیت، این موارد را بررسی کنید:

- [ ] Breadcrumbs با schema
- [ ] Schema Markup مناسب (Article, Product, Blog, etc.)
- [ ] Meta Tags (description, OG, Twitter)
- [ ] Canonical URL
- [ ] TOC (در صورت محتوای طولانی - حداقل 3 heading)
- [ ] FAQ Section (در صورت نیاز)
- [ ] Comments (در صورت نیاز)
- [ ] Responsive Design (Mobile-first)
- [ ] Semantic HTML (article, section, aside, nav)
- [ ] ARIA Labels برای accessibility
- [ ] Fast Loading
- [ ] Image Optimization (alt, lazy, srcset)
- [ ] Internal Linking
- [ ] Social Sharing (در صورت نیاز)

