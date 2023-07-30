<?php
use Pressmind\HelperFunctions;
use Pressmind\Search\CheapestPrice;
use Pressmind\Travelshop\IB3Tools;
use Pressmind\Travelshop\Template;
use Pressmind\Travelshop\PriceHandler;


/**
 * @var array $args
 */

if(empty($args['cheapest_price']) || !empty($args['booking_on_request'])){
    return;
}

// build a date to best price map
$filter = new CheapestPrice();
$filter->occupancies_disable_fallback = false;

/**
 * @var \Pressmind\ORM\Object\CheapestPriceSpeed[] $offers
 */
$offers = $args['media_object']->getCheapestPrices($filter, ['date_departure' => 'ASC', 'price_total' => 'ASC'], [0, 100]);
?>

<div class="booking-offer-items">
    <?php
    foreach ( $offers as $offer ) {
        ?>
        <div class="booking-offer-item">
            <label for="offer<?php echo $offer->id; ?>">
                <input type="radio" name="offer" id="offer<?php echo $offer->id; ?>" />

                <div class="booking-offer-item-inner">
                    <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/travel-date-range.php', [
                        'date_departure' => $offer->date_departure,
                        'date_arrival' => $offer->date_arrival
                    ]);?>
                </div>
            </label>
        </div>
        <?php
    }
    ?>
</div>
