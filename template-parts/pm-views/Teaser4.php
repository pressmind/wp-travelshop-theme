<?php
/**
 * This Teaser is used in the following modules:
 *  - template-parts/layout-blocks/product-category-teaser.php
 */
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

$args['class'] = empty($args['class']) ? 'col-12' : $args['class'];

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
<article class="<?php echo $args['class']; ?> card-category-travel-wrapper">
       <?php
       echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/wishlist-heart.php', [
                    'cheapest_price' => $args['cheapest_price'],
                    'id_media_object' => $args['id_media_object'],
                    'id_object_type' => $args['id_object_type'],
                ]);
        ?>
        <section class="card-body">

            <h1 class="card-title">
                <a href="<?php echo $args['url']; ?>"><?php echo $args['headline']; ?></a>
            </h1>

            <div class="bottom-aligned">
                    <div class="card-text discount-row">
                    <?php
                        if (($discount = PriceHandler::getDiscount($args['cheapest_price'])) !== false) {
                            echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/discount.php', [
                                'cheapest_price' => $args['cheapest_price'],
                                'discount' => $discount,
                                'hide-price-total' => true,
                                'hide-discount-valid-to' => true,
                            ]);
                            ?>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="card-text price-row">
                        <?php if(!is_null($args['cheapest_price'])){ ?>
                        <span class="small">
                            <span>
                                 <?php
                                 echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration.php', [
                                     'duration' => $args['cheapest_price']->duration,
                                     'suffix' => 'Reise'
                                 ]);
                                 ?>
                            </span><br>
                        </span>
                        <?php } ?>
                        <a href="<?php echo $args['url']; ?>" class="product-price">
                            <?php
                            if(!is_null($args['cheapest_price'])){
                            echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/price-1.php', [
                                'cheapest_price' => $args['cheapest_price'],
                            ]);
                            }else{
                                echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/no-price.php', []);
                            }
                            ?>
                        </a>
                    </div>
            </div>
        </section>
</article>