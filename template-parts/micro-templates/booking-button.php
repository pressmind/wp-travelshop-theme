<?php

use Pressmind\Travelshop\IB3Tools;

/**
 * <code>
 * $args['cheapest_price'] CheapestPriceSpeed
 * $args['url']
 * $args['modal_id'] // if the modal is set, we make no available check
 * </code>
 * @var array $args
 */

?>

<a class="btn btn-primary btn-block booking-btn green" target="_blank"
   rel="nofollow"
    <?php
    if (!empty($args['modal_id'])) {
        echo 'data-modal="true" data-modal-id="' . $args['modal_id'] . '"';
    }
    ?>
   href="<?php echo IB3Tools::get_bookinglink($args['cheapest_price'], $args['url'], null, null, true); ?>"
   <?php if(isset($args['disable_id']) && $args['disable_id'] === false) { ?> data-id-offer="<?php echo $args['cheapest_price']->getId(); ?>" <?php } ?>
   data-anchor="<?php echo $args['cheapest_price']->id; ?>" >

    <span>zur Buchung</span>

    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-right"></use></svg>

    <img class="loader"
         src="<?php echo WEBSERVER_HTTP; ?>/wp-content/themes/travelshop/assets/img/loading-dots.svg">
</a>

