<?php
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

// only this search params are transmitted, price range (pm-pr), date range (pm-dr), duration range (pm-du), housingoption occupancy (pm-ho)
$allowedParams = ['pm-pr', 'pm-dr', 'pm-du', 'pm-ho'];
$filteredParams = array_filter($_GET,
    function ($key) use ($allowedParams) {
        return in_array($key, $allowedParams);
    },
    ARRAY_FILTER_USE_KEY
);

if (empty($filteredParams) === false) {
    $query_string = http_build_query($filteredParams);
    $args['url'] .= '?' . $query_string;
}
?>
<article class="travelshop-teaser-mega-stripe col-12">
    <div class="stripe-inner">
        <div class="stripe-image"
             role="img" aria-label="<?php echo $args['headline']; ?>"
             style="background-image:url(<?php echo !empty($args['image_square']['url']) ? $args['image_square']['url'] : '/placeholder.svg?wh=250x170&text=bilder_default%20not%20found'; ?>);">
            <?php
            echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/wishlist-heart.php', [
                   'cheapest_price' => $args['cheapest_price'],
                   'id_media_object' => $args['id_media_object'],
                   'id_object_type' => $args['id_object_type'],
               ]);
           ?>
            <?php if(!is_null($args['cheapest_price'])){ ?>
            <div class='stripe-duration'>
                <?php
                if($args['cheapest_price']->duration == 1){ ?>
                    <small><?php
                        echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration.php', [
                                'duration' => $args['cheapest_price']->duration]
                        );
                        ?>
                    </small>
                <?php }else{ ?>
                    <strong><?php echo $args['cheapest_price']->duration; ?></strong>
                    <br/>
                    <small>Tage</small>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        <section class="stripe-content">
            <div class="stripe-content-head">
                <h1>
                    <a href="<?php echo $args['url']; ?>"><?php echo $args['headline']; ?></a>
                </h1>
            </div>
            <div class="stripe-content-body">
                <p><?php echo $args['subline']; ?></p>
                <?php
                echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/attribute-row.php', [
                    'attributes' => array_filter([$args['travel_type'] ?? [], $args['destination'] ?? []]),
                ]);
                ?>
            </div>
            <div class="stripe-content-footer">
                <?php if(!is_null($args['cheapest_price'])){  ?>
                <div class="stripe-departure">
                    <strong>Abreise</strong>
                    <?php
                    echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/date-dropdown.php', [
                        'date_departures' => $args['cheapest_price']->date_departures,
                        'dates_per_month' => $args['dates_per_month'],
                        'departure_date_count' => $args['departure_date_count'],
                        'url' => $args['url']
                    ]);
                    ?>
                </div>
                <?php } ?>
                <div class="stripe-cta">
                    <?php
                    if (($discount = PriceHandler::getDiscount($args['cheapest_price'])) !== false) {
                        echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/discount.php', [
                            'cheapest_price' => $args['cheapest_price'],
                            'discount' => $discount,
                            'hide-price-total' => true,
                            'hide-discount-valid-to' => true,
                        ]);
                    }
                    ?>
                    <a href="<?php echo $args['url']; ?>" class="travel-teaser-link">
                        <div class="btn btn-primary">
                            <?php
                            if(!is_null($args['cheapest_price'])) {
                                echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/price-1.php', [
                                    'cheapest_price' => $args['cheapest_price'],
                                ]);
                            }else{
                                echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/no-price.php', []);
                            }
                            ?>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    </div>
</article>