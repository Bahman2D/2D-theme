<?php
/**
 * Template Name: دسته‌بندی صفحات
 * Template Post Type: page
 * 
 * تمپلیت برای صفحات والد که زیرصفحات را نمایش می‌دهد
 * 
 * @package D_Theme
 * @version 1.0.0
 */

get_header(); ?>

<main class="site-main category-page-main" id="main" role="main">
    
    <div class="container">
        <!-- Breadcrumbs -->
        <?php d_theme_breadcrumb(); ?>
        
        <?php
        while (have_posts()) : the_post();
            
            // دریافت زیرصفحات
            $child_pages = new WP_Query(array(
                'post_type'      => 'page',
                'post_parent'    => get_the_ID(),
                'posts_per_page' => -1,
                'orderby'        => 'menu_order title',
                'order'          => 'ASC',
                'post_status'    => 'publish'
            ));
            
            ?>
            
            <!-- Header -->
            <header class="category-header">
                <h1 class="category-title" itemprop="name">
                    <?php the_title(); ?>
                </h1>
                
                <?php if (has_excerpt() || get_the_content()) : ?>
                    <div class="category-description" itemprop="description">
                        <?php 
                        if (has_excerpt()) {
                            the_excerpt();
                        } else {
                            the_content();
                        }
                        ?>
                    </div>
                    
                    <!-- TOC برای توضیحات طولانی -->
                    <?php 
                    $content = has_excerpt() ? get_the_excerpt() : get_the_content();
                    if (d_theme_needs_toc($content)) : 
                    ?>
                        <div class="category-toc">
                            <?php get_template_part('template-parts/components/toc'); ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                
                <?php if ($child_pages->have_posts()) : ?>
                    <div class="category-count">
                        <span><?php echo $child_pages->found_posts; ?> صفحه در این دسته‌بندی</span>
                    </div>
                <?php endif; ?>
            </header>
            
            <?php if ($child_pages->have_posts()) : ?>
                
                <!-- لیست زیرصفحات -->
                <div class="category-pages-grid" itemscope itemtype="https://schema.org/ItemList">
                    <?php 
                    $position = 1;
                    while ($child_pages->have_posts()) : $child_pages->the_post(); 
                    ?>
                        <article class="category-page-item" itemscope itemtype="https://schema.org/WebPage">
                            <meta itemprop="position" content="<?php echo $position++; ?>">
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>" class="page-thumbnail">
                                    <?php 
                                    the_post_thumbnail('d-card', array(
                                        'itemprop' => 'image',
                                        'loading' => 'lazy',
                                        'alt' => get_the_title(),
                                    )); 
                                    ?>
                                </a>
                            <?php else : ?>
                                <a href="<?php the_permalink(); ?>" class="page-thumbnail page-thumbnail-placeholder">
                                    <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="100" height="100" fill="#e2e8f0"/>
                                        <path d="M30 40L50 60L70 40M50 20V60" stroke="#94a3b8" stroke-width="3" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                            
                            <div class="page-content">
                                <h2 class="page-title" itemprop="name">
                                    <a href="<?php the_permalink(); ?>" itemprop="url">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                                
                                <?php if (has_excerpt() || get_the_content()) : ?>
                                    <div class="page-excerpt" itemprop="description">
                                        <?php 
                                        if (has_excerpt()) {
                                            echo wp_trim_words(get_the_excerpt(), 20, '...');
                                        } else {
                                            echo d_theme_get_excerpt(20);
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="page-read-more">
                                    مشاهده جزئیات
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M10 4L6 8L10 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                
            <?php else : ?>
                
                <div class="category-no-pages">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="40" cy="40" r="38" stroke="#e2e8f0" stroke-width="4"/>
                        <path d="M30 40H50M40 30V50" stroke="#94a3b8" stroke-width="4" stroke-linecap="round"/>
                    </svg>
                    <p>هنوز صفحه‌ای در این دسته‌بندی ایجاد نشده است.</p>
                    <?php if (current_user_can('edit_pages')) : ?>
                        <a href="<?php echo admin_url('post-new.php?post_type=page&post_parent=' . get_the_ID()); ?>" class="btn-primary">
                            افزودن صفحه جدید
                        </a>
                    <?php endif; ?>
                </div>
                
            <?php endif; ?>
            
            <?php wp_reset_postdata(); ?>
            
            <!-- FAQ Section -->
            <?php
            $faqs = get_post_meta(get_the_ID(), 'd_theme_faq_items', true);
            if (!empty($faqs)) {
                get_template_part('template-parts/components/faq');
            }
            ?>
            
        <?php endwhile; ?>
        
    </div>
    
    <?php
    // Schema CollectionPage
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => get_the_title(),
        'description' => has_excerpt() ? wp_strip_all_tags(get_the_excerpt()) : wp_trim_words(wp_strip_all_tags(get_the_content()), 30),
        'url' => get_permalink(),
        'breadcrumb' => array(
            '@type' => 'BreadcrumbList',
            'itemListElement' => array(
                array(
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'خانه',
                    'item' => home_url('/')
                ),
                array(
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => get_the_title(),
                    'item' => get_permalink()
                )
            )
        )
    );
    
    // اضافه کردن لیست زیرصفحات به Schema
    if (isset($child_pages) && $child_pages->have_posts()) {
        $items = array();
        $child_pages->rewind_posts();
        $position = 1;
        while ($child_pages->have_posts()) {
            $child_pages->the_post();
            $items[] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'url' => get_permalink(),
                'name' => get_the_title()
            );
        }
        wp_reset_postdata();
        
        if (!empty($items)) {
            $schema['mainEntity'] = array(
                '@type' => 'ItemList',
                'itemListElement' => $items
            );
        }
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    ?>
    
</main>

<?php get_footer(); ?>

