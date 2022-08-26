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

$config = Registry::getInstance()->get('config');

// only this search params are transmitted, price range (pm-pr), date range (pm-dr), duration range (pm-du), housingoption occupancy (pm-ho)
$allowedParams = ['pm-pr', 'pm-dr', 'pm-du', 'pm-ho', 'pm-tr'];
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
<article class="<?php echo empty($args['class']) ? 'col-12 col-md-6 col-lg-3' : $args['class']; ?> card-travel-wrapper">
    <div class="card card-travel">
            <div class="card-image-holder col-5 col-sm-5 col-md-12 p-0">
                <?php
                echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/card-badge.php', [
                    'cheapest_price' => $args['cheapest_price'],
                    'id_media_object' => $args['id_media_object'],
                    'id_object_type' => $args['id_object_type'],
                ]);
                echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/wishlist-heart.php', [
                    'cheapest_price' => $args['cheapest_price'],
                    'id_media_object' => $args['id_media_object'],
                    'id_object_type' => $args['id_object_type'],
                ]);
                ?>
                <a href="<?php echo $args['url']; ?>">
                    <?php
                    echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/image.php', [
                        'image' => $args['image'],
                        'class' => 'card-img-top',
                    ]);
                    ?>
                </a>
            </div>

        <section class="card-body col-7 col-sm-7 col-md-12">
            <?php
                if(!empty($_GET['debug'])){
                    echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/debug-textsearch.php', $args);
                }
            ?>
            <h1 class="card-title">
                <a href="<?php echo $args['url']; ?>"><?php echo $args['headline']; ?></a>
            </h1>
            <?php
            echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/attribute-row.php', [
                'attributes' => array_filter([$args['travel_type'] ?? [], $args['destination'] ?? []]),
            ]);
            ?>
            <?php if (empty($args['subline']) === false) { ?>
                <p class="card-text subline">
                    <?php echo $args['subline']; ?>
                    <span class="fade-out"></span>
                </p>
            <?php } ?>
            <div class="bottom-aligned">
                <?php if(!is_null($args['cheapest_price'])){ ?>
                <div class="card-text date-row">
                    <span class="small">
                        <span>
                        <?php
                            echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration.php', [
                                    'duration' => $args['cheapest_price']->duration]
                            );
                            if(!empty($args['cheapest_price']->option_board_type)){
                                echo ', inkl. '.$args['cheapest_price']->option_board_type;
                            }
                        ?><br>
                        </span>
                    </span>
                    <?php
                        echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/date-dropdown.php', [
                            'date_departures' => $args['cheapest_price']->date_departures,
                            'dates_per_month' => $args['dates_per_month'],
                            'departure_date_count' => $args['departure_date_count'],
                            'url' => $args['url']
                        ]);
                    ?>
                </div>
                <?php } ?>
                <div class="card-text price-row">
                        <?php
                        if (($discount = PriceHandler::getDiscount($args['cheapest_price'])) !== false) {
                            echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/discount.php', [
                                'prefix' => '<hr>',
                                'cheapest_price' => $args['cheapest_price'],
                                'discount' => $discount,
                                'hide-price-total' => true,
                                'hide-discount-valid-to' => true,
                            ], 0);
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