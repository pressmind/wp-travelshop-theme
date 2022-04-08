<?php
use Pressmind\DB\Adapter\Pdo;
use Pressmind\Registry;
use Pressmind\Log\Writer;
use Pressmind\Storage\Bucket;

if (php_sapi_name() !== 'cli') {
    die("This file is meant to be run from command line");
}

/**
 * This script is intended to run as cron job every night
 */
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

$config = Registry::getInstance()->get('config');

Writer::write('storage cleanup started', WRITER::OUTPUT_BOTH, 'storage_cleanup', Writer::TYPE_INFO);

/** @var Pdo $db */
$db = Registry::getInstance()->get('db');
$c = 0;
$c_deleted = 0;
$Storage = new Bucket($config['image_handling']['storage']['bucket']);
$files = $Storage->listFiles(); // @TODO if storage provide is s3, this query get's only 1000 items per call, here is a pagination required...
foreach($files as $file){
    if(preg_match('/^[0-9]+_([0-9]+)[\_|\.]/', $file->name, $m) !== 0){
        $exist = $db->fetchAll('SELECT id_picture FROM pmt2core_media_object_images WHERE id_picture = '.$m[1]);
        if(empty($exist)){
            Writer::write("delete orphan: ".$file->name." >  id_picture: ".$m[1], WRITER::OUTPUT_SCREEN, 'storage_cleanup', Writer::TYPE_INFO);
            $Storage->removeFile($file);
            $c_deleted++;
        }
    }else if(preg_match('/^itinerary_([0-9]+)_[0-9]+[\_|\.]/', $file->name, $m) !== 0){
        $exist = $db->fetchAll('SELECT id FROM pmt2core_itinerary_steps WHERE id = '.$m[1]);
        if(empty($exist)){
            Writer::write("delete orphan: ".$file->name." >  id_step: ".$m[1], WRITER::OUTPUT_SCREEN, 'storage_cleanup', Writer::TYPE_INFO);
            $Storage->removeFile($file);
            $c_deleted++;
        }
    }
    $c++;
}

// TODO add attachements files cleanup

Writer::write("files found: ".$c, WRITER::OUTPUT_BOTH, 'storage_cleanup', Writer::TYPE_INFO);
Writer::write("orphans deleted: ".$c_deleted, WRITER::OUTPUT_BOTH, 'storage_cleanup', Writer::TYPE_INFO);
