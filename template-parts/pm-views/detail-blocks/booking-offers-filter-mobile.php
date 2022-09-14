<?php
use Pressmind\Travelshop\Template;
/**
 * <code>
 * $args['booking_offers_intersection']
 * </code>
 * @var array $args
 */
$args['filter_data'] = [];
?>
<form class="filter-form-mobile">
    <?php if(count($args['booking_offers_intersection']->duration) > 1) { ?>
        <?php
            $args['label'] = 'Reisedauer';
            $args['filter_param'] = 'pm-du';
            $args['behavior'] = 'OR';
            $args['type'] = 'checkbox';
            $args['filter_val'] = 'duration';
            $args['icon'] = '<svg xmlns="http://www.w3.org/2000/svg" class="dropdown-icon icon icon-tabler icon-tabler-calendar-stats" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>   <path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"></path>   <path d="M18 14v4h4"></path>   <circle cx="18" cy="18" r="4"></circle>   <path d="M15 3v4"></path>   <path d="M7 3v4"></path>   <path d="M3 11h16"></path></svg>';
            foreach($args['booking_offers_intersection']->duration as $key => $value) {
                $string = $value <= 1 ? 'Tagesfahrt' : $value . ' Tage';
                $args['filter_data'][$args['filter_val']][$string] = $args['booking_offers_intersection']->{$args['filter_val']}[$key];
            }
        ?>
        <?php echo Template::render(APPLICATION_PATH.'/template-parts/pm-search/filter/checkbox-dropdown.php', $args); ?>
    <?php } ?>
    <?php if(count($args['booking_offers_intersection']->option_occupancy) > 1) { ?>
        <?php
        $args['label'] = 'Unterkunft';
        $args['filter_param'] = 'pm-ho';
        $args['behavior'] = null;
        $args['filter_val'] = 'option_occupancy';
        $args['type'] = 'radio';
        $args['icon'] = '<svg xmlns="http://www.w3.org/2000/svg" class="dropdown-icon icon icon-tabler icon-tabler-home" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>   <polyline points="5 12 3 12 12 3 21 12 19 12"></polyline>   <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>   <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path></svg>';
        foreach($args['booking_offers_intersection']->option_occupancy as $key => $value) {
            $value = intval($value);
            $string = $value == 1 ? 'Einzelzimmer' : ( $value == 2 ? 'Doppelzimmer' : $value . '-Bett-Zimmer');
            $args['filter_data'][$args['filter_val']][$string] = $value;
        }
        ?>
        <?php echo Template::render(APPLICATION_PATH.'/template-parts/pm-search/filter/checkbox-dropdown.php', $args); ?>
    <?php } ?>
    <?php if(count($args['booking_offers_intersection']->transport_type) > 1) { ?>
        <?php
        $args['label'] = 'Anreiseart';
        $args['filter_param'] = 'pm-tt';
        $args['behavior'] = 'OR';
        $args['filter_val'] = 'transport_type';
        $args['type'] = 'checkbox';
        $args['icon'] = '<svg xmlns="http://www.w3.org/2000/svg" class="dropdown-icon icon icon-tabler icon-tabler-bus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>   <circle cx="6" cy="17" r="2"></circle>   <circle cx="18" cy="17" r="2"></circle>   <path d="M4 17h-2v-11a1 1 0 0 1 1 -1h14a5 7 0 0 1 5 7v5h-2m-4 0h-8"></path>   <polyline points="16 5 17.5 12 22 12"></polyline>   <line x1="2" y1="10" x2="17" y2="10"></line>   <line x1="7" y1="5" x2="7" y2="10"></line>   <line x1="12" y1="5" x2="12" y2="10"></line></svg>';
        foreach($args['booking_offers_intersection']->transport_type as $key => $value) {
            $args['filter_data'][$args['filter_val']][$args['booking_offers_intersection']->{$args['filter_val']}[$key]] = $args['booking_offers_intersection']->{$args['filter_val']}[$key];
        }
        ?>
        <?php echo Template::render(APPLICATION_PATH.'/template-parts/pm-search/filter/checkbox-dropdown.php', $args); ?>
    <?php } ?>
    <?php if(in_array('Flug', $args['booking_offers_intersection']->transport_type)){ ?>
        <?php
        $args['label'] = 'Flughafen ab';
        $args['filter_param'] = 'pm-ap';
        $args['behavior'] = 'OR';
        $args['filter_val'] = 'transport_1_airport_name';
        $args['filter_val2'] = 'transport_1_airport';
        $args['type'] = 'radio';
        $args['icon'] = '<svg xmlns="http://www.w3.org/2000/svg" class="dropdown-icon icon icon-tabler icon-tabler-plane-departure" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>   <path d="M15 12h5a2 2 0 0 1 0 4h-15l-3 -6h3l2 2h3l-2 -7h3z" transform="rotate(-15 12 12) translate(0 -1)"></path>   <line x1="3" y1="21" x2="21" y2="21"></line></svg>';
        foreach($args['booking_offers_intersection']->transport_1_airport_name as $key => $value) {
            $args['filter_data'][$args['filter_val']][$key] = $args['booking_offers_intersection']->{$args['filter_val']}[$key];
            $args['filter_data'][$args['filter_val2']][$key] = $args['booking_offers_intersection']->{$args['filter_val2']}[$key];
        }
        ?>
        <?php echo Template::render(APPLICATION_PATH.'/template-parts/pm-search/filter/checkbox-dropdown.php', $args); $args['filter_val2'] = null;  ?>
    <?php } ?>
    <?php
    $dateFrom = DateTime::createFromFormat('Y-m-d H:i:s', $args['booking_offers_intersection']->date_departure_from[0]);
    $dateTo = DateTime::createFromFormat('Y-m-d H:i:s', $args['booking_offers_intersection']->date_departure_to[0]);
    $currentDate = new DateTime(); ?>
    <div class="col-12 col-md-3">
        <?php echo Template::render(APPLICATION_PATH . '/template-parts/pm-search/search/date-picker.php', ['name' => 'Reisezeitraum', 'departure_min' => $dateFrom, 'departure_max' => $dateTo, 'departure_dates' => '[' . $currentDate->format('Y-m-d') . ']']); ?>
    </div>
    <div class="col-12 col-md-3">
        <div class="btn btn-primary modal-close-btn" style="width: 100%; margin: 1rem auto; font-size: 1.15rem;"><span id="offers-filter-total"><?php echo $args['booking_offers_intersection']->count == 15 ? 'Über 15 ' : $args['booking_offers_intersection']->count; ?></span> Angebote gefunden</div>
    </div>
</form>