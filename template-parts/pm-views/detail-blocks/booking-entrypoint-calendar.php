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
            <div class="btn-group">
            <?php
            foreach($durations as $duration) { ?>
                <a href="<?php echo Template::modifyUrl($args['url'], ['pm-du' => $duration, 'pm-dr' => '']); ?>" class="btn <?php echo ($duration == $args['cheapest_price']->duration) ? ' btn-primary' : ' btn-outline-primary';?>"><?php
                    echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration.php', [
                        'duration' => $duration,
                    ]);
                    ?></a>
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
                    <div class="calendar-item-month h6">
                        <?php
                        echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/month-name.php', [
                            'date' => $dt]);
                        ?>
                    </div>
                    <div class="calender-item-wrapper">
                        <?php
                        foreach (range(1, 7) as $day_of_week) {
                            ?>
                            <div class="calender-item-day calender-item-weekday"><?php echo HelperFunctions::dayNumberToLocalDayName($day_of_week, 'short'); ?></div>
                            <?php
                        }

                        $class_map = [];
                        $class_map['3'] = 'bookable';
                        $class_map['1'] = 'request';
                        $class_map['5'] = 'stopp';

                        foreach ($days as $day) {
                            $current_date = $dt->format('Y-m-') . $day;
                            if (!empty($date_to_cheapest_price[$current_date])) {

                                ?>
                                <div class="calender-item-day travel-date position-relative <?php echo isset($class_map[$date_to_cheapest_price[$current_date]->state]) ? $class_map[$date_to_cheapest_price[$current_date]->state] : 'bookable';?>" title="<?php
                                echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/duration.php', ['duration' => $date_to_cheapest_price[$current_date]->duration]); ?>
                                <?php
                                echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/transport_type_human_string.php', [
                                    'transport_type' => $date_to_cheapest_price[$current_date]->transport_type,
                                ]);
                                ?> <br>  <?php

                                if(!empty($date_to_cheapest_price[$current_date]->price_regular_before_discount)){
                                    echo ' Frühbucherpreis: <br> statt '.PriceHandler::format($date_to_cheapest_price[$current_date]->price_regular_before_discount). ' nur '.PriceHandler::format($date_to_cheapest_price[$current_date]->price_total). ' <br>';
                                }

                                if($date_to_cheapest_price[$current_date]->state === 3){
                                    echo 'zur Buchung';
                                } else if($date_to_cheapest_price[$current_date]->state === 1){
                                    echo 'zur Anfrage';
                                }else{
                                    echo 'leider ausgebucht';
                                }



                                ?>" data-html="true" data-toggle="tooltip"><a data-duration="<?php echo $date_to_cheapest_price[$current_date]->duration; ?>" data-anchor="<?php echo $date_to_cheapest_price[$current_date]->id; ?>" data-modal="false" data-modal-id="<?php echo $args['id_modal_price_box']; ?>" href="<?php echo IB3Tools::get_bookinglink($date_to_cheapest_price[$current_date], $args['url'], null, null, true);?>" class="stretched-link"><?php echo $day; ?>
                                        <div data-offer-id="<?php echo $date_to_cheapest_price[$current_date]->id;?>" >ab&nbsp;<?php echo PriceHandler::format($date_to_cheapest_price[$current_date]->price_total); ?>
                                        </div>
                                    </a></div>
                                <?php
                            } else {
                                ?>
                                <div class="calender-item-day"><?php echo $day; ?></div>
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
