<?php
/**
 * Comments Template
 * 
 * تمپلیت کامنت‌ها با طراحی سفارشی فارسی
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// Exit if accessed directly
if (post_password_required()) {
    return;
}

$comments_count = get_comments_number();
?>

<section id="comments" class="comments-area" aria-label="بخش دیدگاه‌ها">
    
    <?php if (have_comments()) : ?>
        <h2 class="comments-title" id="<?php 
            $comments_count = get_comments_number();
            $comments_text = ($comments_count === 1) ? 'یک دیدگاه' : sprintf('%s دیدگاه', number_format_i18n($comments_count));
            echo d_theme_get_heading_id($comments_text, 0);
        ?>">
            <?php
            if ($comments_count === 1) {
                echo 'یک دیدگاه';
            } else {
                printf(
                    /* translators: %s: تعداد دیدگاه‌ها */
                    esc_html('%s دیدگاه'),
                    number_format_i18n($comments_count)
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style' => 'ol',
                'short_ping' => true,
                'callback' => 'd_theme_comment_callback',
                'max_depth' => 3,
            ));
            ?>
        </ol>

        <?php
        the_comments_pagination(array(
            'prev_text' => '← دیدگاه‌های قبلی',
            'next_text' => 'دیدگاه‌های بعدی →',
        ));
        ?>

    <?php endif; ?>

    <?php
    if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
    ?>
        <p class="no-comments"><?php _e('دیدگاه‌ها بسته شده‌اند.', 'd-theme'); ?></p>
    <?php endif; ?>

    <?php
    // اگر دیدگاهی وجود نداشت، اما comments باز است، heading برای "دیدگاه‌ها" اضافه کن
    if (!have_comments() && comments_open()) :
    ?>
        <h2 class="comments-title" id="<?php echo d_theme_get_heading_id('دیدگاه‌ها', 0); ?>">دیدگاه‌ها</h2>
    <?php endif; ?>

    <?php
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    
    comment_form(array(
        'title_reply' => 'دیدگاه خود را بنویسید',
        'title_reply_to' => 'پاسخ به %s',
        'cancel_reply_link' => 'لغو پاسخ',
        'label_submit' => 'ارسال دیدگاه',
        'comment_field' => '<div class="comment-form-comment"><label for="comment">دیدگاه</label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></div>',
        'fields' => array(
            'author' => '<div class="comment-form-author"><label for="author">' . __('نام', 'd-theme') . ($req ? ' <span class="required">*</span>' : '') . '</label><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . ($req ? ' required' : '') . ' /></div>',
            'email' => '<div class="comment-form-email"><label for="email">' . __('ایمیل', 'd-theme') . ($req ? ' <span class="required">*</span>' : '') . '</label><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . ($req ? ' required' : '') . ' /></div>',
            'phone' => '<div class="comment-form-phone"><label for="phone">' . __('شماره تماس', 'd-theme') . '</label><input id="phone" name="phone" type="tel" value="" size="30" placeholder="09123456789" /></div>',
        ),
    ));
    ?>

</section>

<?php
/**
 * Callback برای نمایش هر کامنت
 */
function d_theme_comment_callback($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class('comment-item'); ?> id="comment-<?php comment_ID(); ?>">
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            
            <div class="comment-author-avatar">
                <?php echo get_avatar($comment, 60); ?>
            </div>
            
            <div class="comment-content">
                <div class="comment-meta">
                    <cite class="comment-author">
                        <?php comment_author_link(); ?>
                    </cite>
                    <time class="comment-time" datetime="<?php comment_time('c'); ?>">
                        <?php 
                        if (function_exists('persian_date')) {
                            echo persian_date('j F Y، ساعت H:i', get_comment_time('U'));
                        } else {
                            printf(
                                /* translators: 1: date, 2: time */
                                __('%1$s در %2$s', 'd-theme'),
                                get_comment_date(),
                                get_comment_time()
                            );
                        }
                        ?>
                    </time>
                    <?php edit_comment_link(__('ویرایش', 'd-theme'), '<span class="edit-link">', '</span>'); ?>
                </div>
                
                <div class="comment-text">
                    <?php comment_text(); ?>
                </div>
                
                <?php if ($comment->comment_approved == '0') : ?>
                    <p class="comment-awaiting-moderation">
                        <?php _e('دیدگاه شما در انتظار تایید است.', 'd-theme'); ?>
                    </p>
                <?php endif; ?>
                
                <div class="comment-reply">
                    <?php
                    comment_reply_link(array_merge($args, array(
                        'depth' => $depth,
                        'max_depth' => $args['max_depth'],
                        'reply_text' => 'پاسخ',
                    )));
                    ?>
                </div>
            </div>
            
        </article>
    <?php
}

