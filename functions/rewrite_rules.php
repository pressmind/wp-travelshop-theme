<?php
add_action( 'init',  function() {
    // @TODO does not work?
    add_rewrite_rule( 'service-worker\.min\.js', 'wp-content/themes/travelshop/assets/js/service-worker.min.js', 'top' );
    add_rewrite_rule( 'placeholder\.svg(.*)', 'wp-content/themes/travelshop/placeholder.svg.php$1', 'top' );
});
add_filter('mod_rewrite_rules', function ( $rules )
{
    $str = file_get_contents(get_stylesheet_directory().'/functions/default.htaccess');
    return $str."\n".$rules;
});

// flush rewrite rules after changing this lines, usage wp-cli  $ wp rewrite flush --hard --allow-root