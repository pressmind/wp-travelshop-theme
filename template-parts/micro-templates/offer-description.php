<?php

use Pressmind\Travelshop\Template;

/**
 * <code>
 * $args['cheapest_price'] CheapestPriceSpeed
 * $args['url']
 * </code>
 * @var array $args
 */

if ($args['cheapest_price']->duration == 1) {
    //echo $args['cheapest_price']->option_name;
    //return;
}

$offer_description = [];
$offer_description[] = $args['cheapest_price']->housing_package_name;
$offer_description[] = $args['cheapest_price']->option_name;
$offer_description = implode(', ', array_filter($offer_description));
if (!empty($offer_description)) {
    echo $offer_description . '<br><small>';
}
$lines = [];
if (!empty($args['cheapest_price']->option_occupancy)) {
    $lines[] = 'Belegung: ' . $args['cheapest_price']->option_occupancy . ' Person'. (($args['cheapest_price']->option_occupancy > 1) ? 'en' : '');
}
if(!empty($args['cheapest_price']->option_board_type)){
    $lines[] = 'inkl. ' . $args['cheapest_price']->option_board_type;
}

$lines[] = Template::render(APPLICATION_PATH . '/template-parts/micro-templates/transport_type_human_string.php', [
    'transport_type' => $args['cheapest_price']->transport_type,
]);

if (!empty($args['cheapest_price']->transport_type) && strpos($args['cheapest_price']->transport_type, 'FLU') === 0) {
    if (trim($args['cheapest_price']->transport_1_description) == ($args['cheapest_price']->transport_2_description)) {
        $lines[] = 'Flug ab ' . $args['cheapest_price']->transport_1_description;
    } else {
        $lines[] = 'Flug hin :  ' . $args['cheapest_price']->transport_1_description;
        $lines[] = 'Flug zurück:  ' . $args['cheapest_price']->transport_2_description;
    }
}
if (!empty($args['cheapest_price']->included_options_price)) {
    $lines[] =  'inkl. ' . implode(', ', explode(',', $args['cheapest_price']->included_options_description));
    //echo ' im Wert von&nbsp;'.\Pressmind\Travelshop\PriceHandler::format($args['cheapest_price']->included_options_price);
}
if (!empty($args['cheapest_price']->diff_to_single_room)) {
    $prefix = $args['cheapest_price']->diff_to_single_room > 0 ? 'zzgl.' : 'abzgl.';
    $lines[] =  'Einzelzimmer ' . $prefix . ' ' . \Pressmind\Travelshop\PriceHandler::format($args['cheapest_price']->diff_to_single_room);
}
echo implode('<br>', $lines);

if (!empty($offer_description)) {
    echo '</small>';
}

