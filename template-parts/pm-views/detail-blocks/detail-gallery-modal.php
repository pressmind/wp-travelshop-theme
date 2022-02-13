<?php
/**
 * @var array $args
 */
?>
<div class="detail-gallery-overlay">
    <button class="detail-gallery-overlay-close">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="28" height="28"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round"
                stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z"/>
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
    </button>
    <div class="detail-gallery-overlay-slider">
        <div class="detail-gallery-overlay-inner" id="detail-gallery-overlay-inner">
            <?php
            foreach ($args['pictures'] as $picture) {
                ?>
                <div class="detail-gallery-overlay-item">
                    <div class="detail-gallery-overlay-item--image">
                        <img data-src="<?php echo $picture['url_detail_gallery']; ?>" class="w-100 h-100 imglazy" loading="lazy"/>
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