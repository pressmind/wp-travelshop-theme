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

if(empty($args['calendar_filter'])){
    $args['calendar_filter'] = null;
}

$calendar = $args['media_object']->getCalendar($args['calendar_filter']);
$filter = $calendar->filter;

?>
<div class="booking-entrypoint-calendar">
    <?php /* if(count($filter['durations']) > 1){ ?>
        <div class="booking-entrypoint-calender-duration">
            <div class="duration-switch">
            <?php
            foreach($filter['durations'] as $duration => $items) { ?>
                <button type="button" data-duration="<?php echo $duration; ?>" class="<?php echo ($duration == $args['cheapest_price']->duration) ? 'active' : '';?>"><?php
                    echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration.php', [
                        'duration' => $duration,
                    ]);
                    ?></button>
            <?php } ?>
            </div>
        </div>
    <?php } */ ?>

    <div class="booking-entrypoint-calendar-outer">
        <div class="booking-entrypoint-calendar-inner">
            <?php
            foreach ($calendar->calendar->month as $month) {
                $transport_type = $calendar->calendar->transport_type;
                ?>
                <div class="booking-entrypoint-calendar-item calendar-item">
                    <div class="calendar-item-month h5">
                        <?php
                        echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/month-name.php', [
                            'date' => $month->days[0]->date]);
                        ?>
                    </div>
                    <div class="calendar-item-wrapper">
                        <?php
                        foreach (range(1, 7) as $day_of_week) {
                            ?>
                            <div class="calendar-item-day calendar-item-weekday"><?php echo HelperFunctions::dayNumberToLocalDayName($day_of_week, 'short'); ?></div>
                            <?php
                        }
                        foreach ($month->days as $day) {
                            if (!empty($day->cheapest_price)) {
                                ?>
                                <div class="calendar-item-day travel-date position-relative bookable"
                                     data-html="true" data-toggle="tooltip">
                                    <a data-id_date="<?php echo $day->cheapest_price->id_date; ?>"
                                       data-duration="<?php echo $calendar->calendar->booking_package->duration; ?>"
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
                                       data-booking_url="<?php echo IB3Tools::get_bookinglink($day->cheapest_price); ?>"
                                    >
                                        <?php echo $day->date->format('d'); ?>
                                        <div>
                                            <?php echo PriceHandler::format($day->cheapest_price->price_total); ?>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="calendar-item-day"><?php echo $day->date->format('d'); ?></div>
                                <?php
                            }
                        } ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
        echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/slider-controls.php', []);
        ?>
    </div>
</div>
