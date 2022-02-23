<?php
/**
 * Setup PHP Environment
 */

if(defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY === true) {
    error_reporting(-1);
    ini_set('display_errors', 'On');
    ini_set('max_execution_time', 600);
}

/**
 * the web-path to the wordpress installation, do not set wordpress function like site_url() here.
 * because of the pm-ajax-endpoint.php which is running without a WordPress Bootstrap
 * during installation (install.php) this value will be set to wordpress's site_url()
 */

define('SITE_URL', getenv('SITE_URL'));

/**
 * Url to the pressmind IB3 if used
 */
define('TS_IBE3_BASE_URL', getenv('TS_IBE3_BASE_URL'));
define('TS_IBE3_CHECK_AVAILABILITY_URL', getenv('TS_IBE3_CHECK_AVAILABILITY_URL'));

/**
 * Demo mode, current function
 * - create random data in checkAvailability()
 */
define('TS_DEMO_MODE', true);


// Activate multilanguage support
// one big change is the routing, if multilanguage, all routes have the language code as prefix:
// domain.de/de/reisen/schoene-reise/ instead of domain.de/reisen/schoene-reise/
// also we have alternate language html header
define('MULTILANGUAGE_SITE', false);

if(MULTILANGUAGE_SITE === true){
    // Support for WPML multilanguage, if no lang is set, we set a default:
    if(defined('ICL_LANGUAGE_CODE')){

        /* if the language codes are different between wmpl and pressmind, you can build a map like this
        $language_map = ['de-de' => 'de', 'en-gb' => 'en'];
        define('TS_LANGUAGE_CODE', $language_map[ICL_LANGUAGE_CODE]);
        */

        define('TS_LANGUAGE_CODE', ICL_LANGUAGE_CODE);
    }else{
        define('TS_LANGUAGE_CODE', 'de');
    }
}else{
    define('TS_LANGUAGE_CODE', null);
}
/**
 * we' have to renormalize the generic pressmind entities,
 * so it would be a easier handling in this shop context
 * @todo at this moment you have to configure this manually!! pressmind change request #130757
 *          the theme supports only TS_TOUR_PRODUCTS at this moment

 */
define('TS_TOUR_PRODUCTS', null);
define('TS_HOTEL_PRODUCTS', null);
define('TS_HOLIDAYHOMES_PRODUCTS', null);
define('TS_DAYTRIPS_PRODUCTS', null);
define('TS_DESTINATIONS', null);

/**
 * Setup the search routes for each media object type by language
 * <code>
 * define('TS_SEARCH_ROUTES', [
 *  TS_TOUR_PRODUCTS => [
 *      '{LANGUAGE_CODE|default}' => [
 *          'route' => 'reise-suche',
 *          'title' => 'Reise Suche - Travelshop',
 *          'meta_description' => ''
 *      ],
 *  ],
 *  TS_DAYTRIPS_PRODUCTS => [
 *      ...
 *  ],
 * ]);
 * </code>
 *
 */
define('TS_SEARCH_ROUTES', []);



/**
 * If your using the blogfeature it's recommend to enable this two auto generated pagetypes
 * if you dont use the blog feature set this pages to false, to avoid unvalid pages in the search engine indexes
 */
define('BLOG_ENABLE_AUTHORPAGE', true);
define('BLOG_ENABLE_CATEGORYPAGE', true);

/**
 * Default visibility level
 * 30 = public
 * 10 = nobody
 * In some development cases it's required to add a other visibility than public (30)
 */
define('TS_VISIBILTY', [30]);


/**
 * the possible category tree item search fields
 * used in this files:
 *  /template-parts/pm-search/search-bar.php
 *  /template-parts/pm-search/search-bar-plain.php
 * .. to draw the primary search bars.
 * <code>
 * define('TS_SEARCH', [
 *      TS_TOUR_PRODUCTS => [
 *          [ 'id_tree' => 1207, 'fieldname' => 'zielgebiet_default', 'name' => 'Zielgebiet', 'condition_type' => 'c'],
 *          [ 'id_tree' => 1206, 'fieldname' => 'reiseart_default', 'name' => 'Reiseart', 'condition_type' => 'c'],
 *      ],
 *      TS_DAYTRIPS_PRODUCTS => [
 *          [ 'id_tree' => 1207, 'fieldname' => 'zielgebiet_default', 'name' => 'Zielgebiet', 'condition_type' => 'c'],
 *          [ 'id_tree' => 1206, 'fieldname' => 'reiseart_default', 'name' => 'Reiseart', 'condition_type' => 'c'],
 *      ]
 * ]);
 * </code>
 *
 *
 */

define('TS_SEARCH', []);

/**
 * @TODO ebene rein für type
 * the possible category tree item filters
 * used in /template-parts/pm-search/filter-vertical.php to draw the filter list.
 * <code>
 * define('TS_FILTERS', [
[ 'id_tree' => 1207, 'fieldname' => 'zielgebiet_default', 'name' => 'Zielgebiet', 'condition_type' => 'c'],
[ 'id_tree' => 1206, 'fieldname' => 'reiseart_default', 'name' => 'Reiseart', 'condition_type' => 'c'],
[ 'id_tree' => 2655, 'fieldname' => 'befoerderung_default', 'name' => 'Beförderung', 'condition_type' => 'c'],
[ 'id_tree' => 1204, 'fieldname' => 'saison_default', 'name' => 'Saison', 'condition_type' => 'c'],
// Example of a category tree from a sub object
[ 'id_tree' => 1205, 'fieldname' => 'sterne_default', 'name' => 'Hotelkategorie', 'condition_type' => 'cl'],
]);
 * </code>
 */
define('TS_FILTERS', []);

