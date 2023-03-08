<?php
/**
 * @var array $args
 */
?>
<section class="description-block-wrapper">
    <?php
    foreach ($args['descriptions'] as $i => $description) {
        ?>
        <div class="description-block description-block--<?php echo $description['type']; ?>">
            <?php if (!empty($description['headline']) && $description['type'] !== 'accordion') { ?>
                <div class="description-block-header">
                    <h2 class="h3"><?php echo $description['headline']; ?></h2>
                </div>
            <?php } ?>
        </div>
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
                            <a href="<?php echo $picture['url_detail']; ?>"
                               data-lightbox="description-block-gallery-<?php echo $k; ?>">
                                <img src="<?php echo $picture['url_teaser']; ?>"
                                     alt="<?php echo $picture['alt']; ?>"/>
                                <div class="description-block-element-gallery-copyright">
                                    <?php echo $picture['copyright']; ?>
                                </div>
                            </a>
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