<?php
use Pressmind\HelperFunctions;
use Pressmind\Travelshop\Template;

/**
 * <code>
 * $args['date_departure']
 * $args['date_arrival']
 * $args['dates_per_month']
 * $args['departure_date_count']
 * $args['url']
 * </code>
 * @var array $args
 */

$today = new DateTime();
$date_format = $args['date_departures'][0]->format('Y') == $today->format('Y') ? 'd.m.' : 'd.m.Y';
?>
<div class="dropdown">
    <button class="btn <?php echo $args['departure_date_count'] == 1  || empty($args['dates_per_month']) ? ' disabled' : ' dropdown-toggle'; ?>"
            type="button"
            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
        <?php
        echo '<i class="circle green"></i> ab ';
        echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/travel-date-range.php', [
            'date_departure' => $args['date_departures'][0],
            'date_from_format ' => $date_format
        ]);
        if(in_array($args['date_departures'][0], $args['guaranteed_departures'])){
            echo ' garantiert';
        }
        if ($args['departure_date_count'] > 1 && !empty($args['dates_per_month'])) {
            ?>
            <span class="small more-dates">
                (<?php echo $args['departure_date_count']; ?> <?php echo ($args['departure_date_count'] > 1) ? 'weitere Termine' : 'weiterer Termin';?>)
            </span>
            <?php
        }
        ?>
    </button>
    <?php if ($args['departure_date_count'] > 1  && !empty($args['dates_per_month'])) { ?>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <?php
            foreach ($args['dates_per_month'] as $month) {
                echo '<p class="dropdown-header">' . HelperFunctions::monthNumberToLocalMonthName($month['month']) . '</p>';
                foreach ($month['five_dates_in_month'] as $date) {
                    ?>
                    <a class="dropdown-item<?php echo $date['active'] ? ' active' : ''; ?>"
                       href="<?php echo $args['url'].(!strpos($args['url'], '?') ? '?' : '&') . 'pm-dr=' . $date['date_departure']->format('Ymd'); ?>">
                        <?php
                        echo '<i class="circle green"></i>';
                        echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/travel-date-range.php', [
                            'date_departure' => $date['date_departure'],
                            'duration' => $date['duration'],
                            'price_total' => $date['price_total'],
                            'price_regular_before_discount' => $date['price_regular_before_discount'],
                            'durations_from_this_departure' => $date['durations_from_this_departure'],
                            'date_from_format ' => $date_format
                        ]);

                        if($date['guaranteed'] === true){
                            echo ' garantierte Abreise';
                        }
                        ?>
                    </a>
                    <?php
                }
                if ($month['dates_total'] > 5) {
                    ?>
                    <a class="dropdown-item" href="<?php echo $args['url']; ?>"><small>mehr Termine
                            im <?php echo HelperFunctions::monthNumberToLocalMonthName($month['month']); ?></small></a>
                    <?php
                }
            }
            ?>
        </div>
    <?php } ?>
</div>

