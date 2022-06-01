<?php
namespace Pressmind;

use Exception;
use Pressmind\MVC\Request;
use Pressmind\MVC\Response;
use Pressmind\REST\Controller\Ibe;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';


function find_wordpress_base_path()
{
    $dir = dirname(__FILE__);
    do {
        //it is possible to check for other files here
        if (file_exists($dir . "/wp-config.php")) {
            return $dir;
        }
    } while ($dir = realpath("$dir/.."));
    return null;
}

$wp_path = find_wordpress_base_path() . "/";

define('DONOTCACHE', true);
define('WP_USE_THEMES', false);

require_once($wp_path . 'wp-load.php');
require_once($wp_path . 'wp-admin/includes/admin.php');

global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;

$request = new Request();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if($request->isPost()) {
    $response = new Response();
    $response->setContentType('application/json');
    try {
        $action = $request->getParameter('action');
        $class = new Ibe($request->getParameter('data'));
        $response->setBody(['success' => true, 'data' => $class->$action()]);
    } catch (Exception $e) {
        $response->setCode(500);
        $response->setBody(['success' => false, 'msg' => $e->getMessage()]);
    }
    $response->send();
}

if($request->isGet()) {
    if($request->getParameter('type') == 'import') {
        $response = new Response();
        $response->setContentType('application/json');
        try {
            $importer = new Import('mediaobject');
            //$importer->importMediaObject($request->getParameter('id_media_object'));
            $importer->importMediaObjectsFromArray([$request->getParameter('id_media_object')]);


            $log = $importer->getLog();
            if(defined('PM_REDIS_ACTIVATE') && PM_REDIS_ACTIVATE){
                $ids = $importer->getImportedIds();
                $c = \RedisPageCache::del_by_id_media_object($ids);
                $log[] =  $c.' keys updated';
                $c = \RedisPageCache::prime_by_id_media_object($ids, false, true);
                $log[] = $c.' urls primed';
            }


            $importer->postImport();
            $media_object = new ORM\Object\MediaObject($request->getParameter('id_media_object'));
            $media_object->updateCache($request->getParameter('id_media_object'));
            $url = WEBSERVER_HTTP.$media_object->getPrettyUrl().'?preview=1&no_cache='.uniqid();
            if($request->getParameter('preview') == "1") {
                $config = Registry::getInstance()->get('config');
                $response->setContentType('text/html');
                $response->setBody('You will be redirected to Preview Page: ' . $url);
                $response->addHeader('Location', $url);
            } else {
                $response->setBody(['status' => 'Code 200: Import erfolgreich', 'url' => $url, 'msg' => implode("\n", $log)]);
            }
        } catch (Exception $e) {
            $response->setCode(500);
            $response->setBody(['status' => 'Code 500: Es ist ein Fehler aufgetreten', 'msg' => $e->getMessage()]);
        }
        $response->send();
    }
}
