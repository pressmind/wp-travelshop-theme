<?php
/**
 * @var $args | mediaobject data
 */
?>

<div class="detail-header-info-top">

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
            <?php echo $args['usps']; ?>
        <?php } ?>
    </div>
</div>
