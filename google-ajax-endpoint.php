<?php
ini_set('display_errors', -1);
ini_set('display_startup_errors', -1);
error_reporting(-1);
require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->safeLoad();
require_once getenv('CONFIG_THEME');

if ($_GET['action'] == 'place/autocomplete') {
    $cURLConnection = curl_init('https://maps.googleapis.com/maps/api/place/autocomplete/json?key=' . TS_GOOGLEMAPS_API . '&input=' . urlencode($_GET['term']) . '&components=' . implode('|', preg_filter('/^/','country:',explode(',', $_GET['countries']))) . '&language=de');
    curl_setopt($cURLConnection,CURLOPT_RETURNTRANSFER,1);
    $apiResponse = curl_exec($cURLConnection);
    echo json_encode($apiResponse);
    curl_close($cURLConnection);
} else if($_GET['action'] == 'directions') {
    $cURLConnection = curl_init('https://maps.googleapis.com/maps/api/directions/json?key=' . TS_GOOGLEMAPS_API . '&origin=place_id:' . urlencode($_GET['origin']) . '&destination=place_id:' . urlencode($_GET['destination']) . '&language=de');
    curl_setopt($cURLConnection,CURLOPT_RETURNTRANSFER,1);
    $apiResponse = curl_exec($cURLConnection);
    echo json_encode($apiResponse);
    curl_close($cURLConnection);
}