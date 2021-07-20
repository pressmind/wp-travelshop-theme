<?php

// Config
use Pressmind\Travelshop\AdminPage;
use Pressmind\Travelshop\ThemeActivation;
use Pressmind\Travelshop\Shortcodes;
use Pressmind\Travelshop\WPFunctions;
use Pressmind\Travelshop\RouteProcessor;
use Pressmind\Travelshop\Router;
use Pressmind\Travelshop\Route;

// this code is only for a better onboarding, remove in production
    if(file_exists(get_template_directory().'/pm-config.php') === false ){
        if(file_exists(get_template_directory().'/bootstrap.php') === false ) {
            echo 'Error: pressmind web-core SDK is not installed<br>';
            echo 'run "composer install" in ' . __DIR__;
        } else if(file_exists(get_template_directory().'/pm-config.php') === false ) {
            echo 'Error: pressmind web-core SDK is not installed correctly<br>';
            echo 'pm-config.php is missing';
        }
        exit();
    }

    // check if web-core sdk installation is done
    if(file_exists(get_template_directory().'/Custom/MediaType') === true
        && count(glob(get_template_directory().'/Custom/MediaType/*.php')) <= 1){
            echo 'Error: pressmind web-core SDK is not configured correctly.<br>';
            echo 'run "php install.php " in ' . get_template_directory().'/cli/';
            exit();
    }


// load the theme-config
require_once 'config-theme.php';

// pressmind web-core sdk
require_once 'bootstrap.php';

// admin/system related functions
require_once 'src/ThemeActivation.php';
require_once 'src/AdminPage.php';
require_once 'src/Shortcodes.php';
require_once 'src/WPFunctions.php';
require_once 'src/BuildSearch.php';
require_once 'src/RouteProcessor.php';
require_once 'src/Route.php';
require_once 'src/Router.php';
require_once 'src/SitemapProvider.php';
require_once 'src/IB3Tools.php';


// Cleanup
require_once 'functions/cleanup_meta_includes.php';
require_once 'functions/disable_emojis.php';
require_once 'functions/disable_pagetypes.php';

// Menus
require_once 'functions/menus.php';
require_once 'functions/the_breadcrumb.php';
require_once 'functions/theme_support.php';
require_once 'functions/image-sizes.php';

// Header
require_once 'functions/http_header.php';
require_once 'functions/add_meta.php';

// Search
require_once 'functions/search.php';

// Author
require_once 'functions/author_boxes.php';

// Rewrite Rules
require_once 'functions/rewrite_rules.php';

// JS & CSS
require_once  'functions/enqueue_js.php';
require_once  'functions/enqueue_css.php';

// Sitemaps
require_once 'functions/sitemaps.php';

class PMTravelShop{

    public $Shortcodes;
    public $AdminPage;
    public $ThemeActivation;
    public $RouteProcessor;
    public $Redis = null;


    public function __construct($routes)
    {
        $this->RouteProcessor = RouteProcessor::init(new Router('pmwc_routes'), $routes);
        $this->Shortcodes = new Shortcodes();
        $this->AdminPage = new AdminPage();
        $this->ThemeActivation = new ThemeActivation();
        if(defined(PM_REDIS_HOST) === true){
            $this->Redis = new Redis();
            $this->Redis->connect(PM_REDIS_HOST, PM_REDIS_PORT);
        }
    }

}

require_once 'config-routing.php';
$PMTravelShop = new PMTravelShop($routes);

// load beaver builder custom plugins if required
if(BB_ACTIVE == true){
    require_once 'src/BeaverBuilderModuleLoader.php';
    BeaverBuilderModuleLoader::init();
}