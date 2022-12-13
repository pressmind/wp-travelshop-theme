<?php
error_reporting(-1);
ini_set('display_errors', 'On');
include_once '../bootstrap.php';
// This CSV is from https://ourairports.com/data/
$zip_csv = APPLICATION_PATH.'/example-data/airports.csv.zip';
$zip = new ZipArchive;
if ($zip->open($zip_csv) === TRUE) {
    $r = $zip->extractTo(APPLICATION_PATH.'/example-data/');
    $zip->close();
} else {
    echo 'error: can not unzip:'.$zip_csv."\r\n";
    exit;
}
$csv = APPLICATION_PATH.'/example-data/airports.csv';
$row = 0;
$import = fopen($csv, 'r');
$columns = [];
$Airport = new \Pressmind\ORM\Object\Airport();
$Airport->truncate();
$c = 0;
while ($data = fgetcsv($import, 0, ',')) {
    $row++;
    if ($row == 1) {
        continue;
    }
    if(empty($data[13]) && !in_array($data[2], ['medium_airport', 'large_airport']) ){
        continue;
    }
    $Airport = new \Pressmind\ORM\Object\Airport();
    $Airport->id = $data[0];
    $Airport->name = trim(str_replace(['Airfield', 'Flugplatz', 'Airport', 'Flugfeld', 'Air Base', 'Air Field'], '', $data[3]));
    $Airport->name = str_replace('Munich', 'München',  $Airport->name);  // translation bug reported to ourairports
    $Airport->latitude = $data[4];
    $Airport->longitude = $data[5];
    $Airport->country = $data[8];
    $Airport->city = $data[10];
    $Airport->city = str_replace('Munich', 'München',  (string)$Airport->city);
    $Airport->iata = $data[13];
    $Airport->create();
    $c++;
}
@unlink($csv);
echo $c." airports successfully imported, thanks to ourairports.com\n";