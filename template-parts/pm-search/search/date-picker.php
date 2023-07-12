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
$use_ajax = '1';
if(isset($args['use_ajax'])) {
    $use_ajax = $args['use_ajax'];
}

$human_readable_str = '';
$value = '';
if (empty($_GET['pm-dr']) === false && $use_ajax == '1') {
    $dr = BuildSearch::extractDaterange($_GET['pm-dr']);
    $human_readable_str = $dr[0]->format('d.m.') . ' - ' . $dr[1]->format('d.m.y');
    $value = $dr[0]->format('Ymd') . '-' . $dr[1]->format('Ymd');
}
?>
<div class="search-field-input search-field-input--datepicker">
    <input type="text"
        class="search-field-input-field travelshop-datepicker-input"
        data-type="daterange"
        name="pm-dr"
        autocomplete="off"
        readonly
        data-mindate="<?php echo $minDate;?>"
        data-maxdate="<?php echo $maxDate;?>"
        data-value="<?php echo $value; ?>"
        placeholder="<?php echo empty($args['name']) ? 'Reisezeitraum' : $args['name']; ?>"
        data-ajax="<?php echo $use_ajax; ?>"
        data-departures='<?php echo $departures_dates;?>'
        value="<?php echo $human_readable_str; ?>"/>

    <?php // @todo: this is needed/used for what? ?>
    <?php if($use_ajax == "0") { ?>
    <svg xmlns="http://www.w3.org/2000/svg"
        <?php if (!empty($_GET['pm-dr'])) { echo 'style="display: none;"'; } else { echo 'style="display: block;"'; } ?>
         class="icon icon-tabler icon-tabler-calendar datepicker-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <rect x="4" y="5" width="16" height="16" rx="2" />
        <line x1="16" y1="3" x2="16" y2="7" />
        <line x1="8" y1="3" x2="8" y2="7" />
        <line x1="4" y1="11" x2="20" y2="11" />
        <line x1="11" y1="15" x2="12" y2="15" />
        <line x1="12" y1="15" x2="12" y2="18" />
    </svg>
    <?php } ?>


    <svg <?php if (!empty($_GET['pm-dr']) && $use_ajax == "1") { echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?> class="input-clear datepicker-clear"><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>


</div>