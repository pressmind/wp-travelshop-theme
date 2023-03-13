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

/**
 * @var \Pressmind\ORM\Object\CheapestPriceSpeed[] $date_to_cheapest_price
 */
$date_to_cheapest_price = [];
$durations = [];
$transport_types = [];
foreach($offers as $offer){
        $durations[] = $offer->duration;
        $transport_types[] = $offer->transport_type;
        if($offer->duration != $args['cheapest_price']->duration) {
            continue;
        }
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
$durations = array_unique(array_filter($durations), SORT_NUMERIC);
$transport_types = array_unique(array_filter($transport_types), SORT_ASC);

// find the min and max date range
$from = new DateTime(array_key_first($date_to_cheapest_price));
$from->modify('first day of this month');
$to = new DateTime(array_key_last($date_to_cheapest_price));
$to->modify('first day of next month');

// display always three month, even if only one or two months have a valid travel date
$interval = $to->diff($from);
if ($interval->format('%m') < 3) {
    $add_months = 3 - $interval->format('%m');
    $to->modify('+' . $add_months . ' month');
}

?>
<div class="booking-entrypoint-calendar">
    <?php if(count($durations) > 1){ ?>
        <div class="booking-entrypoint-calender-duration">
            <div class="duration-switch">
            <?php
            foreach($durations as $duration) { ?>
                <button type="button" data-duration="<?php echo $duration; ?>" class="<?php echo ($duration == $args['cheapest_price']->duration) ? 'active' : '';?>"><?php
                    echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration.php', [
                        'duration' => $duration,
                    ]);
                    ?></button>
            <?php } ?>
            </div>
        </div>
    <?php } ?>

    <div class="booking-entrypoint-calendar-outer">
        <div class="booking-entrypoint-calendar-inner">
            <?php
            $today = new DateTime();
            // loop trough all months
            foreach (new DatePeriod($from, new DateInterval('P1M'), $to) as $dt) {
                // fill the calendar grid
                $days = array_merge(
                    array_fill(1, $dt->format('N') - 1, ' '),
                    range(1, $dt->format('t'))
                );
                if (count($days) < 35) {
                    $delta = 35 - count($days);
                    $days = array_merge($days, array_fill(1, $delta, ' '));
                }
                ?>
                <div class="booking-entrypoint-calendar-item calendar-item">
                    <div class="calendar-item-month h5">
                        <?php
                        echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/month-name.php', [
                            'date' => $dt]);
                        ?>
                    </div>
                    <div class="calendar-item-wrapper">
                        <?php
                        foreach (range(1, 7) as $day_of_week) {
                            ?>
                            <div class="calendar-item-day calendar-item-weekday"><?php echo HelperFunctions::dayNumberToLocalDayName($day_of_week, 'short'); ?></div>
                            <?php
                        }

                        $class_map = [];
                        $class_map['3'] = 'bookable';
                        $class_map['1'] = 'request';
                        $class_map['5'] = 'stopp';
                        $active = false;
                        $activeDuration = false;
                        $activeDurationLast = false;
                        $iterateDuration = false;
                        $iterateDurationDays = 1;
                        $setDuration = 0;

                        foreach ($days as $day) {
                            $current_date = $dt->format('Y-m-') . $day;

                            if ( $iterateDuration = true ) {
                                if ( $iterateDurationDays == ($setDuration - 1) ) {
                                    $activeDurationLast = true;
                                }
                                if ( $iterateDurationDays < $setDuration ) {
                                    $iterateDurationDays++;
                                } else {
                                    $iterateDurationDays = 1;
                                    $activeDuration = false;
                                    $activeDurationLast = false;
                                }
                            }

                            if (!empty($date_to_cheapest_price[$current_date])) {

                                // -- hook for current date
                                if ( isset($_POST['offer']) && ( intval($_POST['offer']) === $date_to_cheapest_price[$current_date]->id ) ) {
                                    $active = true;
                                    $iterateDuration = true;
                                    $activeDuration = true;
                                    $setDuration = $date_to_cheapest_price[$current_date]->duration;
                                } else {
                                    $active = false;
                                }

                                $dateDateRange = Template::render(APPLICATION_PATH . '/template-parts/micro-templates/travel-date-range.php', [
                                    'date_departure' => $date_to_cheapest_price[$current_date]->date_departure,
                                    'date_arrival' => $date_to_cheapest_price[$current_date]->date_arrival
                                ]);?>

                                <div class="calendar-item-day <?php echo !$activeDuration ? '' : 'active-duration'; ?> <?php echo !$activeDurationLast ? '' : 'active-duration-last'; ?> <?php echo !$active ? '' : 'active'; ?> travel-date position-relative <?php echo isset($class_map[$date_to_cheapest_price[$current_date]->state]) ? $class_map[$date_to_cheapest_price[$current_date]->state] : 'bookable';?>" data-html="true" data-toggle="tooltip">
                                    <a data-daterange="<?php echo $dateDateRange; ?>" data-duration="<?php echo $date_to_cheapest_price[$current_date]->duration; ?>" data-anchor="<?php echo $date_to_cheapest_price[$current_date]->id; ?>" data-modal="false" data-modal-id="<?php echo $args['id_modal_price_box']; ?>" href="<?php echo IB3Tools::get_bookinglink($date_to_cheapest_price[$current_date], $args['url'], null, null, true);?>" class="stretched-link"><?php echo $day; ?>
                                        <div  data-offer-id="<?php echo $date_to_cheapest_price[$current_date]->id;?>" ><?php echo PriceHandler::format($date_to_cheapest_price[$current_date]->price_total); ?>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="calendar-item-day <?php echo is_string($day) ? 'is-blank' : ''; ?> <?php echo (!$activeDurationLast && is_string($day)) ? '' : 'active-duration-last'; ?> <?php echo (!$activeDuration && is_string($day)) ? '' : 'active-duration'; ?>"><?php echo $day; ?></div>
                                <?php
                            }
                        } ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
