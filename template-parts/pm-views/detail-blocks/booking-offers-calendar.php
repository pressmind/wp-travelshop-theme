<?php
use Pressmind\HelperFunctions;
use Pressmind\Search\CheapestPrice;
use Pressmind\Travelshop\IB3Tools;
use Pressmind\Travelshop\Template;
use Pressmind\Travelshop\PriceHandler;


/**
 * @var array $args
 */

if(empty($args['cheapest_price'])){
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
<div class="row content-block-detail-booking-calendar">
    <div class="col-12">
        <div class="booking-calendar-title">
            <h2>Buchungskalender
               <?php echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/duration.php', ['duration' => $args['cheapest_price']->duration]); ?>
                <?php
                echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/transport_type_human_string.php', [
                    'transport_type' => $args['cheapest_price']->transport_type,
                ]);
                ?>
            </h2>
            <?php if(count($durations) > 0 && count($transport_types) > 0){ ?>
            <div>
                <div class="btn-group" role="group" aria-label="Durations">
                    <?php
                        foreach($durations as $duration) { ?>
                            <a href="<?php echo Template::modifyUrl($args['url'], ['pm-du' => $duration, 'pm-dr' => '']); ?>" class="btn btn<?php echo ($duration == $args['cheapest_price']->duration) ? ' btn-primary' : ' btn-outline-primary';?>"><?php
                                echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration.php', [
                                    'duration' => $duration,
                                ]);
                                ?></a>
                    <?php } ?>
                </div>
                <div class="btn-group" role="group" aria-label="Durations">
                <?php
                foreach($transport_types as $transport_type) { ?>
                    <a href="<?php echo Template::modifyUrl($args['url'], ['pm-tr' => $transport_type, 'pm-dr' =>'']); ?>" class="btn btn<?php echo ($transport_type == $args['cheapest_price']->transport_type) ? ' btn-primary' : ' btn-outline-primary';?>"><?php

                        echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/transport_type_human_string.php', [
                            'transport_type' => $transport_type,
                        ]);

                    ?></a>
                <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="col-12">
        <div class="booking-calendar-slider">
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
                <div class="calendar-wrapper">
                    <div class="month-name">
                        <?php
                        echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/month-name.php', [
                            'date' => $dt]);
                        ?>
                    </div>
                    <ul class="calendar">
                        <?php
                        foreach (range(1, 7) as $day_of_week) {
                            ?>
                            <li class="weekday"><?php echo HelperFunctions::dayNumberToLocalDayName($day_of_week, 'short'); ?></li>
                            <?php
                        }
                        foreach ($days as $day) {
                            $current_date = $dt->format('Y-m-') . $day;
                            if (!empty($date_to_cheapest_price[$current_date])) {
                                ?>
                                <li class="travel-date position-relative" title="<?php
                                echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/duration.php', ['duration' => $date_to_cheapest_price[$current_date]->duration]); ?>
                                <?php
                                echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/transport_type_human_string.php', [
                                    'transport_type' => $date_to_cheapest_price[$current_date]->transport_type,
                                ]);
                                ?> <br> zur Buchung" data-html="true" data-toggle="tooltip"><a data-duration="<?php echo $date_to_cheapest_price[$current_date]->duration; ?>" data-anchor="<?php echo $date_to_cheapest_price[$current_date]->id; ?>" data-modal="true" data-modal-id="<?php echo $args['id_modal_price_box']; ?>" href="<?php echo IB3Tools::get_bookinglink($date_to_cheapest_price[$current_date], $args['url'], null, null, true);?>" class="stretched-link"><?php echo $day; ?>
                                        <div>ab&nbsp;<?php echo PriceHandler::format($date_to_cheapest_price[$current_date]->price_total); ?>
                                        </div>
                                    </a></li>
                                <?php
                            } else {
                                ?>
                                <li><?php echo $day; ?></li>
                                <?php
                            }
                        } ?>
                    </ul>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>