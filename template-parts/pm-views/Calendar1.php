<?php

use Pressmind\Registry;
use Pressmind\Travelshop\PriceHandler;
use Pressmind\Travelshop\Template;
/**
 * <code>
 * $args = [
 *  'id_media_object' => 12345
 *  'id_object_type' => 123
 *  'headline' => ''
 *  'subline' => ''
 *  'travel_type' => ''
 *  'destination' => ''
 *  'image' => []
 *  'cheapest_price' => {}
 *  'departure_date_count' => 12
 *  'possible_durations' => []
 *  'dates_per_month' => []
 *  'class' => ''
 * ];
 * </code>
 * @var array $args
 *
 */

/**
 * DON'T USE WordPress Stuff here
 */

$cheapest_price = $args['cheapest_price'];
$random = rand(1, 999999);
?>

<div class="product-calendar-group-item " data-row-id="<?php echo $random; ?>" data-pm-id="<?php echo $args['id_media_object']; ?>">
    <div class="row">
        <div class="col-12 col-lg-3">
            <div class="arrow--wrapper">
                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-down"></use></svg>

                <i class="circle green"></i>
                <?php
                if(!empty($cheapest_price)) {
                    // var_dump($cheapest_price);
                    echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/travel-date-range.php', [
                        'date_departure' => $cheapest_price->date_departures[0],
                        //'date_arrival' => $cheapest_price->date_arrival
                    ]);
                }
                ?>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <strong><?php echo $args['headline']; ?></strong>
        </div>
        <div class="col-6 col-lg-2">
            <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration.php', ['duration' => $cheapest_price->duration]);?>
        </div>
        <div class="col-6 col-lg-3 text-lg-right">
        <span class="price">
            <?php
            if (!empty($cheapest_price) && ($discount = PriceHandler::getDiscount($cheapest_price)) !== false) {
                echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/discount.php', [
                    'cheapest_price' => $cheapest_price,
                    'discount' => $discount,
                    'hide-price-total' => true,
                    'hide-discount-valid-to' => true,
                ]);
            }
            if (empty($cheapest_price->price_total) === false) {
                echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/price-1.php', [
                    'cheapest_price' => $cheapest_price,
                ]);
            }
            ?>
        </span>
        </div>
    </div>
</div>


<div class="product-calendar-group-item-product">
    <div class="row product-calendar-group-item--product" data-row-id="<?php echo $random; ?>">
        <?php // this section will get the content by ajax; (pm-view/Teaser*), see ajax.js:initCalendarRowClick();
        ?>
    </div>
</div>