<?php
namespace Pressmind;

error_reporting(-1);
ini_set('display_errors', 'On');

use Exception;
use Pressmind\Log\Writer;
use Pressmind\ORM\Object\MediaObject;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

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

define('WP_USE_THEMES', false);

require_once($wp_path . 'wp-load.php');
require_once($wp_path . 'wp-admin/includes/admin.php');

global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;

$args = $argv;
$args[1] = isset($argv[1]) ? $argv[1] : null;

if(in_array('debug', $args)){
    define('PM_SDK_DEBUG', true);
}

switch ($args[1]) {
    case 'fullimport':
        $importer = new Import('fullimport');
        Writer::write('Importing all media objects', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
        try {
            $importer->import();
            if($importer->hasErrors()) {
                echo ("WARNING: Import threw errors:\n" . implode("\n", $importer->getErrors())) . "\nSEE " . Writer::getLogFilePath() . DIRECTORY_SEPARATOR . "import_error.log for details\n";
            }
            Writer::write('Import done.', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
        } catch(Exception $e) {
            Writer::write($e->getMessage(), Writer::OUTPUT_BOTH, 'import', Writer::TYPE_ERROR);
            echo "WARNING: Import threw errors:\n" . $e->getMessage() . "\nSEE " . Writer::getLogFilePath() . DIRECTORY_SEPARATOR . "import_error.log for details\n";
        } finally {
            $importer->postImport();

            /**
             * @TODO it's better to have a callback for each imported media object, but the sdk has no hooks at this time
             */
            if(defined('PM_REDIS_ACTIVATE') && PM_REDIS_ACTIVATE){
                $ids = $importer->getImportedIds();
                Writer::write('Page Cache update', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
                $c = \RedisPageCache::del_by_id_media_object($ids);
                Writer::write($c.' keys updated', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
                $c = \RedisPageCache::prime_by_id_media_object($ids);
                Writer::write($c.' urls primed', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
            }

            echo implode(', ', $importer->getImportedIds());
        }
        break;
    case 'mediaobject':
        if(!empty($args[2])) {
            $importer = new Import('mediaobject');
            Writer::write('Importing mediaobject ID(s): ' . $args[2], Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
            $ids = array_map('trim', explode(',', $args[2]));
            try {
                $importer->importMediaObjectsFromArray($ids);
                Writer::write('Import done.', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
                $importer->postImport();
                if($importer->hasErrors()) {
                    echo ("WARNING: Import threw errors:\n" . implode("\n", $importer->getErrors())) . "\nSEE " . Writer::getLogFilePath() . DIRECTORY_SEPARATOR . "import_errors.log for details\n";
                }
            } catch(Exception $e) {
                Writer::write($e->getMessage(), Writer::OUTPUT_BOTH, 'import', Writer::TYPE_ERROR);
                echo "WARNING: Import threw errors:\n" . $e->getMessage() . "\nSEE " . Writer::getLogFilePath() . DIRECTORY_SEPARATOR . "import_error.log for details\n";
            }
            if(defined('PM_REDIS_ACTIVATE') && PM_REDIS_ACTIVATE){
                $ids = $importer->getImportedIds();
                Writer::write('Page Cache update', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
                $c = \RedisPageCache::del_by_id_media_object($ids);
                Writer::write($c.' keys updated', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
                $c = \RedisPageCache::prime_by_id_media_object($ids, false, false);
                Writer::write($c.' urls primed', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
            }
        } else {
            echo "Missing mediaobject id(s)";
        }
        break;
    case 'mediaobject_cache_update':
        if(!empty($args[2])) {
            Writer::write('Importing mediaobject ID(s): ' . $args[2], Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
            $ids = array_map('trim', explode(',', $args[2]));
            if(defined('PM_REDIS_ACTIVATE') && PM_REDIS_ACTIVATE){
                Writer::write('Page Cache update', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
                $c = \RedisPageCache::del_by_id_media_object($ids);
                Writer::write($c.' keys updated', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
                $c = \RedisPageCache::prime_by_id_media_object($ids, false, false);
                Writer::write($c.' urls primed', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
            }
        } else {
            echo "Missing mediaobject id(s)";
        }
        break;
    case 'itinerary':
        if(!empty($args[2])) {
            $importer = new Import('itinerary');
            Writer::write('Importing itinerary for Media Object ID(s): ' . $args[2], Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
            $ids = array_map('trim', explode(',', $args[2]));
            try {
                foreach ($ids as $id) {
                    $importer->importItinerary($id);
                }
            } catch (Exception $e) {
                Writer::write($e->getMessage(), Writer::OUTPUT_BOTH, 'import', Writer::TYPE_ERROR);
                echo "WARNING: Import threw errors:\n" . $e->getMessage() . "\nSEE " . Writer::getLogFilePath() . DIRECTORY_SEPARATOR . "import_error.log for details\n";
            }
        } else {
            echo "Missing mediaobject id(s)";
        }
        break;
    case 'objecttypes':
        if(!empty($args[2])) {
            $importer = new Import('objecttypes');
            Writer::write('Importing objecttypes ID(s): ' . $args[2], Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
            $ids = array_map('trim', explode(',', $args[2]));
            try {
                $importer->importMediaObjectTypes($ids);
                Writer::write('Import done.', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
                if($importer->hasErrors()) {
                    echo ("WARNING: Import threw errors:\n" . implode("\n", $importer->getErrors())) . "\nSEE " . Writer::getLogFilePath() . DIRECTORY_SEPARATOR . "import_error.log for details\n";
                }
            } catch(Exception $e) {
                Writer::write($e->getMessage(), Writer::OUTPUT_BOTH, 'import', Writer::TYPE_ERROR);
                echo "WARNING: Import threw errors:\n" . $e->getMessage() . "\nSEE " . Writer::getLogFilePath() . DIRECTORY_SEPARATOR . "import_error.log for details\n";
            }
        } else {
            echo "Missing objecttype id(s)";
        }
        break;
    case 'depublish':
        if(!empty($args[2])) {
            Writer::write('Depublishing mediaobject ID(s): ' . $args[2], Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
            $ids = array_map('trim', explode(',', $args[2]));
            foreach ($ids as $id) {
                try {
                    $media_object = new MediaObject($id);
                    $media_object->visibility = 10;
                    $media_object->update();
                    $media_object->createMongoDBIndex();
                    Writer::write('Mediaobject ' . $id . ' successfully depublished (visibility set to 10/nobody)', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
                } catch (Exception $e) {
                    Writer::write($e->getMessage(), Writer::OUTPUT_BOTH, 'import', Writer::TYPE_ERROR);
                    echo "WARNING: Depublish for id " . $id . "  failed:\n" . $e->getMessage() . "\nSEE " . Writer::getLogFilePath() . DIRECTORY_SEPARATOR . "import_error.log for details\n";
                }
            }
        }
        break;
    case 'destroy':
        if(!empty($args[2])) {
            Writer::write('Destroying mediaobject ID(s): ' . $args[2], Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
            $ids = array_map('trim', explode(',', $args[2]));
            foreach ($ids as $id) {
                try {
                    $media_object = new MediaObject($id);
                    $media_object->delete(true);
                    Writer::write('Mediaobject ' . $id . ' successfully destroyed', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
                } catch (Exception $e) {
                    Writer::write($e->getMessage(), Writer::OUTPUT_BOTH, 'import', Writer::TYPE_ERROR);
                    echo "WARNING: Destruction for mediaobject " . $id . "  failed:\n" . $e->getMessage() . "\nSEE " . Writer::getLogFilePath() . DIRECTORY_SEPARATOR . "import_error.log for details\n";
                }
            }
        }
        break;
    case 'remove_orphans':
        $importer = new Import('remove_orphans');
        Writer::write('Removing orphans from database', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
        try {
            $importer->removeOrphans();
        } catch(Exception $e) {
            Writer::write($e->getMessage(), Writer::OUTPUT_BOTH, 'import', Writer::TYPE_ERROR);
            echo "WARNING: Import threw errors:\n" . $e->getMessage() . "\nSEE " . Writer::getLogFilePath() . DIRECTORY_SEPARATOR . "import_error.log for details\n";
        }
        break;
    case 'help':
    case '--help':
    case '-h':
    default:
        $helptext = "usage: import.php [fullimport | mediaobject | itinerary | objecttypes | remove_orphans | destroy | depublish] [<single id or commaseparated list of ids>] [debug]\n";
        $helptext .= "Example usages:\n";
        $helptext .= "php import.php fullimport\n";
        $helptext .= "php import.php mediaobject 12345,12346  <single/multiple ids allowed  / imports one or more media objects>\n";
        $helptext .= "php import.php objecttypes 12345,12346  <single/multiple ids allowed / imports media objects by given object types>\n";
        $helptext .= "php import.php itinerary 12345,12346    <single/multiple ids allowed / imports itineraries for the given media object types>\n";
        $helptext .= "php import.php destroy 12345,12346      <single/multiple ids allowed / removes the given media objects from the database>\n";
        $helptext .= "php import.php depublish 12345,12346    <single/multiple ids allowed / sets the given media objects to the visibility=10/nobody state>\n";
        $helptext .= "php import.php remove_orphans           <removes all orphans from the database that are not delivered by the pressmind api>\n";

        echo $helptext;
}

