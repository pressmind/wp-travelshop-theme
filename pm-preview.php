<?php
/**
 * This file is called from the pressmind® PIM Application
 */

require_once 'config-theme.php';
require_once 'bootstrap.php';

$id_media_object = (int)$_GET['id_media_object'];
if(empty($id_media_object) === true){
    header('Bad Request', 400);
    echo 'Parameter "id_media_object" is not defined';
    exit;
}

$mediaObject = new Pressmind\ORM\Object\MediaObject($id_media_object);
$mediaObject->updateCache($id_media_object);

// @TODO check if the parameter no_cache or update_cache is the better one in context to the web-core caching strategy
$url = SITE_URL.$mediaObject->getPrettyUrl().'?no_cache='.time().'&preview=1';
header('Location: '.$url,TRUE,302);
exit();