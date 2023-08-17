<?php

/**
 * @var $current_post WP_Post
 */
$current_post = $args;
$id_post_thumbnail = get_post_thumbnail_id($current_post);

?>
<article class="<?php echo $current_post->class; ?>">
    <div class="teaser wp-teaser">
        <div class="teaser-image">
            <img class="w-100 h-auto" src="<?php echo wp_get_attachment_image_url($id_post_thumbnail, 'thumbnail'); ?>"
                alt="<?php echo get_the_post_thumbnail_caption($current_post); ?>" loading="lazy" />
        </div>
        <div class="teaser-body">
            <h1 class="teaser-title h5">
                <?php echo $current_post->post_title; ?>
            </h1>
            <?php if(!empty($current_post->post_excerpt)) { ?>
            <p>
                <?php echo $current_post->post_excerpt; ?>
            </p>
            <?php } ?>
            <a href="<?php echo get_permalink($current_post); ?>" class="btn btn-primary btn-block">Mehr erfahren</a>
        </div>
    </div>
</article>