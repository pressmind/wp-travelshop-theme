<?php

/**
 * @var $current_post WP_Post
 */
$current_post = $args;

$id_post_thumbnail = get_post_thumbnail_id($current_post);
$url_post_thumbnail = wp_get_attachment_image_url($id_post_thumbnail, 'medium');

if($url_post_thumbnail) {
    $image_src = $url_post_thumbnail;
} else {
    $image_src = get_stylesheet_directory_uri() . '/assets/img/slide-1-mobile.jpg';
}

?>
<article class="col-12 col-sm-6 col-lg-4">
    <div class="teaser image-teaser">
        <a title="<?php echo $current_post->post_title; ?>" href="<?php echo get_permalink($current_post); ?>">

            <div class="teaser-image">
                    <img src="<?php echo $image_src; ?>" title="<?php echo $current_post->post_title; ?>" loading="lazy" />
            </div>
            <div class="teaser-body">
                <h1 class="teaser-title h5">
                    <?php echo $current_post->post_title; ?>
                </h1>
                <?php if(!empty($current_post->post_excerpt)) { ?>
                <p>
                    <?php echo wp_trim_words($current_post->post_excerpt, 10, '...'); ?>
                </p>
                <?php } ?>
                <div class="btn btn-primary">Mehr erfahren</div>
            </div>
        </a>
    </div>
</article>