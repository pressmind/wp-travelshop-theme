<?php
if(defined('SAVEQUERIES') && SAVEQUERIES){
    add_action('shutdown', function(){
        global $wpdb;
        $log_file = fopen(ABSPATH.'/wordpress_queries.txt', 'a');
        echo $log_file;
        fwrite($log_file, "//////////////////////////////////////////\n\n" . date("F j, Y, g:i:s a")."\n");
        foreach($wpdb->queries as $q) {
            fwrite($log_file, $q[0] . " - ($q[1] s)" . "\n\n");
        }
        fclose($log_file);
    });
}