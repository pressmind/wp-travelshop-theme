<?php
error_reporting(-1);
ini_set('display_errors', 'on');
/**
 ** Create a symbolic link to this file from your wp-content directory and
 * on osx:
 * --
 * cd /var/www/vhosts/travelshop-theme.de/wp-content/
 * ln -s /var/www/vhosts/travelshop-theme.de/wp-content/themes/travelshop/advanced-cache.php wp-content/advanced-cache.php
 * --
 * enable page caching in your wp-config.php = WP_CACHE = true

 *
 * Put this constants to wp-config
 * define('PM_REDIS_HOST', '127.0.0.1');
 * define('PM_REDIS_PORT', '6379');
 * define('PM_REDIS_TTL', 48000); // seconds
 * define('PM_REDIS_BACKGROUND_KEY_REFRESH', 1000); // seconds
 * define('PM_REDIS_DEBUG', TRUE);
 * define('PM_REDIS_GZIP', TRUE);
 * define('PM_REDIS_KEY_PREFIX', 'fpc');
 * define('PM_REDIS_ACTIVATE', true);
 *
 * Redis CLI Commands:
 * Start Redis Server:  redis-server
 * Get all keys:        redis-cli keys "*"
 * Get key:             redis-cli get KEY
 * Delete key:          redis-cli del KEY
 * Flush all:           redis-cli flushall
 *
 * try redis-commander - a nice debugging gui
 *
 * Use this GET vars
 * cache-refresh=1 will renew the cache
 * no-cache=1 will display the page without cache
 */

if (!defined('ABSPATH')) {
    die();
}
require_once 'src/RedisPageCache.php';
if(defined('PM_REDIS_ACTIVATE') === true && PM_REDIS_ACTIVATE === true) {
    RedisPageCache::cache_init();
}