<?php
error_reporting(-1);
ini_set('display_errors', 'On');
include_once '../bootstrap.php';
// This CSV is from https://raw.githubusercontent.com/jpatokal/openflights/master/data/airlines.dat
$zip_csv = APPLICATION_PATH.'/example-data/airline.csv.zip';
$zip = new ZipArchive;
if ($zip->open($zip_csv) === TRUE) {
    $r = $zip->extractTo(APPLICATION_PATH.'/example-data/');
    $zip->close();
} else {
    echo 'error: can not unzip:'.$zip_csv."\r\n";
    exit;
}
$csv = APPLICATION_PATH.'/example-data/airline.csv';
$row = 0;
$import = fopen($csv, 'r');
$columns = [];
$Airline = new \Pressmind\ORM\Object\Airline();
$Airline->truncate();
$c = 0;
while ($data = fgetcsv($import, 0, ',')) {
    $row++;
    if ($row == 1) {
        continue;
    }
    if(!empty($data[3]) && $data[3] != '\N' && $data[7] == 'Y') {
        $Airline = new \Pressmind\ORM\Object\Airline();
        $Airline->id = $data[0];
        $Airline->name = $data[1];
        $Airline->alias = $data[2] == '\N' ? null : $data[2];
        $Airline->iata = $data[3] == '\N' ? null : $data[3];
        $Airline->icao = $data[4] == '\N' ? null : $data[4];
        $Airline->callsign = $data[5];
        $Airline->country = $data[6];
        $Airline->active = $data[7] == 'Y';
        $Airline->create();
        $c++;
    }
}
@unlink($csv);
echo $c." airlines successfully imported, thanks to openflights.org\n";