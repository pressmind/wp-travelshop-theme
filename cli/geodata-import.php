<?php
error_reporting(-1);
ini_set('display_errors', 'On');
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
$zip_csv = APPLICATION_PATH.'/example-data/5005_geodatendeutschland_1001_20220711.csv.zip';
$zip = new ZipArchive;
if ($zip->open($zip_csv) === TRUE) {
    $zip->extractTo(APPLICATION_PATH.'/example-data/');
    $zip->close();
} else {
    echo 'error: can not unzip:'.$zip_csv."\r\n";
    exit;
}
$csv = APPLICATION_PATH.'/example-data/5005_geodatendeutschland_1001_20220711.csv';
$row = 0;
$import = fopen($csv, 'r');
$columns = [];
$GeoData = new Pressmind\ORM\Object\Geodata();
$GeoData->truncate();
while ($data = fgetcsv($import)) {
    $row++;
    $line = [];
    //skip header row
    if ($row == 1) {
        foreach($data as &$v){
            $v = strtolower($v);
        }
        $columns = array_values($data);
        continue;
    }
    foreach($data as $k => $i){
        $line[$columns[$k]] = $i;
    }
    $geoData = new Pressmind\ORM\Object\Geodata();
    $geoData->id = $line['id'];
    $geoData->bundesland_name = $line['bundesland_name'];
    $geoData->bundesland_nutscode = $line['bundesland_nutscode'];
    $geoData->regierungsbezirk_name = $line['regierungsbezirk_name'];
    $geoData->regierungsbezirk_nutscode = $line['regierungsbezirk_nutscode'];
    $geoData->kreis_typ = $line['kreis_typ'];
    $geoData->kreis_nutscode = $line['kreis_nutscode'];
    $geoData->gemeinde_name = $line['gemeinde_name'];
    $geoData->gemeinde_typ = $line['gemeinde_typ'];
    $geoData->gemeinde_ags = $line['gemeinde_ags'];
    $geoData->gemeinde_rs = $line['gemeinde_rs'];
    $geoData->gemeinde_lat = $line['gemeinde_lat'];
    $geoData->gemeinde_lon = $line['gemeinde_lon'];
    $geoData->ort_id = $line['ort_id'];
    $geoData->ort_name = $line['ort_name'];
    $geoData->ort_lat = $line['ort_lat'];
    $geoData->ort_lon = $line['ort_lon'];
    $geoData->postleitzahl = $line['postleitzahl'];
    $geoData->strasse_name = isset($line['strasse_name']) ? $line['strasse_name'] : null;
    $geoData->kreis_name = $line['kreis_name'];
    $geoData->create();
}
unlink($csv);
