<?php

ini_set('display_errors', 'On');
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Init
if (php_sapi_name() !== 'cli') {
    die("Meant to be run from command line");
}

function find_wordpress_base_path()
{
    $dir = dirname(__FILE__);
    do {
        //it is possible to check for other files here
        if (file_exists($dir . "/wp-config.php")) {
            return $dir;
        }
    } while ($dir = realpath("$dir/.."));
    return null;
}

$wp_path = find_wordpress_base_path() . "/";

define('WP_USE_THEMES', false);

require_once($wp_path . 'wp-load.php');

global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;

if ( ! function_exists( 'wp_crop_image' ) ) {
    include(ABSPATH . 'wp-admin/includes/image.php');
}

$param = getopt("", array('id:', 'all'));

if (isset($param['id']) === true) {
    echo 'regenerate image derivates from attachment/post id' . $param['id'] . "\r\n";
    RegenerateImages::run((int)$param['id']);
    exit;
} else if (isset($param['all']) === true) {
    echo 'regenerate all image derivates' . "\r\n";
    RegenerateImages::run();
    exit;
} else {
    echo 'usage:' . "\r\n";
    echo '--id    example: php regenerate-images.php --id=123     regenerates only the specified wordpress attachment image derivates  ' . "\r\n";
    echo '--all   example: php regenerate-images.php --all        regenerate image derivates from the whole media library ' . "\r\n";
    exit;
}

class RegenerateImages{


    public static function get_all_uploads()
    {
        global $wpdb;
        $attachments = $wpdb->get_results("SELECT ID FROM {$wpdb->posts} p WHERE post_type = 'attachment'");
        $attachments = array_map(function ($o) {
            return $o->ID;
        }, $attachments);

        return $attachments;
    }


    public static function run($post_id = null){

        /**
         * @var PM_Stateless $PM_Stateless
         */
        global $PM_Stateless;

        if (empty($post_id) === true) {
            $attachments = self::get_all_uploads();
        } else {
            $attachments[] = $post_id;
        }


        foreach ($attachments as $post_id) {

            $file = get_attached_file($post_id);


            // Support pressmind® Statelesse S3 Plugin
            if(empty($PM_Stateless) === false){
                $is_on_s3 = (bool)get_post_meta($post_id, 'is_on_s3', true);
                if($is_on_s3 === true){

                    // Download the Attachment first.
                    $url = wp_get_attachment_image_url($post_id);
                    $upload_dir = wp_upload_dir();
                    set_time_limit(0);
                    $file = $upload_dir['basedir'].'/'.basename($file);
                    $fp = fopen ($file, 'w+');
                    $ch = curl_init(str_replace(" ","%20",$url));
                    curl_setopt($ch, CURLOPT_TIMEOUT, 50);
                    curl_setopt($ch, CURLOPT_FILE, $fp);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    $data = curl_exec($ch);
                }

            }


            if(empty($file) === true || file_exists($file) === false){
                echo "> error: file not found: ".$file."\r\n";
                continue;
            }

            echo "> regenerate image for post/attachment id: " . $post_id . ' ('.basename($file).")\r\n";

            // Generate new thumbs
            $meta = wp_generate_attachment_metadata( $post_id, $file);
            wp_update_attachment_metadata( $post_id, $meta );

        }

        return true;

    }

}






