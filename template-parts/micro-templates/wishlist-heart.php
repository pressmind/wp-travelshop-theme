<?php
use Pressmind\Travelshop\IB3Tools;
/**
 * <code>
 * $args['cheapest_price'] CheapestPriceSpeed
 * $args['id_media_object']
 * $args['id_object_type']
 * </code>
 * @var array $args
 */
?>
<div data-pm-id="<?php echo $args['id_media_object']; ?>"
     data-pm-ot="<?php echo $args['id_object_type']; ?>"
     data-pm-dr="<?php echo !is_null($args['cheapest_price']) ? $args['cheapest_price']->date_departures[0]->format('Ymd') : null;?>"
     data-pm-du="<?php echo !is_null($args['cheapest_price']) ? $args['cheapest_price']->duration : ''; ?>"
     class="add-to-wishlist">
    <svg class="heart-stroke"><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#heart-straight"></use></svg>
    <svg class="heart-filled"><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#heart-straight-filled"></use></svg>

</div>