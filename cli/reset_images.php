<?php
use Pressmind\DB\Adapter\Pdo;
use Pressmind\Registry;
use Pressmind\Log\Writer;
use Pressmind\Storage\Bucket;
use \Pressmind\Search\MongoDB\Indexer;

if (php_sapi_name() !== 'cli') {
    die("This file is meant to be run from command line");
}

/**
 * This script is intended to run as cron job every night
 */
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

$config = Registry::getInstance()->get('config');
if(readline("Type 'yes' and this script will delete all files in this folders '".$config['image_handling']['storage']['bucket']."' and '".$config['file_handling']['storage']['bucket']."': ") != 'yes'){
    echo "aborted by user\n";
    exit;
}

Writer::write('starting delete', WRITER::OUTPUT_BOTH, 'image_reset', Writer::TYPE_INFO);

$ImageStorage = new Bucket($config['image_handling']['storage']['bucket']);
if($ImageStorage->removeAll()){
    echo "images deleted\n";
}

$FileStorage = new Bucket($config['file_handling']['storage']['bucket']);
if($FileStorage->removeAll()){
    echo "files deleted\n";
}

echo "reset database entries\n";
try{
    /**
     * @var \Pdo $db
     */
    $db->execute("update pmt2core_media_object_images set download_successful = 0;");
    $db->execute("update pmt2core_media_object_image_sections set download_successful = 0;");
    $db->execute("update pmt2core_media_object_image_derivatives set download_successful = 0;");
}catch (\Exception $e){
    echo $e->getMessage();
}

echo "rebuild mongo index\n";
$Indexer = new Indexer();
$Indexer->createIndexes();
echo "ok\n";