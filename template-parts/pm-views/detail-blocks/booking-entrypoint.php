<?php
use Pressmind\HelperFunctions;
use Pressmind\ORM\Object\Airport;
use Pressmind\Travelshop\PriceHandler;
use Pressmind\Search\CheapestPrice;
use Pressmind\Travelshop\Template;

/**
 * @var array $args
 */

if (empty($args['cheapest_price']) || !empty($args['booking_on_request'])) {
    return;
}

/**
 * @var \Pressmind\ORM\Object\CheapestPriceSpeed $CheapestPrice
 */
$CheapestPrice = $args['cheapest_price'];
$calendar_filter = new \Pressmind\Search\CalendarFilter();
$calendar_filter->occupancy = $CheapestPrice->option_occupancy;
$calendar_filter->duration = $CheapestPrice->duration;
$calendar_filter->transport_type = $CheapestPrice->transport_type;
$calendar_filter->airport = $CheapestPrice->transport_1_airport;
$calendar = $args['media_object']->getCalendar($calendar_filter);
$filter = $calendar->filter;
if (empty($args['cheapest_price']) || !empty($args['booking_on_request'])) {
    return;
}
if ($CheapestPrice->is_virtual_created_price) {
    echo 'Error: virtual created price - contact support';
    return;
}
?>

