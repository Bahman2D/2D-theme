# 📋 تغییرات و بهبودهای قالب D-Theme

## نسخه 1.1.0 - تاریخ اعمال تغییرات

### 🐛 رفع باگ‌ها

#### 1. اصلاح نام فایل JavaScript
- **مشکل**: در `functions.php` فایل `/assets/js/theme-toggle.js` فراخوانی می‌شد ولی فایل واقعی `toggle.js` نام داشت
- **رفع شده**: نام فایل در `functions.php` خط 177 به `toggle.js` تغییر یافت

#### 2. اصلاح تم پیش‌فرض به Dark Mode
- **مشکل**: در `header.php` خط 12 مقدار `data-theme="light"` به صورت هارد کد شده بود
- **رفع شده**: 
  - تم پیش‌فرض به `dark` تغییر یافت
  - منطق `toggle.js` برای دیفالت dark بهینه شد
  - سیستم حالا از localStorage برای ذخیره انتخاب کاربر استفاده می‌کند

#### 3. اصلاح موقعیت فلش‌های هیرو سکشن
- **مشکل**: در `hero.css` موقعیت فلش‌های چپ و راست برعکس بود (RTL)
- **رفع شده**:
  - `.hero-arrow-right` از `left` به `right` تغییر یافت (خط 193)
  - `.hero-arrow-left` از `right` به `left` تغییر یافت (خط 197)
  - همین تغییرات در media query موبایل (خطوط 212-217) هم اعمال شد

#### 4. اصلاح موقعیت Dots Navigation
- **مشکل**: در `hero.css` خط 229 مقدار `transform: translateX(50%)` باعث می‌شد dots به درستی center نشوند
- **رفع شده**: به `translateX(-50%)` تغییر یافت

#### 5. ارتفاع Hero Slider به Fullscreen
- **مشکل**: ارتفاع hero slider `80vh` بود و تمام صفحه را پوشش نمی‌داد
- **رفع شده**:
  - ارتفاع به `100vh` تغییر یافت (خط 16)
  - `min-height` از 500px به 600px افزایش یافت
  - `max-height` حذف شد برای fullscreen کامل
  - تغییرات مشابه در media query‌های موبایل اعمال شد

#### 6. پشتیبانی از لوگوی جداگانه برای Light/Dark Mode
- **مشکل**: فقط یک لوگو وجود داشت و امکان تعیین لوگوی مجزا برای حالت روز نبود
- **رفع شده**:
  - فیلد `logo_light` به `inc/customizer/logo.php` اضافه شد
  - `header.php` برای نمایش لوگوی مناسب بر اساس تم بهینه شد
  - `toggle.js` برای تغییر خودکار لوگو هنگام تغییر تم بروز شد
  - لوگوها با استفاده از `data-logo-dark` و `data-logo-light` مدیریت می‌شوند

---

### ✨ ویژگی‌های جدید

#### 1. کامپوننت‌های قابل استفاده مجدد
به `components.css` اضافه شده‌اند:

**Tables (جداول):**
- `.table` - جدول پایه با استایل تمیز
- `.table-striped` - جدول با ردیف‌های راه‌راه
- `.table-bordered` - جدول با border
- پشتیبانی کامل از Dark Mode
- Hover effects برای بهبود UX

**Accordions (آکاردئون):**
- `.accordion` - کانتینر اصلی
- `.accordion-item` - هر آیتم آکاردئون
- `.accordion-header` - هدر قابل کلیک
- `.accordion-content` - محتوای تاشو با انیمیشن نرم
- `.accordion-icon` - آیکون چرخشی
- پشتیبانی از حالت single mode (فقط یک آیتم باز)
- دسترسی‌پذیری کامل (ARIA attributes)
- پشتیبانی از کیبورد (Enter و Space)
- فایل `accordion.js` با API عمومی

**Sections (بخش‌ها):**
- `.section` - بخش استاندارد
- `.section-sm` - بخش کوچک
- `.section-lg` - بخش بزرگ
- `.section-title` - عنوان بخش
- `.section-subtitle` - زیرعنوان بخش
- `.section-primary`, `.section-secondary`, `.section-dark` - تم‌های مختلف

