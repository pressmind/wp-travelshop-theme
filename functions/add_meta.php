<?php

add_action( 'wp_head', function() {
    global $post;
    if(!defined('TS_IS_DETAIL')){
        if ( is_singular() ) {
            $des_post = strip_tags( $post->post_content );
            $des_post = strip_shortcodes( $des_post );
            $des_post = str_replace( array("\n", "\r", "\t"), ' ', $des_post );
            $des_post = mb_substr( $des_post, 0, 300, 'utf8' );
            echo '<meta name="description" content="' . $des_post . '" />' . "\n";
        }
        if ( is_home() ) {
            echo '<meta name="description" content="' . get_bloginfo( "description" ) . '" />' . "\n";
        }
        if ( is_category() ) {
            $des_cat = strip_tags(category_description());
            echo '<meta name="description" content="' . $des_cat . '" />' . "\n";
        }
    }
});