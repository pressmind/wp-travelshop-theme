<?php
/**
 * @var array $args
 */
?>

<section class="description-block-wrapper">
    <?php
    foreach ($args['descriptions'] as $i => $description) {
        if ( !empty($description['items']) ) {
        ?>
        <div class="description-block description-block--<?php echo $description['type']; ?>">
            <?php if ($description['type'] !== 'accordion') { ?>
                <?php if ( !empty($description['headline']) ) { ?>
                    <div class="description-block-header">
                        <h2 class="h3"><?php echo $description['headline']; ?></h2>
                    </div>
                <?php } ?>

                <?php if ( $description['type'] === 'text' ) { ?>
                    <div class="text-blocks">
                        <?php foreach ( $description['items'] as $k => $item ) { ?>
                            <div class="text-block text-block--<?php echo $i; ?>-<?php echo $k; ?>">
                                <?php if ( !empty($item['name']) ) { ?>
                                    <h3 class="text-block-title">
                                        <?php echo $item['name']; ?>
                                    </h3>
                                <?php } ?>

                                <?php if (!empty($item['text'])) { ?>
                                    <div class="text-block-text">
                                        <?php echo remove_empty_paragraphs($item['text']); ?>
                                    </div>
                                <?php } ?>

                                <?php if (!empty($item['pictures'])) { ?>
                                    <div class="text-block-gallery" data-gallery="true" id="text-block-gallery--<?php echo $k; ?>">
                                        <div class="text-block-gallery--inner">
                                            <?php foreach ($item['pictures'] as $picture) { ?>
                                                <div class="text-block-gallery-item">
                                                    <a  href="<?php echo $picture['url_detail']; ?>"
                                                        data-lightbox="text-block-gallery-<?php echo $k; ?>">
                                                        <div class="zoom-indicator">
                                                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#magnifying-glass-plus"></use></svg>
                                                        </div>
                                                        <div class="text-block-gallery-item--image">
                                                            <img src="<?php echo $picture['url_teaser']; ?>"
                                                                 alt="<?php echo $picture['alt']; ?>"/>
                                                        </div>
                                                        <div class="text-block-gallery-item--copyright">
                                                            <?php echo $picture['copyright']; ?>
                                                        </div>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if ( $description['type'] === 'teaser' ) { ?>
                    <div class="teaser-blocks">
                        <?php foreach ( $description['items'] as $k => $item ) { ?>
                            <div class="teaser-block teaser-block--<?php echo $i; ?>-<?php echo $k; ?>">
                                <div class="teaser-block-preview">
                                    <div class="teaser-block-preview--inner">
                                        <?php if ( !empty($item['name']) ) { ?>
                                            <h3 class="teaser-block-title">
                                                <?php echo $item['name']; ?>
                                            </h3>
                                        <?php } ?>

                                        <div class="teaser-block-content">
                                            <?php if (!empty($item['text'])) { ?>
                                                <div class="teaser-block-text">
                                                    <?php echo remove_empty_paragraphs($item['text']); ?>
                                                </div>
                                            <?php } ?>

                                            <?php if (!empty($item['pictures'])) { ?>
                                                <div class="teaser-block-gallery" data-gallery="true" id="teaser-block-gallery--<?php echo $k; ?>">
                                                    <div class="teaser-block-gallery--inner">
                                                        <?php foreach ($item['pictures'] as $picture) { ?>
                                                            <div class="teaser-block-gallery-item">

                                                                <a href="<?php echo $picture['url_detail']; ?>"
                                                                   data-lightbox="teaser-block-gallery-<?php echo $k; ?>">
                                                                    <div class="zoom-indicator">
                                                                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#magnifying-glass-plus"></use></svg>
                                                                    </div>

                                                                    <div class="teaser-block-gallery-item--image">
                                                                        <img src="<?php echo $picture['url_teaser']; ?>"
                                                                             alt="<?php echo $picture['alt']; ?>"/>
                                                                    </div>
                                                                    <div class="teaser-block-gallery-item--copyright">
                                                                        <?php echo $picture['copyright']; ?>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>

                                    </div>

                                    <?php
                                    // render read-more link
                                    ?>
                                    <div class="teaser-block-toggle">
                                        <button class="btn btn-link btn-bold" type="button" data-modal-id="<?php echo $i; ?>-<?php echo $k; ?>">
                                            Mehr anzeigen
                                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-right-bold"></use></svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="teaser-block-modal" id="teaser-modal--<?php echo $i; ?>-<?php echo $k; ?>">
                                    <div class="teaser-block-modal-inner">
                                        <div class="teaser-block-modal-content">
                                            <div class="teaser-block-modal-header">
                                                <?php if ( !empty($item['name']) ) { ?>
                                                    <div class="h4"><?php echo $item['name']; ?></div>
                                                <?php } ?>

                                                <button class="teaser-block-modal-close" data-type="close-popup" type="button">
                                                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
                                                </button>
                                            </div>

                                            <div class="teaser-block-modal-body">


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } ?>

            <?php // render accordion if type accordion ?>
            <?php if ( $description['type'] === 'accordion' || !isset($description['type']) || empty($description['type']) ) { ?>
                <div class="accordion-group">
                    <?php if (!empty($description['headline'])) { ?>
                        <div class="accordion-header">
                            <h2 class="h3"><?php echo $description['headline']; ?></h2>
                        </div>
                    <?php } ?>

                    <?php if ( count($description['items']) > 0 ) { ?>
                        <div class="accordion-wrapper">
                            <?php foreach ( $description['items'] as $k => $item ) { ?>
                            <div class="accordion-item">
                                <button class="accordion-toggle">
                                    <h3 class="accordion-toggle--title h5">
                                        <?php echo $item['name']; ?>

                                        <?php
                                        if (!empty($item['icons'])) {
                                            ?>
                                            <div class="accordion-toggle--rating">
                                                <?php echo $item['icons']; // svg or img ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </h3>

                                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-down"></use></svg>
                                </button>

                                <div class="accordion-content">
                                    <div class="accordion-content--inner">
                                        <?php if (!empty($item['text'])) { ?>
                                            <div class="accordion-block accordion-block-text">
                                                <?php echo remove_empty_paragraphs($item['text']); ?>
                                            </div>
                                        <?php } ?>


                                        <?php if (!empty($item['pictures'])) { ?>
                                            <div class="accordion-block accordion-block-gallery" data-gallery="true" id="accordion-block-gallery__<?php echo $k; ?>">

                                                <div class="accordion-block-gallery--inner">
                                                <?php foreach ($item['pictures'] as $picture) { ?>
                                                    <div class="accordion-gallery-item">
                                                        <a  href="<?php echo $picture['url_detail']; ?>"
                                                            data-lightbox="accordion-gallery-<?php echo $k; ?>">
                                                            <div class="zoom-indicator">
                                                                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#magnifying-glass-plus"></use></svg>
                                                            </div>
                                                            <div class="accordion-gallery-item--image">
                                                                <img src="<?php echo $picture['url_teaser']; ?>"
                                                                     alt="<?php echo $picture['caption']; ?>"/>
                                                            </div>
                                                            <div class="accordion-gallery-item--copyright">
                                                                <?php echo $picture['copyright']; ?>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <?php
        }
    }
    ?>
</section>