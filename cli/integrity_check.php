<?php
namespace Pressmind;

use Exception;
use Pressmind\ORM\Object\AbstractObject;
use Pressmind\REST\Client;
use Pressmind\System\Info;

$args = $argv;
$args[1] = isset($argv[1]) ? $argv[1] : null;
if($matches = preg_grep("/^\-c\=/", $args)){
    $config_file = trim(substr(reset($matches), 3));
    if(!file_exists('../'.$config_file)){
        echo "error: file does not exist".'../'.$config_file."\n";
        exit;
    }
    putenv('PM_CONFIG='.$config_file);
    echo "pm-config loaded: ".getenv('PM_CONFIG')."\n";
}

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


echo 'Checking static models for integrity'. "\n";
foreach (Info::STATIC_MODELS as $model_name) {
    $model_name = '\Pressmind\ORM\Object' . $model_name;
    /** @var AbstractObject $object */
    $object = new $model_name();
    $check = $object->checkStorageIntegrity();
    if(is_array($check)) {
        echo "!!!!!!!!!!!\n" . 'Integrity violation for database table ' . $object->getDbTableName() . "\n";
        foreach ($check as $difference) {
            echo "\n" . $difference['msg'] . "\n";
        }
        echo "\n";
        $line = readline("Apply changes? [y for yes, any for no]: ");
        if (strtolower($line) == 'y') {
            echo $line . "\n";
            foreach ($check as $difference) {
                switch($difference['action']) {
                    case 'create_table':
                        $Scaffolder = new DB\Scaffolder\Mysql(new $model_name());
                        $Scaffolder->run(true);
                        break;
                    case 'alter_column_null':
                        modifyDatabaseTableNull($object->getDbTableName(), $difference['column_name'], $difference['column_type'], $difference['column_null']);
                        break;
                    case 'alter_column_type':
                        modifyDatabaseTableColumn($object->getDbTableName(), $difference['column_name'], $difference['column_type'], $difference['column_null']);
                        break;
                    case 'create_column':
                        addDatabaseTableColumn($object->getDbTableName(), $difference['column_name'], $difference['column_type'], $difference['column_null']);
                        break;
                }
            }
            foreach ($check as $difference) {
                switch($difference['action']) {
                    case 'remove_auto_increment':
                        removeAutoIncrement($object->getDbTableName(), $difference['column_name'], $difference['column_type'], $difference['column_null']);
                        break;
                    case 'set_auto_increment':
                        addAutoIncrement($object->getDbTableName(), $difference['column_name'], $difference['column_type'], $difference['column_null']);
                        break;
                    case 'add_index':
                        addIndex($object->getDbTableName(), $difference['column_names'], $difference['index_name']);
                        break;
                    case 'alter_primary_key':
                        alterPrimaryKey($object->getDbTableName(), $difference['column_names'], $difference['old_column_names']);
                        break;
                }
            }
            foreach ($check as $difference) {
                switch($difference['action']) {
                    case 'drop_column':
                        dropColumn($object->getDbTableName(), $difference['column_name']);
                        break;
                }
            }
        }
    } else {
        echo $model_name . ' is up to date.' . "\n";
    }
}

