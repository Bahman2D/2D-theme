<?php get_header(); ?>

<main>
    <h2>صفحه اصلی قالب D-Theme</h2>
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            ?>
            <article>
                <h3><?php the_title(); ?></h3>
                <div><?php the_excerpt(); ?></div>
            </article>
            <?php
        endwhile;
    else :
        echo '<p>محتوایی وجود ندارد</p>';
    endif;
    ?>
</main>

<?php get_footer(); ?>