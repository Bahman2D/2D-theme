<?php
/**
 * Footer Template
 * 
 * فوتر قالب - دسکتاپ 4 ستونی و موبایل چسبان
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// Hook قبل از footer
d_theme_before_footer();
?>

<!-- ========== DESKTOP FOOTER ========== -->
<footer class="desktop-footer" role="contentinfo">
    <div class="footer-container">
        <div class="footer-grid">
            
            <!-- ستون 1: درباره -->
            <div class="footer-col">
                <h3><?php bloginfo('name'); ?></h3>
                <p><?php 
                    $description = get_bloginfo('description');
                    echo $description ? esc_html($description) : 'قالب وردپرس مدرن و حرفه‌ای با امکانات پیشرفته';
                ?></p>
            </div>

            <!-- ستون 2: دسترسی سریع -->
            <div class="footer-col">
                <h3>دسترسی سریع</h3>
                <?php
                if (is_active_sidebar('footer-1')) {
                    dynamic_sidebar('footer-1');
                } else {
                ?>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/')); ?>">صفحه اصلی</a></li>
                        <li><a href="#">دسته‌بندی محصولات</a></li>
                        <li><a href="#">بلاگ آموزشی</a></li>
                        <li><a href="#">تماس با ما</a></li>
                    </ul>
                <?php } ?>
            </div>

            <!-- ستون 3: لینک‌ها -->
            <div class="footer-col">
                <h3>لینک‌های مفید</h3>
                <?php
                if (is_active_sidebar('footer-2')) {
                    dynamic_sidebar('footer-2');
                } else {
                ?>
                    <ul>
                        <li><a href="#">درباره ما</a></li>
                        <li><a href="#">خدمات</a></li>
                        <li><a href="#">سوالات متداول</a></li>
                        <li><a href="#">حریم خصوصی</a></li>
                    </ul>
                <?php } ?>
            </div>

            <!-- ستون 4: تماس -->
            <div class="footer-col">
                <h3>تماس با ما</h3>
                <?php
                if (is_active_sidebar('footer-3')) {
                    dynamic_sidebar('footer-3');
                } else {
                ?>
                    <ul>
                        <li><a href="tel:02100000000">📞 021-00000000</a></li>
                        <li><a href="tel:09120000000">📱 0912-195-0000</a></li>
                        <li><a href="mailto:info@example.com">✉️ info@example.com</a></li>
                        <li><a href="#">📍 تهران، ایران</a></li>
                    </ul>
                <?php } ?>
            </div>

        </div>

        <div class="footer-bottom">
            <p>© <?php echo date_i18n('Y'); ?> <?php bloginfo('name'); ?> - تمامی حقوق محفوظ است</p>
        </div>
    </div>
</footer>

<!-- ========== MOBILE FOOTER ========== -->
<div class="mobile-footer">
    <nav class="mobile-footer-nav" role="navigation" aria-label="منوی موبایل">
        
        <!-- خانه -->
        <a href="<?php echo esc_url(home_url('/')); ?>" 
           class="mobile-footer-item <?php echo is_front_page() ? 'active' : ''; ?>"
           aria-label="خانه"
           <?php if (is_front_page()) echo 'aria-current="page"'; ?>>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
            </svg>
            <div>خانه</div>
        </a>
        
        <!-- محصولات -->
        <a href="#" 
           class="mobile-footer-item"
           aria-label="محصولات">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 8h4V4H4v4zm6 12h4v-4h-4v4zm-6 0h4v-4H4v4zm0-6h4v-4H4v4zm6 0h4v-4h-4v4zm6-10v4h4V4h-4zm-6 4h4V4h-4v4zm6 6h4v-4h-4v4zm0 6h4v-4h-4v4z"/>
            </svg>
            <div>محصولات</div>
        </a>
        
        <!-- منو (باز کردن منوی کشویی) -->
        <a href="#" 
           class="mobile-footer-item" 
           id="mobileFooterMenu"
           aria-label="منو">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
            </svg>
            <div>منو</div>
        </a>
        
        <!-- بلاگ -->
        <a href="#" 
           class="mobile-footer-item"
           aria-label="بلاگ">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
            </svg>
            <div>بلاگ</div>
        </a>
        
        <!-- تماس -->
        <a href="#" 
           class="mobile-footer-item"
           aria-label="تماس">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
            </svg>
            <div>تماس</div>
        </a>
        
    </nav>
</div>

<?php
// Hook بعد از footer
d_theme_after_footer();

wp_footer(); 
?>
</body>
</html>
