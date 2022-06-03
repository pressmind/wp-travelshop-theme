<?php
/**
 * Custom Ajax Endpoint to avoid loading a full wordpress stack load with WordPress's regular admin-ajax.php
 */

use \Pressmind\Travelshop\Search;
use \Pressmind\ORM\Object\MediaObject;
use \Pressmind\Search\CheapestPrice;
use \Pressmind\Travelshop\PriceHandler;
use \Pressmind\Travelshop\IB3Tools;
use Pressmind\Travelshop\Template;

//error_reporting(-1);
//ini_set('display_errors', 'On');

require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->safeLoad();
require_once getenv('CONFIG_THEME');
require_once 'bootstrap.php';
require_once 'src/Search.php';
require_once 'src/BuildSearch.php';
require_once 'src/RouteHelper.php';
require_once 'src/PriceHandler.php';
require_once 'src/Template.php';
require_once 'src/IB3Tools.php';
header('Content-type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");
$Output = new stdClass();
$Output->error = true;
$Output->result = null;
$Output->html = array();
$Output->msg = null;
$Output->count = null;
$request = json_decode(file_get_contents('php://input'));
if (empty($_GET['action'])) {
    $Output->result = $request;
    echo json_encode($Output);
    exit;
} else if ($_GET['action'] == 'search') {
    $output = null;
    $view = 'Teaser1';
    if(!empty($_GET['view']) && preg_match('/^[0-9A-Za-z\_]+$/', $_GET['view']) !== false){
        $view = $_GET['view'];
        if($view == 'Calendar1') {
            $output = 'date_list';
        }
    }
    $args = Search::getResult($_GET, 2, 12, true, false, TS_TTL_FILTER, TS_TTL_SEARCH, $output);
    ob_start();
    require 'template-parts/pm-search/result.php';
    $Output->count = (int)$args['total_result'];
    $Output->html['search-result'] = ob_get_contents();
    ob_end_clean();
    ob_start();
    require 'template-parts/pm-search/filter-vertical.php';
    $Output->html['search-filter'] = ob_get_contents();
    ob_end_clean();
    $Output->error = false;
    $result = json_encode($Output);
    if(json_last_error() > 0){
        $Output->error = true;
        $Output->msg = 'json error: '.json_last_error_msg();
        $Output->html = $Output->msg;
        $result = json_encode($Output);
    }
    echo $result;
    exit;
} else if ($_GET['action'] == 'wishlist'){
    /**
     * @var array $result
     * @var array $ids
     */
    ob_start();
    require 'template-parts/pm-search/wishlist-result.php';
    $Output->count = $result['total_result'];
    $Output->mongo = $result['mongodb'];
    $Output->ids = $ids;
    $Output->html['wishlist-result'] = ob_get_contents();
    ob_end_clean();
    $Output->error = false;
    $result = json_encode($Output);
    echo $result;
    exit;
} else if ($_GET['action'] == 'searchbar'){
    $args = [];
    $args['search_box_tab'] = intval($_GET['pm-tab']);
    if(!empty($_GET['pm-get']) && preg_match('/^[0-9A-Za-z\_\-]+$/', $_GET['pm-box']) !== false){
        $args['search_box'] = $_GET['pm-tab'];
    }
    ob_start();
    require 'template-parts/pm-search/search/searchbar-form.php';
    $Output->html['main-search'] = ob_get_contents();
    ob_end_clean();
    $Output->error = false;
    $result = json_encode($Output);
    echo $result;
    exit;
} else if ($_GET['action'] == 'autocomplete') {
    ob_start();
    require 'template-parts/pm-search/autocomplete.php';
    $output = ob_get_contents();
    ob_end_clean();
    echo $output;
    exit;
} else if ($_GET['action'] == 'pm-view') {
    $id_media_object = (int)$_GET['pm-id'];
    if(empty($id_media_object)){
        exit;
    }
    $view = 'Teaser1';
    if(!empty($_GET['view']) && preg_match('/^[0-9A-Za-z\_]+$/', $_GET['view']) !== false){
        $view = $_GET['view'];
    }
    $result = Search::getResult(['pm-id' => $id_media_object], 2, 1, false, false, TS_TTL_FILTER, TS_TTL_SEARCH);
    $Output->error = true;
    $Output->html = '<!-- media object not found -->';
    if(!empty($result['items'][0])){
        $Output->error = false;
        $Output->html = Template::render(__DIR__ . '/template-parts/pm-views/' . $view . '.php', $result['items'][0]);
    }
    $result = json_encode($Output);
    echo $result;
    exit;
}else if ($_GET['action'] == 'offers') {
    $id_media_object = (int)$_GET['pm-id'];
    if(empty($id_media_object)){
        exit;
    }
    $mediaObject = new MediaObject($id_media_object);
    $filter = new CheapestPrice();
    if (isset($_GET['pm-du']) === true && preg_match('/^([0-9]+)\-([0-9]+)$/', $_GET['pm-du']) > 0) {
        list($filter->duration_from, $filter->duration_to) = explode('-', $_GET['pm-du']);
    }
    if (isset($_GET['pm-dr']) === true) {
        $dateRange = BuildSearch::extractDaterange($_GET['pm-dr']);
        if($dateRange !== false){
            $filter->date_from = $dateRange[0];
            $filter->date_to = $dateRange[1];
        }
    }
    $limit = [0,100];
    if (isset($_GET['pm-l']) === true && preg_match('/^([0-9]+)\,([0-9]+)$/', $_GET['pm-l'], $m) > 0) {
        $limit = [intval($m[1]), intval($m[2])];
    }
    $filter->occupancies_disable_fallback = true;
    $prices = $mediaObject->getCheapestPrices($filter, ['date_departure' => 'ASC', 'price_total' => 'ASC'], $limit);
    $offers = [];
    foreach($prices as $price){
        $tmp = new \stdClass();
        $tmp = $price->toStdClass(false);
        $tmp->price_total_formatted = PriceHandler::format($price->price_total);
        $tmp->ib3_url = IB3Tools::get_bookinglink($price, $mediaObject->getPrettyUrl());
        $offers[] = $tmp;
    }
    $result = json_encode($offers);
    echo $result;
    exit;
}else if ($_GET['action'] == 'checkAvailability') {
    //print_r($request);
    if(defined('TS_DEMO_MODE') && TS_DEMO_MODE === true){
        sleep(1.5);
        $demo_mode = [];
        $demo_mode[0] = $demo_mode[1] = $demo_mode[2] = ['green', 'zur Buchung', 'bookable', true];
        $demo_mode[3] = ['orange', 'Anfrage', 'request', true];
        $demo_mode[4] = ['gray', 'Buchungsstop', '', false];
        $demo_mode[5] = ['red', 'ausgebucht', '', false];
        $random_state = array_rand($demo_mode, 1);
        $r = new stdClass();
        $r->class = $demo_mode[$random_state][0];
        $r->msg = $r->btn_msg = $demo_mode[$random_state][1];
        $r->booking_type = $demo_mode[$random_state][2];
        $r->bookable = $demo_mode[$random_state][3];
    }else{
        sleep(0.2);
        $r = new stdClass();
        $r->class = 'green';
        $r->msg = $r->btn_msg = 'zur Buchung';
        $r->booking_type = 'bookable';
        $r->bookable = true;
    }
    $result = json_encode($r);
    echo $result;
    exit;
}else{
    header("HTTP/1.0 400 Bad Request");
    $Output->msg = 'error: action not known';
    $Output->error = true;
    echo json_encode($Output);
    exit;
}