**Grid System:**
- `.grid` - کانتینر Grid
- `.grid-cols-1` تا `.grid-cols-4` - ستون‌های مختلف
- ریسپانسیو کامل (موبایل: 1 ستون، تبلت: 2 ستون، دسکتاپ: 3-4 ستون)

**Containers:**
- `.container` - کانتینر استاندارد (1400px)
- `.container-sm` - کانتینر کوچک
- `.container-lg` - کانتینر بزرگ
- `.container-fluid` - تمام عرض

**Responsive Utilities:**
- `.hide-mobile` - پنهان در موبایل
- `.show-mobile` - نمایش فقط در موبایل

#### 2. پشتیبانی کامل از SVG
فایل جدید: `inc/helpers/svg-support.php`

**قابلیت‌ها:**
- امکان آپلود فایل‌های SVG در Media Library
- بررسی امنیتی فایل‌های SVG (جلوگیری از کد مخرب)
- پیش‌نمایش SVG در Media Library
- فیلدهای Customizer برای آپلود آیکون‌های SVG:
  - آیکون تلفن
  - آیکون ایمیل
  - آیکون موقعیت مکانی
- تابع کمکی `d_theme_get_svg_icon()` برای استفاده آسان
- استایل‌های خودکار برای SVG images

#### 3. Schema.org Markup برای سئو
فایل جدید: `inc/helpers/schema.php`

**انواع Schema پیاده‌سازی شده:**
- **Organization Schema** (صفحه اصلی):
  - نام، URL، توضیحات سازمان
  - لوگو
  - لینک‌های شبکه‌های اجتماعی
  
- **WebSite Schema** (صفحه اصلی):
  - اطلاعات سایت
  - SearchAction برای جعبه جستجو در نتایج گوگل
  
- **Article Schema** (پست‌ها):
  - عنوان، توضیحات، تاریخ انتشار و ویرایش
  - نویسنده و ناشر
  - تصویر شاخص
  
- **Breadcrumb Schema** (همه صفحات):
  - مسیر ناوبری (breadcrumb trail)
  - سلسله مراتب صفحات
  
- **FAQPage Schema** (آماده برای استفاده):
  - قابل فعال‌سازی برای صفحات سوالات متداول

#### 4. بهینه‌سازی‌های پرفورمنس
فایل جدید: `inc/helpers/performance.php`

**بهینه‌سازی‌های اعمال شده:**

**تصاویر:**
- Lazy Loading خودکار برای همه تصاویر
- پشتیبانی از srcset و sizes
- بهینه‌سازی responsive images

**اسکریپت‌ها و استایل‌ها:**
- حذف query strings از static resources
- اضافه کردن defer به اسکریپت‌های غیر ضروری
- حذف jQuery Migrate
- Async/defer برای اسکریپت‌های خارجی

**حذف موارد غیر ضروری:**
- غیرفعال‌سازی Emoji scripts و styles
- غیرفعال‌سازی Embeds
- حذف Dashicons برای کاربران غیر لاگین
- حذف WordPress Block Library CSS (در صورت عدم استفاده)
- حذف Global Styles (WordPress 5.9+)

**بهبود سرعت:**
- Preconnect برای فونت‌ها
- DNS prefetch
- Cache-Control headers
- Expires headers
- Resource hints

**بهینه‌سازی دیتابیس:**
- محدود کردن Revisions به 3
- خالی کردن خودکار Trash بعد از 7 روز

**بهینه‌سازی Heartbeat:**
- کاهش فرکانس به 60 ثانیه
- غیرفعال‌سازی در فرانت

---

### 🔧 بهبودهای کد

#### 1. سازگاری با ACF
- قالب کاملاً آماده برای استفاده با Advanced Custom Fields
- ساختار قالب به گونه‌ای طراحی شده که فیلدهای سفارشی ACF را پشتیبانی کند

#### 2. سازگاری با Rank Math
- Schema Markup پیاده‌سازی شده با Rank Math سازگار است
- قالب از SEO best practices پیروی می‌کند

