<?php

use Pressmind\Travelshop\PriceHandler;

/**
 * @var array $args
 */

/**
 * @var Pressmind\ORM\Object\MediaObject $mo
 */
$mo = $args['media_object'];

/**
 * @var Pressmind\ORM\Object\CheapestPriceSpeed $cheapest_price
 */
$cheapest_price = $args['cheapest_price'];

?>
<?php if (!is_null($cheapest_price)) {
    $unique_extras = [];
    foreach ($mo->booking_packages as $booking_package) {
        foreach (['extras', 'tickets', 'sightseeings'] as $type) {
            foreach ($booking_package->{$type} as $extra) {
                $key = md5(implode(',', [
                        $extra->name,
                        $extra->price,
                        $extra->season,
                        is_null($extra->reservation_date_from) ? null : $extra->reservation_date_from->format('Y.m.d'),
                        is_null($extra->reservation_date_to) ? null : $extra->reservation_date_to->format('Y.m.d')
                    ])
                );
                if (!isset($unique_extras[$key])) {
                    $unique_extras[] = $extra;
                }
            }
        }
    }
    // @TODO saison handling missing
    if (count($unique_extras) > 0) { ?>
        <ul>
            <?php
            foreach ($unique_extras as $extra) { ?>
                <li>
                    <?php echo $extra->name . ' ' . PriceHandler::format($extra->price); ?>
                </li>
            <?php }
            ?>
        </ul>
        <?php
    }
}
