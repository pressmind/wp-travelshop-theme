<?php
/**
 * @var $args | mediaobject data
 */
?>

<div class="detail-header-info-top">

    <?php
    if ( !empty($args['zielgebiete']) ) {
        ?>
        <div class="detail-header-info-top-attributes">
            <?php foreach ( $args['zielgebiete'] as $item ) { ?>
                <a href="<?php echo $item['url']; ?>" title="<?php echo $item['name']; ?>" target="_blank">
                    <?php echo $item['name']; ?>
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
