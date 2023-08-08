<?php

/**
 * How does this routing work:
 * 1. a route delivers a custom template from the theme directory (like WP's single.php)
 * 2. a route can trigger a custom hook, this is useful to setup customs headers, or deliver the requested site
 * from the content from pressmind's web-core sdk, sample above
 */

use Pressmind\Registry;
use Pressmind\Travelshop\Route;
use Pressmind\Travelshop\Search;
use Pressmind\Travelshop\Template;
use Pressmind\Travelshop\WPFunctions;

/**
 * Routing
 * Generating the routes dynamically based on the pressmind web-core pretty_url config, see pm-config.php
 * In real world you should check if all routes are required by your project
 */
$config = Registry::getInstance()->get('config');
$routes = array();


$languages = [$config['data']['languages']['default']];
if (MULTILANGUAGE_SITE) {
    $languages = $config['data']['languages']['allowed'];
}

// - DETAIL PAGE ROUTE -
// Build a route for each primary media object type > detailpage <
// e.g. www.xxx.de/reise/reisename/
foreach ($config['data']['media_types_pretty_url'] as $object_type => $pretty_url) {
    if (!empty($config['data']['primary_media_type_ids']) && !in_array($object_type, $config['data']['primary_media_type_ids'])) {
        continue;
    }
    $language_prefix = '';
    if (MULTILANGUAGE_SITE && !empty($pretty_url['language'])) {
        $language_prefix = $pretty_url['language'].'/';
    }
    $route_prefix = $language_prefix . trim($pretty_url['prefix'], '/');
    $routename = 'ts_default_' . $route_prefix . '_route';
    $data = [];
    $data['id_object_type'] = $object_type;
    $data['type'] = 'detail';
    $data['language'] = $pretty_url['language'];
    $data['base_url'] = $route_prefix;
    $routes[$routename] = new Route('^' . $route_prefix . '/(.+?)', 'ts_detail_hook', 'pm-detail', $data);
}
// - SEARCH ROUTE -
// Build a route for each media object type > searchpage <
// e.g. www.xxx.de/de/reise-suche/
foreach(TS_SEARCH_ROUTES as $search_route){
    foreach($search_route['languages'] as $language_code => $language){
        $language_prefix = '';
        if($language_code != 'default'){
            $language_prefix = $language_code.'/';
        }
        $route_prefix = $language_prefix.trim($language['route'],'/');
        $routename = 'ts_default_' . $route_prefix . '_route';
        $data = [];
        $data['id_object_types'] = $search_route['pm-ot'];
        $data['order'] = !empty($search_route['pm-o']) ? $search_route['pm-o'] : 'price-asc';
        $data['type'] = 'search';
        $data['language'] = $language_code;
        $data['base_url'] = $route_prefix;
        $data['title'] = $language['title'];
        $data['meta_description'] = $language['meta_description'];
        $routes[$routename] = new Route('^' . $route_prefix . '/?', 'ts_search_hook', 'pm-search', $data);
    }
}

// Setup the route for the calendar page
foreach ($languages as $language) {
    $language_prefix = '';
    if (MULTILANGUAGE_SITE && !empty($pretty_url['language'])) {
        $language_prefix = $pretty_url['language'].'/';
    }
    $route_prefix = $language_prefix .  'calendar';
    $routename = 'ts_default_' . $route_prefix . '_route';
    $data = [];
    $data['type'] = 'search';
    $data['language'] = $language;
    $data['base_url'] = $route_prefix;
    $data['title'] = 'Reisekalender | ' . get_bloginfo('name');
    $data['meta_description'] = '';
    $routes[$routename] = new Route('^' . $route_prefix . '/?', 'ts_calendar_hook', 'pm-calendar', $data);
}

// route by id
$route_prefix = $language_prefix .  'id';
$data = [];
$data['type'] = 'detail-by-id';
$data['language'] = null;
$data['base_url'] = $route_prefix;
$routename = 'ts_by_id_route';
$routes[$routename] = new Route('^' . $route_prefix . '/([0-9]+)', 'ts_detail_hook', 'pm-detail', $data);

// route by code
$route_prefix = $language_prefix .  'code';
$data = [];
$data['type'] = 'detail-by-code';
$data['language'] = null;
$data['base_url'] = $route_prefix;
$routename = 'ts_by_code_route';
$routes[$routename] = new Route('^' . $route_prefix . '/(.+?)', 'ts_detail_hook', 'pm-detail', $data);



