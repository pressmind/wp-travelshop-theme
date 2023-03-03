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
            <div class="row">
                <?php foreach( $transport_types as $type ) { ?>
                    <div class=" col form-radio-col">
                        <div class="form-radio">
                            <input type="radio" class="form-radio-input" id="transport-type-<?php echo $type; ?>" name="transport_type" value="<?php echo $type; ?>" <?php if ( $args['cheapest_price']->transport_type == $type ) { ?>checked<?php } ?> />

                            <span>
                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#circle-filled"></use></svg>
                        </span>

                            <label class="form-radio-label" for="transport-type-<?php echo $type; ?>">
                                <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/transport_type_human_string.php', [
                                    'transport_type' => $type
                                ]);?>
                            </label>
                        </div>
                    </div>
                <?php } ?>
            </div>

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
        <div class="dropdown">
            <button class="dropdownAirport select-form-control dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="dropdown-icon">
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#airplane-tilt"></use></svg>
                </span>
                <span class="selected-options" data-placeholder="bitte wählen">
                    Berlin
                </span>
                <span class="dropdown-chevron">
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-down"></use></svg>
                </span>
                <span class="dropdown-clear input-clear">
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
                </span>
            </button>

            <div class="dropdown-menu dropdown-menu-select" aria-labelledby="dropdownAirport" x-placement="top-start">
                <div class="dropdown-menu-inner">
                    <div class="dropdown-menu-content">
                        <div class="dropdown-menu-header d-none">
                            <div class="h4">
                                Airport
                            </div>
                            <button class="filter-prompt" data-type="close-popup">
                                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
                            </button>
                        </div>

                        <?php
                        $airports = [
                            'BER' => 'Berlin',
                            'FRA' => 'Frankfurt Main',
                            'MUC' => 'Flughafen München',
                            'DUS' => 'Flughafen Düsselforf',
                            'HAM' => 'Hamburg',
                            'CGN' => 'Köln / Bonn',
                            'HHN' => 'Frankfurt-Hahn'
                        ]
                        ?>

                        <div class="category-tree-field-items multi-level-checkboxes">
                            <?php $i = 0; ?>
                            <?php foreach( $airports as $key => $value ) { ?>
                                <div class="form-radio">
                                    <input type="radio" class="form-radio-input" id="transport-type-<?php echo $key; ?>" name="transport_type" value="<?php echo $type; ?>" <?php if ( $i == 0 ) { ?>checked<?php } ?> />

                                    <span>
                                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#circle-filled"></use></svg>
                                    </span>

                                    <label class="form-radio-label" for="transport-type-<?php echo $key; ?>">
                                        <?php echo $value; ?>
                                    </label>
                                </div>
                                <?php $i++; ?>
                            <?php } ?>
                        </div>

                        <div class="dropdown-menu-footer">
                            <button class="btn btn-primary btn-block mt-3 filter-prompt">
                                Auswahl übernehmen
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="booking-filter-item booking-filter-item--persons">
        <div class="dropdown">
            <button class="dropdownPersons select-form-control dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="dropdown-icon">
                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#users"></use></svg>
                </span>
                <span class="selected-options">
                    2 Personen
                </span>
                <span class="dropdown-chevron">
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-down"></use></svg>
                </span>
                <span class="dropdown-clear input-clear">
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
                </span>
            </button>

            <div class="dropdown-menu dropdown-menu-select" aria-labelledby="dropdownPersons" x-placement="top-start">
                <div class="dropdown-menu-inner">
                    <div class="dropdown-menu-content">
                        <div class="dropdown-menu-header d-none">
                            <div class="h4">
                                Personen
                            </div>
                            <button class="filter-prompt" data-type="close-popup">
                                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
                            </button>
                        </div>

                        <div class="dropdown-body">
                           PERSONEN-SELECT
                        </div>
                    </div>
                </div>
            </div>
        </div>
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