/**
 * Price Format (number_format() is used for rendering)
 */

define('TS_PRICE_DECIMAL_SEPARATOR', ',');
define('TS_PRICE_THOUSANDS_SEPARATOR', '.');
define('TS_PRICE_DECIMALS', 0);
define('TS_PRICE_CURRENCY', '€');

/**
 * enum (RIGHT, LEFT)
 */
define('TS_PRICE_CURRENCY_POSITION', 'RIGHT');


/**
 * Pagebuilder support
 * set to 'beaverbuilder' to load theme specific bb-modules
 * leave empty if no pagebuilder is not used.
 * at this moment we support only beaverbuilder
 */
define('PAGEBUILDER', 'beaverbuilder');


/**
 * Google MAPS API Key
 * The following templates/modules are using this kex, with the following registered google services:
 *
 * template-parts/pm-views/*_Detail1.php
 *  - Maps JavaScript API
 *  - Maps Static API
 *
 * Create your api key here: https://console.cloud.google.com/apis/credentials
 *
 */
define('TS_GOOGLEMAPS_API', '');

/**
 * Send E-Mails via SMTP AUTH
 */
define( 'TS_SMTP_ACTIVE', false);
define( 'TS_SMTP_USER', '');
define( 'TS_SMTP_PASS', '');
define( 'TS_SMTP_HOST', '');
define( 'TS_SMTP_FROM_EMAIL', '');
define( 'TS_SMTP_FROM_NAME', '');
define( 'TS_SMTP_PORT', 25);
define( 'TS_SMTP_SECURE', 'tls'); // ssl | tls
define( 'TS_SMTP_AUTH', true);
define( 'TS_SMTP_DEBUG',0 );



/**
 * Define WordPress Images here
 *
 * You can add ore remove image sizes, but you can not remove the default
 * types like (post_thumbnail, thumbnail, medium, large)
 *
 * if you edit the values, you have to recreate the images:
 *  run: php travelshop/cli/regenerate-images.php --all` on your cli
 *      to set the images sizes in the wp-options table
 *      and than renew the image derivates

 *
 * image sizes are planned for a viewport of 1140px width
 * image ratio 1.6
 * the "thumb"-size is used for a 4 columns
 * the "medium"-size is used for a 3 columns
 * the "large"-size is used for 75% of the viewport (9/12)
 * the ungropped original version are also present in each format
 */

define('TS_WP_IMAGES', [

    'post_thumbnail' => [ // default type, do not remove
        'w' => 255,
        'h' => 159,
        'crop' => 1,
        'name' => '',
    ],

    'thumbnail' => [  // default type, do not remove
        'w' => 255,
        'h' => 159,
        'crop' => 1,
        'name' => ''
    ],

    'medium' => [  // default type, do not remove
        'w' => 350,
        'h' => 218,
        'crop' => 1,
        'name' => ''
    ],

    'large' => [  // default type, do not remove
        'w' => 825,
        'h' => 515,
        'crop' => 1,
        'name' => 'Large'
    ],

    'thumbnail_original' => [
        'w' => 255,
        'h' => null,
        'crop' => 0,
        'name' => 'Thumbnail (uncropped)'
    ],

    'medium_original' => [
        'w' => 350,
        'h' => null,
        'crop' => 0,
        'name' => 'Medium (uncropped)'
    ],

    'large_original' => [
        'w' => 825,
        'h' => null,
        'crop' => 0,
        'name' => 'Large (uncropped)'
    ],

    'bigslide' => [
        'w' => 1980,
        'h' => null,
        'crop' => 0,
        'name' => 'Bigslide (uncropped)'
    ],

]);


/**
 * Prevent the user from uploading images in the worppress image gallery that breaking the rules of a performant website.
 * The value defines the max size in kilobyte of one image upload
 */
define('TS_WP_IMAGE_MAX_UPLOAD_SIZE', 500);

/**
 * All images are reduced to this size if a image is bigger than the defined value
 * The value defines the max size in pixel an image can have in this installation
 * If the image is bigger than defined, we reduce the image size to this value
 * You have to set this value to the max image image format, as defined in TS_WP_IMAGES
 */
define('TS_WP_IMAGE_ORIGINAL_RESIZE_TO', 1980);

/**
 * Enables WEBP support. jpeg images will be generated with the internal php function imagewebp()
 */
define('TS_WP_IMAGE_WEBP_ENABLED', TRUE);
define('TS_WP_IMAGE_WEBP_QUALITY', 80);


/**
 * Enables Cookie Consent
 * Set UA ID for Google Tag Manager
 */
define('TS_COOKIE_CONSENT', TRUE);
define('TS_GOOGLETAGMANAGER_UA_ID', 'UA-1234-1');


/**
 * Marks departure dates in the datepicker control (these dates are usually styled green)
 */
define('TS_CALENDAR_SHOW_DEPARTURES', true);

/**
 * @TODO not implemented yet
 * Enables routes based on categpry-trees
 * Example Tree: Deutschland > Sauerland > Schmallenberg
 * Created route: site.de/deutschland/sauerland/schmallenberg
 */
define('TS_LANDINGPAGE', [
    ['type' => 'categorytree', 'id_tree' => 1207, 'fieldname' => 'zielgebiet_default'],
    ['type' => 'categorytree', 'id_tree' => 1206, 'fieldname' => 'reiseart_default'],
]);


/**
 * Cache time in seconds of a search result, (redis-cache/MONGODB must be enabled in the pressmind sdk)
 */
define('TS_TTL_SEARCH', 0);

/**
 * Cache time in seconds of a search-filter result, (redis-cache/MONGODB must be enabled in the pressmind sdk)
 */
define('TS_TTL_FILTER', 0);