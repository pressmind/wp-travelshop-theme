<?php

use Pressmind\HelperFunctions;
use Pressmind\Search\CheapestPrice;
use Pressmind\Travelshop\PriceHandler;

/**
 * @var array $args
 */

/**
 * @var Pressmind\ORM\Object\MediaObject $mo
 */
$mo = $args['media_object'];

/**
 * @var Custom\MediaType\Reise $moc
 */
$moc = $mo->getDataForLanguage();

/**
 * @var Pressmind\ORM\Object\Touristic\Booking\Package[] $booking_packages
 */
$booking_packages = $mo->booking_packages;

/**
 * @var Pressmind\ORM\Object\CheapestPriceSpeed $cheapest_price
 */
$cheapest_price = $args['cheapest_price'];

?>

<?php if (empty($cheapest_price) === false) {

    $c_dates = 0;
    foreach($mo->booking_packages as $booking_package){
        $c_dates += count($booking_package->dates);
    }

    ?>
    <div class="detail-price-box">

        <?php
        if (($discount = PriceHandler::getDiscount($cheapest_price)) !== false) {
            ?>
            <div class="discount-wrapper discount-wrapper--border">
                <hr>
                <div class="discount-wrapper--inner">
                    <span class="msg"><?php echo $discount['name']; ?> bis 24.12</span>
                    <span class="discount-label">
                                <span class="price"><?php echo $discount['price_before_discount']; ?></span>
                                <span class="discount"><?php echo $discount['price_delta']; ?></span>
                            </span>
                </div>
            </div>
            <?php
        }

        ?>
        <div class="price">

            <span class="h5 mb-0 mt-0"><?php echo $booking_package->duration; ?>&nbsp;Tag<?php echo($booking_package->duration > 1 ? 'e' : ''); ?> ab</span> <span
                    class="h3 mb-0 mt-0"><?php echo PriceHandler::format($cheapest_price->price_total); ?></span>
        </div>
        <p class="small mt-2"><?php echo $cheapest_price->option_name; ?> p.P.</p>
        <hr>
        <div class="h5">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <rect x="4" y="5" width="16" height="16" rx="2" />
                <line x1="16" y1="3" x2="16" y2="7" />
                <line x1="8" y1="3" x2="8" y2="7" />
                <line x1="4" y1="11" x2="20" y2="11" />
                <rect x="8" y="15" width="2" height="2" />
            </svg>
            Reisetermine
        </div>
        <p>
            <i class="circle green"></i><?php echo HelperFunctions::dayNumberToLocalDayName($cheapest_price->date_departure->format('N'), 'short').'. '.$cheapest_price->date_departure->format('d.m') . ' - ' . HelperFunctions::dayNumberToLocalDayName($cheapest_price->date_arrival->format('N'), 'short').'. '.$cheapest_price->date_arrival->format('d.m.Y'); ?>
        </p>
        <p class="mb-0">

        <?php if($c_dates > 1){ ?>
        <div class="dropdown dropdown-termine">
            <a href="#content-block-detail-booking" class="smoothscroll">
               <?php echo ($c_dates - 1); ?> <?php echo ($c_dates - 1 == 1) ? 'weiterer Termin' :'weitere Termine';?>
            </a>
        </div>
        <?php } ?>

        <div  data-pm-id="<?php echo $mo->id; ?>"
              data-pm-ot="<?php echo $mo->id_object_type; ?>"
              data-pm-dr="<?php echo !is_null($cheapest_price) ? $cheapest_price->date_arrival->format('Ymd').'-'.$cheapest_price->date_arrival->format('Ymd') : ''; ?>"
              data-pm-du="<?php echo !is_null($cheapest_price) ? $cheapest_price->duration : ''; ?>"
              class="add-to-wishlist">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#06f" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path class="wishlist-heart" d="M19.5 13.572l-7.5 7.428l-7.5 -7.428m0 0a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
            </svg>
        </div>


        </p>

        <!--
        <hr>
        <p class="mb-0">
            <a href="#" class="detail-pdf-download"><i class="la la-download"></i> PDF
                Downloaden</a>
        </p>
        -->
    </div>
    <a class="btn btn-primary btn-booking btn-block green smoothscroll"
       href="#content-block-detail-booking">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="16" height="16" viewBox="0 0 24 24" stroke-width="3" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <polyline points="9 6 15 12 9 18" />
        </svg>Termine &amp; Preise
    </a>
<?php } else { ?>
    <div class="detail-price-box">
        <p class="small mt-2">Diese Reise ist zur Zeit nur auf Anfrage buchbar.</p>
    </div>
    <a class="btn btn-primary btn-booking btn-block smoothscroll"
       href="#content-block-detail-booking">
        Anfragen
    </a>

    <div data-id="<?php echo $mo->id; ?>" class="add-to-wishlist">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#06f" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path class="wishlist-heart" d="M19.5 13.572l-7.5 7.428l-7.5 -7.428m0 0a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
        </svg>
    </div>
<?php } ?>
