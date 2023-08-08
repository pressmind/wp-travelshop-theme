<?php
/**
 * This script can migrate the site from one domain to another domain
 * it changes all database records, known config files, flushes the
 * redis and generating an new htaccess files
 * useful for stage to production switches and so on...
 * run from cli
 */
if (php_sapi_name() !== 'cli') {
    die("Meant to be run from command line");
}

ini_set('display_errors', 'On');
error_reporting(E_ERROR | E_WARNING | E_PARSE);


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
require_once($wp_path . 'wp-admin/includes/admin.php');

global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;


$param = getopt("", array('new-site:','old-site::', 'id_blog::'));

if (isset($param['new-site']) === true) {
    Migrate::toSite($param['new-site'], !empty($param['old-site']) ? $param['old-site'] : null, !empty($param['id_blog']) ? $param['id_blog'] : null);
    exit;
} else if (isset($param['all']) === true) {
} else {
    echo 'usage:' . "\r\n";
    echo '--new-site    example: php migrate-site.php --new-site=http://wordpress.local (the old site will read from installation)' . "\r\n";
    echo '--old-site    example: php migrate-site.php --new-site=https://wordpress.de --old-site=http://wordpress.local ' . "\r\n";
    echo '--old-site    example for multisites (old-site must be set): php migrate-site.php --new-site=https://wordpress.de --old-site=http://wordpress.local --id_blog=1' . "\r\n";
    exit;

}

class Migrate{

    private static $newSite;
    private static $oldSite;
    private static $oldHome;
    private static $id_blog;


    public static function toSite($newSite, $oldsite = null, $id_blog = null)
    {
        global $wpdb;

        self::$newSite = trim($newSite,'/');
        self::$oldSite = trim(empty($oldsite) ? get_option('siteurl') : $oldsite,'/');
        self::$oldHome = trim(get_option('home'), '/');

        self::$id_blog = empty($id_blog) ? (int)get_option('id_blog') : $id_blog;
        $is_multisite = is_multisite();

        if($is_multisite && empty($id_blog)){
            echo "error: this is a multisite, set id_blog and continue\n";
            exit;
        }
        if($is_multisite){
            echo "(multisite) migrate blog id: ".$id_blog."\n";#
            if(!self::migrateMultisiteBlogTable()){
                echo "error: can not set wp_blog table\n";
                exit;
            }
            if(switch_to_blog($id_blog) === false){
                echo "error: can not switch to blog id: ".$id_blog."\n";
                exit;
            }
        }

        echo "starting migration from: \r\n";
        echo self::$oldSite." > ".self::$newSite."\r\n";
        self::migratePostmeta();
        self::migratePosts();
        self::migrateOptions();
        self::generateModRewrite();
        self::flushCaches();

        if($is_multisite){
            echo 'please check wp-config.php constant \'DOMAIN_CURRENT_SITE\' (this value must match to one of the pages)'."\n";
        }
    }

    public static function migrateOptions(){

        global $wpdb;
        $r = $wpdb->get_results("SELECT * FROM {$wpdb->options} p where option_value like '%".self::$oldSite."%'");
        foreach ($r as $option){
            $new_value = self::replacer($option->option_value);
            if($new_value != $option->option_value){
                $wpdb->update($wpdb->options, array('option_value' => $new_value), array('option_id' => $option->option_id));
                echo "option ".$option->option_name." updated \r\n";
            }
        }

    }


    public static function migratePostmeta(){

        global $wpdb;
        echo "migrate table: ".$wpdb->postmeta."\n";
        $r = $wpdb->get_results("SELECT * FROM {$wpdb->postmeta} p where meta_value like '%".self::$oldSite."%'");
        foreach ($r as $meta){
            $new_value = self::replacer($meta->meta_value);
            if($new_value != $meta->meta_value){
                $wpdb->update($wpdb->postmeta, array('meta_value' => $new_value), array('meta_id' => $meta->meta_id));
                echo "postmeta ".$meta->meta_key." updated \r\n";
            }
        }
    }

    public static function migrateMultisiteBlogTable(){
        global $wpdb;
        echo "update table: ".$wpdb->blogs." (blog id: ".self::$id_blog.") new site: ".self::$newSite."\n";
        $url = trim(str_replace(['https://www.', 'https://'], ['', ''], self::$newSite),'/');
        $r = $wpdb->update($wpdb->blogs, ['domain' => $url], ['blog_id' => self::$id_blog]);
        return !empty($r);
    }

    public static function migratePosts(){

        global $wpdb;
        echo "migrate table: ".$wpdb->posts."\n";
        $fields = array('post_content', 'post_title', 'post_excerpt', 'guid');
        $query = [];
        $query[] = "SELECT * FROM {$wpdb->posts} p where 1=1 ";
        foreach($fields as $field){
            $query[] = $field." like '%".self::$oldSite."%'";
        }

        $SQL = implode(' OR ', $query);
        $r = $wpdb->get_results($SQL);

        foreach ($r as $post){
            foreach($fields as $field){
                $new_value = self::replacer($post->{$field});
                if($new_value != $post->{$field}){
                    $wpdb->update($wpdb->posts, array($field => $new_value), array('ID' => $post->ID));
                    echo "post ".$field." updated \r\n";
                }
            }
        }

    }


    public static function replacer($value){

        if(is_serialized($value)){
            $object = unserialize($value);
            $object = self::walk_recursive($object, 'Migrate::replace');
            return serialize($object);
        }else{
            return self::replace($value);
        }

    }

    public static function replace($value){
        return str_replace(self::$oldSite, self::$newSite, $value);
    }


    public static function walk_recursive($obj, $closure) {
        if ( is_object($obj) ) {
            $newObj = new stdClass();
            foreach ($obj as $property => $value) {
                $newProperty = $closure($property);
                $newValue = self::walk_recursive($value, $closure);
                $newObj->$newProperty = $newValue;
            }
            return $newObj;
        } else if ( is_array($obj) ) {
            $newArray = array();
            foreach ($obj as $key => $value) {
                $key = $closure($key);
                $newArray[$key] = self::walk_recursive($value, $closure);
            }
            return $newArray;
        } else {
            return $closure($obj);
        }
    }

    public static function migrateConfigFiles(){

        $file = get_theme_file_path().'/config-theme.php';
        if(file_exists($file)){
            $config = file_get_contents($file);
            $config = self::setConstant('SITEURL', self::$newSite, $config);
            file_put_contents($file, $config);
            echo "$file changed (SITE_URL)\r\n";
        }


    }


    private static function setConstant($constant, $value, $str){
        return preg_replace('/(define\(\''.$constant.'\',\s*\')(.*)(\'\);)/', '$1'.$value.'$3', $str);
    }


    private static function flushCaches(){

    }


    public static function generateModRewrite(){
        global $wp_rewrite;

        // if we're on the cli, we can not check if mod_rewrite is enabled, so we think it's on
        add_filter( 'got_rewrite', function(){return true;});

        // generate a new htaccess by WordPress
        save_mod_rewrite_rules();
        echo "new htaccess generated\r\n";
    }

}