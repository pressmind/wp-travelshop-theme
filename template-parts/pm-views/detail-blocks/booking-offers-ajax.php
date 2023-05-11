<?php
use Pressmind\Search\CheapestPrice;
use Pressmind\Travelshop\PriceHandler;
use Pressmind\Travelshop\Template;

/**
 * <code>
 * $args['cheapest_price']
 * $args['media_object']
 * $args['url']
 * $args['booking_offers']
 * $args['available_options']
 * </code>
 * @var array $args
 */
?>
<?php if (!empty($args['booking_offers'])) { ?>
<div id="offer-section">
    <section class="content-block content-block-detail-booking" id="content-block-detail-booking">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="content-block-detail-booking-inner">
                        <?php
                        $current_month = null;
                        foreach ($args['booking_offers'] as $key => $offer) {
                            /**
                             * @var \Pressmind\ORM\Object\CheapestPriceSpeed $offer
                             */
                            if($current_month != $offer->date_departure->format('Y-m')){
                                $current_month = $offer->date_departure->format('Y-m');
                                $checked = $args['cheapest_price_id'] == $offer->getId(); ?>

                                <?php if(($key != 0 && $args['hide_month'] == false) || $key == 0 && !$checked) { ?>
                                    <div class="booking-row no-gutters row booking-row-head d-flex month-name">
                                        <div class="col-12">
                                             <h2><?php echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/month-name.php', [
                                                    'date' => $offer->date_departure]); ?></h2>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="booking-row no-gutters row booking-row-head d-none d-lg-flex">
                                    <div class="col-2">
                                        Dauer
                                    </div>
                                    <div class="col-3">
                                        <?php
                                        if($offer->duration == 1){
                                            ?>Datum<?php
                                        }else{
                                            ?>Zeitraum<?php
                                        }
                                        ?>
                                    </div>
                                    <div class="col-3">
                                        Leistung
                                    </div>
                                    <div class="col-2">
                                        Preis pro Person
                                    </div>
                                </div>

                            <?php } ?>
                            <div data-id-offer="<?php echo $offer->getId(); ?>" data-duration="<?php echo $offer->duration; ?>" data-airport="<?php echo $offer->transport_1_airport; ?>" class="booking-row no-gutters row booking-row-date<?php echo $checked ? ' checked' : ''; ?>">
                                <?php
                                echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/checked-icon.php', []);
                                ?>
                                <div class="col-12 col-lg-2">
                                    <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration-icon.php', []);?>
                                    <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration.php', ['duration' => $offer->duration]);?>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/transport-icon.php', ['transport_type' => $offer->transport_type]);?>
                                    <span class="date">
                                        <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/travel-date-range.php', [
                                            'date_departure' => $offer->date_departure,
                                            'date_arrival' => $offer->date_arrival,
                                            'saved' => $offer->saved,
                                            'guaranteed' => $offer->guaranteed,
                                        ]);?>
                                    </span>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div>
                                    <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/price-mix-icon.php', ['price_mix' => $offer->price_mix]);?>
                                    </div>
                                    <div>
                                        <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/offer-description.php', ['cheapest_price' => $offer]);?>
                                    </div>
                                    <div>
                                        <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/offer-extras.php', ['cheapest_price' => $offer, 'available_options' => $args['available_options']]);?>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2 price-container">
                                    <?php
                                    if (($discount = PriceHandler::getDiscount($offer)) !== false) {
                                        echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/discount.php', [
                                            'cheapest_price' => $offer,
                                            'discount' => $discount,
                                        ]);
                                    } else {
                                        echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/price.php', [
                                            'cheapest_price' => $offer,
                                        ]);
                                    } ?>

                                </div>
                                <div class="col-12 col-lg-2">
                                    <?php // Random Availability
                                    $randint = random_int(1, 20);
                                    ?>
                                    <div class="booking-button-wrap">
                                        <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/booking-button.php', [
                                            'cheapest_price' => $offer,
                                            'url' => $args['url'],
                                            'disable_id' => false,
                                            'booking_type' => $args['media_object']->booking_type
                                        ]);?>
                                        <?php if($randint < 10) { ?>
                                            <!-- Toggle in badge the class "active" to toggle status with animation -->
                                            <div class="badge status active <?php echo $randint <= 3 ? 'alert' : ''; ?>">Nur noch <?php echo $randint < 10 ? $randint == 1 ? '1 Platz' : $randint . ' Plätze ' : ''; ?> frei</div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <?php if($key == 0 && count($args['booking_offers']) > 1 && $checked) { ?>
                                <div class="booking-row no-gutters row booking-row-head d-flex additional-offers">
                                    <div class="col-12">
                                        <h2><?php echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/month-name.php', [
                                                'date' => $args['booking_offers'][$key + 1]->date_departure]); ?></h2>
                                    </div>
                                </div>
                            <?php } ?>

                        <?php } ?>

                </div>
            </div>
        </div>
    </section>
</div>
<?php } else { ?>
    <section>
        <div class="content-block content-block-detail-booking" id="content-block-detail-booking">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div style="margin: 100px auto 50px auto; display: block; max-width: 500px; font-size: 1rem; color: #000; text-align: center; padding: 20px; white-space: normal; line-height: 1.4;">Es konnten keine gültigen Angebote gefunden werden. Bitte passen Sie Ihre Filterung an. <a href="#" class="reset-filter">Filter zurücksetzen</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>