$config = Registry::getInstance()->get('config');
$rest_client = new Client();
$media_type_ids = [];
foreach ($config['data']['media_types'] as $media_type_id => $media_type_name) {
    $media_type_ids[] = $media_type_id;
}
try {
    echo 'Checking custom media objects for integrity'. "\n";
    $media_type_definition_response = $rest_client->sendRequest('ObjectType', 'getById', ['ids' => implode(',', $media_type_ids)]);
    foreach($media_type_definition_response->result as $media_type_definition) {
        echo 'checking table ' . 'objectdata_' . $media_type_definition->id . "\n";
        $integrityCheck = new ObjectIntegrityCheck($media_type_definition, 'objectdata_' . $media_type_definition->id);
        $differences = $integrityCheck->getDifferences();
        if(count($differences) > 0) {
            echo "!!!!!!!!!!!\n" . 'Integrity violation for database table ' . 'objectdata_' . $media_type_definition->id . "\n";
            foreach ($differences as $difference) {
                echo "\n" . $difference['msg'] . "\n";
            }
            $line = readline("Apply changes? [y for yes, any for no]: ");
            if (strtolower($line) == 'y') {
                echo $line . "\n";
                foreach ($differences as $difference) {
                    switch($difference['action']) {
                        case 'alter_column_type':
                            modifyDatabaseTableColumn('objectdata_' . $media_type_definition->id, $difference['column_name'], $difference['column_type']);
                            break;
                        case 'create_column':
                            addDatabaseTableColumn('objectdata_' . $media_type_definition->id, $difference['column_name'], $difference['column_type']);
                            break;
                        case 'drop_column':
                            dropColumn('objectdata_' . $media_type_definition->id, $difference['column_name']);
                            break;
                    }
                }
                $line2 = readline("Apply Changes to PHP file? [y for yes, any for no]: ");
                if (strtolower($line2) == 'y') {
                    $scaffolder = new ObjectTypeScaffolder($media_type_definition, $media_type_definition->id);
                    $scaffolder->parse();
                }
            }
        } else {
            echo 'Table ' . 'objectdata_' . $media_type_definition->id . " is up to date.\n";
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

function walkArray($default_settings, &$current_settings) {
    $has_changes = false;
    foreach ($default_settings as $default_setting_key => $default_setting) {
        if(!key_exists($default_setting_key, $current_settings)) {
            echo 'New option "' . $default_setting_key . '" found. Added to current configuration file' . "\n";
            $current_settings[$default_setting_key] = $default_settings[$default_setting_key];
            $has_changes = true;
        }
        if(is_array($default_setting) && isArrayAssociative($default_setting)) {
            walkArray($default_settings[$default_setting_key], $current_settings[$default_setting_key]);
        }
    }
    return ['has_changes' => $has_changes, 'settings' => $current_settings];
}

function isArrayAssociative($array) {
    foreach ($array as $key => $value) {
        if(is_string($key)) {
            return true;
        }
    }
    return false;
}

function modifyDatabaseTableColumn($tableName, $columnName, $type, $is_null = 'NULL') {
    $sql = 'ALTER TABLE ' . $tableName . ' MODIFY `' . $columnName . '` ' . $type . ' ' . $is_null;
    $db = Registry::getInstance()->get('db');
    echo $sql . "\n";
    $db->execute($sql);
}

function addDatabaseTableColumn($tableName, $columnName, $type, $is_null = 'NULL') {
    $sql = 'ALTER TABLE ' . $tableName . ' ADD `' . $columnName . '`  ' . $type . ' ' . $is_null;
    $db = Registry::getInstance()->get('db');
    echo $sql . "\n";
    $db->execute($sql);
}

function modifyDatabaseTableNull($tableName, $columnName, $type, $is_null) {
    $sql = 'ALTER TABLE ' . $tableName . ' MODIFY `' . $columnName . '` ' . $type . ' ' . $is_null;
    $db = Registry::getInstance()->get('db');
    echo $sql . "\n";
    $db->execute($sql);
}

function addAutoIncrement($tableName, $columnName, $type, $is_null) {
    $sql = 'ALTER TABLE ' . $tableName . ' MODIFY `' . $columnName . '` ' . $type . ' ' . $is_null . ' auto_increment';
    $db = Registry::getInstance()->get('db');
    echo $sql . "\n";
    $db->execute($sql);
}

function removeAutoIncrement($tableName, $columnName, $type, $is_null) {
    $sql = 'ALTER TABLE ' . $tableName . ' MODIFY `' . $columnName . '` ' . $type . ' ' . $is_null;
    $db = Registry::getInstance()->get('db');
    echo $sql . "\n";
    $db->execute($sql);
}

function dropColumn($tableName, $columnName) {
    $sql = 'ALTER TABLE ' . $tableName . ' DROP `' . $columnName . '`';
    $db = Registry::getInstance()->get('db');
    echo $sql . "\n";
    $db->execute($sql);
}

function addIndex($tableName, $columnNames, $indexName) {
    $sql = "CREATE INDEX " . $indexName . " ON " . $tableName . " (`" . implode('`,' , $columnNames) . "`)";
    $db = Registry::getInstance()->get('db');
    echo $sql . "\n";
    $db->execute($sql);
}

function alterPrimaryKey($tableName, $newPrimaryKey, $oldPrimaryKey) {
    $sql = "ALTER TABLE " . $tableName . " MODIFY " . $oldPrimaryKey . " varchar(255) NOT NULL";
    $db = Registry::getInstance()->get('db');
    echo $sql . "\n";
    $db->execute($sql);

    $sql = "ALTER TABLE " . $tableName . " DROP PRIMARY KEY";
    $db = Registry::getInstance()->get('db');
    echo $sql . "\n";
    $db->execute($sql);

    $sql = "ALTER TABLE " . $tableName . " ADD PRIMARY KEY (" . $newPrimaryKey . ")";
    $db = Registry::getInstance()->get('db');
    echo $sql . "\n";
    $db->execute($sql);
}