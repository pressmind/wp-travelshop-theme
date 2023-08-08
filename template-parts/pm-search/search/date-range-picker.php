<?php
use Pressmind\Registry;
use Pressmind\Travelshop\CalendarGenerator;

/**
 * @var $args['name']
 * @var $args['departure_min']
 * @var $args['departure_max']
 * @var $args['departure_dates']
 */

$minDate = $maxDate = $minYear = $maxYear = '';
if(!empty($args['departure_min']) && !empty($args['departure_max'])){
    $minDate = $args['departure_min']->format('d.m.Y');
    $maxDate = $args['departure_max']->format('d.m.Y');
    $minYear = $args['departure_min']->format('Y');
    $maxYear = $args['departure_max']->format('Y');
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

$duration_readable = '';

$durConfig = Registry::getInstance()->get('config');

foreach ( $durConfig['data']['search_mongodb']['search']['touristic']['duration_ranges'] as $range ) {
    $isCurrentDur = false;

    if ( !empty($_GET['pm-du']) && $_GET['pm-du'] == implode('-', $range) ) {
        if(next($durConfig['data']['search_mongodb']['search']['touristic']['duration_ranges'] )){
            $duration_readable = implode('-', $range).' Tage';
        }else{
            $duration_readable = $range[0].' Tage und mehr';
        }
    }
}
?>
<div class="search-field-input search-field-input--datepicker">

    <button class="search-field-input-field travelshop-datepicker-input"
            type="button"
            data-type="datedurationrange"
            readonly
            data-mindate="<?php echo $minDate;?>"
            data-maxdate="<?php echo $maxDate;?>"
            data-value="<?php echo $value; ?>"
            placeholder="<?php echo empty($args['name']) ? 'Reisezeitraum' : $args['name']; ?>"
            data-departures='<?php echo $departures_dates;?>'>

        <span class="selected-options selected-options-fade">
            <span class="selected-options-date" data-default="<?php echo empty($args['name']) ? 'Reisezeitraum' : $args['name']; ?>"><?php echo !empty($human_readable_str) ? $human_readable_str : 'Reisezeitraum'; ?></span>
        </span>
        <div class="input-icon">
            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#calendar-blank"></use></svg>
        </div>

    </button>
    <svg class="input-clear datepicker-clear" <?php if (!empty($_GET['pm-dr']) && $use_ajax == "1") { echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?>><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>

    <input class="travelshop-datepicker-input-hidden d-none" type="text" name="pm-dr"  data-value="<?php echo $value; ?>" value="<?php echo $human_readable_str; ?>" />
</div>

<div class="daterange-overlay">
    <div class="daterange-overlay-header d-flex flex-row flex-nowrap justify-content-between justify-content-lg-center">
        <div class="h5 d-none d-lg-block">
            <span class="selected-options-date" data-default="<?php echo empty($args['name']) ? 'Reisezeitraum' : $args['name']; ?>"><?php echo !empty($human_readable_str) ? $human_readable_str : 'Reisezeitraum'; ?></span>
        </div>
        <div class="h5 d-block d-lg-none">
            <?php echo empty($args['name']) ? 'Reisezeitraum' : $args['name']; ?>
        </div>
        <button type="button" class="daterange-overlay-close d-flex d-lg-none">
            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
        </button>
    </div>

    <div class="daterange-overlay-content">
        <?php
        $Calendar = new CalendarGenerator(new DateTime('now'), $value, $minDate, $maxDate, $minYear, $maxYear, $departures_dates);
        $CalendarObject = $Calendar->getCalendarObject();
        ?>

        <?php
        require "date-range-picker-overlay.php";
        ?>
    </div>

    <div class="daterange-overlay-footer">
        <button type="button" class="daterange-overlay-reset btn btn-link">
            Zurücksetzen
        </button>
        <button type="button" class="daterange-overlay-prompt btn btn-outline-primary">
            Übernehmen
        </button>
    </div>
</div>

<div class="daterange-overlay-backdrop"></div>