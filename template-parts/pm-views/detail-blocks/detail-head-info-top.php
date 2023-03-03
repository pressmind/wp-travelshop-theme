<?php
/**
 * @var $args | mediaobject data
 */
?>

<div class="detail-header-info-top">

    <div data-pm-id="<?php echo $args['id_media_object']; ?>"
         data-pm-ot="<?php echo $args['id_object_type']; ?>"
         data-pm-dr="<?php //echo !is_null($args['cheapest_price']) ? $args['cheapest_price']->date_arrival->format('Ymd') . '-' . $args['cheapest_price']->date_arrival->format('Ymd') : ''; ?>"
         data-pm-du="<?php echo !is_null($args['cheapest_price']) ? $args['cheapest_price']->duration : ''; ?>"
         class="add-to-wishlist">
        <svg class="heart-stroke"><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#heart-straight"></use></svg>
        <svg class="heart-filled"><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#heart-straight-filled"></use></svg>

    </div>

    <?php
    if ( !empty($args['destination_attributes']) || !empty($args['travel_type_attributes']) ) {
        ?>
        <div class="detail-header-info-top-attributes">
            <?php if ( !empty($args['travel_type_attributes']) ) { ?>
                <a href="<?php echo $args['travel_type_attributes']->url; ?>" title="<?php echo $args['travel_type_attributes']->name; ?>" target="_blank">
                    <?php echo $args['travel_type_attributes']->name; ?>
                </a>
                <?php if ( !empty($args['destination_attributes']) ) { ?>
                    <span class="attribute-sep">&middot;</span>
                <?php } ?>
            <?php } ?>
            <?php if ( !empty($args['destination_attributes']) ) { ?>
                <a href="<?php echo $args['destination_attributes']->url; ?>" title="<?php echo $args['destination_attributes']->name; ?>" target="_blank">
                    <?php echo $args['destination_attributes']->name; ?>
                </a>
            <?php } ?>
        </div>
        <?php
    }
    ?>
    <div class="detail-header-info-top-body">
        <h2><?php echo $args['name']; ?></h2>
        <?php if (!empty($args['subline'])) { ?>
            <p><?php echo $args['subline']; ?></p>
        <?php } ?>
        <?php if (!empty($args['usps'])) { ?>
            <?php echo checklist_formatter($args['usps']); ?>
        <?php } ?>
    </div>
</div>