/**
 * Each route can have its own hook,
 * This hook will be fire before html output. (useful for sending http status codes or set meta data...
 */
function ts_detail_hook($data)
{
    global $wp, $wp_query, $post;
    $post = null;
    define('TS_IS_DETAIL', true);
    try {
        if($data['type'] == 'detail'){
            $route = $wp->request;
            if (MULTILANGUAGE_SITE) {
                $route = preg_replace('(^' . $data['language'] . '\/)', '', $wp->request);
            }
            $q = [
                'pm-url' => '/' . $route . '/',
                'pm-ot' => $data['id_object_type']
            ];
        }elseif($data['type'] == 'detail-by-id'){
            $id = preg_replace('(^id\/)', '', $wp->request);
            if (MULTILANGUAGE_SITE) {
                $id = preg_replace('(^' . $data['language'] . '\/id\/)', '', $wp->request);
            }
            $q = ['pm-id' => $id];
        }elseif($data['type'] == 'detail-by-code'){
            $code = preg_replace('(^code\/)', '', $wp->request);
            if (MULTILANGUAGE_SITE) {
                $code = preg_replace('(^' . $data['language'] . '\/code\/)', '', $wp->request);
            }
            $q = [ 'pm-co' => $code];
        }else{
            exit('route type not valid');
        }
        $preview_date = null;
        if(!empty($_GET['preview'])){
            $preview_date = new DateTime();
        }
        $r = Search::getResult($q, null, 10, false, false, null, null, null, $preview_date, [], [30,60]);
        if (empty($r['total_result'])) {
            WPFunctions::throw404(410, 'object not found, check visibility'); // 410 = page/product has gone
        }
        // Preload mediaobjects
        $id_media_objects = [];
        $mediaObjects = [];
        $mediaObjectCachedKeys = [];
        $is_hidden = false;
        foreach ($r['items'] as $i) {
            $mediaObject = new Pressmind\ORM\Object\MediaObject($i['id_media_object'], false, (!empty($_GET['no_cache']) || !empty($_GET['update_cache'])));
            if(empty($_GET['preview']) && !in_array($mediaObject->visibility, [30,60])) {
                continue;
            }
            $id_media_objects[] = $i['id_media_object'];
            if(!empty($_GET['update_cache'])){
                $mediaObject->updateCache($i['id_media_object']);
            }
            if($mediaObject->isCached()){
                $mediaObjectCachedKeys[] = $mediaObject->getCacheInfo();
            }
            if($mediaObject->visibility == 60){
                $is_hidden = true;
            }
            $mediaObjects[] = $mediaObject;
        }
        if (empty($id_media_objects) === true) {
            WPFunctions::throw404(410, 'requested objects ('.implode(',', $id_media_objects).') are not valid, visibility must be 30 or 60');
        }
        // Add custom headers, for better debugging
        header('X-TS-id-pressmind: ' . implode(',', $id_media_objects));
        // set cache headers  (remove in strong production env)
        if(count($mediaObjectCachedKeys) > 0){
            $cached_dates = [];
            $cached_keys = [];
            foreach ($mediaObjectCachedKeys as $mediaObjectCachedKey){
                $cached_dates[] = $mediaObjectCachedKey['date'];
                $cached_keys[] = $mediaObjectCachedKey['key'];
            }
            header('X-TS-Object-Cache: ' . implode(',', $cached_keys).' ; '.implode(',', $cached_dates));
        }
        // Add meta data
        $args = [
            'media_objects' => $mediaObjects
        ];
        $meta_description = Template::render(APPLICATION_PATH . '/template-parts/micro-templates/meta-description-detail.php', $args);
        $the_title = Template::render(APPLICATION_PATH . '/template-parts/micro-templates/meta-title-detail.php', $args);
        add_filter('pre_get_document_title', function ($title_parts) use ($the_title) {
            return $the_title;
        });
        add_action('wp_head', function () use ($meta_description) {
            echo $meta_description;
        });
        // set canonical url
        $canonical = '<link rel="canonical" href="' . site_url() . $mediaObjects[0]->getPrettyUrl() . '">' . "\r\n";
        add_action('wp_head', function () use ($canonical) {
            echo $canonical;
        });
        // set alternate languages
        if(MULTILANGUAGE_SITE){
            add_action('wp_head', function () use ($mediaObjects) {
                foreach($mediaObjects[0]->getPrettyUrls() as $url){
                    echo '<link rel="alternate" hreflang="'.$url->language.'" href="'.SITE_URL.$url->route.'" />'."\r\n";
                }
            });
        }
        // index or not?
        if($is_hidden){
            header('X-TS-hidden: true');
            add_action('wp_head', function () use ($canonical) {
                echo '<meta name="robots" content="noindex, nofollow">';
            });
        }
        $wp_query->set('media_objects', $mediaObjects);
        add_filter( 'body_class', function( $classes ) {
            $classes[] = 'pm-detail-page';
            return $classes;
        });
        return;

    } catch (\Exception $e) {
        echo $e->getMessage();
    }

}

