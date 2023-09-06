<?php

use Pressmind\Travelshop\PriceHandler;

/**
 * <code>
 * $args['cheapest_price'] CheapestPriceSpeed
 * $args['discount']
 * $args['prefix']
 * $args['hide-price-total'] = bool
 * $args['hide-discount-valid-to'] = bool
 * </code>
 * @var array $args
 */
?>
<div class="discount-wrapper">
    <?php echo !empty($args['prefix']) ? $args['prefix'] : ''; ?>
    <div class="discount-wrapper--inner">
        <?php if(empty($args['hide-price-total'])) {?>
            <span class="price-total">ab <strong><?php echo PriceHandler::format($args['cheapest_price']->price_total); ?></strong></span>
        <?php } ?>
        <span class="msg"><?php echo $args['discount']['name']; ?>
            <?php if (empty($args['hide-discount-valid-to']) && !empty($args['discount']['valid_to'])) {
                echo ' bis ' . $args['discount']['valid_to']->format('d.m.');
            } ?>
        </span>
        <span class="discount-label">
            <span class="price"><?php echo $args['discount']['price_before_discount']; ?></span>
            <span class="discount"><?php echo $args['discount']['price_delta']; ?></span>
        </span>
    </div>
</div>