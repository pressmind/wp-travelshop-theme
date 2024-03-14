<?php

/**
 * This function is based on wp load_template(), but makes use of the wp transient caching
 *
 * @param string $_template_file Path to template file.
 * @param bool   $require_once   Whether to require_once or require. Default true.
 * @param array  $args           Optional. Additional arguments passed to the template.
 *                               Default empty array.
 */
function load_template_transient( $_template_file, $require_once = true, $args = array(), $expiration = TS_TTL_TRANSIENTS) {
    global $id_object_type;

    $transient = 'ts_template_transient_'.md5(serialize( [$_template_file, $args, $id_object_type]));
    if (($output = get_transient( $transient)) === false || is_admin_bar_showing() === true
        || is_user_logged_in() === true || !empty($_GET['debug']) || $expiration === 0) {
        ob_start();
        load_template($_template_file, $require_once, $args);
        $output = ob_get_contents();
        ob_end_clean();
        set_transient($transient, $output, $expiration);
    }

    echo $output;

}