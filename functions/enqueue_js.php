<?php
if (!is_admin()) {
    add_filter('script_loader_tag', function ($tag, $handle) {
        if (strpos($handle, 'async') !== false) {
            return str_replace('\'>', '\' async>', $tag);
        } else if (strpos($handle, 'defer') !== false) {
            return str_replace('\'>', '\' defer>', $tag);
        } else {
            return $tag;
        }
    }, 10, 2);
}

add_action('wp_enqueue_scripts', function () {

    $js_files = array();
    $js_files[] = array('handle' => 'prettydropdowns', 'dependencies' => ['jquery'], 'src' => '/assets/js/jquery.prettydropdowns.min.js', 'defer' => true, 'version' => '4.17.0');
    $js_files[] = array('handle' => 'popper', 'dependencies' => ['jquery'], 'src' => '/assets/js/popper-1.14.7.min.js', 'defer' => true, 'version' => '1.14.7');
    $js_files[] = array('handle' => 'bootstrap', 'dependencies' => ['jquery'], 'src' => '/assets/js/bootstrap.min.js', 'defer' => true, 'version' => '4.3.1');
    $js_files[] = array('handle' => 'pulltorefresh', 'dependencies' => ['jquery'], 'src' => '/assets/js/pulltorefresh.min.js', 'defer' => true, 'version' => '0.1.22');
    $js_files[] = array('handle' => 'bodyscrolllock', 'dependencies' => ['jquery'], 'src' => '/assets/js/bodyScrollLock.min.js', 'defer' => true, 'version' => '1.0');
    $js_files[] = array('handle' => 'dayjs-pack', 'dependencies' => ['jquery'], 'src' => '/assets/js/dayjs-1.10.6.pack.min.js', 'defer' => true, 'version' => '1.10.6');
    $js_files[] = array('handle' => 'daterangepicker', 'dependencies' => ['jquery'], 'src' => '/assets/js/daterangepicker.min.js', 'defer' => true, 'version' => filemtime(get_template_directory() . '/assets/js/daterangepicker.min.js'));
    $js_files[] = array('handle' => 'autocomplete', 'dependencies' => ['jquery'], 'src' => '/assets/js/autocomplete.min.js', 'defer' => true, 'version' => '1.4.10');
    $js_files[] = array('handle' => 'rangeslider', 'dependencies' => ['jquery'], 'src' => '/assets/js/ion.rangeSlider.min.js', 'defer' => true, 'version' => '2.3.1');
    $js_files[] = array('handle' => 'tiny-slider', 'dependencies' => ['jquery'], 'src' => '/assets/js/tiny-slider.min.js', 'defer' => true, 'version' => '2.9.3');
    $js_files[] = array('handle' => 'lightbox', 'dependencies' => ['jquery'], 'src' => '/assets/js/lightbox.min.js', 'defer' => true, 'version' => '1.0.0');
    $js_files[] = array('handle' => 'travelshop-ui', 'dependencies' => ['jquery'], 'src' => '/assets/js/ui.min.js', 'defer' => true, 'version' => filemtime(get_template_directory() . '/assets/js/ui.min.js'));
    $js_files[] = array('handle' => 'travelshop-search', 'dependencies' => ['jquery'], 'src' => '/assets/js/search.min.js', 'defer' => true, 'version' => filemtime(get_template_directory() . '/assets/js/search.min.js'));
    $js_files[] = array('handle' => 'travelshop-ajax', 'dependencies' => ['jquery'], 'src' => '/assets/js/ajax.min.js', 'defer' => true, 'version' => filemtime(get_template_directory() . '/assets/js/ajax.min.js'));
    $js_files[] = array('handle' => 'instant-page', 'dependencies' => ['jquery'], 'src' => '/assets/js/instant.page.min.js', 'defer' => true, 'version' => '5.1.0');

    foreach ($js_files as $f) {

        if ($f['defer']) {
            $f['handle'] .= '-defer';
        }

        wp_enqueue_script($f['handle'], get_stylesheet_directory_uri() . $f['src'], $f['dependencies'], $f['version'], true);
    }


});