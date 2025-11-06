<?php
/**
 * Single Post Template
 * 
 * تمپلیت نوشته‌ها با TOC، FAQ، Comments و SEO کامل
 * 
 * @package D_Theme
 * @version 1.0.0
 */

get_header(); ?>

<main class="site-main single-post-main" id="main" role="main">
    
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Breadcrumbs -->
        <?php d_theme_breadcrumb(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?> itemscope itemtype="https://schema.org/Article">
            
            <div class="container">
                <div class="single-post-wrapper">
                    
                    <!-- محتوای اصلی -->
                    <div class="single-post-content">
                        
                        <!-- Header -->
                        <header class="entry-header">
                            <h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
                            
                            <div class="entry-meta">
                                <span class="entry-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                                    <span itemprop="name"><?php the_author(); ?></span>
                                </span>
                                <span class="entry-date">
                                    <time datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished">
                                        <?php 
                                        if (function_exists('persian_date')) {
                                            echo persian_date('j F Y', get_the_time('U'));
                                        } else {
                                            the_date();
                                        }
                                        ?>
                                    </time>
                                </span>
                                <?php if (get_the_modified_date() !== get_the_date()) : ?>
                                    <span class="entry-updated">
                                        <time datetime="<?php echo get_the_modified_date('c'); ?>" itemprop="dateModified">
                                            بروزرسانی: <?php 
                                            if (function_exists('persian_date')) {
                                                echo persian_date('j F Y', get_the_modified_time('U'));
                                            } else {
                                                echo get_the_modified_date();
                                            }
                                            ?>
                                        </time>
                                    </span>
                                <?php endif; ?>
                                <span class="entry-reading-time">
                                    ⏱ <?php echo d_theme_reading_time(); ?> دقیقه مطالعه
                                </span>
                            </div>
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="entry-thumbnail">
                                    <?php 
                                    the_post_thumbnail('large', array(
                                        'itemprop' => 'image',
                                        'loading' => 'eager',
                                        'fetchpriority' => 'high',
                                    )); 
                                    ?>
                                </div>
                            <?php endif; ?>
                        </header>
                        
                        <!-- TOC Mobile (در بالای محتوا) -->
                        <div class="toc-mobile-wrapper">
                            <?php 
                            $content = get_the_content();
                            if (d_theme_needs_toc($content)) {
                                get_template_part('template-parts/components/toc');
                            }
                            ?>
                        </div>
                        
                        <!-- محتوای نوشته -->
                        <div class="entry-content" itemprop="articleBody">
                            <?php 
                            // اضافه کردن anchor به headings
                            $content = get_the_content();
                            $content = d_theme_add_toc_anchors($content);
                            echo apply_filters('the_content', $content);
                            ?>
                        </div>
                        
                        <!-- Footer -->
                        <footer class="entry-footer">
                            <?php
                            $categories = get_the_category();
                            if (!empty($categories)) :
                            ?>
                                <div class="entry-categories">
                                    <span class="entry-categories-label">دسته‌بندی:</span>
                                    <?php
                                    foreach ($categories as $category) {
                                        echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" rel="category tag">' . esc_html($category->name) . '</a>';
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php
                            $tags = get_the_tags();
                            if (!empty($tags)) :
                            ?>
                                <div class="entry-tags">
                                    <span class="entry-tags-label">برچسب‌ها:</span>
                                    <?php
                                    foreach ($tags as $tag) {
                                        echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" rel="tag">' . esc_html($tag->name) . '</a>';
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Social Share -->
                            <div class="entry-share">
                                <span class="entry-share-label">اشتراک‌گذاری:</span>
                                <div class="share-buttons">
                                    <a href="https://telegram.me/share/url?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" 
                                       target="_blank" 
                                       rel="noopener"
                                       class="share-btn share-telegram"
                                       aria-label="اشتراک در تلگرام">
                                        تلگرام
                                    </a>
                                    <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>" 
                                       target="_blank" 
                                       rel="noopener"
                                       class="share-btn share-whatsapp"
                                       aria-label="اشتراک در واتساپ">
                                        واتساپ
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" 
                                       target="_blank" 
                                       rel="noopener"
                                       class="share-btn share-twitter"
                                       aria-label="اشتراک در توییتر">
                                        توییتر
                                    </a>
                                </div>
                            </div>
                        </footer>
                        
                        <!-- FAQ Section -->
                        <?php 
                        $faqs = get_post_meta(get_the_ID(), 'd_theme_faq_items', true);
                        if (!empty($faqs)) {
                            get_template_part('template-parts/components/faq');
                        }
                        ?>
                        
                        <!-- نوشته‌های مرتبط -->
                        <?php
                        $related_posts = d_theme_get_related_posts(get_the_ID(), 3);
                        if (!empty($related_posts)) :
                        ?>
                            <section class="related-posts">
                                <h2 class="related-posts-title">نوشته‌های مرتبط</h2>
                                <div class="related-posts-grid">
                                    <?php foreach ($related_posts as $related_post) : 
                                        setup_postdata($related_post);
                                    ?>
                                        <article class="related-post-item">
                                            <?php if (has_post_thumbnail($related_post->ID)) : ?>
                                                <a href="<?php echo get_permalink($related_post->ID); ?>" class="related-post-thumbnail">
                                                    <?php echo get_the_post_thumbnail($related_post->ID, 'd-thumbnail'); ?>
                                                </a>
                                            <?php endif; ?>
                                            <h3 class="related-post-title">
                                                <a href="<?php echo get_permalink($related_post->ID); ?>">
                                                    <?php echo get_the_title($related_post->ID); ?>
                                                </a>
                                            </h3>
                                            <div class="related-post-excerpt">
                                                <?php echo d_theme_get_excerpt(20, $related_post->ID); ?>
                                            </div>
                                        </article>
                                    <?php 
                                    endforeach;
                                    wp_reset_postdata();
                                    ?>
                                </div>
                            </section>
                        <?php endif; ?>
                        
                        <!-- Navigation -->
                        <nav class="post-navigation" aria-label="ناوبری نوشته">
                            <div class="nav-links">
                                <?php
                                $prev_post = get_previous_post();
                                $next_post = get_next_post();
                                ?>
                                
                                <?php if ($prev_post) : ?>
                                    <div class="nav-previous">
                                        <a href="<?php echo get_permalink($prev_post->ID); ?>" rel="prev">
                                            <span class="nav-subtitle">← نوشته قبلی</span>
                                            <span class="nav-title"><?php echo get_the_title($prev_post->ID); ?></span>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($next_post) : ?>
                                    <div class="nav-next">
                                        <a href="<?php echo get_permalink($next_post->ID); ?>" rel="next">
                                            <span class="nav-subtitle">نوشته بعدی →</span>
                                            <span class="nav-title"><?php echo get_the_title($next_post->ID); ?></span>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </nav>
                        
                        <!-- Comments -->
                        <?php
                        if (comments_open() || get_comments_number()) {
                            comments_template();
                        }
                        ?>
                        
                    </div>
                    
                    <!-- Sidebar (TOC Desktop) -->
                    <aside class="single-post-sidebar" role="complementary">
                        <div class="toc-desktop-wrapper">
                            <?php 
                            $content = get_the_content();
                            if (d_theme_needs_toc($content)) {
                                get_template_part('template-parts/components/toc');
                            }
                            ?>
                        </div>
                    </aside>
                    
                </div>
            </div>
            
        </article>
        
        <?php
        // Schema markup
        d_theme_add_schema_markup($post, 'Article');
        ?>
        
    <?php endwhile; ?>
    
</main>

<?php get_footer(); ?>

