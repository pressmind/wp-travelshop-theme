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
    <div class="row">
        <?php if (!empty($args['headline']) || !empty($args['text'])) { ?>
            <div class="col-12">
                <?php if (!empty($args['headline'])) { ?>
                    <h2 class="mt-0">
                        <?php echo $args['headline']; ?>
                    </h2>
                <?php } ?>
                <?php if (!empty($args['text'])) { ?>
                    <p>
                        <?php echo $args['text']; ?>
                    </p>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="col-12">
            <div class="row month-teaser-group">
                <?php
                // -- use Grouped Array to render Items
                $month_count = 1;
                foreach ($travel_months as $item) {
                    ?>
                    <div class='col-12 col-sm-6 col-lg-4'>
                        <div class='teaser month-teaser'>
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
                            ?>
                            <a href='<?php echo RouteHelper::get_url_by_object_type($args['id_object_type']) . '/?pm-o=date_departure-asc&pm-dr='.$item['from']->format('Ymd').'-'.$item['to']->format('Ymd'); ?>'
                               title="<?php echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/month-name.php', ['date' => $item['from']]); ?>">
                                <div class="month-teaser-image">
                                    <div>
                                        <img src="<?php echo $image_url; ?>"
                                                 title="<?php echo $image_copyright; ?>"
                                                 alt="<?php echo strip_tags($mo->name); ?>"
                                                 class="card-img-top"
                                                 loading="lazy">
                                    </div>
                                </div>
                                <div class="month-teaser-title">
                                    <?php
                                    echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/month-name.php', [
                                        'date' => $item['from']
                                    ]);
                                    ?>
                                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-right"></use></svg>

                                </div>
                            </a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>
