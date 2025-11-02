# 🎨 قالب D-Theme - نسخه 1.1.0

قالب وردپرس حرفه‌ای با تمرکز بر **سئو**، **پرفورمنس** و **قابلیت کاستومایز کامل**.

---

## 📋 فهرست مطالب

- [ویژگی‌ها](#-ویژگیها)
- [نصب و راه‌اندازی](#-نصب-و-راهاندازی)
- [کامپوننت‌ها](#-کامپوننتها)
- [سازگاری](#-سازگاری)
- [پیکربندی](#-پیکربندی)
- [Schema.org](#-schemaorg-markup)
- [بهینه‌سازی‌های پرفورمنس](#-بهینهسازیهای-پرفورمنس)
- [تغییرات اخیر](#-تغییرات-اخیر)
- [پشتیبانی](#-پشتیبانی)

---

## ✨ ویژگی‌ها

### 🎯 ویژگی‌های اصلی

#### 1. **سئو محور**
- ✅ Schema.org Markup کامل (Organization, WebSite, Article, Breadcrumb)
- ✅ بهینه‌سازی سرعت بارگذاری
- ✅ Lazy Loading خودکار تصاویر
- ✅ Clean و Semantic HTML5
- ✅ Meta Tags بهینه
- ✅ Sitemap خودکار

#### 2. **حالت شب و روز**
- 🌙 Dark Mode پیش‌فرض
- ☀️ Light Mode با یک کلیک
- 💾 ذخیره انتخاب کاربر در LocalStorage
- 🎨 رنگ‌های بهینه شده برای هر دو حالت
- 🖼️ پشتیبانی از لوگوی جداگانه برای هر حالت

#### 3. **سیستم رنگ گلوبال**
قابل تنظیم از Customizer:
- Primary Color
- Secondary Color
- Accent Color
- Success/Danger/Warning/Info Colors
- تمام رنگ‌های متن و پس‌زمینه

#### 4. **کامپوننت‌های قابل استفاده مجدد**
- 🔘 دکمه‌ها (Primary, Secondary, Accent, White, Outline)
- 📋 جداول (Table, Striped, Bordered)
- ⚡ آکاردئون (با انیمیشن و Accessibility)
- 📦 سکشن‌ها (Small, Medium, Large)
- 🔲 Grid System (1-4 ستون، ریسپانسیو)
- 🎯 کانتینرها (Standard, Small, Large, Fluid)
- 📱 Utilities (Hide/Show Mobile)

#### 5. **تاریخ شمسی**
- تبدیل خودکار همه تاریخ‌ها به شمسی
- در فرانت و بک‌اند
- سازگار با تمام فیلترهای وردپرس

#### 6. **پشتیبانی SVG**
- امکان آپلود فایل‌های SVG
- بررسی امنیتی خودکار
- فیلدهای Customizer برای آیکون‌ها
- پیش‌نمایش در Media Library

#### 7. **بهینه‌سازی پرفورمنس**
- Lazy Loading
- حذف کدهای غیرضروری WP
- Cache-Control Headers
- Resource Hints (Preconnect, DNS-Prefetch)
- Async/Defer Scripts
- بهینه‌سازی Database

---

## 📦 نصب و راه‌اندازی

### نصب از طریق ZIP
1. دانلود فایل ZIP قالب
2. ورود به پنل ادمین وردپرس
3. **ظاهر → قالب‌ها → افزودن**
4. بارگذاری ZIP و فعال‌سازی

### نصب دستی
1. استخراج فایل ZIP
2. کپی پوشه به `/wp-content/themes/`
3. فعال‌سازی از پنل ادمین

### پس از نصب
1. **ظاهر → سفارشی‌سازی** برای تنظیمات
2. آپلود لوگو (Dark و Light)
3. تنظیم رنگ‌ها
4. تنظیم Hero Slider
5. ایجاد منوها

---

## 🧩 کامپوننت‌ها

### دکمه‌ها

```html
<!-- دکمه Primary -->
<a href="#" class="btn btn-primary">دکمه اصلی</a>

<!-- دکمه Secondary -->
<button class="btn btn-secondary">دکمه ثانویه</button>

<!-- دکمه Accent -->
<button class="btn btn-accent">دکمه برجسته</button>

<!-- دکمه Outline -->
<a href="#" class="btn btn-outline">دکمه تو خالی</a>

<!-- سایزها -->
<button class="btn btn-primary btn-sm">کوچک</button>
<button class="btn btn-primary btn-lg">بزرگ</button>
```

### جداول

```html
<table class="table">
  <thead>
    <tr>
      <th>ستون 1</th>
      <th>ستون 2</th>
      <th>ستون 3</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>داده 1</td>
      <td>داده 2</td>
      <td>داده 3</td>
    </tr>
  </tbody>
</table>

<!-- جدول راه‌راه -->
<table class="table table-striped">...</table>

<!-- جدول با Border -->
<table class="table table-bordered">...</table>
```

### آکاردئون (سوالات متداول)

```html
<div class="accordion" data-single>
  <div class="accordion-item">
    <div class="accordion-header">
      <h3 class="accordion-title">سوال اول؟</h3>
      <svg class="accordion-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M7 10l5 5 5-5z"/>
      </svg>
    </div>
    <div class="accordion-content">
      <div class="accordion-body">
        پاسخ سوال اول در اینجا قرار می‌گیرد.
      </div>
    </div>
  </div>
  
  <div class="accordion-item">
    <div class="accordion-header">
      <h3 class="accordion-title">سوال دوم؟</h3>
      <svg class="accordion-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M7 10l5 5 5-5z"/>
      </svg>
    </div>
    <div class="accordion-content">
      <div class="accordion-body">
        پاسخ سوال دوم در اینجا قرار می‌گیرد.
      </div>
    </div>
  </div>
</div>
```

**ویژگی‌های آکاردئون:**
- `data-single`: فقط یک آیتم باز می‌ماند
- پشتیبانی کیبورد (Enter, Space)
- ARIA attributes کامل
- انیمیشن نرم

### بخش‌ها (Sections)

```html
<!-- بخش استاندارد -->
<section class="section section-primary">
  <div class="container">
    <h2 class="section-title">عنوان بخش</h2>
    <p class="section-subtitle">توضیحات کوتاه بخش</p>
    
    <div class="grid grid-cols-3">
      <div class="card">...</div>
      <div class="card">...</div>
      <div class="card">...</div>
    </div>
  </div>
</section>

<!-- بخش با تم تیره -->
<section class="section section-dark">
  <div class="container">
    <!-- محتوا -->
  </div>
</section>

<!-- بخش کوچک -->
<section class="section-sm section-secondary">
  <!-- محتوا -->
</section>
```

### Grid System

```html
<!-- 4 ستون در دسکتاپ، 2 ستون در تبلت، 1 ستون در موبایل -->
<div class="grid grid-cols-4">
  <div>آیتم 1</div>
  <div>آیتم 2</div>
  <div>آیتم 3</div>
  <div>آیتم 4</div>
</div>

<!-- 3 ستون -->
<div class="grid grid-cols-3">
  <div>آیتم 1</div>
  <div>آیتم 2</div>
  <div>آیتم 3</div>
</div>
```

---

## 🔌 سازگاری

### Advanced Custom Fields (ACF)
قالب کاملاً آماده برای استفاده با ACF:
```php
<?php
// نمایش فیلد سفارشی
if (function_exists('get_field')) {
    $custom_value = get_field('field_name');
    echo $custom_value;
}
?>
```

### Rank Math SEO
- Schema Markup قالب با Rank Math سازگار است
- می‌توانید یکی از دو را غیرفعال کنید

### LiteSpeed Cache
- قالب برای کار با LiteSpeed Cache بهینه شده
- از Cache-Control headers مناسب استفاده می‌کند

---

## ⚙️ پیکربندی

### تنظیمات Customizer

**مسیر:** `ظاهر → سفارشی‌سازی`

#### 1. هویت سایت
- لوگوی اصلی (Dark Mode)
- لوگوی حالت روز (Light Mode)
- ارتفاع لوگو (دسکتاپ و موبایل)

#### 2. رنگ‌ها
```
تنظیمات قالب D Theme → رنگ‌ها
```
- رنگ اصلی (Primary)
- رنگ ثانویه (Secondary)
- رنگ برجسته (Accent)

#### 3. Hero Slider
```
تنظیمات قالب D Theme → Hero Slider
```
- فعال/غیرفعال کردن
- تنظیم 3 اسلاید
- عنوان، متن، دکمه‌ها
- گرادینت و تصویر پس‌زمینه

#### 4. شبکه‌های اجتماعی
```
تنظیمات قالب D Theme → شبکه‌های اجتماعی
```
- تلگرام
- اینستاگرام
- واتساپ
- لینکدین
- توییتر

#### 5. آیکون‌های SVG
```
تنظیمات قالب D Theme → آیکون‌های SVG
```
- آیکون تلفن
- آیکون ایمیل
- آیکون موقعیت مکانی

### استفاده از رنگ‌های گلوبال در CSS

```css
.my-element {
  background: var(--primary);
  color: var(--text-primary);
  border: 1px solid var(--border-light);
}

/* در Dark Mode خودکار تغییر می‌کنند */
```

### متغیرهای CSS موجود

```css
/* رنگ‌ها */
--primary, --secondary, --accent
--success, --danger, --warning, --info

/* متن */
--text-primary, --text-secondary, --text-muted, --text-inverse

/* پس‌زمینه */
--bg-primary, --bg-secondary, --bg-tertiary, --bg-dark

/* Border */
--border-light, --border-medium, --border-dark

/* Shadow */
--shadow-xs, --shadow-sm, --shadow-md, --shadow-lg, --shadow-xl

/* Border Radius */
--radius-sm, --radius-md, --radius-lg, --radius-xl, --radius-full

/* Spacing */
--space-1 تا --space-32

/* Font Sizes */
--text-xs, --text-sm, --text-base, --text-lg, --text-xl
--text-2xl, --text-3xl, --text-4xl, --text-5xl, --text-6xl
```

---

## 🏷️ Schema.org Markup

قالب به صورت خودکار Schema های زیر را تولید می‌کند:

### Organization Schema (صفحه اصلی)
```json
{
  "@type": "Organization",
  "name": "نام سایت",
  "url": "https://example.com",
  "logo": "لوگوی سایت",
  "sameAs": ["لینک‌های اجتماعی"]
}
```

### WebSite Schema با SearchAction
```json
{
  "@type": "WebSite",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://example.com/?s={search_term}"
  }
}
```

### Article Schema (پست‌ها)
```json
{
  "@type": "Article",
  "headline": "عنوان",
  "author": "نویسنده",
  "datePublished": "تاریخ",
  "image": "تصویر شاخص"
}
```

### Breadcrumb Schema
```json
{
  "@type": "BreadcrumbList",
  "itemListElement": [...]
}
```

---

## ⚡ بهینه‌سازی‌های پرفورمنس

### تصاویر
- ✅ Lazy Loading خودکار
- ✅ Srcset و Sizes ریسپانسیو
- ✅ پیش‌بارگذاری تصاویر مهم

### اسکریپت‌ها
- ✅ Defer برای JS های غیر بحرانی
- ✅ حذف jQuery Migrate
- ✅ Async برای اسکریپت‌های خارجی

### حذف موارد غیرضروری
- ✅ Emoji Scripts
- ✅ Embeds
- ✅ Dashicons (کاربران غیر لاگین)
- ✅ Block Library CSS (در صورت عدم استفاده)

### Headers و Hints
- ✅ Cache-Control
- ✅ Expires Headers
- ✅ Preconnect برای فونت‌ها
- ✅ DNS Prefetch

### نتایج PageSpeed:
- 🟢 **Performance:** 95+
- 🟢 **Accessibility:** 100
- 🟢 **Best Practices:** 100
- 🟢 **SEO:** 100

---

## 🔄 تغییرات اخیر

برای مشاهده لیست کامل تغییرات، فایل [CHANGELOG.md](CHANGELOG.md) را ببینید.

### نسخه 1.1.0
- ✅ رفع 6 باگ اصلی
- ✅ اضافه شدن کامپوننت‌های جدید
- ✅ پیاده‌سازی Schema.org
- ✅ پشتیبانی SVG
- ✅ بهینه‌سازی‌های پرفورمنس

---

## 📖 مستندات تکمیلی

### PHP Functions

#### دریافت لوگو:
```php
<?php echo d_theme_get_logo(); ?>
```

#### دریافت آیکون SVG:
```php
<?php echo d_theme_get_svg_icon('phone', 'icon-svg'); ?>
```

#### نمایش Breadcrumb:
```php
<?php d_theme_breadcrumb(); ?>
```

#### زمان مطالعه:
```php
<?php echo d_theme_reading_time(); ?>
```

### JavaScript API

#### تغییر تم:
```javascript
// تغییر به Dark
window.dThemeToggle.setTheme('dark');

// تغییر به Light
window.dThemeToggle.setTheme('light');

// Toggle
window.dThemeToggle.toggleTheme();

// دریافت تم فعلی
const currentTheme = window.dThemeToggle.getCurrentTheme();
```

#### کنترل آکاردئون:
```javascript
const item = document.querySelector('.accordion-item');

// باز کردن
window.dAccordion.open(item);

// بستن
window.dAccordion.close(item);

// Toggle
window.dAccordion.toggle(item);
```

---

## 📱 پشتیبانی

### Browser Support
- ✅ Chrome (آخرین 2 نسخه)
- ✅ Firefox (آخرین 2 نسخه)
- ✅ Safari (آخرین 2 نسخه)
- ✅ Edge (آخرین 2 نسخه)

### WordPress Version
- ✅ WordPress 6.0+
- ✅ PHP 7.4+
- ✅ MySQL 5.7+

### تماس با ما
- 📧 ایمیل: support@example.com
- 💬 تلگرام: [@behman2d](https://t.me/behman2d)
- 🌐 وبسایت: [eghbalisteel.com](https://eghbalisteel.com)

---

## 📝 لایسنس

این قالب تحت لایسنس GPL v2 یا جدیدتر منتشر شده است.

---

## 🙏 تشکر

از استفاده از قالب D-Theme متشکریم! 

**نسخه:** 1.1.0  
**توسعه‌دهنده:** Bahman2D  
**تاریخ بروزرسانی:** 2025-11-03
