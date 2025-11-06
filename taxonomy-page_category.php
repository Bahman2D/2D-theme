<?php
/**
 * Taxonomy Template: Page Category
 * 
 * تمپلیت صفحات کتگوری
 * 
 * @package D_Theme
 * @version 1.0.0
 */

get_header(); ?>

<main class="site-main taxonomy-page-main" id="main" role="main">
    
    <!-- Breadcrumbs -->
    <?php d_theme_breadcrumb(); ?>
    
    <div class="container">
        
        <?php if (have_posts()) : ?>
            
            <!-- Header -->
            <header class="taxonomy-header">
                <h1 class="taxonomy-title">
                    <?php single_term_title('دسته‌بندی: '); ?>
                </h1>
                
                <?php
                $term = get_queried_object();
                $description = term_description();
                if (!empty($description)) :
                ?>
                    <div class="taxonomy-description">
                        <?php echo wp_kses_post($description); ?>
                    </div>
                    
                    <!-- TOC برای توضیحات کتگوری (اگر طولانی باشد) -->
                    <?php if (d_theme_needs_toc($description)) : ?>
                        <div class="taxonomy-toc">
                            <?php get_template_part('template-parts/components/toc'); ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </header>
            
            <!-- لیست صفحات -->
            <div class="taxonomy-pages-grid" itemscope itemtype="https://schema.org/CollectionPage">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="taxonomy-page-item" itemscope itemtype="https://schema.org/WebPage">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="page-thumbnail">
                                <?php 
                                the_post_thumbnail('d-card', array(
                                    'itemprop' => 'image',
                                    'loading' => 'lazy',
                                )); 
                                ?>
                            </a>
                        <?php endif; ?>
                        
                        <div class="page-content">
                            <h2 class="page-title" itemprop="name">
                                <a href="<?php the_permalink(); ?>" itemprop="url">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            
                            <div class="page-excerpt" itemprop="description">
                                <?php echo d_theme_get_excerpt(20); ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="page-read-more">
                                مشاهده بیشتر →
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <!-- Pagination -->
            <nav class="taxonomy-pagination" aria-label="صفحه‌بندی">
                <?php
                echo paginate_links(array(
                    'prev_text' => '← قبلی',
                    'next_text' => 'بعدی →',
                    'type' => 'list',
                ));
                ?>
            </nav>
            
        <?php else : ?>
            <div class="taxonomy-no-posts">
                <p>صفحه‌ای در این دسته‌بندی یافت نشد.</p>
            </div>
        <?php endif; ?>
        
    </div>
    
    <?php
    // Schema CollectionPage
    $term = get_queried_object();
    if ($term) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $term->name,
            'description' => wp_strip_all_tags(term_description()),
            'url' => get_term_link($term),
        );
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }
    ?>
    
</main>

<?php get_footer(); ?>

