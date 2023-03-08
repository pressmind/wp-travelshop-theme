<?php
/**
 * @var \Pressmind\ORM\Object\MediaObject\DataType\Picture[] $pictures
 */
$pictures = $args;

if (empty($pictures) === false) {

    ?>

    <!-- OVERLAYGALLERY: START -->
    <div id="detail-gallery-overlay">
        <button class="detail-gallery-overlay-close">
            <svg class="dropdown-clear input-clear"><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
        </button>
        <!-- GALLERY_SLIDER: START -->
        <div class="detail-gallery-overlay-slider">
            <div class="detail-gallery-overlay-inner" id="detail-gallery-overlay-inner">

                <?php
                foreach ($pictures as $picture) {
                    ?>
                    <div class="detail-gallery-overlay-item">
                        <div class="detail-gallery-overlay-item--image">
                            <img src="<?php echo $picture->getUri('detail'); ?>" class="w-100 h-100"/>
                        </div>
                        <div class="detail-gallery-overlay-item--caption">
                            <?php echo $picture->caption; ?>
                            <small><?php echo $picture->copyright; ?></small>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
        <!-- GALLERY_SLIDER: END -->

        <!-- GALLERY_THUMBNAILS: START -->
        <div class="detail-gallery-thumbnails" id="detail-gallery-thumbnails">

            <?php
            foreach ($pictures as $picture) {
                ?>
                <div class="detail-gallery-thumbnail-item">
                    <div class="detail-gallery-thumbnail-item--image">
                        <img src="<?php echo $picture->getUri('detail'); ?>" class="w-100 h-100"/>
                    </div>
                </div>
            <?php } ?>

        </div>
        <!-- GALLERY_THUMBNAILS: END -->
    </div>
    <!-- OVERLAYGALLERY: END -->

    <?php
}
?>