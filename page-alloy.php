<?php
/**
 * Template Name: صفحه آلیاژها
 * 
 * تمپلیت صفحه آلیاژها با جدول مشخصات فنی
 * 
 * @package D_Theme
 * @version 1.0.0
 */

get_header(); ?>

<main class="site-main alloy-page-main" id="main" role="main">
    
    <div class="container">
        <!-- Breadcrumbs -->
        <?php d_theme_breadcrumb(); ?>
        
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class('alloy-page'); ?> itemscope itemtype="https://schema.org/Product">
                
                <!-- Header -->
                <header class="alloy-header">
                    <h1 class="alloy-title" itemprop="name"><?php the_title(); ?></h1>
                    
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="alloy-thumbnail">
                            <?php 
                            the_post_thumbnail('large', array(
                                'itemprop' => 'image',
                                'loading' => 'eager',
                            )); 
                            ?>
                        </div>
                    <?php endif; ?>
                </header>
                
                <div class="alloy-wrapper">
                    
                    <!-- محتوای اصلی -->
                    <div class="alloy-content">
                        
                        <!-- TOC Mobile -->
                        <div class="toc-mobile-wrapper">
                            <?php 
                            // نمایش TOC (اگر شرایط لازم برقرار باشد)
                            if (d_theme_needs_toc()) {
                                get_template_part('template-parts/components/toc');
                            }
                            ?>
                        </div>
                        
                        <!-- محتوا -->
                        <div class="entry-content" itemprop="description">
                            <?php 
                            $content = get_the_content();
                            $content = d_theme_add_toc_anchors($content);
                            echo apply_filters('the_content', $content);
                            ?>
                        </div>
                        
                        <!-- جدول مشخصات فنی -->
                        <?php
                        $alloy_specs = get_post_meta(get_the_ID(), 'd_theme_alloy_specs', true);
                        if (!empty($alloy_specs) && is_array($alloy_specs)) :
                        ?>
                            <section class="alloy-specs" itemscope itemtype="https://schema.org/Product">
                                <h2 class="alloy-specs-title" id="<?php echo d_theme_get_heading_id('مشخصات فنی', 0); ?>">مشخصات فنی</h2>
                                
                                <table class="alloy-specs-table" itemprop="additionalProperty" itemscope itemtype="https://schema.org/PropertyValue">
                                    <tbody>
                                        <?php
                                        $spec_labels = array(
                                            'composition' => 'ترکیب شیمیایی',
                                            'density' => 'چگالی (g/cm³)',
                                            'melting_point' => 'نقطه ذوب (°C)',
                                            'tensile_strength' => 'استحکام کششی (MPa)',
                                            'yield_strength' => 'استحکام تسلیم (MPa)',
                                            'hardness' => 'سختی (HB)',
                                            'thermal_conductivity' => 'هدایت حرارتی (W/m·K)',
                                            'electrical_conductivity' => 'هدایت الکتریکی (%IACS)',
                                        );
                                        
                                        foreach ($spec_labels as $key => $label) {
                                            if (isset($alloy_specs[$key]) && !empty($alloy_specs[$key])) {
                                                echo '<tr>';
                                                echo '<th scope="row">' . esc_html($label) . '</th>';
                                                echo '<td itemprop="value">' . esc_html($alloy_specs[$key]) . '</td>';
                                                echo '</tr>';
                                            }
                                        }
                                        
                                        // ویژگی‌های اضافی
                                        if (isset($alloy_specs['extra']) && is_array($alloy_specs['extra'])) {
                                            foreach ($alloy_specs['extra'] as $extra) {
                                                if (!empty($extra['label']) && !empty($extra['value'])) {
                                                    echo '<tr>';
                                                    echo '<th scope="row">' . esc_html($extra['label']) . '</th>';
                                                    echo '<td>' . esc_html($extra['value']) . '</td>';
                                                    echo '</tr>';
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </section>
                        <?php endif; ?>
                        
                        <!-- FAQ Section -->
                        <?php 
                        $faqs = get_post_meta(get_the_ID(), 'd_theme_faq_items', true);
                        if (!empty($faqs)) {
                            get_template_part('template-parts/components/faq');
                        }
                        ?>
                        
                        <!-- Comments -->
                        <?php
                        if (comments_open() || get_comments_number()) {
                            comments_template();
                        }
                        ?>
                        
                    </div>
                    
                    <!-- Sidebar (TOC Desktop) -->
                    <aside class="alloy-sidebar" role="complementary">
                        <div class="toc-desktop-wrapper">
                            <?php 
                            // نمایش TOC (اگر شرایط لازم برقرار باشد)
                            if (d_theme_needs_toc()) {
                                get_template_part('template-parts/components/toc');
                            }
                            ?>
                        </div>
                    </aside>
                    
                </div>
                
            </article>
            
            <?php
            // Schema Product
            $schema = array(
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => get_the_title(),
                'description' => d_theme_get_seo_description(),
                'image' => d_theme_get_og_image(),
                'url' => get_permalink(),
            );
            
            if (!empty($alloy_specs)) {
                $schema['additionalProperty'] = array();
                foreach ($alloy_specs as $key => $value) {
                    if ($key !== 'extra' && !empty($value)) {
                        $schema['additionalProperty'][] = array(
                            '@type' => 'PropertyValue',
                            'name' => $spec_labels[$key] ?? $key,
                            'value' => $value,
                        );
                    }
                }
            }
            
            echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
            ?>
            
        <?php endwhile; ?>
        
    </div>
    
</main>

<?php get_footer(); ?>

