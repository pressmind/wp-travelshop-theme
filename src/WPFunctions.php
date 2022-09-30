<?php
namespace Pressmind\Travelshop;

class WPFunctions{

    public static function throw404($code = 404){
        global $wp_query;
        status_header( $code );
        $wp_query->set_404();
        nocache_headers();
        include( get_query_template( '404' ) );
        die();
    }

}
