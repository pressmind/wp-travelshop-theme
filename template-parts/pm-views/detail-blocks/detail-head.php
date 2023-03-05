<?php
use Pressmind\Travelshop\Template;

/**
 * @var array $args
 */
?>
<div class="detail-header-gallery">
    <div class="detail-header-badge">NEU</div>
    <div class="detail-header-gallery-slider">
        <div class="detail-header-gallery-slider--counter">
            <span class="current-image">1</span> / <span class="total-images"><?php echo count($args['pictures']; ?></span>
        </div>
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
    <div class="detail-header-grid">
        <?php
        $i = 0;
        ?>
        <?php foreach ($args['pictures'] as $picture) { ?>
            <?php if ( $i < 3 ) { ?>
                <div class="detail-header-grid-item">
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