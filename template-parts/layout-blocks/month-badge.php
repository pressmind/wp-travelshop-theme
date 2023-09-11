<?php

/**
 * <code>
 *  $args = (
 *          [headline] => Reise-Empfehlungen
 *          [text] => Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip.
 *         [id_object_type] => 123
 * )
 * </code>
 * @var array $args
 */

use Pressmind\HelperFunctions;
use Pressmind\Travelshop\Calendar;
use Pressmind\Travelshop\RouteHelper;
use Pressmind\Travelshop\Template;


$travel_months = Calendar::getTravelMonthRanges();

if (empty($travel_months)) {
    return;
}

?>
<section class="content-block content-block-month-teaser">
    <div class="row row-products">
        <div class="col-12 month-badges d-flex flex-row flex-wrap">
            <?php
            $filtered = false;
            if ( !empty($_GET) && isset($_GET['pm-dr']) && !empty($_GET['pm-dr']) ) {
                $filtered = true;
            }
            ?>
            <div class='month-badge'>
                <a class="<?php echo (!$filtered) ? 'is-active' : ''; ?>" href="/calendar">
                    Alle Monate
                </a>
            </div>
            <?php
            // -- use Grouped Array to render Items
            $month_count = 1;
            foreach ($travel_months as $item) {
                ?>
                <div class='month-badge'>
                    <?php
                    // select a random media object for displaying the image in the teaser (loop trough if the're is a media object without images
                    $image_url = '';
                    $image_copyright = '';
                    $retries_count = 0;
                    while(true){
                        $mo = new \Pressmind\ORM\Object\MediaObject(array_rand(array_flip($item['id_media_objects']), 1));
                        $moc = $mo->getDataForLanguage(TS_LANGUAGE_CODE);
                        if (!empty($moc->bilder_default) && is_array($moc->bilder_default) && count($moc->bilder_default) > 0) {
                            $rand_image = array_rand($moc->bilder_default);
                            $image_url = $moc->bilder_default[$rand_image]->getUri('thumbnail', false, 'base');
                            $image_copyright = $moc->bilder_default[$rand_image]->copyright;
                            break;
                        }
                        if($retries_count >= 3){
                            break;
                        }
                        $retries_count++;
                    }
                    if(empty($image_url)){
                        $image_url = '/placeholder.svg?wh=80x80&text='.HelperFunctions::monthNumberToLocalMonthName($item['from']->format('n'));
                    }
                    $active = false;
                    $duration_string = $item['from']->format('Ymd').'-'.$item['to']->format('Ymd');
                    if ( !empty($_GET) && isset($_GET['pm-dr']) && $_GET['pm-dr'] === $duration_string ) {
                        $active = true;
                    }
                    ?>
                    <a class="<?php echo ($active) ? 'is-active' : ''; ?>" href='<?php echo RouteHelper::get_url_by_object_type($args['id_object_type']) . '/?pm-o=date_departure-asc&pm-dr='.$item['from']->format('Ymd').'-'.$item['to']->format('Ymd'); ?>'
                       title="<?php echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/month-name.php', ['date' => $item['from']]); ?>">

                        <?php
                        echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/month-name.php', [
                            'date' => $item['from']
                        ]);
                        ?>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>
