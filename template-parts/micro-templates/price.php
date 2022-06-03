<?php
use Pressmind\Travelshop\PriceHandler;

/**
 * <code>
 * $args['cheapest_price'] CheapestPriceSpeed
 * </code>
 * @var array $args
 */

if(empty($args['cheapest_price'])){
    return;
}
?>
<span class="price-total">ab <strong><?php echo PriceHandler::format($args['cheapest_price']->price_total); ?></strong></span>