<?php
use Pressmind\HelperFunctions;
use Pressmind\Travelshop\PriceHandler;
use Pressmind\Travelshop\Template;

/**
 * @var array $args
 */

if(empty($args['cheapest_price'])){
    return;
}
?>
<div class="price-box">
    <?php
    echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/checked-icon.php', []);
    ?>
    <div class="col-12">
        <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration-icon.php', []);?>
        <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration.php', ['duration' => $args['cheapest_price']->duration]);?>
    </div>
    <div class="col-12">
        <span class="date">

            <a class="show-dates" data-modal="true" data-anchor="<?php echo $args['cheapest_price']->id; ?>" data-modal-id="<?php echo $args['id_modal_price_box']; ?>">
                <p class="small">Angebot wählen:</p>
                <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/transport-icon.php', ['transport_type' => $args['cheapest_price']->transport_type]);?>
                <span>
                    <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/travel-date-range.php', [
                        'date_departure' => $args['cheapest_price']->date_departure,
                        'date_arrival' => $args['cheapest_price']->date_arrival
                    ]);?>
                </span>
            </a>
        </span>
    </div>
    <?php if($args['cheapest_price']->duration != 1){ ?>
    <div class="col-12">
        <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/price-mix-icon.php', ['price_mix' => $args['cheapest_price']->price_mix]);?>
        <div>
            <?php
            echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/offer-description.php', [
                    'cheapest_price' => $args['cheapest_price']]);
            ?>
        </div>
    </div>
    <?php } ?>
    <div class="col-12">
        <?php
        if (($discount = PriceHandler::getDiscount($args['cheapest_price'])) !== false) {
            echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/discount.php', [
                'cheapest_price' => $args['cheapest_price'],
                'discount' => $discount,
            ]);
        } else {
            echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/price.php', [
                'cheapest_price' => $args['cheapest_price'],
            ]);
        } ?>
    </div>
    <div class="col-12">
        <?php // Random Availability
            $randint = random_int(1, 9);
        ?>
        <div class="booking-button-wrap">
            <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/booking-button.php', [
                'cheapest_price' => $args['cheapest_price'],
                'url' => $args['url'],
                'modal_id' => $args['id_modal_price_box'],
                'disable_id' => true
            ]);?>
            <?php if($randint < 10) { ?>
                <!-- Toggle in badge the class "active" to toggle status with animation -->
                <div class="badge status active <?php echo $randint <= 3 ? 'alert' : ''; ?>">Nur noch <?php echo $randint < 10 ? $randint == 1 ? '1 Platz' : $randint . ' Plätze ' : ''; ?> frei</div>
            <?php } ?>
        </div>
    </div>
</div>