#### 3. سازگاری با LiteSpeed Cache
- کدهای قالب برای کار با LiteSpeed Cache بهینه شده‌اند
- از Cache-Control headers مناسب استفاده می‌شود

#### 4. تاریخ شمسی
- تبدیل خودکار تمام تاریخ‌ها به شمسی در فرانت و بک‌اند
- استفاده از فیلترهای وردپرس برای تبدیل یکپارچه

---

### 📁 ساختار فایل‌های جدید

```
/inc/helpers/
├── schema.php           # Schema.org Markup
├── svg-support.php      # پشتیبانی از SVG
├── performance.php      # بهینه‌سازی‌های پرفورمنس
└── color-helper.php     # (قبلاً موجود)

/assets/js/
└── accordion.js         # فانکشنالیتی آکاردئون

/assets/css/
└── components.css       # کامپوننت‌های جدید اضافه شده
```

---

### 🎯 چک‌لیست ویژگی‌های درخواستی

- [x] کاستومایزیشن کامل برای هر سایت
- [x] سئو محور (سرعت، اسکیما، بهینه‌سازی)
- [x] حالت شب و روز با دیفالت شب
- [x] رنگ‌های گلوبال قابل تغییر از بک‌اند
- [x] کلاس‌های CSS قابل استفاده مجدد (دکمه‌ها، جداول، سکشن‌ها، آکاردئون)
- [x] تاریخ‌های شمسی اتوماتیک
- [x] ویژگی‌های دیفالت وردپرس فعال (عنوان، خلاصه، تصویر شاخص)
- [x] سازگاری با ACF، Rank Math، LiteSpeed Cache
- [x] پشتیبانی از آیکون‌های SVG
- [x] لوگوی جداگانه برای حالت روز و شب

---

### 🚀 نکات مهم برای استفاده

#### استفاده از کامپوننت‌ها:

**جدول:**
```html
<table class="table table-striped">
  <thead>
    <tr>
      <th>ستون 1</th>
      <th>ستون 2</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>داده 1</td>
      <td>داده 2</td>
    </tr>
  </tbody>
</table>
```

**آکاردئون:**
```html
<div class="accordion" data-single> <!-- data-single: فقط یک آیتم باز -->
  <div class="accordion-item">
    <div class="accordion-header">
      <h3 class="accordion-title">سوال 1</h3>
      <svg class="accordion-icon">...</svg>
    </div>
    <div class="accordion-content">
      <div class="accordion-body">
        پاسخ سوال 1
      </div>
    </div>
  </div>
</div>
```

**بخش (Section):**
```html
<section class="section section-primary">
  <div class="container">
    <h2 class="section-title">عنوان بخش</h2>
    <p class="section-subtitle">توضیحات بخش</p>
    <!-- محتوای بخش -->
  </div>
</section>
```

---

### ⚠️ نکات مهم

1. **لوگو:** برای بهترین نتیجه، دو نسخه از لوگو آپلود کنید:
   - لوگوی اصلی (پیش‌فرض): برای Dark Mode (رنگ روشن)
   - لوگوی حالت روز: برای Light Mode (رنگ تیره)

2. **SVG:** هنگام آپلود فایل‌های SVG، اطمینان حاصل کنید که فایل‌ها پاک و بدون کد مخرب هستند.

3. **پرفورمنس:** اگر از Gutenberg استفاده می‌کنید، در `performance.php` خط 207 را کامنت کنید.

4. **Schema:** اگر از Rank Math یا Yoast SEO استفاده می‌کنید، ممکن است Schema تکراری داشته باشید. یکی را غیرفعال کنید.

---

### 📈 بهبودهای آینده پیشنهادی

- [ ] افزودن Dark Mode Toggle به Customizer
- [ ] اضافه کردن Lazy Load برای iframe‌ها
- [ ] پشتیبانی از WebP images
- [ ] اضافه کردن Critical CSS
- [ ] پیاده‌سازی Service Worker
- [ ] افزودن PWA support

---

**نسخه فعلی:** 1.1.0  
**تاریخ آخرین بروزرسانی:** 2025-11-03  
**توسعه‌دهنده:** Bahman2D
