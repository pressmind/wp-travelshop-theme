<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password,
 * return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}

?>

<div id="post-comments" class="post-comments <?php echo get_option( 'show_avatars' ) ? 'show-avatars' : ''; ?>">

    <?php
    if ( have_comments() ) :
        ;
        ?>

        <ol class="comment-list">
            <?php
            wp_list_comments(
                array(
                    'avatar_size' => 60,
                    'style'       => 'ol',
                    'short_ping'  => true,
                )
            );
            ?>
        </ol><!-- .comment-list -->



        <?php if ( ! comments_open() ) : ?>
        <p class="no-comments"><?php esc_html_e( 'Kommentare wurden deaktiviert', 'travelshop' ); ?></p>
    <?php endif; ?>
    <?php endif; ?>

    <?php
    comment_form(
        array(
            'logged_in_as'       => null,
            'title_reply'        => esc_html__( 'Schreibe ein Kommentar', 'travelshop' ),
            'title_reply_before' => '<h4 id="reply-title" class="comment-reply-title">',
            'title_reply_after'  => '</h4>',
            'class_submit' => 'btn btn-primary'
        )
    );
    ?>

</div><!-- #comments -->
