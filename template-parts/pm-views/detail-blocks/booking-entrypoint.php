<?php
use Pressmind\HelperFunctions;
use Pressmind\Travelshop\PriceHandler;
use Pressmind\Search\CheapestPrice;
use Pressmind\Travelshop\Template;

/**
 * @var array $args
 */

if(empty($args['cheapest_price']) || !empty($args['booking_on_request'])){
    return;
}
?>

<div class="booking-filter">
    <div class="booking-filter-title h5">
        "<?php echo $args['headline']; ?>" buchen
    </div>
    <div class="booking-filter-item booking-filter-item--transport-type">
        <?php
//        $transport_types = [
//                'FLUG', 'BUS', 'PKW'
//        ];

        // replace with real data
        // build a date to best price map
        $filter = new CheapestPrice();
        $filter->occupancies_disable_fallback = false;
        $offers = $args['media_object']->getCheapestPrices($filter, ['date_departure' => 'ASC', 'price_total' => 'ASC'], [0, 100]);

        $transport_types = [];

        foreach ($offers as $offer ) {
            $transport_types[] = $offer->transport_type;
        }
        ?>
        <div class="booking-filter-radio booking-filter-radio--transport-type">
            <?php foreach( $transport_types as $type ) { ?>
                <div class="form-radio">
                    <input type="radio" class="form-radio-input" id="transport-type-<?php echo $type; ?>" name="transport_type" value="<?php echo $type; ?>" <?php if ( $args['cheapest_price']->transport_type == $type ) { ?>checked="checked"<?php } ?> />

                    <div>
                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#circle-filled"></use></svg>
                    </div>

                    <label class="form-radio-label" for="transport-type-<?php echo $type; ?>">
                        <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/transport_type_human_string.php', [
                            'transport_type' => $type
                        ]);?>
                    </label>
                </div>
            <?php } ?>
        </div>
    </div>

    <input class="booking-filter-field--duration" type="hidden" name="dur" value="<?php echo $args['cheapest_price']->duration; ?>" />
    <input class="booking-filter-field--mediaobject" type="hidden" name="mediaobject" value="<?php echo $args['cheapest_price']->id_media_object; ?>" />
    <input class="booking-filter-field--offer" type="hidden" name="offer" value="<?php echo $args['cheapest_price']->id; ?>" />

    <div class="booking-filter-items-boxed">
        <div class="booking-filter-item booking-filter-item--date-range">
            <button class="booking-filter-field booking-filter-field--date-range">
            <span class="booking-filter-field--icon">
                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#calendar-blank"></use></svg>
            </span>
                <small class="d-block">Termin wählen</small>
                <span class="booking-filter-field--text">
                <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/travel-date-range.php', [
                    'date_departure' => $args['cheapest_price']->date_departure,
                    'date_arrival' => $args['cheapest_price']->date_arrival
                ]);?>

                <span class="booking-filter-field--counter">
                    +8
                </span>
            </span>
            </button>
        </div>

        <div class="booking-filter-item booking-filter-item--airport <?php echo ( $args['cheapest_price']->transport_type !== 'FLUG' ) ? 'd-none' : ''; ?>">
            <div class="dropdown">
                <button class="dropdownAirport input-has-icon select-form-control dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="dropdown-icon">
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#airplane-tilt"></use></svg>
                </span>
                    <small class="d-block">Flughafen wählen</small>
                <span class="selected-options" data-placeholder="bitte wählen">
                    Berlin
                </span>
                    <span class="dropdown-clear input-clear">
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
                </span>
                </button>

                <div class="dropdown-menu dropdown-menu-booking-select" aria-labelledby="dropdownAirport" x-placement="top-start">
                    <div class="dropdown-menu-inner">
                        <div class="dropdown-menu-content">
                            <div class="dropdown-menu-header d-none">
                                <div class="h4">
                                    Flughafen wählen
                                </div>
                                <button class="filter-prompt" data-type="close-popup" type="button">
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
                                        <input type="radio" class="form-radio-input" id="airport-<?php echo $key; ?>" name="airport" value="<?php echo $key; ?>" <?php if ( $i == 0 ) { ?>checked<?php } ?> />

                                        <span>
                                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#circle-filled"></use></svg>
                                        </span>

                                        <label class="form-radio-label" for="airport-<?php echo $key; ?>">
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
                <button class="dropdownPersons input-has-icon select-form-control dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="dropdown-icon">
                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#users"></use></svg>
                </span>
                    <small class="d-block">Anzahl Personen</small>
                    <span class="selected-options">
                    2 Personen
                </span>
                    <span class="dropdown-clear input-clear">
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
                </span>
                </button>

                <div class="dropdown-menu dropdown-menu-booking-person-select" aria-labelledby="dropdownPersons" x-placement="top-start">
                    <div class="dropdown-menu-inner">
                        <div class="dropdown-menu-content">
                            <div class="dropdown-menu-header d-none">
                                <div class="h4">
                                    Anzahl Personen
                                </div>
                                <button class="filter-prompt" data-type="close-popup" type="button">
                                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
                                </button>
                            </div>

                            <div class="dropdown-menu-body">
                                <div class="personen-select">
                                    <div class="personen-select-title">
                                        Personen
                                    </div>

                                    <div class="personen-select-counter">
                                        <button type="button"  class="personen-select-counter-btn" data-type="-">
                                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#minus-circle"></use></svg>
                                        </button>
                                        <input readonly type="text" class="personen-select-counter-input" value="2" data-singular="Person" data-plural="Personen" data-min="1" data-max="" data-target-input=".dropdownPersons .selected-options"/>
                                        <button type="button" class="personen-select-counter-btn" data-type="+">
                                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#plus-circle"></use></svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="info-text mt-3">
                                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#info"></use></svg>
                                    Informationen bezüglich Reisen mit Kindern sowie Reisen mit Haustieren finden Sie in der Buchung.
                                </div>
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
    </div>

</div>

<div class="booking-action">

    <?php // Random Availability
    $randint = random_int(1, 9);
    ?>
    <?php if($randint < 10) { ?>
        <div class="booking-action-row">
            <!-- Toggle in badge the class "active" to toggle status with animation -->
            <div class="status <?php echo $randint <= 3 ? 'danger' : ''; ?>">Nur noch <?php echo $randint < 10 ? $randint == 1 ? '1 Platz' : $randint . ' Plätze ' : ''; ?> frei</div>
        </div>
    <?php } ?>

    <div class="booking-action-row">
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
    <div class="booking-action-row">

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