<div class="booking-filter">
    <div class="booking-filter-title h5">
        "<?php echo $args['headline']; ?>" buchen
    </div>
    <!-- Transport -->
    <div class="booking-filter-item booking-filter-item--transport-type mb-2<?php echo (count($filter['transport_types']) < 2) ? ' d-none' : ''; ?>">
        <div class="booking-filter-radio booking-filter-radio--transport-type ">
            <?php foreach ($filter['transport_types'] as $transport_type => $v) { ?>
                <div class="form-radio">
                    <input type="radio" class="form-radio-input" id="transport-type-<?php echo $transport_type; ?>"
                           name="transport_type"
                           data-filter='<?php echo json_encode($v); ?>'
                           value="<?php echo $transport_type; ?>" <?php echo $CheapestPrice->transport_type == $transport_type ? 'checked="checked"' : '' ?> />
                    <div>
                        <svg>
                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                 href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#circle-filled"></use>
                        </svg>
                    </div>
                    <label class="form-radio-label" for="transport-type-<?php echo $transport_type; ?>">
                        <?php echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/transport_type_human_string.php', [
                            'transport_type' => $transport_type
                        ]); ?>
                    </label>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="booking-filter-items-boxed">
        <!-- Duration -->
        <div class="booking-filter-item booking-filter-item--duration <?php echo (count($filter['durations']) == 0) ? 'd-none' : ''; ?>">
            <div class="dropdown">
                <button class="dropdownDuration input-has-icon select-form-control dropdown-toggle" type="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="dropdown-icon">
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink"
                              href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#airplane-tilt"></use></svg>
                </span>
                    <small class="d-block">Dauer wählen</small>
                    <span class="selected-options" data-placeholder="bitte wählen"><?php
                        echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/duration.php', [
                            'duration' => $CheapestPrice->duration
                        ]); ?>
                    </span>
                    <span class="dropdown-clear input-clear">
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink"
                              href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
                </span>
                </button>
                <div class="dropdown-menu dropdown-menu-booking-select" aria-labelledby="dropdownDuration"
                     x-placement="top-start">
                    <div class="dropdown-menu-inner">
                        <div class="dropdown-menu-content">
                            <div class="dropdown-menu-header d-none">
                                <div class="h4">
                                    Dauer wählen
                                </div>
                                <button class="filter-prompt" data-type="close-popup" type="button">
                                    <svg>
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                             href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use>
                                    </svg>
                                </button>
                            </div>
                            <div class="booking-filter-radio-items booking-filter-radio--duration">
                                <?php foreach ($filter['durations'] as $duration => $v) { ?>
                                    <div class="form-radio">
                                        <input type="radio" class="form-radio-input"
                                               id="duration-<?php echo $duration; ?>"
                                               name="duration"
                                               data-filter='<?php echo json_encode($v); ?>'
                                               value="<?php echo $duration; ?>" <?php echo $CheapestPrice->duration == $duration ? 'checked="checked"' : '' ?>/>
                                        <span>
                                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                      href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#circle-filled"></use></svg>
                                        </span>
                                        <label class="form-radio-label" for="duration-<?php echo $duration; ?>">
                                            <?php echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/duration.php', [
                                                'duration' => $duration
                                            ]); ?>
                                        </label>
                                    </div>
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

        <!-- Airport -->
        <div class="booking-filter-item booking-filter-item--airport d-none">
            <div class="dropdown">
                <button class="dropdownAirport input-has-icon select-form-control dropdown-toggle" type="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="dropdown-icon">
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink"
                              href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#airplane-tilt"></use></svg>
                </span>
                    <small class="d-block">Flughafen wählen</small>
                    <span class="selected-options" data-placeholder="bitte wählen"><?php
                        echo Airport::getByIata($CheapestPrice->transport_1_airport)->name; ?>
                    </span>
                    <span class="dropdown-clear input-clear">
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink"
                              href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
                </span>
                </button>

                <div class="dropdown-menu dropdown-menu-booking-select" aria-labelledby="dropdownAirport"
                     x-placement="top-start">
                    <div class="dropdown-menu-inner">
                        <div class="dropdown-menu-content">
                            <div class="dropdown-menu-header d-none">
                                <div class="h4">
                                    Flughafen wählen
                                </div>
                                <button class="filter-prompt" data-type="close-popup" type="button">
                                    <svg>
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                             href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use>
                                    </svg>
                                </button>
                            </div>
                            <div class="booking-filter-radio-items">
                                <?php foreach ($filter['airports'] as $airport3L => $value) { ?>
                                    <div class="form-radio">
                                        <input type="radio" class="form-radio-input"
                                               id="airport-<?php echo $airport3L; ?>"
                                               name="airport"
                                               value="<?php echo $airport3L; ?>" <?php echo $CheapestPrice->transport_1_airport == $airport3L ? 'checked="checked"' : '' ?>/>
                                        <span>
                                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                      href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#circle-filled"></use></svg>
                                        </span>
                                        <label class="form-radio-label" for="airport-<?php echo $airport3L; ?>">
                                            <?php
                                            echo Airport::getByIata($airport3L)->name;
                                            ?>
                                        </label>
                                    </div>
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

        <!-- Persons -->
        <?php if ($calendar->calendar->booking_package->price_mix === 'date_housing') { ?>
            <div class="booking-filter-item booking-filter-item--persons">
                <div class="dropdown">
                    <button class="dropdownPersons input-has-icon select-form-control dropdown-toggle" type="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="dropdown-icon">
                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink"
                          href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#users"></use></svg>
                </span>
                        <small class="d-block">Anzahl Personen</small>
                        <span class="selected-options">
                    2 Personen
                </span>
                        <span class="dropdown-clear input-clear">
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink"
                              href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
                </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-booking-person-select" aria-labelledby="dropdownPersons"
                         x-placement="top-start">
                        <div class="dropdown-menu-inner">
                            <div class="dropdown-menu-content">
                                <div class="dropdown-menu-header d-none">
                                    <div class="h4">
                                        Anzahl Personen
                                    </div>
                                    <button class="filter-prompt" data-type="close-popup" type="button">
                                        <svg>
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                 href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use>
                                        </svg>
                                    </button>
                                </div>
                                <div class="dropdown-menu-body">
                                    <div class="personen-select">
                                        <div class="personen-select-title">
                                            Personen
                                        </div>
                                        <div class="personen-select-counter">
                                            <button type="button" class="personen-select-counter-btn" data-type="-">
                                                <svg>
                                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                         href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#minus-circle"></use>
                                                </svg>
                                            </button>
                                            <input readonly type="text" class="personen-select-counter-input" value="2"
                                                   data-singular="Person" data-plural="Personen" data-min="1"
                                                   data-max="" data-target-input=".dropdownPersons .selected-options"/>
                                            <button type="button" class="personen-select-counter-btn" data-type="+">
                                                <svg>
                                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                         href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#plus-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="info-text mt-3">
                                        <svg>
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                 href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#info"></use>
                                        </svg>
                                        Bitte setzen Sie die Anzahl der Personen (inkl. Kindern).
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
        <?php } ?>
        <?php
        $show_calendar_modal = $calendar->calendar->bookable_date_count > 5;
        ?>
        <div class="booking-filter-item booking-filter-item--date-range<?php echo $show_calendar_modal ? ' active' : ' d-none'; ?>">
            <button class="booking-filter-field booking-filter-field--date-range" data-placeholder="Bitte wählen">
                <span class="booking-filter-field--icon">
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink"
                              href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#calendar-blank"></use></svg>
                </span>
                <small class="d-block">Termin wählen</small>
                <span class="booking-filter-field--text">
                <?php echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/travel-date-range.php', [
                    'date_departure' => $CheapestPrice->date_departure,
                    'date_arrival' => $CheapestPrice->date_arrival
                ]); ?>
                </span>
                <span class="booking-filter-field--counter">
                    <?php echo $calendar->calendar->bookable_date_count > 1 ? '+' . $calendar->calendar->bookable_date_count - 1 : ''; ?>
                </span>
            </button>
            <div class="booking-filter-calendar-overlay">
                <div class="booking-filter-calendar-overlay-inner">
                    <div class="booking-filter-calendar-overlay-content">
                        <div class="booking-filter-calendar-overlay-header d-none">
                            <div class="h4">
                                Termin wählen
                            </div>
                            <button class="booking-calendar-close" data-type="close-popup" type="button">
                                <svg>
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                         href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use>
                                </svg>
                            </button>
                        </div>
                        <div class="booking-filter-calendar-overlay-body">
                            <div id="booking-entry-calendar"></div>
                        </div>
                        <div class="booking-filter-calendar-overlay-footer text-center">
                            <button class="btn btn-primary booking-calendar-close">
                                Auswahl übernehmen
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="booking-filter-items<?php echo $show_calendar_modal ? ' d-none' : ' active'; ?>">
        <div class="h6">Termin wählen</div>
        <div id="booking-filter-item--dates" class="booking-filter-item--dates">
            <?php
            echo Template::render(APPLICATION_PATH . '/template-parts/pm-views/detail-blocks/booking-entrypoint-date-list.php', [
                'media_object' => $args['media_object']
            ]);
            ?>
        </div>
    </div>
</div>

<div class="booking-action">
    <?php // @TODO
    $randint = random_int(1, 9);
    ?>
    <?php if ($randint < 10) { ?>
        <div class="booking-action-row">
            <div class="status <?php echo $randint <= 3 ? 'danger' : ''; ?>">Nur
                noch <?php echo $randint < 10 ? $randint == 1 ? '1 Platz' : $randint . ' Plätze ' : ''; ?> frei
            </div>
        </div>
    <?php } ?>

    <div class="booking-action-row">
        <div class="price-box-discount">
            <?php
            if (($discount = PriceHandler::getDiscount($args['cheapest_price'])) !== false) {
                echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/discount.php', [
                    'cheapest_price' => $args['cheapest_price'],
                    'discount' => $discount,
                ]);
            } else {
                echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/price.php', [
                    'cheapest_price' => $args['cheapest_price'],
                ]);
            } ?>
        </div>
    </div>
    <div class="booking-action-row">

        <div class="booking-button-wrap">
            <?php echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/booking-button.php', [
                'cheapest_price' => $args['cheapest_price'],
                'url' => $args['url'],
                'size' => 'lg',
            ]); ?>
        </div>
    </div>
</div>