add_action('ts_detail_hook', 'ts_detail_hook');


function ts_search_hook($data)
{
    global $wp, $wp_query, $post;

    $post = null;

    // TODO
    $data['language'] = 'de';

    // Add meta data
    // set the page title
    if (empty($data['title']) === false) {
        $the_title = $data['title'];
        add_filter('pre_get_document_title', function ($title_parts) use ($the_title) {
            return $the_title;
        });
    }

    // set meta description
    if (empty($data['meta_description']) === false) {
        $meta_desc = '<meta name="description" content="' . $data['meta_description'] . '">' . "\r\n";
        add_action('wp_head', function () use ($meta_desc) {
            echo $meta_desc;
        });
    }

    // set canonical url
    $canonical = '<link rel="canonical" href="' . site_url() . '/' . $wp->request . '/">' . "\r\n";
    add_action('wp_head', function () use ($canonical) {
        echo $canonical;
    });


    /* @TODO set alternate languages (sdk function is missing at this moment)
    if(MULTILANGUAGE_SITE){
        add_action('wp_head', function () use ($data) {
           echo '<link rel="alternate" hreflang="" href="" />'."\r\n";
        });
    }
     */

    // set the id of the current media object as wp parameter
    $wp_query->set('pm-ot', is_array($data['id_object_types']) ? implode(',', $data['id_object_types']) : $data['id_object_types']);
    $wp_query->set('pm-o', $data['order']);
    add_filter( 'body_class', function( $classes ) {
        $classes[] = 'pm-search-page';
        return $classes;
    });
    return;
}

add_action('ts_search_hook', 'ts_search_hook');

function ts_calendar_hook($data)
{
    global $wp, $wp_query, $post;

    $post = null;

    try {

        if (MULTILANGUAGE_SITE) {
            $route = preg_replace('(^' . $data['language'] . '\/)', '', $wp->request);
        } else {
            $route = $wp->request;
        }


        // Add meta data
        // set the page title
        $the_title = $data['title'];
        $meta_description = $data['meta_description'];

        /**
         * If you need meta data from custom fields, use this code example.
         * Be aware:
         * if you have multiple media object types, you have to switch this for each object type if the properties have not the same names
         */
        //$moc = $mediaObjects[0]->getDataForLanguage(TS_LANGUAGE_CODE);
        //$the_title = strip_tags((string)$moc->title_default);
        //$meta_description = strip_tags((string)$moc->meta_description_default);


        add_filter('pre_get_document_title', function ($title_parts) use ($the_title) {
            return $the_title;
        });

        // set meta description
        $meta_desc = '<meta name="description" content="' . $meta_description . '">' . "\r\n";
        add_action('wp_head', function () use ($meta_desc) {
            echo $meta_desc;
        });

        /*
        // set canonical url
        $canonical = '<link rel="canonical" href="' . site_url() . $mediaObjects[0]->getPrettyUrl() . '">' . "\r\n";
        add_action('wp_head', function () use ($canonical) {
            echo $canonical;
        });
        */

        /*
        // set alternate languages
        if(MULTILANGUAGE_SITE){
            add_action('wp_head', function () use ($mediaObjects) {
                foreach($mediaObjects[0]->getPrettyUrls() as $url){
                    echo '<link rel="alternate" hreflang="'.$url->language.'" href="'.SITE_URL.$url->route.'" />'."\r\n";
                }
            });
        }
        */

        //$wp_query->set('media_objects', $mediaObjects);
        add_filter( 'body_class', function( $classes ) {
            $classes[] = 'pm-calendar-page';
            return $classes;
        });
        return;

    } catch (\Exception $e) {
        echo $e->getMessage();
    }

}

add_action('ts_calendar_hook', 'ts_calendar_hook');
