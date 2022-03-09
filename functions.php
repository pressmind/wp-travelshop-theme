<?php

use Pressmind\Travelshop\AdminPage;
use Pressmind\Travelshop\ThemeActivation;
use Pressmind\Travelshop\Shortcodes;
use Pressmind\Travelshop\RouteProcessor;
use Pressmind\Travelshop\Router;
use Pressmind\Travelshop\Timer;

require_once 'vendor/autoload.php';

// load .env environment, if .env file exists
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->safeLoad();

// this code is only for a better onboarding, remove in production
    if(file_exists(get_template_directory().'/'.getenv('PM_CONFIG')) === false ){
        if(file_exists(get_template_directory().'/bootstrap.php') === false ) {
            echo 'Error: pressmind web-core SDK is not installed<br>';
            echo 'run "composer install" in ' . __DIR__;
        } else if(file_exists(get_template_directory().'/'.getenv('PM_CONFIG')) === false ) {
            echo 'Error: pressmind web-core SDK is not installed correctly<br>';
            echo getenv('PM_CONFIG').' is missing';
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

// load the theme-config / config-theme.php per default, defined in .env
require_once getenv('CONFIG_THEME');

// pressmind web-core sdk
require_once 'bootstrap.php';

// register admin setting page (wpsf based)
require_once 'admin-settings/register-settings-page.php';

// admin/system related functions
require_once 'src/ThemeActivation.php';
require_once 'src/AdminPage.php';
require_once 'src/Shortcodes.php';
require_once 'src/WPFunctions.php';
require_once 'src/Search.php';
require_once 'src/BuildSearch.php';
require_once 'src/RouteProcessor.php';
require_once 'src/Route.php';
require_once 'src/Router.php';
require_once 'src/RouteHelper.php';
require_once 'src/SitemapProvider.php';
require_once 'src/IB3Tools.php';
require_once 'src/CategoryTreeTools.php';
require_once 'src/PriceHandler.php';
require_once 'src/Timer.php';
require_once 'src/Calendar.php';
require_once 'src/Template.php';

// enable SMTP auth support
require_once 'functions/email_smtp.php';

// Cleanup
require_once 'functions/heartbeat.php';
require_once 'functions/cleanup_meta_includes.php';
require_once 'functions/disable_emojis.php';
require_once 'functions/disable_pagetypes.php';
//require_once 'functions/disable_main_query.php';

// Menus
require_once 'functions/menus.php';
require_once 'functions/add_menu_meta.php';

require_once 'functions/the_breadcrumb.php';
require_once 'functions/theme_support.php';

// Header
require_once 'functions/http_header.php';
require_once 'functions/add_meta.php';

// Blog Features
require_once 'functions/blog_search.php';
require_once 'functions/user_meta.php';

// Rewrite Rules
require_once 'functions/rewrite_rules.php';

// JS & CSS
require_once  'functions/enqueue_js.php';
require_once  'functions/enqueue_css.php';

// Performance
require_once  'functions/template_transient.php';
require_once  'functions/max_image_upload.php';
require_once  'functions/load_text_domain.php';

// Contactform 7 support, if installed, we will load some custom formfield-tags here.
if(class_exists('WPCF7')){
    require_once 'functions/contactform7_imgbtn_tag.php';
    require_once 'functions/contactform7_modal_tag.php';
}

// Sitemaps
require_once 'functions/sitemaps.php';

// Images
require_once 'functions/images.php';

// Admin Stuff
require_once 'functions/after_wp_save.php';

// Cache
require_once 'src/RedisPageCache.php';

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

    }

}

Timer::startTimer('routing');
require_once 'config-routing.php';
Timer::endTimer('routing');
$PMTravelShop = new PMTravelShop($routes);



// load theme specific pagebuilder modules
if(PAGEBUILDER == 'beaverbuilder' && class_exists( 'FLBuilder' )){

    Timer::startTimer('beaverinit');
    require_once 'config-bb.php';
    require_once 'src/BeaverBuilderModuleLoader.php';
    BeaverBuilderModuleLoader::init();
    Timer::endTimer('beaverinit');
}
