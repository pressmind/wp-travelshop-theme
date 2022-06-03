<?php
/**
 * @var $args['name']
 * @var $args['departure_min']
 * @var $args['departure_max']
 * @var $args['departure_dates']
 */

$minDate = $maxDate = '';
if(!empty($args['departure_min']) && !empty($args['departure_max'])){
    $minDate = $args['departure_min']->format('d.m.Y');
    $maxDate = $args['departure_max']->format('d.m.Y');
}

$departures_dates = '[]';
if(!empty($args['departure_dates'])){
    $departures_dates = json_encode($args['departure_dates']);
}

$human_readable_str = '';
$value = '';
if (empty($_GET['pm-dr']) === false) {
    $dr = BuildSearch::extractDaterange($_GET['pm-dr']);
    $human_readable_str = $dr[0]->format('d.m.') . ' - ' . $dr[1]->format('d.m.Y');
    $value = $dr[0]->format('Ymd') . '-' . $dr[1]->format('Ymd');
}
?>
<div class="list-filter-box form-group mb-md-0">
    <label for=""><?php echo empty($args['name']) ? 'Reisezeitraum' : $args['name']; ?></label>
    <div>
        <input type="text"
            class="form-control travelshop-datepicker-input"
            data-type="daterange"
            name="pm-dr"
            autocomplete="off"
            readonly
            data-mindate="<?php echo $minDate;?>"
            data-maxdate="<?php echo $maxDate;?>"
            data-value="<?php echo $value; ?>"
            placeholder="egal"
            data-departures='{<?php echo $departures_dates;?>}'
            value="<?php echo $human_readable_str; ?>"/>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" 
        <?php if (!empty($_GET['pm-dr'])) { echo 'style="display: block;"'; } ?>
        class="icon icon-tabler icon-tabler-x datepicker-clear" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <line x1="18" y1="6" x2="6" y2="18" />
        <line x1="6" y1="6" x2="18" y2="18" />
    </svg>
</div>