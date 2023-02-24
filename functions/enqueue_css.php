<?php

add_action('wp_head', function(){
    wp_enqueue_style('main-style', get_template_directory_uri().'/assets/scss/app.min.css?'.filemtime(get_template_directory() . '/assets/scss/app.min.css'));
}, 0);

add_action('wp_head', function(){
    wp_add_inline_style( 'main-style', file_get_contents(realpath(__DIR__.'/../../../../wp-includes/css/dist/block-library/style.min.css')));
}, 1);


/* to improve lighthouse speed, try to put all "above the fold styles" in this inline css, and put the scripts above in the footer
add_action('wp_head', function () {
    echo '<style>'.file_get_contents(get_stylesheet_directory().'/assets/scss/app.critical.min.css').'</style>';
}, 1);
*/