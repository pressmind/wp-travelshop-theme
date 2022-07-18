<?php
// Adding Meta-Box to Posts
function meta_box_markup($post) {
    wp_nonce_field(basename(__FILE__), "noindex_nonce");
    wp_nonce_field(basename(__FILE__), "nocache_nonce");
    $checkbox_stored_meta = get_post_meta( $post->ID );

    ?>

    <label style="display: inline-block; margin-bottom: .5rem;" for="_noindex_check">
        <input type="checkbox" name="_noindex_check" id="_noindex_check" value="yes" <?php if ( isset ( $checkbox_stored_meta ['_noindex_check'] ) ) checked( $checkbox_stored_meta['_noindex_check'][0], 'yes' ); ?> />
        <?php _e( 'Set to noindex', 'checkbox-meta' )?>
    </label>
    <br />
    <label for="_nocache_check">
        <input type="checkbox" name="_nocache_check" id="_nocache_check" value="yes" <?php if ( isset ( $checkbox_stored_meta ['_nocache_check'] ) ) checked( $checkbox_stored_meta['_nocache_check'][0], 'yes' ); ?> />
        <?php _e( 'Disable caching', 'checkbox-meta' )?>
    </label>

    <?php

}

/**
 *  Save metabox markup per post/page
 *
 * @since 1.2.0
 */

function save_custom_meta_box( $post_id ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'noindex_nonce' ] ) && wp_verify_nonce( $_POST[ 'noindex_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
    $nocache_nonce = ( isset( $_POST[ 'nocache_nonce' ] ) && wp_verify_nonce( $_POST[ 'nocache_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }


    // Checks for input and saves
    if( isset( $_POST[ '_noindex_check' ] ) ) {
        update_post_meta( $post_id, '_noindex_check', 'yes');
    }
    else {
        update_post_meta( $post_id, '_noindex_check', '' );
    }

    // Checks for input and saves
    if( isset( $_POST[ '_nocache_check' ] ) ) {
        update_post_meta( $post_id, '_nocache_check', 'yes');
    }
    else {
        update_post_meta( $post_id, '_nocache_check', '' );
    }
}
add_action('save_post', 'save_custom_meta_box', 10, 2);


/**
 *  Add Metabox per post/page and any registered custom post type
 *
 * @since 1.2.0
 */
function add_custom_meta_box() {

    $post_types = get_post_types();
    foreach ( $post_types as $post_type ) {
        add_meta_box('checkbox-meta-box', __('Index / Cache', 'checkbox-meta'), 'meta_box_markup', $post_types, 'side', 'default', null);
    }
}
add_action('add_meta_boxes', 'add_custom_meta_box');

function do_the_noindex($robots){
    global $post;
    if(isset($post->ID) && isset(get_post_meta( $post->ID )['_noindex_check'][0])) {
        $noindex = get_post_meta( $post->ID )['_noindex_check'][0];
    }
    if( isset($noindex) && $noindex == 'yes'  ) {
        $robots['noindex'] = true;
        $robots['nofollow'] = true;
    }
    return $robots;
}

add_filter( 'wp_robots', 'do_the_noindex' );

function do_the_nocache() {
    global $post;
    if(isset($post->ID) && isset(get_post_meta( $post->ID )['_nocache_check'][0])) {
        $nocache = get_post_meta( $post->ID )['_nocache_check'][0];
    }
    if( isset($nocache) && $nocache == 'yes'  ) {
        define('DONOTCACHE', true);
    }
}
add_action( 'template_redirect', 'do_the_nocache' );

?>