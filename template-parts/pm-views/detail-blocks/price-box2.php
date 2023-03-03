<?php
use Pressmind\HelperFunctions;
use Pressmind\Travelshop\PriceHandler;
use Pressmind\Travelshop\Template;

/**
 * @var array $args
 */

if(empty($args['cheapest_price']) || !empty($args['booking_on_request'])){
    return;
}
?>

<div class="booking-filter">
    <div class="booking-filter-item booking-filter-item--transport-type">
        <?php
        $transport_types = [
                'FLUG', 'BUS', 'PKW'
        ];
        ?>
        <div class="booking-filter-radio booking-filter-radio--transport-type">
            <?php foreach( $transport_types as $type ) { ?>
                <div class="radio-item">
                    <input type="radio" id="transport-type-<?php echo $type; ?>" name="transport_type" value="<?php echo $type; ?>" />

                    <span></span>

                    <label for="transport-type-<?php echo $type; ?>">
                        <span class="icon-label">
                            <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/transport-icon.php', [
                                'transport_type' => $type
                            ]);?>
                            <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/transport_type_human_string.php', [
                                'transport_type' => $type
                            ]);?>
                        </span>
                    </label>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="booking-filter-item booking-filter-item--date-range">
        <button class="booking-filter-field booking-filter-field--date-range">
            <span class="booking-filter-field--icon">
                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#calendar-blank"></use></svg>
            </span>
            <span class="booking-filter-field--text">
                <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/travel-date-range.php', [
                    'date_departure' => $args['cheapest_price']->date_departure,
                    'date_arrival' => $args['cheapest_price']->date_arrival
                ]);?>
            </span>
        </button>
    </div>

    <div class="booking-filter-item booking-filter-item--airport">
        <button class="booking-filter-field booking-filter-field--airport">
            <span class="booking-filter-field--icon">
                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#airplane-tilt"></use></svg>
            </span>
            <span class="booking-filter-field--text">
                Frankfurt Main
            </span>
        </button>
    </div>

    <div class="booking-filter-item booking-filter-item--persons">
        <button class="booking-filter-field booking-filter-field--persons">
            <span class="booking-filter-field--icon">
                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#users"></use></svg>
            </span>
            <span class="booking-filter-field--text">
                2 Personen
            </span>
        </button>
    </div>
</div>

<div class="price-box">
    <?php
    echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/checked-icon.php', []);
    ?>

    <div class="price-box-row">
        <div class="price-box-icon-item">
            <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration-icon.php', []);?>
            <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration.php', ['duration' => $args['cheapest_price']->duration]);?>
        </div>
    </div>

    <div class="price-box-row">
        <div class="price-box-icon-item">
            <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/transport-icon.php', ['transport_type' => $args['cheapest_price']->transport_type]);?>

            <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/travel-date-range.php', [
                'date_departure' => $args['cheapest_price']->date_departure,
                'date_arrival' => $args['cheapest_price']->date_arrival
            ]);?>
        </div>
        <?php /*
        <div class="price-box-date">
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
        </div>
 */ ?>
    </div>




    <?php if($args['cheapest_price']->duration != 1){ ?>
    <div class="price-box-row">
        <div class="price-box-icon-item">
            <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/price-mix-icon.php', ['price_mix' => $args['cheapest_price']->price_mix]);?>
            <div>
                <?php
                echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/offer-description.php', [
                    'cheapest_price' => $args['cheapest_price']]);
                ?>
            </div>
        </div>
    </div>
    <?php } ?>

    <?php // Random Availability
    $randint = random_int(1, 9);
    ?>

    <?php if($randint < 10) { ?>
    <div class="price-box-row">
        <div class="booking-status">
            <!-- Toggle in badge the class "active" to toggle status with animation -->
            <div class="status <?php echo $randint <= 3 ? 'danger' : ''; ?>">Nur noch <?php echo $randint < 10 ? $randint == 1 ? '1 Platz' : $randint . ' Plätze ' : ''; ?> frei</div>
        </div>
    </div>
    <?php } ?>

    <div class="price-box-row">
        <div class="price-box-discount">
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
    </div>
    <div class="price-box-row">

        <div class="booking-button-wrap">
            <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/booking-button.php', [
                'cheapest_price' => $args['cheapest_price'],
                'url' => $args['url'],
                'size' => 'lg',
                'modal_id' => $args['id_modal_price_box'],
                'disable_id' => true
            ]);?>
        </div>
    </div>

</div>