<?php
use Pressmind\HelperFunctions;
use Pressmind\Travelshop\PriceHandler;
use Pressmind\Travelshop\Template;

/**
 * <code>
 * $args['date_departure']
 * $args['date_arrival']
 * $args['date_from_format']
 * $args['date_to_format']
 * $args['duration']
 * $args['price_total']
 * $args['price_regular_before_discount']
 * </code>
 * @var array $args
 */

$today = new DateTime();
$automatic = false;
if(empty($args['date_from_format'])){
    $automatic = true;
    $args['date_from_format'] =  $args['date_departure']->format('Y') == $today->format('Y') ? 'd.m.' : 'd.m.y';
}
if(empty($args['date_to_format'])){
    $automatic = true;
    $args['date_to_format'] = $args['date_departure']->format('Y') == $today->format('Y') ? 'd.m.' : 'd.m.y';
}

if($automatic === true && $args['date_from_format'] && $args['date_to_format']){
    $args['date_from_format'] = 'd.m.';
}


echo HelperFunctions::dayNumberToLocalDayName($args['date_departure']->format('N'), 'short').'. ';
echo $args['date_departure']->format($args['date_from_format']);

if(!empty($args['date_arrival']) && $args['date_departure']->format('d.m.y') != $args['date_arrival']->format('d.m.y')){
    echo ' - ';
    echo HelperFunctions::dayNumberToLocalDayName($args['date_arrival']->format('N'), 'short').'. ';
    echo $args['date_arrival']->format($args['date_to_format']);
}

if(!empty($args['duration'])){
    echo ' '.Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration.php', [
            'duration' => $args['duration']
        ]
    );
}

if(!empty($args['price_total'])){
    echo ' ab '.PriceHandler::format($args['price_total']);
}