<?php
/**
 * @var array $args
 */
?>
<div class="detail-gallery-overlay">
    <button class="detail-gallery-overlay-close">
        <svg class="dropdown-clear input-clear"><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
    </button>
    <div class="detail-gallery-overlay-slider">

        <?php
        load_template(get_template_directory() . '/template-parts/micro-templates/slider-controls.php', false, $args);
        ?>
        <div class="detail-gallery-overlay-inner" id="detail-gallery-overlay-inner">
            <?php
            foreach ($args['pictures'] as $picture) {
                ?>
                <div class="detail-gallery-overlay-item">
                    <div class="detail-gallery-overlay-item--image">
                        <img src="<?php echo $picture['url_detail_gallery']; ?>" class="w-100 h-100" loading="lazy"/>
                    </div>
                    <div class="detail-gallery-overlay-item--caption">
                        <?php echo $picture['caption']; ?>
                        <small><?php echo $picture['copyright']; ?></small>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="detail-gallery-thumbnails" id="detail-gallery-thumbnails">
        <?php
        foreach ($args['pictures'] as $picture) {
            ?>
            <div class="detail-gallery-thumbnail-item">
                <div class="detail-gallery-thumbnail-item--image">
                    <img src="<?php echo $picture['url_thumbnail']; ?>" class="w-100 h-100" loading="lazy"/>
                </div>
            </div>
        <?php } ?>
    </div>
</div>