<?php
if (!defined('ABSPATH')) { exit; }
/**
 * Template: Single Steel Alloy
 * 
 * صفحه نمایش تک آلیاژ فولادی
 * 
 * @package Eghbal_Steel_Theme
 * @version 1.0.0
 */

get_header();

// دریافت فیلدهای ACF
$alloy_code = get_field('alloy_code');
$common_name = get_field('common_name');
$description_short = get_field('description_short');
$chemical_composition = get_field('chemical_composition');
$tensile_strength = get_field('tensile_strength');
$yield_strength = get_field('yield_strength');
$hardness = get_field('hardness');
$elongation = get_field('elongation');
$density = get_field('density');
$heat_annealing = get_field('heat_annealing');
$heat_hardening = get_field('heat_hardening');
$heat_tempering = get_field('heat_tempering');
$applications_main = get_field('applications_main');
$applications_industries = get_field('applications_industries');
$international_equivalents = get_field('international_equivalents');
$available_forms = get_field('available_forms');
$available_sizes = get_field('available_sizes');
$stock_status = get_field('stock_status');
$price_note = get_field('price_note');
$datasheet_pdf = get_field('datasheet_pdf');
$technical_drawing = get_field('technical_drawing');

// دریافت دسته‌بندی برای رنگ
$categories = get_the_terms(get_the_ID(), 'steel_category');
$category_slug = '';
$category_color = '';

if ($categories && !is_wp_error($categories)) {
    $main_category = $categories[0];
    $category_slug = $main_category->slug;
    
    // رنگ‌های دسته‌بندی (از variables.css)
    $category_colors = array(
        'bearing-steel' => '#b8b563ff',
        'spring-steel' => '#4ca66dff',
        'nitriding-steel' => '#7d57a1ff',
        'heat-resistant-steel' => '#c26565ff',
        'other-alloys' => '#6e8bb4ff',
    );
    
    $category_color = isset($category_colors[$category_slug]) ? $category_colors[$category_slug] : '#3b82f6';
}
?>

