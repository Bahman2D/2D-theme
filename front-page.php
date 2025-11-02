<?php
/**
 * Front Page Template
 * 
 * صفحه اصلی با Hero Slider
 * 
 * @package D_Theme
 * @version 1.0.0
 */

get_header(); ?>

<!-- Hero Slider -->
<?php get_template_part('template-parts/home/hero-slider'); ?>

<!-- محتوای اصلی صفحه -->
<main class="site-main" id="main" role="main">
    
    <?php
    // اگر محتوای صفحه وجود داشت
    if (have_posts()) :
        while (have_posts()) : the_post();
    ?>
    
    <!-- محتوای صفحه استاتیک -->
    <section class="content-section">
        <div class="container">
            <?php
            if (get_the_content()) {
                the_content();
            }
            ?>
        </div>
    </section>
    
    <?php
        endwhile;
    endif;
    ?>
    
    <!-- بخش معرفی (پیش‌فرض) -->
    <section class="content-section">
        <div class="container">
            <h2 class="section-title">خوش آمدید</h2>
            <div class="section-subtitle">
                قالب D Theme - قالبی مدرن، سریع و بهینه شده برای وردپرس
            </div>
            
            <div style="text-align: center; max-width: 700px; margin: var(--space-8) auto; color: var(--text-secondary);">
                <p>این صفحه اصلی قالب است. شما می‌توانید محتوای این صفحه را از طریق:</p>
                <ul style="list-style: none; padding: 0; margin: var(--space-5) 0;">
                    <li>✅ ویرایش صفحه اصلی وردپرس</li>
                    <li>✅ تنظیمات Hero Slider از Customizer</li>
                    <li>✅ افزودن بخش‌های سفارشی به <code>front-page.php</code></li>
                </ul>
            </div>
        </div>
    </section>
    
    <!-- 
        💡 بخش‌هایی که می‌توانید در Phase 2 اضافه کنید:
        
        - ✨ ویژگی‌های قالب (4 کارت)
        - 📦 دسته‌بندی‌های محصولات
        - 📝 آخرین مطالب بلاگ
        - 💬 نظرات مشتریان
        - 📊 آمار و ارقام
        - 📞 فرم تماس
        - 🎯 CTA Banner
    -->

</main>

<?php get_footer(); ?>
