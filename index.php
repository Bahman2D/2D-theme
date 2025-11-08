<?php
/**
 * The main template file
 * 
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * 
 * @package D_Theme
 * @version 1.0.0
 */

get_header(); ?>

<main class="site-main" id="main" role="main">
    <div class="container">
        <!-- Breadcrumbs -->
        <?php d_theme_breadcrumb(); ?>
        
        <?php if (have_posts()) : ?>
            
            <header class="page-header">
                <?php
                if (is_home() && !is_front_page()) :
                    ?>
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                    <?php
                elseif (is_archive()) :
                    the_archive_title('<h1 class="page-title">', '</h1>');
                    the_archive_description('<div class="archive-description">', '</div>');
                elseif (is_search()) :
                    ?>
                    <h1 class="page-title">
                        <?php
                        printf(
                            /* translators: %s: search query. */
                            esc_html__('نتایج جستجو برای: %s', 'd-theme'),
                            '<span>' . get_search_query() . '</span>'
                        );
                        ?>
                    </h1>
                    <?php
                endif;
                ?>
            </header>

            <div class="posts-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                                    <?php the_post_thumbnail('d-card', array('alt' => get_the_title())); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-content">
                            <header class="entry-header">
                                <?php
                                if (is_singular()) :
                                    the_title('<h1 class="entry-title">', '</h1>');
                                else :
                                    the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                                endif;
                                
                                if ('post' === get_post_type()) :
                                    ?>
                                    <div class="entry-meta">
                                        <span class="posted-on">
                                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                                <?php echo esc_html(get_the_date()); ?>
                                            </time>
                                        </span>
                                        <?php if (get_the_category_list()) : ?>
                                            <span class="cat-links">
                                                <?php echo get_the_category_list(', '); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <?php
                                endif;
                                ?>
                            </header>

                            <div class="entry-summary">
                                <?php the_excerpt(); ?>
                            </div>

                            <footer class="entry-footer">
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                    <?php esc_html_e('ادامه مطلب', 'd-theme'); ?>
                                </a>
                            </footer>
                        </div>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>

            <?php
            // Pagination
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => __('قبلی', 'd-theme'),
                'next_text' => __('بعدی', 'd-theme'),
            ));
            ?>

        <?php else : ?>

            <section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e('محتوایی یافت نشد', 'd-theme'); ?></h1>
                </header>

                <div class="page-content">
                    <?php if (is_home() && current_user_can('publish_posts')) : ?>
                        <p>
                            <?php
                            printf(
                                wp_kses(
                                    __('آماده انتشار اولین پست خود هستید؟ <a href="%1$s">اینجا شروع کنید</a>.', 'd-theme'),
                                    array(
                                        'a' => array(
                                            'href' => array(),
                                        ),
                                    )
                                ),
                                esc_url(admin_url('post-new.php'))
                            );
                            ?>
                        </p>
                    <?php elseif (is_search()) : ?>
                        <p><?php esc_html_e('متأسفانه چیزی با جستجوی شما مطابقت ندارد. لطفاً دوباره با کلمات کلیدی مختلف امتحان کنید.', 'd-theme'); ?></p>
                        <?php get_search_form(); ?>
                    <?php else : ?>
                        <p><?php esc_html_e('به نظر می‌رسد در اینجا چیزی پیدا نشد. شاید جستجو کمک کند؟', 'd-theme'); ?></p>
                        <?php get_search_form(); ?>
                    <?php endif; ?>
                </div>
            </section>

        <?php endif; ?>

    </div>
</main>

<?php
// Sidebar is optional - only include if sidebar.php exists
if (file_exists(get_template_directory() . '/sidebar.php')) {
    get_sidebar();
}
get_footer();