<main class="single-alloy" data-category="<?php echo esc_attr($category_slug); ?>">
    
    <!-- Breadcrumbs -->
    <?php get_template_part('template-parts/home/breadcrumbs'); ?>
    
    <!-- Header آلیاژ -->
    <section class="alloy-header" style="--category-accent: <?php echo esc_attr($category_color); ?>">
        <div class="container">
            <div class="alloy-header-content">
                
                <!-- Meta Info -->
                <div class="alloy-meta">
                    <?php if ($categories) : ?>
                        <span class="alloy-category">
                            <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <path d="M22 6l-10 7L2 6"/>
                            </svg>
                            <?php echo esc_html($main_category->name); ?>
                        </span>
                    <?php endif; ?>
                    
                    <?php if ($stock_status) : 
                        $status_labels = array(
                            'in_stock' => 'موجود در انبار',
                            'on_order' => 'قابل سفارش',
                            'out_of_stock' => 'ناموجود'
                        );
                        $status_class = $stock_status === 'in_stock' ? 'success' : ($stock_status === 'on_order' ? 'warning' : 'danger');
                    ?>
                        <span class="alloy-stock stock-<?php echo esc_attr($status_class); ?>">
                            <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <circle cx="12" cy="12" r="8"/>
                            </svg>
                            <?php echo esc_html($status_labels[$stock_status]); ?>
                        </span>
                    <?php endif; ?>
                </div>
                
                <!-- عنوان -->
                <h1 class="alloy-title"><?php the_title(); ?></h1>
                
                <!-- توضیح کوتاه -->
                <?php if ($description_short) : ?>
                    <p class="alloy-description"><?php echo esc_html($description_short); ?></p>
                <?php endif; ?>
                
                <!-- اطلاعات سریع -->
                <div class="alloy-quick-info">
                    <?php if ($alloy_code) : ?>
                        <div class="quick-info-item">
                            <span class="label">کد DIN:</span>
                            <span class="value"><?php echo esc_html($alloy_code); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($common_name) : ?>
                        <div class="quick-info-item">
                            <span class="label">نام رایج:</span>
                            <span class="value"><?php echo esc_html($common_name); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($hardness) : ?>
                        <div class="quick-info-item">
                            <span class="label">سختی:</span>
                            <span class="value"><?php echo esc_html($hardness); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- دکمه‌های اقدام -->
                <div class="alloy-actions">
                    <?php if ($datasheet_pdf) : ?>
                        <a href="<?php echo esc_url($datasheet_pdf['url']); ?>" class="btn btn-primary" download>
                            <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="7 10 12 15 17 10"/>
                                <line x1="12" y1="15" x2="12" y2="3"/>
                            </svg>
                            دانلود PDF مشخصات فنی
                        </a>
                    <?php endif; ?>
                    
                    <a href="#request-quote" class="btn btn-accent">
                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                        </svg>
                        درخواست قیمت
                    </a>
                </div>
                
            </div>
            
            <!-- تصویر (در صورت وجود) -->
            <?php if (has_post_thumbnail() || $technical_drawing) : ?>
                <div class="alloy-header-image">
                    <?php if ($technical_drawing) : ?>
                        <img src="<?php echo esc_url($technical_drawing['sizes']['large']); ?>" 
                             alt="<?php echo esc_attr($technical_drawing['alt']); ?>" 
                             loading="lazy">
                    <?php else : ?>
                        <?php the_post_thumbnail('large'); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- محتوای اصلی -->
    <div class="alloy-content">
        <div class="container">
            <div class="alloy-grid">
                
                <!-- Sidebar (Table of Contents) -->
                <aside class="alloy-sidebar">
                    <div class="toc-wrapper sticky">
                        <h3 class="toc-title">فهرست مطالب</h3>
                        <nav class="toc-nav">
                            <ul>
                                <li><a href="#overview">خلاصه</a></li>
                                <?php if ($chemical_composition) : ?>
                                    <li><a href="#chemical">ترکیب شیمیایی</a></li>
                                <?php endif; ?>
                                <?php if ($tensile_strength || $yield_strength) : ?>
                                    <li><a href="#mechanical">خواص مکانیکی</a></li>
                                <?php endif; ?>
                                <?php if ($heat_annealing || $heat_hardening) : ?>
                                    <li><a href="#heat-treatment">عملیات حرارتی</a></li>
                                <?php endif; ?>
                                <?php if ($applications_main) : ?>
                                    <li><a href="#applications">کاربردها</a></li>
                                <?php endif; ?>
                                <?php if ($international_equivalents) : ?>
                                    <li><a href="#equivalents">معادل‌های بین‌المللی</a></li>
                                <?php endif; ?>
                                <?php if ($available_forms) : ?>
                                    <li><a href="#availability">موجودی و اشکال</a></li>
                                <?php endif; ?>
                                <li><a href="#faq">سوالات متداول</a></li>
                                <li><a href="#request-quote">درخواست قیمت</a></li>
                            </ul>
                        </nav>
                    </div>
                </aside>
                
                <!-- محتوای اصلی -->
                <div class="alloy-main">
                    
                    <!-- خلاصه -->
                    <section id="overview" class="content-section">
                        <h2 class="section-title">خلاصه</h2>
                        <div class="section-content">
                            <?php the_content(); ?>
                        </div>
                    </section>
                    
                    <!-- ترکیب شیمیایی -->
                    <?php if ($chemical_composition && is_array($chemical_composition)) : ?>
                        <section id="chemical" class="content-section">
                            <h2 class="section-title">ترکیب شیمیایی</h2>
                            <div class="section-content">
                                <p>جدول زیر ترکیب شیمیایی استاندارد <?php echo esc_html($alloy_code); ?> را نشان می‌دهد:</p>
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>عنصر</th>
                                                <th>حداقل (%)</th>
                                                <th>حداکثر (%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($chemical_composition as $element) : ?>
                                                <tr>
                                                    <td><strong><?php echo esc_html($element['element_symbol']); ?></strong></td>
                                                    <td><?php echo esc_html($element['percentage_min'] ? $element['percentage_min'] : '—'); ?></td>
                                                    <td><?php echo esc_html($element['percentage_max'] ? $element['percentage_max'] : '—'); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    <?php endif; ?>
                    
                    <!-- خواص مکانیکی -->
                    <?php if ($tensile_strength || $yield_strength || $hardness || $elongation) : ?>
                        <section id="mechanical" class="content-section">
                            <h2 class="section-title">خواص مکانیکی</h2>
                            <div class="section-content">
                                <p>خواص مکانیکی <?php echo esc_html($alloy_code); ?> در حالت عملیات حرارتی شده:</p>
                                
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ویژگی</th>
                                                <th>مقدار</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($tensile_strength) : ?>
                                                <tr>
                                                    <td><strong>استحکام کششی</strong></td>
                                                    <td><?php echo esc_html($tensile_strength); ?> MPa</td>
                                                </tr>
                                            <?php endif; ?>
                                            
                                            <?php if ($yield_strength) : ?>
                                                <tr>
                                                    <td><strong>استحکام تسلیم</strong></td>
                                                    <td><?php echo esc_html($yield_strength); ?> MPa</td>
                                                </tr>
                                            <?php endif; ?>
                                            
                                            <?php if ($hardness) : ?>
                                                <tr>
                                                    <td><strong>سختی</strong></td>
                                                    <td><?php echo esc_html($hardness); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                            
                                            <?php if ($elongation) : ?>
                                                <tr>
                                                    <td><strong>ازدیاد طول</strong></td>
                                                    <td><?php echo esc_html($elongation); ?>%</td>
                                                </tr>
                                            <?php endif; ?>
                                            
                                            <?php if ($density) : ?>
                                                <tr>
                                                    <td><strong>چگالی</strong></td>
                                                    <td><?php echo esc_html($density); ?> g/cm³</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    <?php endif; ?>
                    
                    <!-- عملیات حرارتی -->
                    <?php if ($heat_annealing || $heat_hardening || $heat_tempering) : ?>
                        <section id="heat-treatment" class="content-section">
                            <h2 class="section-title">عملیات حرارتی</h2>
                            <div class="section-content">
                                <p>مراحل و پارامترهای عملیات حرارتی <?php echo esc_html($alloy_code); ?>:</p>
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>مرحله</th>
                                                <th>دما (°C)</th>
                                                <th>زمان</th>
                                                <th>محیط سردسازی</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($heat_annealing && $heat_annealing['temperature']) : ?>
                                                <tr>
                                                    <td><strong>آنیل</strong></td>
                                                    <td><?php echo esc_html($heat_annealing['temperature']); ?></td>
                                                    <td><?php echo esc_html($heat_annealing['time'] ? $heat_annealing['time'] : '—'); ?></td>
                                                    <td><?php echo esc_html($heat_annealing['cooling'] ? $heat_annealing['cooling'] : '—'); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                            
                                            <?php if ($heat_hardening && $heat_hardening['temperature']) : 
                                                $medium_labels = array(
                                                    'oil' => 'روغن',
                                                    'water' => 'آب',
                                                    'air' => 'هوا',
                                                    'polymer' => 'پلیمر'
                                                );
                                                $medium = $heat_hardening['medium'] ? $medium_labels[$heat_hardening['medium']] : '—';
                                            ?>
                                                <tr>
                                                    <td><strong>کوئنچ</strong></td>
                                                    <td><?php echo esc_html($heat_hardening['temperature']); ?></td>
                                                    <td>—</td>
                                                    <td><?php echo esc_html($medium); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                            
                                            <?php if ($heat_tempering && $heat_tempering['temperature']) : ?>
                                                <tr>
                                                    <td><strong>تمپر</strong></td>
                                                    <td><?php echo esc_html($heat_tempering['temperature']); ?></td>
                                                    <td><?php echo esc_html($heat_tempering['time'] ? $heat_tempering['time'] : '—'); ?></td>
                                                    <td>هوا</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    <?php endif; ?>
                    
                    <!-- کاربردها -->
                    <?php if ($applications_main) : ?>
                        <section id="applications" class="content-section">
                            <h2 class="section-title">کاربردهای اصلی</h2>
                            <div class="section-content">
                                <?php echo wp_kses_post($applications_main); ?>
                                
                                <?php if ($applications_industries) : ?>
                                    <h3>صنایع مصرف‌کننده:</h3>
                                    <div class="industries-grid">
                                        <?php 
                                        $industry_labels = array(
                                            'automotive' => 'خودروسازی',
                                            'aerospace' => 'هوافضا',
                                            'bearing' => 'بلبرینگ‌سازی',
                                            'tool' => 'ابزارسازی',
                                            'machinery' => 'ماشین‌آلات صنعتی',
                                            'oil_gas' => 'نفت و گاز',
                                            'power' => 'نیروگاهی',
                                            'railway' => 'ریلی',
                                            'construction' => 'ساختمان‌سازی',
                                            'medical' => 'پزشکی'
                                        );
                                        
                                        foreach ($applications_industries as $industry) : 
                                            if (isset($industry_labels[$industry])) :
                                        ?>
                                            <span class="industry-tag"><?php echo esc_html($industry_labels[$industry]); ?></span>
                                        <?php 
                                            endif;
                                        endforeach; 
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </section>
                    <?php endif; ?>
                    
                    <!-- معادل‌های بین‌المللی -->
                    <?php if ($international_equivalents && is_array($international_equivalents)) : ?>
                        <section id="equivalents" class="content-section">
                            <h2 class="section-title">معادل‌های بین‌المللی</h2>
                            <div class="section-content">
                                <p>استانداردهای معادل <?php echo esc_html($alloy_code); ?> در کشورهای مختلف:</p>
                                
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>کشور/استاندارد</th>
                                                <th>کد معادل</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $country_labels = array(
                                                'USA_AISI' => 'آمریکا (AISI/SAE)',
                                                'USA_ASTM' => 'آمریکا (ASTM)',
                                                'JPN_JIS' => 'ژاپن (JIS)',
                                                'CHN_GB' => 'چین (GB)',
                                                'GBR_BS' => 'انگلیس (BS)',
                                                'FRA_AFNOR' => 'فرانسه (AFNOR)',
                                                'ITA_UNI' => 'ایتالیا (UNI)',
                                                'SWE_SS' => 'سوئد (SS)',
                                                'RUS_GOST' => 'روسیه (GOST)',
                                                'EUR_EN' => 'اروپا (EN)',
                                                'INT_ISO' => 'بین‌المللی (ISO)'
                                            );
                                            
                                            foreach ($international_equivalents as $equivalent) : 
                                            ?>
                                                <tr>
                                                    <td><strong><?php echo esc_html($country_labels[$equivalent['country_standard']]); ?></strong></td>
                                                    <td><?php echo esc_html($equivalent['equivalent_code']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    <?php endif; ?>
                    
                    <!-- موجودی و اشکال -->
                    <?php if ($available_forms || $available_sizes) : ?>
                        <section id="availability" class="content-section">
                            <h2 class="section-title">موجودی و اشکال قابل ارائه</h2>
                            <div class="section-content">
                                
                                <?php if ($available_forms) : ?>
                                    <h3>فرم‌های موجود:</h3>
                                    <div class="forms-grid">
                                        <?php 
                                        $form_labels = array(
                                            'round_bar' => 'میله گرد',
                                            'flat_bar' => 'میله تخت',
                                            'square_bar' => 'میله مربع',
                                            'hexagonal' => 'میله شش‌ضلعی',
                                            'plate' => 'ورق',
                                            'sheet' => 'شیت',
                                            'tube' => 'لوله',
                                            'wire' => 'سیم'
                                        );
                                        
                                        foreach ($available_forms as $form) : 
                                            if (isset($form_labels[$form])) :
                                        ?>
                                            <span class="form-tag"><?php echo esc_html($form_labels[$form]); ?></span>
                                        <?php 
                                            endif;
                                        endforeach; 
                                        ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($available_sizes) : ?>
                                    <h3>سایزهای موجود:</h3>
                                    <div class="sizes-list">
                                        <?php 
                                        $sizes = explode("\n", $available_sizes);
                                        foreach ($sizes as $size) : 
                                            $size = trim($size);
                                            if (!empty($size)) :
                                        ?>
                                            <span class="size-item"><?php echo esc_html($size); ?></span>
                                        <?php 
                                            endif;
                                        endforeach; 
                                        ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($price_note) : ?>
                                    <div class="price-note">
                                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                                        </svg>
                                        <span><?php echo esc_html($price_note); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </section>
                    <?php endif; ?>
                    
                    <!-- سوالات متداول -->
                    <section id="faq" class="content-section">
                        <h2 class="section-title">سوالات متداول</h2>
                        <div class="section-content">
                            <div class="accordion" data-single>
                                
                                <!-- سوال 1 -->
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <h3 class="accordion-title">فولاد <?php echo esc_html($alloy_code); ?> برای چه کاربردهایی مناسب است؟</h3>
                                        <svg class="accordion-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M7 10l5 5 5-5z"/>
                                        </svg>
                                    </div>
                                    <div class="accordion-content">
                                        <div class="accordion-body">
                                            این آلیاژ برای <?php echo wp_strip_all_tags($applications_main ? substr($applications_main, 0, 200) : 'کاربردهای صنعتی مختلف'); ?>... مناسب است.
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- سوال 2 -->
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <h3 class="accordion-title">چطور می‌توانم <?php echo esc_html($alloy_code); ?> را خریداری کنم؟</h3>
                                        <svg class="accordion-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M7 10l5 5 5-5z"/>
                                        </svg>
                                    </div>
                                    <div class="accordion-content">
                                        <div class="accordion-body">
                                            برای خرید <?php echo esc_html($alloy_code); ?> می‌توانید با ما تماس بگیرید یا از طریق فرم درخواست قیمت، سفارش خود را ثبت کنید. ما این آلیاژ را در اشکال و ابعاد مختلف ارائه می‌دهیم.
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- سوال 3 -->
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <h3 class="accordion-title">زمان تحویل <?php echo esc_html($alloy_code); ?> چقدر است؟</h3>
                                        <svg class="accordion-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M7 10l5 5 5-5z"/>
                                        </svg>
                                    </div>
                                    <div class="accordion-content">
                                        <div class="accordion-body">
                                            زمان تحویل بسته به سایز و شکل مورد نیاز شما متفاوت است. معمولاً سایزهای استاندارد در انبار موجود است و برای سایزهای خاص، حداکثر 2-3 هفته زمان نیاز است.
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- سوال 4 -->
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <h3 class="accordion-title">آیا گواهی آنالیز متریال ارائه می‌شود؟</h3>
                                        <svg class="accordion-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M7 10l5 5 5-5z"/>
                                        </svg>
                                    </div>
                                    <div class="accordion-content">
                                        <div class="accordion-body">
                                            بله، تمام محصولات ما همراه با گواهی آنالیز متریال (Mill Certificate) از کارخانه سازنده ارائه می‌شود که تضمین کیفیت و اصالت کالا را می‌دهد.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    
                    <!-- فرم درخواست قیمت -->
                    <section id="request-quote" class="content-section section-cta">
                        <h2 class="section-title">درخواست قیمت و مشاوره رایگان</h2>
                        <div class="section-content">
                            <p>برای دریافت قیمت روز <?php echo esc_html($alloy_code); ?> و مشاوره رایگان، فرم زیر را تکمیل کنید یا با ما تماس بگیرید:</p>
                            
                            <div class="cta-grid">
                                <!-- فرم درخواست -->
                                <div class="quote-form-wrapper">
                                    <form class="quote-form" id="quoteForm" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
                                        <input type="hidden" name="action" value="submit_quote_request">
                                        <input type="hidden" name="alloy_code" value="<?php echo esc_attr($alloy_code); ?>">
                                        <input type="hidden" name="alloy_name" value="<?php echo esc_attr(get_the_title()); ?>">
                                        <?php wp_nonce_field('quote_request_nonce', 'quote_nonce'); ?>
                                        
                                        <div class="form-group">
                                            <label for="customer_name">نام و نام خانوادگی *</label>
                                            <input type="text" id="customer_name" name="customer_name" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="customer_phone">شماره تماس *</label>
                                            <input type="tel" id="customer_phone" name="customer_phone" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="customer_email">ایمیل</label>
                                            <input type="email" id="customer_email" name="customer_email">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="required_quantity">مقدار مورد نیاز</label>
                                            <input type="text" id="required_quantity" name="required_quantity" placeholder="مثال: 500 کیلوگرم">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="required_size">سایز یا شکل مورد نیاز</label>
                                            <input type="text" id="required_size" name="required_size" placeholder="مثال: Ø25mm میله گرد">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="message">توضیحات (اختیاری)</label>
                                            <textarea id="message" name="message" rows="3"></textarea>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-accent btn-block">
                                            <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                                            </svg>
                                            ارسال درخواست
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- اطلاعات تماس -->
                                <div class="contact-info">
                                    <div class="contact-item">
                                        <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20 15.5c-1.2 0-2.4-.2-3.5-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.5-5.2-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H4c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z"/>
                                        </svg>
                                        <div>
                                            <strong>تلفن تماس:</strong>
                                            <a href="tel:09121952564">۰۹۱۲-۱۹۵-۲۵۶۴</a>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-item">
                                        <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                        </svg>
                                        <div>
                                            <strong>آدرس:</strong>
                                            <span>تهران، بازار آهن شادآباد</span>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-item">
                                        <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                        </svg>
                                        <div>
                                            <strong>مزایا:</strong>
                                            <ul>
                                                <li>کیفیت تضمین شده</li>
                                                <li>قیمت مناسب</li>
                                                <li>ارسال سریع</li>
                                                <li>مشاوره رایگان</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    
                    <!-- آلیاژهای مرتبط -->
                    <?php
                    $related_args = array(
                        'post_type' => 'steel_alloy',
                        'posts_per_page' => 4,
                        'post__not_in' => array(get_the_ID()),
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'steel_category',
                                'field' => 'slug',
                                'terms' => $category_slug,
                            ),
                        ),
                    );
                    
                    $related_query = new WP_Query($related_args);
                    
                    if ($related_query->have_posts()) :
                    ?>
                        <section class="content-section">
                            <h2 class="section-title">آلیاژهای مرتبط</h2>
                            <div class="related-alloys-grid">
                                <?php while ($related_query->have_posts()) : $related_query->the_post(); 
                                    $rel_code = get_field('alloy_code');
                                    $rel_common = get_field('common_name');
                                ?>
                                    <article class="alloy-card">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="alloy-card-image">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail('medium'); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="alloy-card-content">
                                            <h3 class="alloy-card-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h3>
                                            
                                            <?php if ($rel_code || $rel_common) : ?>
                                                <div class="alloy-card-meta">
                                                    <?php if ($rel_code) : ?>
                                                        <span>DIN <?php echo esc_html($rel_code); ?></span>
                                                    <?php endif; ?>
                                                    <?php if ($rel_common) : ?>
                                                        <span><?php echo esc_html($rel_common); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline">مشاهده جزئیات</a>
                                        </div>
                                    </article>
                                <?php endwhile; wp_reset_postdata(); ?>
                            </div>
                        </section>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
    
</main>

<?php get_footer(); ?>
