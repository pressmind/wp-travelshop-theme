<?php

use Pressmind\Registry;
use Pressmind\Travelshop\PriceHandler;
use Pressmind\Travelshop\Template;
/**
 * <code>
 * $args = [
 *  'id_media_object' => 12345
 *  'id_object_type' => 123
 *  'headline' => ''
 *  'subline' => ''
 *  'travel_type' => ''
 *  'destination' => ''
 *  'image' => []
 *  'cheapest_price' => {}
 *  'departure_date_count' => 12
 *  'possible_durations' => []
 *  'dates_per_month' => []
 *  'class' => ''
 * ];
 * </code>
 * @var array $args
 *
 */

/**
 * DON'T USE WordPress Stuff here
 */

$cheapest_price = $args['cheapest_price'];
$random = rand(1, 999999);
?>

<div class="product-calendar-group-item row" data-row-id="<?php echo $random; ?>" data-pm-id="<?php echo $args['id_media_object']; ?>">
    <div class="col-12 col-lg-3">
        <div class="arrow--wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 407.437 407.437" style="enable-background:new 0 0 407.437 407.437;" xml:space="preserve">
                <polygon points="386.258,91.567 203.718,273.512 21.179,91.567 0,112.815 203.718,315.87 407.437,112.815 " />
            </svg>
            <i class="circle green"></i>
            <?php
            if(!empty($cheapest_price)) {
                // var_dump($cheapest_price);
                echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/travel-date-range.php', [
                    'date_departure' => $cheapest_price->date_departures[0],
                    //'date_arrival' => $cheapest_price->date_arrival
                ]);
            }
            ?>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <strong><?php echo $args['headline']; ?></strong>
    </div>
    <div class="col-6 col-lg-2">
        <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration.php', ['duration' => $cheapest_price->duration]);?>
    </div>
    <div class="col-6 col-lg-3 md-align-right">
        <span class="price">
            <?php
            if (!empty($cheapest_price) && ($discount = PriceHandler::getDiscount($cheapest_price)) !== false) {
                echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/discount.php', [
                    'cheapest_price' => $cheapest_price,
                    'discount' => $discount,
                    'hide-price-total' => true,
                    'hide-discount-valid-to' => true,
                ]);
            }
            if (empty($cheapest_price->price_total) === false) {
                echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/price-1.php', [
                    'cheapest_price' => $cheapest_price,
                ]);
            }
            ?>
        </span>
    </div>
</div>
<div class="product-calendar-group-item--product row" data-row-id="<?php echo $random; ?>">
    <?php // this section will get the content by ajax; (pm-view/Teaser*), see ajax.js:initCalendarRowClick(); 
    ?>
</div>