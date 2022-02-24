<?php
use Pressmind\HelperFunctions;
/**
 * <code>
 * $args['date_departure']
 * $args['date_arrival']
 * $args['date_from_format']
 * $args['date_to_format']
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