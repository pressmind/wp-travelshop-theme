<?php

/**
 * A class that handles loading custom modules and custom
 * fields if the builder is installed and activated.
 */
class BeaverBuilderModuleLoader{

    /**
     * Setup hooks if the builder is installed and activated.
     */
    static public function init() {

        if ( ! class_exists( 'FLBuilder' ) ) {
            return;
        }

        // Load custom modules.
        add_action( 'init', __CLASS__ . '::load_modules' );
        add_action( 'init', __CLASS__ . '::ajax_handler' );

        // Register custom fields.
        //add_filter( 'fl_builder_custom_fields', __CLASS__ . '::register_fields' );

        // Enqueue custom field assets.
        //add_action( 'init', __CLASS__ . '::enqueue_field_assets' );
    }


    static public function ajax_handler(){

        // at this moment we can not extend the beaver builder autosuggest fields.
        // this simple hack captures the ajax request from the beaver builder suggest field
        if( isset($_GET['fl_builder']) && (!empty($_POST['fl_builder_data']['action']) || isset($_GET['fl_action']))){
            require_once BB_MODULE_TS_DIR . '/includes/TravelShop_BeaverBuilderAutoSuggest.php';
            TravelShop_BeaverBuilderAutoSuggest::handle();
        }
    }

    /**
     * Loads our custom modules.
     */
    static public function load_modules() {
        //require_once BB_MODULE_TS_DIR . 'modules/basic-example/basic-example.php';
        //require_once BB_MODULE_TS_DIR . 'modules/example/example.php';
        require_once BB_MODULE_TS_DIR . 'modules/wp-image-teaser/wp-image-teaser.php';
        require_once BB_MODULE_TS_DIR . 'modules/wp-info-teaser/wp-info-teaser.php';
        // require_once BB_MODULE_TS_DIR . 'modules/jumbotron/jumbotron.php';
        require_once BB_MODULE_TS_DIR . 'modules/pm-search-bar/pm-search-bar.php';
        require_once BB_MODULE_TS_DIR . 'modules/pm-search-header/pm-search-header.php';
        require_once BB_MODULE_TS_DIR . 'modules/icon-teaser/icon-teaser.php';
        require_once BB_MODULE_TS_DIR . 'modules/pm-product-teaser/pm-product-teaser.php';
        require_once BB_MODULE_TS_DIR . 'modules/pm-product-category-teaser/pm-product-category-teaser.php';
        require_once BB_MODULE_TS_DIR . 'modules/pm-month-teaser/pm-month-teaser.php';
        require_once BB_MODULE_TS_DIR . 'modules/pm-calendar/pm-calendar.php';
        require_once BB_MODULE_TS_DIR . 'modules/slider-mixed-content/slider-mixed-content.php';
        require_once BB_MODULE_TS_DIR . 'modules/history/history.php';
        require_once BB_MODULE_TS_DIR . 'modules/team/team.php';
        require_once BB_MODULE_TS_DIR . 'modules/category-header-jumbotron/category-header-jumbotron.php';
        require_once BB_MODULE_TS_DIR . 'modules/faq-schema-accordion/faq-schema-accordion.php';
    }

    /**
     * Registers our custom fields.
     */
    static public function register_fields( $fields ) {
        $fields['my-custom-field'] = BB_MODULE_TS_DIR . 'fields/my-custom-field.php';
        return $fields;
    }

    /**
     * Enqueues our custom field assets only if the builder UI is active.
     */
    static public function enqueue_field_assets() {
        if ( ! FLBuilderModel::is_builder_active() ) {
            return;
        }
        wp_enqueue_style( 'my-custom-fields', BB_MODULE_TS_URL . 'assets/css/fields.css', array(), '' );
        wp_enqueue_script( 'my-custom-fields', BB_MODULE_TS_URL . 'assets/js/fields.js', array(), '', true );
    }
}
