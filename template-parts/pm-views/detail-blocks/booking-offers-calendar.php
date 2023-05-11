<?php
use Pressmind\HelperFunctions;
use Pressmind\ORM\Object\Airport;
use Pressmind\Search\CheapestPrice;
use Pressmind\Travelshop\IB3Tools;
use Pressmind\Travelshop\Template;
use Pressmind\Travelshop\PriceHandler;

/**
 * @var array $args
 */


/**
 * @var \Pressmind\ORM\Object\MediaObject $mo
 */
$mo = $args['media_object'];

if(empty($args['cheapest_price']) || !empty($args['booking_on_request'])){
    return;
}

$filter = new \Pressmind\Search\CalendarFilter();
$filter->occupancy = 2;
if(empty($_GET['pm-du']) && empty($_GET['pm-tr'])){
    $filter->duration = $args['cheapest_price']->duration;
    $filter->transport_type = $args['cheapest_price']->transport_type;
    $filter->id_housing_package = $args['cheapest_price']->id_housing_package;
}else{
    if(!empty($_GET['pm-du'])) {
        $filter->duration = BuildSearch::extractDurationRange($_GET['pm-du'], null, true);
    }
    if(!empty($_GET['pm-tr'])) {
        $filter->transport_type = BuildSearch::extractTransportTypes($_GET['pm-tr'], null, true);
    }
    if(!empty($_GET['pm-hpid'])){
        $filter->id_housing_package = BuildSearch::extractHousingPackageId($_GET['pm-hpid']);
    }
    if(!empty($_GET['pm-da'])){
        $filter->airport = BuildSearch::extractAirport3L($_GET['pm-da']);
    }
}
$result = $mo->getCalendar($filter, 3);
if(empty($result->calendar)){
    return;
}
?>
<div class="row content-block-detail-booking-calendar">
    <div class="col-12">
        <div class="booking-calendar-title">
            <h2>Buchungskalender
               <?php echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/duration.php', ['duration' => $args['cheapest_price']->duration]); ?>
                <?php
                echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/transport_type_human_string.php', [
                    'transport_type' => $args['cheapest_price']->transport_type,
                ]);
                ?>
            </h2>
            <div>
                <div>Wie möchten Sie reisen?</div>
                <div class="btn-group" role="group" aria-label="Transport">
                    <?php
                    foreach($result->filter['transport_types'] as $transport_type => $options) {
                        $current_class = 'btn-outline-primary';
                        if($transport_type == $result->calendar->transport_type){
                            $current_class = 'btn-primary';
                        }
                        $query = [];
                        $query['pm-tr'] = $transport_type;
                        if(in_array($result->calendar->booking_package->duration, $options['durations'])){
                            $query['pm-du'] = $result->calendar->booking_package->duration;
                        }else{
                            $current_class = 'btn-outline-secondary';
                        }
                        ?>
                        <a href="<?php echo Template::modifyUrl($args['url'], $query, true); ?>"
                           class="btn <?php echo $current_class;?>"><?php
                            echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/transport_type_human_string.php', [
                                'transport_type' => $transport_type,
                            ]);
                            ?></a>
                    <?php } ?>
                </div>

                <div>Wie lange möchten Sie reisen?</div>
                <div class="btn-group" role="group" aria-label="Durations">
                    <?php
                        foreach($result->filter['durations'] as $duration => $options) {
                            $current_class = 'btn-outline-primary';
                            if($duration == $result->calendar->booking_package->duration){
                                $current_class = 'btn-primary';
                            }
                            $query = [];
                            $query['pm-du'] = $duration;
                            if(in_array($result->calendar->transport_type, $options['transport_types'])){
                                $query['pm-tr'] = $result->calendar->transport_type;
                            }else{
                                $current_class = 'btn-outline-secondary';
                            }
                            ?>
                            <a href="<?php echo Template::modifyUrl($args['url'], $query, true); ?>"
                               class="btn <?php echo $current_class;?>"><?php
                                echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration.php', ['duration' => $duration]);
                                ?>
                            </a>
                    <?php }
                        ?>
                </div>
                <?php
                $valid_housing_packages = [];
                foreach($result->filter['id_housing_packages'] as $id_housing_package => $options) {
                    if(!in_array($result->calendar->booking_package->duration, $options['durations']) ||
                        !in_array($result->calendar->transport_type, $options['transport_types'])
                    ){
                        continue;
                    }
                    $valid_housing_packages[] = $id_housing_package;
                }
                if(count($valid_housing_packages) > 1){?>
                <div>Bitte wählen Sie Ihr Angebotspaket:</div>
                <div class="btn-group" role="group" aria-label="HousingPackage">
                    <?php
                    foreach($result->filter['id_housing_packages'] as $id_housing_package => $options) {
                        if(!in_array($id_housing_package, $valid_housing_packages)){
                            continue;
                        }
                        $current_class = 'btn-outline-primary';
                        if($id_housing_package == $result->calendar->housing_package->id){
                            $current_class = 'btn-primary';
                        }
                        $query = [];
                        $query['pm-du'] = $result->calendar->booking_package->duration;
                        $query['pm-tr'] = $result->calendar->transport_type;
                        $query['pm-hpid'] = $id_housing_package;
                        ?>
                        <a href="<?php echo Template::modifyUrl($args['url'], $query, true); ?>" class="btn <?php echo $current_class;?>"><?php
                            $HousingPackage = new \Pressmind\ORM\Object\Touristic\Housing\Package($id_housing_package);
                            echo $HousingPackage->name;
                            ?>
                        </a>
                    <?php } ?>
                </div>
                <?php } ?>
                <?php
                $valid_airports = [];
                foreach($result->filter['airports'] as $airport => $options) {
                    if(!in_array($result->calendar->booking_package->duration, $options['durations']) ||
                        !in_array($result->calendar->transport_type, $options['transport_types']) ||
                        !in_array($result->calendar->housing_package->id, $options['id_housing_packages']
                        )
                    ){
                        continue;
                    }
                    $valid_airports[] = $airport;
                }
                if(count($valid_airports) > 0){?>
                    <div>Bitte wählen Sie Ihren Flughafen.</div>
                    <div class="btn-group" role="group" aria-label="Airport">
                        <?php
                        foreach($result->filter['airports'] as $airport => $options) {
                            if(!in_array($airport, $valid_airports)){
                                continue;
                            }
                            $current_class = 'btn-outline-primary';
                            if($airport == $result->calendar->airport){
                                $current_class = 'btn-primary';
                            }
                            $query = [];
                            $query['pm-du'] = $result->calendar->booking_package->duration;
                            $query['pm-tr'] = $result->calendar->transport_type;
                            $query['pm-hpid'] = $result->calendar->housing_package->id;
                            $query['pm-da'] = $airport;
                            ?>
                            <a href="<?php echo Template::modifyUrl($args['url'], $query, true); ?>" class="btn <?php echo $current_class;?>"><?php
                                echo Airport::getByIata($airport)->name;
                                ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
    <div class="col-12">
        <div class="booking-calendar-slider">
            <?php
            foreach ($result->calendar->month as $month) {
                $duration = $result->calendar->booking_package->duration;
                $transport_type = $result->calendar->transport_type;
                ?>
                <div class="calendar-wrapper">
                    <div class="month-name">
                        <?php
                        echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/month-name.php', ['date' => $month->days[0]->date]);
                        ?>
                    </div>
                    <ul class="calendar">
                        <?php
                        foreach (range(1, 7) as $day_of_week) {
                            ?>
                            <li class="weekday"><?php echo HelperFunctions::dayNumberToLocalDayName($day_of_week, 'short'); ?></li>
                            <?php
                        }
                        for ($d = 2 ; $d < $month->days[0]->date->format('w') + 1; $d++){ echo '<li></li>'; }
                        foreach ($month->days as $day) {
                            if (!empty($day->cheapest_price)) {
                                $info = Template::render(APPLICATION_PATH . '/template-parts/micro-templates/duration.php', ['duration' => $duration]);
                                $info .= ' / ';
                                $info .= Template::render(APPLICATION_PATH.'/template-parts/micro-templates/transport_type_human_string.php', ['transport_type' => $transport_type]);
                                $class = '';
                                if($day->cheapest_price->guaranteed){
                                    $class = ' date-is-guaranteed';
                                    $info .= "\ngarantierte Durchführung";
                                }
                                if($day->cheapest_price->saved){
                                    $class = ' date-is-saved';
                                    $info .= "\ngesicherte Durchführung";
                                }
                                ?>
                                <li class="travel-date position-relative<?php echo $class;?>" title="<?php echo $info; ?> <br> zur Buchung" data-html="true" data-toggle="tooltip">
                                    <a data-duration="<?php echo $duration; ?>"
                                       data-anchor="<?php echo $day->cheapest_price->id; ?>"
                                       data-modal="true" data-modal-id="<?php echo $args['id_modal_price_box']; ?>"
                                       href="<?php echo IB3Tools::get_bookinglink($day->cheapest_price, $args['url'], null, $args['booking_type'] ?? null, true);?>"
                                       class="stretched-link"><?php echo $day->date->format('d'); ?>
                                        <div>ab&nbsp;<?php echo PriceHandler::format($day->cheapest_price->price_total); ?></div>
                                    </a>
                                </li>
                                <?php
                            } else {
                                ?>
                                <li><?php echo $day->date->format('d'); ?></li>
                                <?php
                            }
                        } ?>
                    </ul>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>