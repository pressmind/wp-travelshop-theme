<?php
/**
 * <code>
 *  $args['headline']
 *  $args['subline']
 *  $args['lead']
 *  $args['text']
 *  $args['btn_link']
 *  $args['btn_label']
 *  $args['bg_image']
 *  $args['bg_image_src']
 *  $args['bg_image_alt_text']
 *  $args['btn_link_nofollow']
 * </code>
 * @var array $args
 */
?>
<article class="jumbotron jumbotron-fluid mb-0">
    <section class="jumbotron-background">
        <?php
        if(empty($args['bg_image_src'])){ // Fallback image
            $args['bg_image_src'] = get_stylesheet_directory_uri().'/assets/img/slide-1.webp';
        }
        ?>
        <img src="<?php echo $args['bg_image_src']; ?>" alt="<?php echo empty($args['bg_image_alt_text']) ? $args['bg_image_alt_text'] : '';?>" loading="lazy"/>
    </section>
    <section class="container text-center">
        <?php if(!empty($args['headline'])){?>
            <h1 class="display-4"><?php echo $args['headline'];?></h1>
        <?php } ?>
        <?php if(!empty($args['subline'])){?>
            <h2 class="display-5"><?php echo $args['subline'];?></h2>
        <?php } ?>
        <?php if(!empty($args['lead'])){?>
            <p class="lead"><?php echo $args['lead'];?></p>
        <?php } ?>
        <?php if(!empty($args['text'])){?>
            <p><?php echo $args['text'];?></p>
        <?php } ?>
        <?php if(!empty($args['btn_link'])){?>
            <a class="btn btn-primary btn-lg" href="<?php echo site_url(); ?>/<?php echo $args['btn_link'];?>" role="button" <?php
            echo !empty($args['btn_link_target']) ? ' target="'.$args['btn_link_target'].'"' : '';
            echo (!empty($args['btn_link_nofollow']) && $args['btn_link_nofollow'] == 'yes') ? ' rel="nofollow"' : '';
            ?>><?php echo !empty($args['btn_label']) ? $args['btn_label'] : 'Button';?></a>
        <?php } ?>
    </section>
</article>