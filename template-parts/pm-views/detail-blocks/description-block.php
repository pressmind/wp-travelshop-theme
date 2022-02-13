<?php
/**
 * @var array $args
 */
global $args;
global $pictureIndex;
?>
<section class="description-block-wrapper">
    <?php
    foreach ($args['descriptions'] as $i => $description) {
        ?>
        <?php if (!empty($description['headline'])) { ?>
        <h2><?php echo $description['headline']; ?></h2>
        <?php } ?>
        <hr/>
        <?php foreach ($description['items'] as $k => $item) { ?>
            <div class="description-block-element <?php echo $i == 0 ? 'description-block-open' : ''; ?>">
                <h3>
                    <div class="description-block-element-title">
                        <?php if (!empty($item['name'])) { ?>
                        <span><?php echo $item['name']; ?></span>
                        <?php } ?>
                        <?php
                        if (!empty($item['icons'])) {
                            ?>
                            <div class="description-block-star-rating">
                                <?php echo $item['icons']; // svg or img ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="icon icon-tabler icon-tabler-plus travelshop-itinerary-step-open" width="30" height="30"
                         viewBox="0 0 24 24" stroke-width="2.5" stroke="#06f" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                </h3>
                <div class="description-block-element-more">
                    <?php if (!empty($item['text'])) { ?>
                        <?php echo $item['text']; ?>
                    <?php } ?>
                    <?php if (!empty($item['pictures'])) { ?>
                    <div class="description-block-element-gallery description-block-gallery-<?php echo $k; ?>">
                        <?php foreach ($item['pictures'] as $picture) { ?>
                                <div>
                                    <img class="detail-gallery-modal-image imglazy" data-index="<?php echo $pictureIndex; ?>" src="<?php echo $picture['url_teaser']; ?>" alt="<?php echo $picture['alt']; ?>" loading="lazy" />
                                    <div class="description-block-element-gallery-copyright">
                                        <?php echo $picture['copyright']; ?>
                                    </div>
                                </div>
                            <?php $args['pictures'][] = [
                                    'caption' => $picture['caption'],
                                    'copyright' => $picture['copyright'],
                                    'url_detail' => $picture['url_detail'],
                                    'url_detail_gallery' => $picture['url_detail'],
                                    'url_thumbnail' => $picture['url_teaser'],
                                    'picture_index' => $pictureIndex++,
                            ]; ?>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <hr/>
        <?php } ?>
        <?php
    }
    ?>
</section>