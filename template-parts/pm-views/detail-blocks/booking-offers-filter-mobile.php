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
    <div class="filter-inputs">
        <?php if(count($args['booking_offers_intersection']->duration) > 1) { ?>
            <?php
            $args['label'] = 'Reisedauer';
            $args['filter_param'] = 'pm-du';
            $args['behavior'] = 'OR';
            $args['type'] = 'checkbox';
            $args['filter_val'] = 'duration';
            $args['icon'] = '<svg xmlns="http://www.w3.org/2000/svg" class="dropdown-icon icon icon-tabler icon-tabler-clock" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>  <circle cx="12" cy="12" r="9" />  <polyline points="12 7 12 12 15 15" /></svg>';
            foreach($args['booking_offers_intersection']->duration as $key => $value) {
                $string = $value <= 1 ? 'Tagesfahrt' : $value . ' Tage';
                $args['filter_data'][$args['filter_val']][$string] = $args['booking_offers_intersection']->{$args['filter_val']}[$key];
            }
            ?>
            <?php echo Template::render(APPLICATION_PATH.'/template-parts/pm-search/filter/checkbox-dropdown.php', $args); ?>
        <?php } ?>
        <?php if(count($args['booking_offers_intersection']->option_occupancy) > 1) { ?>
            <?php
            $args['label'] = 'Unterbringung';
            $args['filter_param'] = 'pm-ho';
            $args['behavior'] = null;
            $args['filter_val'] = 'option_occupancy';
            $args['type'] = 'radio';
            $args['icon'] = '<svg xmlns="http://www.w3.org/2000/svg" class="dropdown-icon icon icon-tabler icon-tabler-bed" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>  <path d="M3 7v11m0 -4h18m0 4v-8a2 2 0 0 0 -2 -2h-8v6" />  <circle cx="7" cy="10" r="1" /></svg>';
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
            $args['icon'] = '<svg xmlns="http://www.w3.org/2000/svg" class="dropdown-icon icon icon-tabler icon-tabler-bus" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>   <circle cx="6" cy="17" r="2"></circle>   <circle cx="18" cy="17" r="2"></circle>   <path d="M4 17h-2v-11a1 1 0 0 1 1 -1h14a5 7 0 0 1 5 7v5h-2m-4 0h-8"></path>   <polyline points="16 5 17.5 12 22 12"></polyline>   <line x1="2" y1="10" x2="17" y2="10"></line>   <line x1="7" y1="5" x2="7" y2="10"></line>   <line x1="12" y1="5" x2="12" y2="10"></line></svg>';
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
            $args['icon'] = '<svg xmlns="http://www.w3.org/2000/svg" class="dropdown-icon icon icon-tabler icon-tabler-plane-departure" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>   <path d="M15 12h5a2 2 0 0 1 0 4h-15l-3 -6h3l2 2h3l-2 -7h3z" transform="rotate(-15 12 12) translate(0 -1)"></path>   <line x1="3" y1="21" x2="21" y2="21"></line></svg>';
            foreach($args['booking_offers_intersection']->transport_1_airport_name as $key => $value) {
                $args['filter_data'][$args['filter_val']][$key] = $args['booking_offers_intersection']->{$args['filter_val']}[$key];
                $args['filter_data'][$args['filter_val2']][$key] = $args['booking_offers_intersection']->{$args['filter_val2']}[$key];
            }
            ?>
            <?php echo Template::render(APPLICATION_PATH.'/template-parts/pm-search/filter/checkbox-dropdown.php', $args); $args['filter_val2'] = null; ?>
        <?php } ?>
        <?php
        $dateFrom = DateTime::createFromFormat('Y-m-d H:i:s', $args['booking_offers_intersection']->date_departure_from[0]);
        $dateTo = DateTime::createFromFormat('Y-m-d H:i:s', $args['booking_offers_intersection']->date_departure_to[array_key_last($args['booking_offers_intersection']->date_departure_to)]);
        $currentDate = new DateTime();
        $ajax = '0';
        if($dateFrom != $dateTo) { ?>
            <div class="col-12 col-lg-3">
                <?php echo Template::render(APPLICATION_PATH . '/template-parts/pm-search/search/date-picker.php', ['name' => 'Reisezeitraum', 'departure_min' => $dateFrom, 'departure_max' => $dateTo, 'departure_dates' => [], 'use_ajax' => $ajax ] ); ?>
            </div>
        <?php } ?>
    </div>
    <div class="col-12 col-md-3 filter-control">
        <div class="btn btn-primary modal-close-btn"><span id="offers-filter-total"><?php echo $args['booking_offers_intersection']->count == 15 ? 'Über 15 ' : $args['booking_offers_intersection']->count; ?></span> Angebote anzeigen</div>
        <div class="btn btn-secondary clear-filter">Filter zurücksetzen</div>
    </div>
</form>