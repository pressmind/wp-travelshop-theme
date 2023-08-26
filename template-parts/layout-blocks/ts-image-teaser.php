<?php
/**
 * @var array $args defined by module
 */

// get some basic variables
$headline = $args['headline'];
$text = $args['text'];
$layout_type = $args['layout_type'];
$columns = (int)$args['display_on_desktop'];
$mobile_slider = false;

if ( $layout_type !== 'slider' && $args['mobile_slider'] === 'yes' ) {
    $mobile_slider = true;
}

$items = $args['teasers'];

?>

<section class="content-block content-block-ts-image-teaser" id="ts-image-teaser-<?php echo $args['uid']; ?>">

    <?php if ( !empty($headline) || !empty($text) ) { ?>
    <div class="row row-introduction">
        <div class="col-12">
                <?php if ( !empty($headline) ) { ?>
                    <h2>
                        <?php echo $headline; ?>
                    </h2>
                <?php } ?>
                <?php if ( !empty($text) ) { ?>
                    <p>
                        <?php echo trim($text); ?>
                    </p>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <div class="row row-products">

        <?php
        if ( count($items) > 0 ) {
            ?>
            <div class="col-12">
                <?php
                $wrapper = 'row';
                $item_wrapper = 'col-12 col-md-6 col-lg-4';

                if ( $columns === 4 ) {
                    $item_wrapper = 'col-12 col-md-6 col-lg-3';
                }

                if ( $columns === 2 ) {
                    $item_wrapper = 'col-12 col-md-6';
                }

                if ( $layout_type === 'slider' ) {
                    $wrapper = 'item-slider-wrapper';
                    $item_wrapper = 'slider-item';
                }

                if ( $layout_type === 'default' && $mobile_slider ) {
                    $wrapper = 'item-default-wrapper item-slider-wrapper--mobile';
                    $item_wrapper = 'default-item slider-item';
                }
                ?>

                <div class="<?php echo $wrapper; ?>" data-columns="<?php echo $columns; ?>">
                    <?php
                    foreach ( $items as $item ) {
                        $item = (array)$item;
                        ?>
                        <div class="<?php echo $item_wrapper; ?>">
                            <article class="ts-image-teaser">
                                <?php
                                if ( !empty($item['link']) ) {
                                ?>
                                <a href="<?php echo $item['link']; ?>" target="<?php echo $item['link_target']; ?>" title="<?php echo $item['headline']; ?>">
                                    <?php
                                    }
                                    ?>
                                    <?php if ( !empty($item['image']) ) { ?>
                                        <div class="teaser-image">
                                            <?php
                                            $image_id = $item['image'];
                                            $image_src = wp_get_attachment_image_src($image_id, 'large', false);
                                            ?>

                                            <div class="media media-cover media-overlay media-overlay-full">
                                                <img src="<?php echo $image_src[0]; ?>" />
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="teaser-body <?php if ( !empty($item['link']) ) { ?>has-link<?php } ?>">
                                        <div class="teaser-body-inner">

                                            <h1 class="h4">
                                                <?php echo $item['headline']; ?>
                                            </h1>

                                                <?php if ( !empty($item['text']) ) { ?>
                                                    <div class="teaser-sub-line">
                                                        <?php echo trim($item['text']); ?>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>

                                        <?php if ( !empty($item['link']) ) { ?>
                                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-right"></use></svg>
                                        <?php } ?>
                                    </div>

                                    <?php
                                    if ( !empty($item['link']) ) {
                                    ?>
                                </a>
                            <?php
                            }
                            ?>
                            </article>
                        </div>

                        <?php
                    }
                    ?>
                </div>



                <?php if ( $layout_type === 'slider' || $mobile_slider ) { ?>
                    <?php load_template( get_stylesheet_directory().'/template-parts/micro-templates/slider-controls.php', false, []); ?>
                <?php } ?>
            </div>
            <?php
        } else {
            ?>
            <div class="col-12">
                <div class="alert alert-info">
                    No items found. Set it up in BeaverBuilder
                </div>
            </div>
            <?php
        }
        ?>
    </div>


    <?php if ( !empty($args['button_link']) && !empty($args['button_text']) ) { ?>
        <div class="row row-button">
            <div class="col-12">
                <a class="btn btn-primary" href="<?php echo site_url(); ?>/<?php echo $args['button_link'];?>" role="button" <?php
                echo !empty($args['button_link_target']) ? ' target="'.$args['button_link_target'].'"' : '';
                echo (!empty($args['button_link_nofollow']) && $args['button_link_nofollow'] == 'yes') ? ' rel="nofollow"' : '';
                ?>>

                    <?php echo !empty($args['button_text']) ? $args['button_text'] : '';?>
                </a>
            </div>
        </div>
    <?php } ?>


</section>