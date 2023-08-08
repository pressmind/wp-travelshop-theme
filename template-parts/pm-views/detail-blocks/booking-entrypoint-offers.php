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

$date_to_cheapest_price = [];
foreach($offers as $offer){

    // if the date has multiple prices, display only the cheapest
    if (!empty($date_to_cheapest_price[$offer->date_departure->format('Y-m-j')]) &&
        $offer->price_total < $date_to_cheapest_price[$offer->date_departure->format('Y-m-j')]->price_total
    ) {
        // set the cheapier price
        $date_to_cheapest_price[$offer->date_departure->format('Y-m-j')] = $offer;
    } elseif (empty($date_to_cheapest_price[$offer->date_departure->format('Y-m-j')])
    ){
        $date_to_cheapest_price[$offer->date_departure->format('Y-m-j')] = $offer;
    }
}
?>


<div class="booking-offer-items">
    <?php
    $activeOffer = false;
    foreach ( $offers as $offer ) {
        $activeOffer = ( $offer->id === $args['offer_id'] ) ? true : false;

        $current_date = $offer->date_departure->format('Y-m-j');

        $priceHTML = '';

        if (($discount = PriceHandler::getDiscount($date_to_cheapest_price[$current_date])) !== false) {
            $priceHTML = Template::render(APPLICATION_PATH.'/template-parts/micro-templates/discount.php', [
                'cheapest_price' => $date_to_cheapest_price[$current_date],
                'discount' => $discount,
            ]);
        } else {
            $priceHTML = Template::render(APPLICATION_PATH.'/template-parts/micro-templates/price.php', [
                'cheapest_price' => $date_to_cheapest_price[$current_date],
            ]);
        }

        $dateDateRange = Template::render(APPLICATION_PATH . '/template-parts/micro-templates/travel-date-range.php', [
            'date_departure' => $date_to_cheapest_price[$current_date]->date_departure,
            'date_arrival' => $date_to_cheapest_price[$current_date]->date_arrival
        ]);
        ?>
        <div class="booking-offer-item">
            <label data-price-html='<?php echo $priceHTML; ?>'
                   for="offer<?php echo $offer->id; ?>"
                   class="booking-offer-item-label <?php echo ($activeOffer) ? 'is-active' : ''; ?>"
                   data-offer-id="<?php echo $offer->id; ?>"
                   data-duration="<?php echo $offer->duration; ?>"
                   data-booking-url="<?php echo IB3Tools::get_bookinglink($date_to_cheapest_price[$current_date], $args['url'], null, null, true);?>"
                   data-daterange="<?php echo $dateDateRange; ?>"
            >
                <input type="radio" name="offer" id="offer<?php echo $offer->id; ?>" <?php echo ($activeOffer) ? 'checked="checked"' : ''; ?> />


                <span>
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#circle-filled"></use></svg>
                </span>

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
