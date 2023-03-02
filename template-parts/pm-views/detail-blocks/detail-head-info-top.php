<?php
/**
 * @var $args | mediaobject data
 */
?>

<div class="detail-header-info-top">
    <h2><?php echo $args['name']; ?></h2>
    <?php if (!empty($args['subline'])) { ?>
        <p><?php echo $args['subline']; ?></p>
    <?php } ?>
    <?php if (!empty($args['usps'])) { ?>
        <div class="detail-services-desktop">
            <?php echo $args['usps']; ?>
        </div>
    <?php } ?>
</div>
