<?php

use Pressmind\HelperFunctions;
use Pressmind\Search\CheapestPrice;
use Pressmind\Travelshop\IB3Tools;
use Pressmind\Travelshop\PriceHandler;
use Pressmind\Travelshop\Template;

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
<?php if (!is_null($cheapest_price)) { ?>

    <section class="content-block content-block-detail-booking" id="content-block-detail-booking">
        <div class="container">
           <?php require 'booking-offers-calendar.php'; ?>
            <div class="row">
                <div class="col-12">
                    <h2>Termine &amp; Preise</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="content-block-detail-booking-inner">

                        <!--
                        <div class="booking-row no-gutters row booking-row-head d-none d-lg-flex">
                            <div class="col-2">
                                Dauer
                            </div>
                            <div class="col-3">
                                Zeitraum
                            </div>
                            <div class="col-3">
                                Unterbringung
                            </div>
                            <div class="col-2">
                                Preis pro Person
                            </div>
                        </div>-->
                    <?php

                    // group result by date and cheapest occupancy
                    $date_group = [];

                    foreach ($mo->booking_packages as $booking_package) {
                            foreach ($booking_package->dates as $date) {

                                $tmp = [
                                        'date' => $date,
                                        'booking_package' => $booking_package,
                                        'occupancies' => [],
                                        'discounts' => []
                                ];


                                foreach ($date->getHousingOptions() as $key => $housing_option) {

                                    $cheapest_price_filter = new CheapestPrice();
                                    $cheapest_price_filter->id_option = $housing_option->id;
                                    $cheapest_price_filter->id_booking_package = $housing_option->id_booking_package;
                                    $cheapest_price_filter->id_date = $date->id;
                                    $housing_options_cheapest_price = $mo->getCheapestPrice($cheapest_price_filter);

                                    // get all discounts for this date, to output the biggest available discount
                                    if(!empty($housing_option->discount)) {
                                        $discount = $housing_option->discount->toStdClass();
                                        foreach($discount->scales as $scale){
                                            $tmp['discount_scales'][$scale->id] = $scale;
                                        }
                                    }

                                    if(empty($occupancies[$housing_option->occupancy])){ // if is not set
                                        $tmp['occupancies'][$housing_option->occupancy]['option'] = $housing_option;
                                        $tmp['occupancies'][$housing_option->occupancy]['cheapest_price'] = $housing_options_cheapest_price;
                                    }elseif($occupancies[$housing_option->occupancy]['cheapest_price']->price_total >
                                        $housing_options_cheapest_price->price_total){ // if the option is cheaper as the previos
                                        $tmp['occupancies'][$housing_option->occupancy]['option'] = $housing_option;
                                        $tmp['occupancies'][$housing_option->occupancy]['cheapest_price'] = $housing_options_cheapest_price;
                                    }

                                }

                                $date_group[] = $tmp;
                            }
                    }


                            ?>

                        <?php


                                $current_month = null;
                                $current_year = new DateTime();
                                foreach ($date_group as $key => $row) {

                                    /**
                                     * @var $date Pressmind\ORM\Object\Touristic\Date
                                     */
                                    $date = $row['date'];

                                    /**
                                     * @var $housing_option_primary Pressmind\ORM\Object\Touristic\Option
                                     */
                                    $housing_option_primary = $row['occupancies'][2]['option'];

                                    /**
                                     * @var $housing_option_secondary Pressmind\ORM\Object\Touristic\Option
                                     */
                                    $housing_option_secondary = $row['occupancies'][1]['option'];

                                    /**
                                     * @var $housing_options_cheapest_price_primary Pressmind\ORM\Object\CheapestPriceSpeed
                                     */
                                    $housing_options_cheapest_price_primary = $row['occupancies'][2]['cheapest_price'];

                                    /**
                                     * @var $housing_options_cheapest_price_secondary Pressmind\ORM\Object\CheapestPriceSpeed
                                     */
                                    $housing_options_cheapest_price_secondary = $row['occupancies'][1]['cheapest_price'];

                                    /**
                                     * @var $booking_package \Pressmind\ORM\Object\Touristic\Booking\Package
                                     */
                                    $booking_package = $row['booking_package'];


                                    /**
                                     * @var $discount_scales \Pressmind\ORM\Object\Touristic\Option\Discount\Scale[]
                                     */
                                    $discount_scales = $row['discount_scales'];



                                    $housing_package = $housing_option_primary->getHousingPackage();
                                    $checked = ($cheapest_price->id_option == $housing_option_primary->id && $cheapest_price->id_date == $date->id);

?>

                                    <?php
                                    // Output the month name
                                    if($current_month != $date->departure->format('m-Y')){
                                        $current_month = $date->departure->format('m-Y');
                                    ?>

                                        <div class="booking-row no-gutters row booking-row-head d-none d-lg-flex">
                                            <div class="col-12">
                                                <h3><?php
                                                    echo HelperFunctions::monthNumberToLocalMonthName($date->departure->format('n'));

                                                    if($date->departure->format('Y') != $current_year->format('Y')){
                                                        echo ' '.$date->departure->format('Y');
                                                    }


                                                    ?>

                                                </h3>
                                            </div>
                                        </div>
                                        <?php
                                    }

                                    ?>
                                    <div class="booking-row no-gutters row booking-row-date<?php echo $checked ? ' checked' : '';?>">
                                        <?php if($checked){?>
                                            <div class="checked-state check-state-success">
                                                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#check-bold"></use></svg>
                                            </div>
                                        <?php } ?>
                                        <div class="col-12 col-lg-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <circle cx="12" cy="12" r="9" />
                                                <polyline points="12 7 12 12 15 15" />
                                            </svg>
                                            <?php echo $booking_package->duration; ?>
                                            Tag<?php echo($booking_package->duration > 1 ? 'e' : ''); ?>
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <rect x="4" y="5" width="16" height="16" rx="2" />
                                                <line x1="16" y1="3" x2="16" y2="7" />
                                                <line x1="8" y1="3" x2="8" y2="7" />
                                                <line x1="4" y1="11" x2="20" y2="11" />
                                                <rect x="8" y="15" width="2" height="2" />
                                            </svg>
                                            <span class="date">
                                                <?php echo HelperFunctions::dayNumberToLocalDayName($date->departure->format('N'), 'short'); ?>.
                                                <?php echo $date->departure->format('d.m.'); ?>
                                                -
                                                <?php echo HelperFunctions::dayNumberToLocalDayName($date->arrival->format('N'), 'short'); ?>.
                                                <?php echo $date->arrival->format('d.m.Y'); ?>
                                            </span>

                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bed" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M3 7v11m0 -4h18m0 4v-8a2 2 0 0 0 -2 -2h-8v6" />
                                                <circle cx="7" cy="10" r="1" />
                                            </svg>
                                            <div>
                                                <?php
                                                echo implode(',', array_filter([$housing_package->name, $housing_option_primary->name]));
                                                ?><br />
                                                <small>
                                                    Belegung: <?php echo $housing_option_primary->occupancy; echo ' Person'; if ($housing_option_primary->occupancy > 1) { echo 'en'; } ?>

                                                    <?php  echo empty($housing_option_primary->board_type) ? '' : '<br />inkl. '.$housing_option_primary->board_type; ?>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-2 price-container">

                                            <?php
                                            if (($discount = PriceHandler::getDiscount($housing_options_cheapest_price_primary)) !== false) {
                                                ?>
                                                <div class="discount-wrapper">
                                                    <div class="discount-wrapper--inner">
                                                        <span class="price-total">ab <strong><?php
                                                                echo PriceHandler::format($housing_options_cheapest_price_primary->price_total);
                                                                ?></strong>
                                                        </span>
                                                        <span class="msg"><?php echo $discount['name']; ?>
                                                            <?php if(!empty($discount['valid_to'])){
                                                                echo ' bis '.$discount['valid_to']->format('d.m.');
                                                            }?>
                                                        </span>
                                                        <span class="discount-label">
                                                            <span class="price"><?php echo $discount['price_before_discount']; ?></span>
                                                            <span class="discount"><?php echo $discount['price_delta']; ?></span>
                                                        </span>

                                                    </div>
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <span class="price-total">ab <strong><?php
                                                            echo PriceHandler::format($housing_options_cheapest_price_primary->price_total);
                                                        ?></strong>
                                                </span>
                                                <?php
                                            } ?>
                                        </div>
                                        <div class="col-12 col-lg-2">
                                            <a class="btn btn-primary btn-block booking-btn green" target="_blank" rel="nofollow"
                                               href="<?php echo IB3Tools::get_bookinglink($housing_options_cheapest_price_primary);?>"

                                                zur Buchung
                                                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-right"></use></svg>

                                            </a>
                                        </div>

                                        <div class="bottom-bar">
                                            <div class="col-12">
                                                <p><small>
                                                <?php
                                                echo $housing_option_secondary->name. ' Zuschlag: ';
                                                $diff =  $housing_options_cheapest_price_secondary->price_total - $housing_options_cheapest_price_primary->price_total;
                                                echo PriceHandler::format($diff);

                                                // return the discount row, like "Kinderrabatt: 0‑2 Jahre: bis zu 100%; 2‑13 Jahre: bis zu 8%"
                                                if(!empty($discount_scales)){
                                                    echo '<span class="d-none d-sm-none d-md-inline">,</span> <br class="d-md-none">'.PriceHandler::getCheapestOptionDiscount($discount_scales);
                                                }

                                                ?>
                                                </small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php } else { ?>
    <section>
        <div class="content-block content-block-detail-booking" id="content-block-detail-booking">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <small>Es konnten keine gültigen Termine gefunden werden. Bitte wenden Sie sich an
                            unser Service-Center.</small>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>