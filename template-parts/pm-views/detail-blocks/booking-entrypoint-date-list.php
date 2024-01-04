<?php
use Pressmind\HelperFunctions;
use Pressmind\Search\CheapestPrice;
use Pressmind\Travelshop\IB3Tools;
use Pressmind\Travelshop\Template;
use Pressmind\Travelshop\PriceHandler;


/**
 * @var array $args
 * <code>
 * $args['media_object']
 * </code>
 *
 */

if(!empty($args['booking_on_request'])){
    return;
}
if(empty($args['calendar_filter'])){
    $args['calendar_filter'] = null;
}

$calendar = $args['media_object']->getCalendar($args['calendar_filter']);
?>
<div class="booking-offer-items">
    <?php
    foreach ($calendar->calendar->month as $month) {
        foreach ($month->days as $day) {
            if (empty($day->cheapest_price)) {
                continue;
            }
        ?>
        <div class="booking-offer-item">
            <label for="offer<?php echo $day->cheapest_price->id_date; ?>"
                   class="booking-offer-item-label<?php // class 'is-active' is set via jquery*/ ?>">
                <input type="radio" name="date"
                       id="offer<?php echo $day->cheapest_price->id_date; ?>"
                       data-id_date="<?php echo $day->cheapest_price->id_date; ?>"
                       data-duration="<?php echo $calendar->calendar->booking_package->duration ?>"
                       data-date-range="<?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/travel-date-range.php', [
                           'date_departure' => $day->cheapest_price->date_departure,
                           'date_arrival' => $day->cheapest_price->date_arrival
                       ]);?>"
                       class="stretched-link"
                       data-id_option="<?php echo $day->cheapest_price->id_option; ?>"
                       data-date_departure="<?php echo $day->cheapest_price->date_departure->format('Y-m-d'); ?>"
                       data-id_booking_package="<?php echo $day->cheapest_price->id_booking_package; ?>"
                       data-id_housing_package="<?php echo $day->cheapest_price->id_housing_package; ?>"
                       data-id_offer = "<?php echo $day->cheapest_price->id; ?>"
                       data-id_transport_pair="<?php echo $day->cheapest_price->id_transport_1.','.$day->cheapest_price->id_transport_2; ?>"
                       data-price_info='<?php
                       if (($discount = PriceHandler::getDiscount($day->cheapest_price)) !== false) {
                           echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/discount.php', [
                               'cheapest_price' => $day->cheapest_price,
                               'discount' => $discount,
                           ]);
                       } else {
                           echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/price.php', [
                               'cheapest_price' => $day->cheapest_price,
                           ]);
                       } ?>'
                       data-booking_url="<?php echo IB3Tools::get_bookinglink($day->cheapest_price, SITE_URL, null, null, true); ?>"<?php /* attribut 'checked="checked"' is set by jquery */?> />
                <span>
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#circle-filled"></use></svg>
                </span>

                <div class="booking-offer-item-inner">
                    <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/travel-date-range.php', [
                        'date_departure' => $day->cheapest_price->date_departure,
                        'date_arrival' => $day->cheapest_price->date_arrival
                    ]);?>
                </div>
            </label>
        </div>
        <?php
        }
    }
    ?>
</div>