<?php
use Pressmind\Travelshop\Template;

/**
 * @var array $args
 */
?>
<div class="detail-header-gallery">
    <div class="detail-header-badge">NEU</div>
    <div class="detail-header-gallery-slider image-slider" id="detailHeaderGallerySlider" data-slider-container=".detail-header-gallery-slider--inner" data-nav="true" data-counter=".detail-header-gallery-slider--counter">
        <div class="detail-header-gallery-slider--counter">
            <span class="current-image">1</span> / <span class="total-images"><?php echo count($args['pictures']); ?></span>
        </div>
        <?php
        load_template(get_template_directory() . '/template-parts/micro-templates/slider-controls.php', false, $args);
        ?>
        <div class="detail-header-gallery-slider--inner">
            <?php foreach ($args['pictures'] as $picture) { ?>
                <div class="detail-header-gallery-slider-item">
                    <div class="detail-header-gallery-slider-item--image">
                        <img src="<?php echo $picture['url_detail']; ?>" alt="<?php echo $picture['caption']; ?>"
                             loading="lazy"/>
                    </div>
                    <div class="detail-header-gallery-slider-item--copyright">
                        <?php echo $picture['copyright']; ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
    $i = 0;
    $show_images = 3;

    if ( count($args['pictures']) < ( $show_images - 1 ) ) {
        $show_images = 1;
    }
    ?>
    <div class="detail-header-gallery-grid <?php echo ($show_images == 3) ? 'is-grid' : ''; ?>">
        <?php if ( count($args['pictures']) > 1 ) { ?>
        <button class="detail-header-gallery-grid--modal btn btn-light">
            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#dots-nine"></use></svg>
            Alle Bilder
        </button>
        <?php } ?>
        <?php foreach ($args['pictures'] as $picture) { ?>
            <?php if ( $i < 3 ) { ?>
                <div class="detail-header-gallery-grid-item detail-header-gallery-grid-item--<?php echo ( $i + 1 ); ?>">
                    <div class="detail-header-gallery-slider-item--image">
                        <img src="<?php echo $picture['url_detail']; ?>" alt="<?php echo $picture['caption']; ?>"
                             loading="lazy"/>
                    </div>
                    <div class="detail-header-gallery-slider-item--copyright">
                        <?php echo $picture['copyright']; ?>
                    </div>
                </div>
                <?php
                $i++;
            }
            ?>
        <?php } ?>
    </div>
</div>


<?php
// = = = > detail gallery overlay < = = =
load_template(get_template_directory() . '/template-parts/pm-views/detail-blocks/detail-gallery-modal.php', false, $args);
?>