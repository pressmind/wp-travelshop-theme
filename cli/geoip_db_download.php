<?php
error_reporting(-1);
ini_set('display_errors', 'On');
include_once '../bootstrap.php';
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
$url = 'https://download.maxmind.com/app/geoip_download?edition_id=GeoIP2-City&license_key='.MAXMIND_GEOIP_LICENSE.'&suffix=tar.gz';
$database_dir = APPLICATION_PATH.'/database';
$tmp_dir = $database_dir.'/tmp/maxmind';
@mkdir($tmp_dir, 0777, true);
file_put_contents($tmp_dir.'/geoip.tar.gz', file_get_contents($url));
$p = new PharData($tmp_dir.'/geoip.tar.gz');
$p->decompress();
$phar = new PharData($tmp_dir.'/geoip.tar');
$phar->extractTo($tmp_dir, null, true);
foreach(glob($tmp_dir.'/*/GeoIP2-City.mmdb', ) as $file){
    rename($file, $database_dir.'/GeoIP2-City.mmdb');
    break;
}
exec('rm -rf '.$tmp_dir);
echo "done, see: ".$database_dir."/GeoIP2-City.mmdb\n";