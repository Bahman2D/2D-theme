<?php
/**
 * Template Name: صفحه بلاگ
 * 
 * تمپلیت صفحه بلاگ با لیست نوشته‌ها
 * 
 * @package D_Theme
 * @version 1.0.0
 */

get_header(); ?>

<main class="site-main blog-page-main" id="main" role="main">
    
    <div class="container">
        <!-- Breadcrumbs -->
        <?php d_theme_breadcrumb(); ?>
        <div class="blog-page-wrapper">
            
            <!-- محتوای اصلی -->
            <div class="blog-content">
                
                <!-- Header -->
                <header class="blog-header">
                    <h1 class="blog-title"><?php the_title(); ?></h1>
                    <?php if (get_the_content()) : ?>
                        <div class="blog-description">
                            <?php the_content(); ?>
                        </div>
                    <?php endif; ?>
                </header>
                
                <!-- فیلتر و جستجو -->
                <div class="blog-filters">
                    <form method="get" class="blog-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <input 
                            type="search" 
                            name="s" 
                            placeholder="جستجو در بلاگ..." 
                            value="<?php echo get_search_query(); ?>"
                            class="blog-search-input"
                        >
                        <button type="submit" class="blog-search-submit">جستجو</button>
                    </form>
                    
                    <div class="blog-categories-filter">
                        <?php
                        $categories = get_categories(array('hide_empty' => true));
                        if (!empty($categories)) :
                        ?>
                            <div class="categories-list">
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="category-filter-item <?php echo !isset($_GET['cat']) ? 'active' : ''; ?>">
                                    همه
                                </a>
                                <?php foreach ($categories as $category) : ?>
                                    <a href="<?php echo esc_url(add_query_arg('cat', $category->term_id, get_permalink())); ?>" 
                                       class="category-filter-item <?php echo (isset($_GET['cat']) && $_GET['cat'] == $category->term_id) ? 'active' : ''; ?>">
                                        <?php echo esc_html($category->name); ?>
                                        <span class="category-count">(<?php echo $category->count; ?>)</span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- لیست نوشته‌ها -->
                <?php
                $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                $cat_filter = isset($_GET['cat']) ? absint($_GET['cat']) : 0;
                
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 12,
                    'paged' => $paged,
                    'post_status' => 'publish',
                );
                
                if ($cat_filter > 0) {
                    $args['cat'] = $cat_filter;
                }
                
                $blog_query = new WP_Query($args);
                
                if ($blog_query->have_posts()) :
                ?>
                    <div class="blog-posts-grid" itemscope itemtype="https://schema.org/Blog">
                        <?php while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                            <article class="blog-post-item" itemscope itemtype="https://schema.org/BlogPosting">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>" class="blog-post-thumbnail">
                                        <?php 
                                        the_post_thumbnail('d-card', array(
                                            'itemprop' => 'image',
                                            'loading' => 'lazy',
                                        )); 
                                        ?>
                                    </a>
                                <?php endif; ?>
                                
                                <div class="blog-post-content">
                                    <h2 class="blog-post-title" itemprop="headline">
                                        <a href="<?php the_permalink(); ?>" itemprop="url">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>
                                    
                                    <div class="blog-post-meta">
                                        <time datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished">
                                            <?php 
                                            if (function_exists('persian_date')) {
                                                echo persian_date('j F Y', get_the_time('U'));
                                            } else {
                                                the_date();
                                            }
                                            ?>
                                        </time>
                                        <span class="blog-post-reading-time">
                                            ⏱ <?php echo d_theme_reading_time(); ?> دقیقه
                                        </span>
                                    </div>
                                    
                                    <div class="blog-post-excerpt" itemprop="description">
                                        <?php echo d_theme_get_excerpt(25); ?>
                                    </div>
                                    
                                    <a href="<?php the_permalink(); ?>" class="blog-post-read-more">
                                        ادامه مطلب →
                                    </a>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <nav class="blog-pagination" aria-label="صفحه‌بندی بلاگ">
                        <?php
                        echo paginate_links(array(
                            'total' => $blog_query->max_num_pages,
                            'current' => $paged,
                            'prev_text' => '← قبلی',
                            'next_text' => 'بعدی →',
                            'type' => 'list',
                        ));
                        ?>
                    </nav>
                    
                <?php else : ?>
                    <div class="blog-no-posts">
                        <p>نوشته‌ای یافت نشد.</p>
                    </div>
                <?php endif; ?>
                
                <?php wp_reset_postdata(); ?>
                
            </div>
            
            <!-- Sidebar -->
            <aside class="blog-sidebar" role="complementary">
                <?php if (is_active_sidebar('sidebar-main')) : ?>
                    <?php dynamic_sidebar('sidebar-main'); ?>
                <?php else : ?>
                    <!-- آخرین نوشته‌ها -->
                    <div class="widget widget-recent-posts">
                        <h3 class="widget-title">آخرین نوشته‌ها</h3>
                        <ul>
                            <?php
                            $recent_posts = wp_get_recent_posts(array('numberposts' => 5));
                            foreach ($recent_posts as $recent) :
                            ?>
                                <li>
                                    <a href="<?php echo get_permalink($recent['ID']); ?>">
                                        <?php echo esc_html($recent['post_title']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <!-- دسته‌بندی‌ها -->
                    <div class="widget widget-categories">
                        <h3 class="widget-title">دسته‌بندی‌ها</h3>
                        <ul>
                            <?php wp_list_categories(array('title_li' => '')); ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </aside>
            
        </div>
    </div>
    
    <?php
    // Schema Blog
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Blog',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
    );
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    ?>
    
</main>

<?php get_footer(); ?>

