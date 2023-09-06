<?php
/**
 * @var $args ['price_min']
 * @var $args ['price_max']
 */

// set the price range to the closest 100, 1000 and so on...
$args['price_min'] = str_pad(substr(round($args['price_min']), 0, 1), strlen(round($args['price_min'])), 0);
$args['price_max'] = str_pad(substr(round($args['price_max']), 0, 1) + 1, strlen(round($args['price_max'])) + strlen(substr(round($args['price_max']), 0, 1) + 1) - 1, 0);
if (isset($_GET['pm-pr']) === true && preg_match('/^([0-9]+)\-([0-9]+)$/', $_GET['pm-pr'], $m) > 0) {
    $from = $m[1];
    $to = $m[2];
} else {
    $from = $args['price_min'];
    $to = $args['price_max'];
}
?>
<div class="list-filter-box list-filter-box-price">
    <div class="list-filter-box-title">
        <strong>Preis</strong>

        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-down-bold"></use></svg>
    </div>
    <div class="list-filter-box-body" style="width: 90%; margin: 0 auto;">
        <?php
        // ion.rangeSlider is used here, see API Docu: @link http://ionden.com/a/plugins/ion.rangeSlider/api.html
        ?>
        <input id="js-range-slider" style="display:none;" type="text" class="js-range-slider" name="pm-pr" value=""
               data-type="double"
               data-min="<?php echo empty($args['price_min']) ? 0 : $args['price_min']; ?>"
               data-max="<?php echo empty($args['price_max']) ? 1000 : $args['price_max']; ?>"
               data-from="<?php echo $from; ?>"
               data-to="<?php echo $to; ?>"
               data-val-from="<?php echo !empty($_GET['pm-pr']) ? explode('-', $_GET['pm-pr'])[0] : $args['price_min']; ?>"
               data-val-to="<?php echo !empty($_GET['pm-pr']) ? explode('-', $_GET['pm-pr'])[1] : $args['price_max']; ?>"
               data-grid="false"
               data-prefix="€ "
               data-step="100"
               data-drag-interval="true"
               data-min-interval="100"
               data-hide-min-max="1"
               data-hide-min-min="1"
               data-input-values-separator="-"
               data-disable="<?php
               // disable the picker if there is no plausible step to pick
               echo ($args['price_min'] == $args['price_max'] || ($args['price_max'] - $args['price_min']) == 100) ? 'true' : 'false';
               ?>"
        />
    </div>
</div>