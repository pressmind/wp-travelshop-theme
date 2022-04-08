<?php
namespace Pressmind;
use Exception;
use Pressmind\Log\Writer;
use Pressmind\ORM\Object\Scheduler\Task;
use Pressmind\REST\Client;
use Pressmind\System\Info;

require_once '../vendor/autoload.php';
if(!file_exists('../.env')){
    copy('../.env.default', '../.env');
}

if(!file_exists('../.env')){
    echo "error: ../.env does not exists\n";
   exit();
}

$dotenv = \Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__));
$dotenv->safeLoad();

$pm_config_file = dirname(__DIR__) . DIRECTORY_SEPARATOR . getenv('PM_CONFIG');

error_reporting(-1);
ini_set('display_errors', 'On');
//@unlink($pm_config_file);

if (php_sapi_name() !== 'cli') {
    die("This file is meant to be run from command line");
}

$first_install = !file_exists($pm_config_file);

if($first_install) {
    echo "Welcome to the initial installation of your new pressmind web-core project.\n";

    $sdk_directory = dirname(__DIR__)
        . DIRECTORY_SEPARATOR
        . 'vendor'
        . DIRECTORY_SEPARATOR
        . 'pressmind'
        . DIRECTORY_SEPARATOR
        . 'sdk';
    if(!is_dir($sdk_directory)) {
        echo "ERROR!\n";
        echo "pressmind sdk seems not to be installed. Please run 'composer install' in " . dirname(__DIR__) . " to install all required dependencies before running this script\n";
        die();
    }

    echo "Welcome to the initial installation of your new pressmind web-core project.\n";
    echo "Please enter some initial configuration data.\n";

    $default_config_file = $sdk_directory . DIRECTORY_SEPARATOR . 'config.default.json';
    $config = json_decode(file_get_contents($default_config_file), true);

    // add command line support
    $options = getopt('', [
        'db_host::',
        'db_port::',
        'db_name::',
        'db_user::',
        'db_password::',
        'mongodb_uri::',
        'mongodb_db::',
        'pressmind_api_key::',
        'pressmind_api_user::',
        'pressmind_api_password::',
        'webserver_http::'
    ]);

    // if no values are set by parameter, we ask...
    $webserver_http = !empty($options['webserver_http']) ? $options['webserver_http'] : readline("Enter Webserver HTTP e.g. 'https://domain.de' [http://127.0.0.1]: ");
    $db_host =  !empty($options['db_host']) ? $options['db_host'] : readline("Enter MySQL Database Host [127.0.0.1]: ");
    $db_port = !empty($options['db_port']) ? $options['db_port'] : readline("Enter MySQL Database Port [3306]: ");
    $db_name = !empty($options['db_name']) ? $options['db_name'] : readline("Enter MySQL Database Name: ");
    $db_user = !empty($options['db_user']) ? $options['db_user'] : readline("Enter MySQL Database Username: ");
    $db_password = !empty($options['db_password']) ? $options['db_password'] : readline("Enter MySQL Database Password: ");
    $mongodb_uri = !empty($options['mongodb_uri']) ? $options['mongodb_uri'] : readline("Enter MongoDB Connection String e.g 'mongodb+srv://...': ");
    $mongodb_db = !empty($options['mongodb_db']) ? $options['mongodb_db'] : readline("Enter MongoDB Database Name: ");
    $pressmind_api_key = !empty($options['pressmind_api_key']) ? $options['pressmind_api_key'] : readline("Enter Pressmind API Key: ");
    $pressmind_api_user = !empty($options['pressmind_api_user']) ? $options['pressmind_api_user'] : readline("Enter Pressmind API User: ");
    $pressmind_api_password = !empty($options['pressmind_api_password']) ? $options['pressmind_api_password'] : readline("Enter Pressmind API Password: ");


    if(empty($db_host)) $db_host = '127.0.0.1';
    if(empty($db_port)) $db_port = '3306';
    if(empty($webserver_http)) $webserver_http = '';

    $config['development']['database']['username'] = $db_user;
    $config['development']['database']['password'] = $db_password;
    $config['development']['database']['host'] = $db_host;
    $config['development']['database']['port']= $db_port;
    $config['development']['database']['dbname'] = $db_name;
    $config['development']['database']['engine'] = 'MySQL';

    $config['development']['rest']['client']['api_key'] = $pressmind_api_key;
    $config['development']['rest']['client']['api_user'] = $pressmind_api_user;
    $config['development']['rest']['client']['api_password'] = $pressmind_api_password;

    $config['development']['data']['search_mongodb']['database']['uri'] = $mongodb_uri;
    $config['development']['data']['search_mongodb']['database']['db'] = $mongodb_db;
    $config['development']['data']['search_mongodb']['enabled'] = true;

    $config['development']['server']['webserver_http'] = $webserver_http;
    $config['development']['server']['php_cli_binary'] = PHP_BINARY;

    //Setting some default values in config
    $config['development']['server']['document_root'] = 'BASE_PATH';
    $config['development']['docs_dir'] = 'APPLICATION_PATH/docs';

    // Setup REST server
    $config['development']['rest']['server']['api_endpoint'] = '/wp-content/themes/travelshop/rest';

    // Setup the Preview URL
    $config['development']['data']['preview_url'] = "/examples/detail.php?id={{id_media_object}}&preview={{preview}}";

    // Setup some Pathes, all relative to to pressmind lib
    $config['development']['view_scripts']['base_path'] = "APPLICATION_PATH/template-parts/pm-views";
    $config['development']['file_handling']['storage']['bucket'] = "WEBSERVER_DOCUMENT_ROOT/wp-content/uploads/pressmind/downloads";
    $config['development']['file_handling']['http_src'] = "WEBSERVER_HTTP/wp-content/uploads/pressmind/downloads";

    // Setup Scaffolder Templates
    $config['development']['scaffolder_templates']['overwrite_existing_templates'] = false;
    $config['development']['scaffolder_templates']['base_path'] = "APPLICATION_PATH/template-parts/pm-views/scaffolder";

    // Image Processor
    $config['development']['image_handling']['storage']['bucket'] = "WEBSERVER_DOCUMENT_ROOT/wp-content/uploads/pressmind/images";
    $config['development']['image_handling']['http_src'] = "WEBSERVER_HTTP/wp-content/uploads/pressmind/images";

    // Enable WebPicture Support
    $config['development']['image_handling']['processor']['webp_support'] = true;

    // Setup Image Derivatives

    $config['development']['image_handling']['processor']['derivatives']['thumbnail'] = [];
    $config['development']['image_handling']['processor']['derivatives']['thumbnail']['max_width'] = 125;
    $config['development']['image_handling']['processor']['derivatives']['thumbnail']['max_height'] = 78;
    $config['development']['image_handling']['processor']['derivatives']['thumbnail']['preserve_aspect_ratio'] = true;
    $config['development']['image_handling']['processor']['derivatives']['thumbnail']['crop'] = true;
    $config['development']['image_handling']['processor']['derivatives']['thumbnail']['horizontal_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['thumbnail']['vertical_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['thumbnail']['webp_create'] = true;
    $config['development']['image_handling']['processor']['derivatives']['thumbnail']['webp_quality'] = 80;

    $config['development']['image_handling']['processor']['derivatives']['teaser'] = [];
    $config['development']['image_handling']['processor']['derivatives']['teaser']['max_width'] = 250;
    $config['development']['image_handling']['processor']['derivatives']['teaser']['max_height'] = 156;
    $config['development']['image_handling']['processor']['derivatives']['teaser']['preserve_aspect_ratio'] = true;
    $config['development']['image_handling']['processor']['derivatives']['teaser']['crop'] = true;
    $config['development']['image_handling']['processor']['derivatives']['teaser']['horizontal_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['teaser']['vertical_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['teaser']['webp_create'] = true;
    $config['development']['image_handling']['processor']['derivatives']['teaser']['webp_quality'] = 80;

    $config['development']['image_handling']['processor']['derivatives']['square'] = [];
    $config['development']['image_handling']['processor']['derivatives']['square']['max_width'] = 300;
    $config['development']['image_handling']['processor']['derivatives']['square']['max_height'] = 300;
    $config['development']['image_handling']['processor']['derivatives']['square']['preserve_aspect_ratio'] = true;
    $config['development']['image_handling']['processor']['derivatives']['square']['crop'] = true;
    $config['development']['image_handling']['processor']['derivatives']['square']['horizontal_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['square']['vertical_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['square']['webp_create'] = true;
    $config['development']['image_handling']['processor']['derivatives']['square']['webp_quality'] = 80;

    $config['development']['image_handling']['processor']['derivatives']['detail_thumb'] = [];
    $config['development']['image_handling']['processor']['derivatives']['detail_thumb']['max_width'] = 90;
    $config['development']['image_handling']['processor']['derivatives']['detail_thumb']['max_height'] = 90;
    $config['development']['image_handling']['processor']['derivatives']['detail_thumb']['preserve_aspect_ratio'] = true;
    $config['development']['image_handling']['processor']['derivatives']['detail_thumb']['crop'] = true;
    $config['development']['image_handling']['processor']['derivatives']['detail_thumb']['horizontal_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['detail_thumb']['vertical_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['detail_thumb']['webp_create'] = true;
    $config['development']['image_handling']['processor']['derivatives']['detail_thumb']['webp_quality'] = 80;

    $config['development']['image_handling']['processor']['derivatives']['detail'] = [];
    $config['development']['image_handling']['processor']['derivatives']['detail']['max_width'] = 730;
    $config['development']['image_handling']['processor']['derivatives']['detail']['max_height'] = 460;
    $config['development']['image_handling']['processor']['derivatives']['detail']['preserve_aspect_ratio'] = true;
    $config['development']['image_handling']['processor']['derivatives']['detail']['crop'] = true;
    $config['development']['image_handling']['processor']['derivatives']['detail']['horizontal_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['detail']['vertical_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['detail']['webp_create'] = true;
    $config['development']['image_handling']['processor']['derivatives']['detail']['webp_quality'] = 80;

    $config['development']['image_handling']['processor']['derivatives']['detail_gallery'] = [];
    $config['development']['image_handling']['processor']['derivatives']['detail_gallery']['max_width'] = 1200;
    $config['development']['image_handling']['processor']['derivatives']['detail_gallery']['max_height'] = 750;
    $config['development']['image_handling']['processor']['derivatives']['detail_gallery']['preserve_aspect_ratio'] = true;
    $config['development']['image_handling']['processor']['derivatives']['detail_gallery']['crop'] = true;
    $config['development']['image_handling']['processor']['derivatives']['detail_gallery']['horizontal_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['detail_gallery']['vertical_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['detail_gallery']['webp_create'] = true;
    $config['development']['image_handling']['processor']['derivatives']['detail_gallery']['webp_quality'] = 80;

    $config['development']['image_handling']['processor']['derivatives']['bigslide'] = [];
    $config['development']['image_handling']['processor']['derivatives']['bigslide']['max_width'] = 1980;
    $config['development']['image_handling']['processor']['derivatives']['bigslide']['max_height'] = 600;
    $config['development']['image_handling']['processor']['derivatives']['bigslide']['preserve_aspect_ratio'] = true;
    $config['development']['image_handling']['processor']['derivatives']['bigslide']['crop'] = true;
    $config['development']['image_handling']['processor']['derivatives']['bigslide']['horizontal_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['bigslide']['vertical_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['bigslide']['webp_create'] = true;
    $config['development']['image_handling']['processor']['derivatives']['bigslide']['webp_quality'] = 80;

    $config_file = dirname(__DIR__) . DIRECTORY_SEPARATOR . getenv('PM_CONFIG');
    $config_text = "<?php\n\$config = " . _var_export($config) . ';';
    echo 'Writing config to ' . $config_file . "\n";
    file_put_contents($config_file, $config_text);
}

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

$args = $argv;
$args[1] = isset($argv[1]) ? $argv[1] : null;

$namespace = 'Pressmind\ORM\Object';

if($args[1] != 'only_static') {
    $config = Registry::getInstance()->get('config');

    if($first_install) {
        $first_install_success = true;
        Writer::write('Creating required directories', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        $required_directories = [];
        $required_directories[] = HelperFunctions::buildPathString([APPLICATION_PATH, 'Custom', 'MediaType']);
        $required_directories[] = HelperFunctions::replaceConstantsFromConfig($config['logging']['log_file_path']);
        $required_directories[] = HelperFunctions::replaceConstantsFromConfig($config['tmp_dir']);
        if ($config['file_handling']['storage']['provider'] == 'filesystem') {
            $required_directories[] = HelperFunctions::replaceConstantsFromConfig($config['file_handling']['storage']['bucket']);
        }
        if ($config['image_handling']['storage']['provider'] == 'filesystem') {
            $required_directories[] = HelperFunctions::replaceConstantsFromConfig($config['image_handling']['storage']['bucket']);
        }
        $required_directories[] = HelperFunctions::buildPathString([HelperFunctions::replaceConstantsFromConfig($config['docs_dir']), 'objecttypes']);

        foreach ($required_directories as $directory) {
            if (!is_dir($directory)) {
                if(mkdir($directory, 0775, true)) {
                    Writer::write('Directory ' . $directory . ' created', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
                } else {
                    Writer::write('Failed to create directory ' . $directory, Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
                    $first_install_success = false;
                }
            }
        }
        if(!$first_install_success) {
            Writer::write('Creating required directories failed! Installation aborted!', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
            die();
        }
    }

    foreach (Info::STATIC_MODELS as $model) {
        try {
            $model_name = $namespace . $model;
            Writer::write('Creating database table for model: ' . $model_name, Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
            $scaffolder = new DB\Scaffolder\Mysql(new $model_name());
            $scaffolder->run($args[1] === 'drop_tables');
            foreach ($scaffolder->getLog() as $scaffolder_log) {
                Writer::write($scaffolder_log, Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
            }
        } catch (Exception $e) {
            Writer::write($model_name, Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_ERROR);
            Writer::write($e->getMessage(), Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_ERROR);
        }
    }

    try {
        Writer::write('Installing scheduler tasks', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        $existing_scheduled_tasks = Task::listAll();
        foreach ($existing_scheduled_tasks as $existing_scheduled_task) {
            Writer::write('Deleting existing task "' . $existing_scheduled_task->name . '"', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
            $existing_scheduled_task->delete(true);
        }
        foreach ($config['scheduled_tasks'] as $config_scheduled_task) {
            $scheduled_task = new Task();
            $scheduled_task->name = $config_scheduled_task['name'];
            $scheduled_task->description = isset($config_scheduled_task['description']) ? $config_scheduled_task['description'] : null;
            $scheduled_task->class_name = $config_scheduled_task['class_name'];
            $scheduled_task->schedule = json_encode($config_scheduled_task['schedule']);
            $scheduled_task->last_run = new \DateTime();
            $scheduled_task->active = true;
            $scheduled_task->running = false;
            $scheduled_task->error_count = 0;
            $scheduled_task->methods = [];
            foreach ($config_scheduled_task['methods'] as $config_scheduled_task_method) {
                $task_method = new Task\Method();
                $task_method->name = $config_scheduled_task_method['method'];
                $task_method->parameters = json_encode($config_scheduled_task_method['parameters']);
                $task_method->position = intval($config_scheduled_task_method['position']);
                $scheduled_task->methods[] = $task_method;
            }
            $scheduled_task->create();
            Writer::write('New task "' . $scheduled_task->name . '" created', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        }
    } catch (Exception $e) {
        Writer::write($e->getMessage(), Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_ERROR);
    }

    try {
        Writer::write('Requesting and parsing information on media object types ...', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        $importer = new Import();
        $ids = [];
        $client = new Client();
        $response = $client->sendRequest('ObjectType', 'getAll');
        $media_types = [];
        $media_types_pretty_url = [];
        $media_types_allowed_visibilities = [];

        $searchroutes = [];
        $theme_config = [];
        $type_map = [
            'TOUR' => 'TS_TOUR_PRODUCTS',
            'HOTEL' => 'TS_HOTEL_PRODUCTS',
            'HOLIDAYHOME' => 'TS_HOLIDAYHOMES_PRODUCTS',
            'DAYTRIP' => 'TS_DAYTRIPS_PRODUCTS',
            'DESTINATION' => 'TS_DESTINATIONS'
        ];

        if(!isset($config['data']['primary_media_type_ids']) || !is_array($config['data']['primary_media_type_ids'])){
            $config['data']['primary_media_type_ids'] = [];
        }
        foreach ($response->result as $item) {
            Writer::write('Parsing media object type ' . $item->type_name, Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
            $media_types[$item->id_type] = ucfirst(HelperFunctions::human_to_machine($item->type_name));
            $ids[] = $item->id_type;
            $pretty_url = [
                'prefix' => '/' . HelperFunctions::human_to_machine($item->type_name) . '/',
                'field' => ['name' => 'name'],
                'strategy' => 'none',
                'suffix' => '/'
            ];
            $media_types_pretty_url[$item->id_type] = $pretty_url;
            $media_types_allowed_visibilities[$item->id_type] = [30];

            if(isset($type_map[$item->gtxf_product_type])){
                Writer::write('GTXF product type found for ID '.$item->id_type.' : ' . $item->gtxf_product_type, Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
                $theme_config[$type_map[$item->gtxf_product_type]] = $item->id_type;
            }

            if(in_array($item->gtxf_product_type, ['TOUR', 'DAYTRIP', 'HOLIDAYHOME'])){
                $config['data']['primary_media_type_ids'][] = $item->id_type;
                $searchroute = [
                    'pm-ot' => $item->id_type,
                    'languages' => [
                        'default' => [
                            'route' => HelperFunctions::human_to_machine($item->type_name).'-suche',
                            'title' => $item->type_name.' Suche - Travelshop',
                            'meta_description' => ''
                        ]
                    ]
                ];

                $searchroutes[] = $searchroute;
            }
        }

        $config['data']['primary_media_type_ids'] = array_unique($config['data']['primary_media_type_ids']);

        $searchroutes = array_merge([[
            'pm-ot' => implode(',', $config['data']['primary_media_type_ids']),
            'languages' => [
                'default' => [
                    'route' => 'suche',
                    'title' => 'Reise Suche - Travelshop',
                    'meta_description' => '',
                ],
            ],
        ]], $searchroutes);

        $theme_config['TS_SEARCH_ROUTES'] = _var_export($searchroutes);
        $config['data']['primary_media_type_ids'] = array_unique($config['data']['primary_media_type_ids']);

        $response = $client->sendRequest('ObjectType', 'getById', ['ids' => implode(',',$config['data']['primary_media_type_ids'])]);
        $search_fields = [];
        $ts_filter = [];
        $mongodb_search_categories = [];
        $mongodb_search_descriptions = [];
        $mongodb_search_build_for= [];

        foreach ($response->result as $item) {

            if(empty($item->gtxf_product_type)){
                continue;
            }
            $mongodb_search_build_for[$item->id][] = [
                'language' => NULL,
                'origin' => 0,
            ];
            foreach($item->fields as $field){
                if(empty($field->sections)){
                    continue;
                }
                if(empty($mongodb_search_descriptions[$item->id]['headline']) ){
                    $mongodb_search_descriptions[$item->id]['headline'] = [
                        'field' => 'name',
                        'from' => null,
                        'filter' => null,
                    ];
                }
                foreach($field->sections as $section){
                    $field_name = strtolower($field->var_name.'_'.$section->name);

                    if($field->type == 'categorytree'){
                        $search_fields[$item->id][] = [
                            'fieldname' => $field_name,
                            'name' => $field->name,
                            'behavior' => 'OR'
                        ];

                        if(!in_array($field_name,$ts_filter)){
                            $ts_filter[$field_name] = [
                                'fieldname' => $field_name,
                                'name' => $field->name,
                                'behavior' => 'OR'
                            ];
                        }
                        $mongodb_search_categories[$item->id][$field_name] = null;
                    }
                    if(in_array($field->type, ['text', 'plaintext']) &&
                        preg_match('/subline/', $field->var_name) > 0 &&
                        empty($mongodb_search_descriptions[$item->id]['subline']) ){
                        $mongodb_search_descriptions[$item->id]['subline'] = [
                            'field' => $field_name,
                            'from' => null,
                            'filter' => '\\Custom\\Filter::strip',
                        ];
                    }
                    if(in_array($field->type, ['text', 'plaintext']) &&
                        preg_match('/intro|einleitung/', $field->var_name) > 0 &&
                        empty($mongodb_search_descriptions[$item->id]['intro']) ){
                        $mongodb_search_descriptions[$item->id]['intro'] = [
                            'field' => $field_name,
                            'from' => null,
                            'filter' => '\\Custom\\Filter::strip',
                        ];
                    }
                    if(in_array($field->type, ['picture']) &&
                        preg_match('/bilder|picture|image/', $field->var_name) > 0 &&
                        empty($mongodb_search_descriptions[$item->id]['image']) ){
                        $mongodb_search_descriptions[$item->id]['image'] = [
                            'field' => $field_name,
                            'from' => null,
                            'filter' => '\\Custom\\Filter::firstPicture',
                            'params' => [
                                'derivative' => 'teaser',
                                'section' => 'base',
                            ],
                        ];
                    }
                    if(in_array($field->type, ['picture']) &&
                        preg_match('/bilder|picture|image/', $field->var_name) > 0 &&
                        empty($mongodb_search_descriptions[$item->id]['bigslide']) ){
                        $mongodb_search_descriptions[$item->id]['bigslide'] = [
                            'field' => $field_name,
                            'from' => null,
                            'filter' => '\\Custom\\Filter::firstPicture',
                            'params' => [
                                'derivative' => 'bigslide',
                                'section' => 'panorama',
                            ],
                        ];
                    }

                    if(in_array($field->type, ['picture']) &&
                        preg_match('/bilder|picture|image/', $field->var_name) > 0 &&
                        empty($mongodb_search_descriptions[$item->id]['image_square']) ){
                        $mongodb_search_descriptions[$item->id]['image_square'] = [
                            'field' => $field_name,
                            'from' => null,
                            'filter' => '\\Custom\\Filter::firstPicture',
                            'params' => [
                                'derivative' => 'square',
                                'section' => 'quadrate',
                            ],
                        ];
                    }

                    if(in_array($field->type, ['categorytree']) &&
                        preg_match('/^zielgebiet|^destination/', $field->var_name) > 0 &&
                        empty($mongodb_search_descriptions[$item->id]['destination']) ){
                        $mongodb_search_descriptions[$item->id]['destination'] = [
                            'field' => $field_name,
                            'from' => null,
                            'filter' => '\\Custom\\Filter::lastTreeItemAsString',
                        ];
                    }
                    if(in_array($field->type, ['categorytree']) &&
                        preg_match('/^reiseart/', $field->var_name) > 0 &&
                        empty($mongodb_search_descriptions[$item->id]['travel_type']) ){
                        $mongodb_search_descriptions[$item->id]['travel_type'] = [
                            'field' => $field_name,
                            'from' => null,
                            'filter' => '\\Custom\\Filter::lastTreeItemAsString',
                        ];
                    }
                }



            }
        }

        $ts_filter = array_values($ts_filter);

        // Build Searchboxes
        $ts_search = [];
        $combined_search = [];
        $ts_search['default_search_box']['tabs'] = [];
        foreach($search_fields as $id_object_type => $fields){
            foreach($fields as $field){
                if(!isset($combined_search[$field['fieldname']]) && (strpos($field['fieldname'], 'reiseart') === 0 || strpos($field['fieldname'], 'zielgebiet') === 0)){
                    $combined_search[$field['fieldname']] = $field;
                }
            }
        }

        $combined_search = array_merge([
            [
                'fieldname' => 'string_search',
                'name' => 'Suche',
            ],
            [
                'fieldname' => 'date_picker',
                'name' => 'Zeitraum',
            ]
        ], array_values($combined_search));

        $ts_search['default_search_box']['tabs'][] = [
            'name' => 'Suche',
            'search' => [
                'pm-ot' => implode(',', $config['data']['primary_media_type_ids'])
            ],
            'route' => 'suche',
            'fields' => $combined_search
        ];

        $ts_single_search = [
            'placeholder' => 'Suchbegriff...',
            'route' => 'suche',
            'search' => [
                'pm-ot' => implode(',', $config['data']['primary_media_type_ids'])
            ],
        ];

        if($first_install){
            $theme_config['TS_FILTERS'] = _var_export($ts_filter);
            $theme_config['TS_SEARCH'] = _var_export($ts_search);
            $theme_config['TS_SINGLE_SEARCH'] = _var_export($ts_single_search);
            \Custom\InstallHelper::writeConfig($theme_config);
            $config['data']['search_mongodb']['search']['descriptions'] = $mongodb_search_descriptions;
            $config['data']['search_mongodb']['search']['categories'] = $mongodb_search_categories;
            $config['data']['search_mongodb']['search']['categories'] = $mongodb_search_categories;
            $config['data']['search_mongodb']['search']['build_for'] = $mongodb_search_build_for;
            $config['data']['search_mongodb']['search']['touristic']['departure_offset_to'] = 730;
        }
        $config['data']['media_types'] = $media_types;
        $config['data']['media_types_pretty_url'] = $media_types_pretty_url;
        $config['data']['media_types_allowed_visibilities'] = $media_types_allowed_visibilities;
        Registry::getInstance()->get('config_adapter')->write($config);
        Registry::getInstance()->add('config', $config);

        $importer->importMediaObjectTypes($ids);
    } catch (Exception $e) {
        Writer::write($e->getMessage(), Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_ERROR);
    }
}
echo "\n";
// TODO:
//Writer::write('It is recommended to install a cronjob on your system. Add the following line to your servers crontab:', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
//Writer::write('*/1 * * * * php ' . APPLICATION_PATH . '/cli/cron.php > /dev/null 2>&1', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
echo "\n";
if($args[1] == 'with_static' || $args[1] == 'only_static') {
    try {
        Writer::write('Dumping static data, this may take a while ...', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        Writer::write('Data will be dumped using "gunzip" and "mysql" with "shell_exec". Dump data in ' . HelperFunctions::buildPathString([dirname(__DIR__), 'src', 'data']) . ' by hand if shell_exec fails', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        $config = Registry::getInstance()->get('config');
        Writer::write('Dumping data for pmt2core_airlines', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        shell_exec("gunzip < " . HelperFunctions::buildPathString([dirname(__DIR__), 'src', 'data', 'pmt2core_airlines.sql.gz']) . " | mysql --host=" . $config['database']['host'] . " --user=" . $config['database']['username'] . " --password=" . $config['database']['password'] . " " . $config['database']['dbname']);
        Writer::write('Dumping data for pmt2core_airports', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        shell_exec("gunzip < " . HelperFunctions::buildPathString([dirname(__DIR__), 'src', 'data', 'pmt2core_airports.sql.gz']) . " | mysql --host=" . $config['database']['host'] . " --user=" . $config['database']['username'] . " --password=" . $config['database']['password'] . " " . $config['database']['dbname']);
        Writer::write('Dumping data for pmt2core_banks', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        shell_exec("gunzip < " . HelperFunctions::buildPathString([dirname(__DIR__), 'src', 'data', 'pmt2core_banks.sql.gz']) . " | mysql --host=" . $config['database']['host'] . " --user=" . $config['database']['username'] . " --password=" . $config['database']['password'] . " " . $config['database']['dbname']);
        Writer::write('Dumping data for pmt2core_geozip', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        shell_exec("gunzip < " . HelperFunctions::buildPathString([dirname(__DIR__), 'src', 'data', 'pmt2core_geozip.sql.gz']) . " | mysql --host=" . $config['database']['host'] . " --user=" . $config['database']['username'] . " --password=" . $config['database']['password'] . " " . $config['database']['dbname']);
    } catch (Exception $e) {
        Writer::write($e->getMessage(), Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_ERROR);
    }
} else {
    echo "\n";
    Writer::write('Some optional static data has not been dumped yet. If this data is needed (you will know, if) dump static data by calling "install.php with_static" or "install.php only_static"', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
    Writer::write('You can also dump the data by hand. Data resides here: ' . HelperFunctions::buildPathString([dirname(__DIR__), 'src', 'data']), Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
}


/**
 * @param $expression
 * @param bool $return
 * @return mixed|string|string[]|null
 */
function _var_export($expression) {
    $export = var_export($expression, true);
    $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
    $array = preg_split("/\r\n|\n|\r/", $export);
    $array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [NULL, ']$1', ' => ['], $array);
    //$array = preg_replace("/[0-9]+\s*\=\>\s*\[\$/", "[", $array);
    $export = join(PHP_EOL, array_filter(["["] + $array));
    return $export;
}
// echo '!!!ATTENTION: Please have a look at the CHANGES.md file, there might be important information on breaking changes!!!!' . "\n";
