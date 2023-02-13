<?php
use Pressmind\Travelshop\PriceHandler;

/**
 * <code>
 * $args['cheapest_price'] CheapestPriceSpeed
 * </code>
 * @var array $args
 */
?>
<small><span>Preis p.P.</span> <strong>ab </strong></small><strong><?php echo PriceHandler::format($args['cheapest_price']->price_total); ?></strong>
