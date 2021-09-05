<?php
/**
 * <code>
 *  $args = (
 *          [headline] => Reise-Empfehlungen
 *          [text] => Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip.
 *      )
 * </code>
 * @var array $args
 */

use Pressmind\Search\CheapestPrice;
use Pressmind\HelperFunctions;
use Pressmind\Travelshop\PriceHandler;
use Pressmind\Travelshop\Calendar;

// get the calendar items
$items = Calendar::get();

// abort if nothing to display
if (count($items) == 0) {
    return;
}

?>
<section class="content-block">
    <div class="row">
        <?php if (!empty($args['headline']) || !empty($args['text'])) { ?>
            <div class="col-12">
                <?php if (!empty($args['headline'])) { ?>
                    <h2 class="mt-0">
                        <?php echo $args['headline']; ?>
                    </h2>
                <?php } ?>
                <?php if (!empty($args['text'])) { ?>
                    <p>
                        <?php echo $args['text']; ?>
                    </p>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="col-12">
            <div class="product-calendar-wrap">
                <?php
                // group items by month & year
                $itemsGroupedByMonth = [];
                foreach ($items as $item) {
                    $item->date_departure = new DateTime($item->date_departure);
                    $itemsGroupedByMonth[$item->date_departure->format('m.Y')][] = $item;
                }

                // use grouped array to render items
                $month_count = 1;
                foreach ($itemsGroupedByMonth as $items) { ?>
                    <div class="product-calendar-group">

                        <div class="product-calendar-group--title">
                            <h3><?php
                                echo HelperFunctions::monthNumberToLocalMonthName($items[0]->date_departure->format('n'));
                                echo $items[0]->date_departure->format('Y') != date('Y') ? ' '.$items[0]->date_departure->format('Y') : '';
                                ?>
                            </h3>
                        </div>

                        <div class="product-calendar-group--items">
                            <div class="product-calendar-items--title row d-none d-md-flex">
                                <div class="col-3">Reisezeitraum</div>
                                <div class="col-4">Reise</div>
                                <div class="col-2">Dauer</div>
                                <div class="col-3 md-align-right">Preis</div>
                            </div>
                            <?php

                            $date_count = 1;
                            foreach ($items as $item) {

                                $mo = new \Pressmind\ORM\Object\MediaObject($item->id);
                                $CheapestPriceFilter = new CheapestPrice();
                                $CheapestPriceFilter->date_from = $CheapestPriceFilter->date_to = $item->date_departure;
                                $CheapestPriceFilter->occupancies = [2];
                                $cheapest_price = $mo->getCheapestPrice($CheapestPriceFilter);

                                ?>
                                <div class="product-calendar-group-item row"
                                     data-row-id="<?php echo $month_count . "-" . $date_count; ?>"
                                     data-pm-id="<?php echo $item->id;?>"
                                     data-pm-dr="<?php echo $CheapestPriceFilter->date_from->format("Ymd").'-'.$CheapestPriceFilter->date_to->format("Ymd");?>">

                                    <div class="col-12 col-md-3">
                                        <div class="arrow--wrapper">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                                 x="0px" y="0px" viewBox="0 0 407.437 407.437"
                                                 style="enable-background:new 0 0 407.437 407.437;"
                                                 xml:space="preserve">
                                        <polygon
                                                points="386.258,91.567 203.718,273.512 21.179,91.567 0,112.815 203.718,315.87 407.437,112.815 "/>
                                    </svg>
                                            <i class="circle green"></i>
                                            <?php
                                            echo HelperFunctions::dayNumberToLocalDayName($cheapest_price->date_departure->format('N'), 'short').'. '.
                                                 $cheapest_price->date_departure->format('d.m.').
                                                 ' - '.
                                                 HelperFunctions::dayNumberToLocalDayName($cheapest_price->date_arrival->format('N'), 'short').'. '.
                                                 $cheapest_price->date_arrival->format('d.m.');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <strong><?php echo $item->name;?></strong>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <?php echo $cheapest_price->duration . ' Tage'; ?>
                                    </div>
                                    <div class="col-6 col-md-3 md-align-right">
                                        <span class="price">
                                            <?php
                                            if (($discount = PriceHandler::getDiscount($cheapest_price)) !== false) {
                                                ?>
                                                <div class="discount-wrapper">
                                                    <p>
                                                        <span class="msg"><?php echo $discount['name']; ?></span>
                                                        <span class="discount-label">
                                                            <span class="price"><?php echo $discount['price_before_discount']; ?></span>
                                                            <span class="discount"><?php echo $discount['price_delta']; ?></span>
                                                        </span>
                                                    </p>
                                                </div>
                                                <?php
                                            }
                                            if (empty($cheapest_price->price_total) === false) {
                                                echo '<small><span>Preis p.P.</span> <strong>ab</strong> </small><strong>' . PriceHandler::format($cheapest_price->price_total). '</strong>';
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="product-calendar-group-item--product row"
                                     data-row-id="<?php echo $month_count . "-" . $date_count; ?>">
                                    <?php // this section will get the content by ajax; (pm-view/Teaser*), see ajax.js:initCalendarRowClick(); ?>
                                </div>
                                <?php
                                $date_count++;
                            } // each date
                            ?>
                        </div>
                    </div>
                    <?php
                    $month_count++;
                } // each month
                ?>
            </div>
        </div>
    </div>
</section>