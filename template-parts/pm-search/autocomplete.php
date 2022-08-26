<?php
/**
 * this file is required in pm-ajax-endpoint.php
 * @var $args
 */



$output = new stdClass();
$output->suggestions = [];
$q = BuildSearch::sanitizeStr($_GET['pm-t']);

foreach(TS_SEARCH_AUTOCOMPLETE as $param) {
    if($param['type'] == 'media_object') {

        if($args['total_result'] > 0){
            $suggestion = new stdClass();
            $suggestion->data = new stdClass();
            $suggestion->data->q = $q;
            $suggestion->value = $args['total_result'].' Reise'.($args['total_result'] > 1 ? 'n' : '').' zu "'.$q.'" gefunden <br><span class="smaller">(Reisen anzeigen)</span>';
            $suggestion->data->type = 'link';
            $suggestion->data->category = 'found';
            $suggestion->data->url =  '/suche/?pm-t='.$q;
            $output->suggestions[] = $suggestion;
        }

        foreach($args['items'] as $key => $item) {
            $suggestion = new stdClass();
            $suggestion->type = $param['type'];
            $suggestion->value = $item[$param['mongo_fieldname']];
            $suggestion->img = $item['image']['url'];
            $suggestion->price = \Pressmind\Travelshop\PriceHandler::format($item['cheapest_price']->price_total);
            $suggestion->data = new stdClass();
            $suggestion->data->q = $q;
            $suggestion->data->search_request = '';
            $suggestion->data->category = $param['name'];
            $suggestion->data->type = 'link';
            $suggestion->data->url = SITE_URL . $item['url'];
            $output->suggestions[] = $suggestion;
        }


    }
    
    if($param['type'] == 'category_tree') {
        foreach($args['categories'] as $key => $cat) {
            if($key == $param['fieldname']) {
                foreach($cat as $key2 => $catItem) {
                    foreach($catItem as $key3 => $catResult) {
                        $str = implode(' › ', (array) $catResult->path_str). ' ('.$catResult->count_in_search.')';
                        if($catResult->count_in_search > 0 && str_contains(strtolower($str), strtolower($q))) {
                            $suggestion = new stdClass();
                            $suggestion->type = $param['type'];
                            $suggestion->value = $str;
                            $suggestion->data = new stdClass();
                            $suggestion->data->q = $q;
                            $suggestion->data->search_request = '';
                            $suggestion->data->category = $param['name'];
                            $suggestion->data->type = 'link';
                            $suggestion->data->url =  '/suche/?pm-c['.$param['fieldname'].']='.$catResult->id_item;
                            $output->suggestions[] = $suggestion;
                        }
                    }
                }
            }
        }
    }
    if($param['type'] == 'wordpress') {
        // if this file is loaded by ajax, we have to reload the wp bootstrap
        if (defined('DOING_AJAX') && DOING_AJAX === true) {
            define('WP_USE_THEMES', false);
            include(preg_replace('/wp-content.*$/', '', __DIR__) . 'wp-load.php');
            global $wpdb;
        }
        $args = $param['args'];
        $args['post_status'] = 'publish';
        $args['posts_per_page'] = 1000;
        $args['extend_where'] = "(post_title like '%".$wpdb->esc_like($q)."%')";
        $query = new WP_Query( $args );
        if($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();
                if(stripos(get_the_title(), $q) !== false) {
                    $suggestion = new stdClass();
                    $suggestion->type = $param['type'];
                    $suggestion->value = get_the_title();
                    $suggestion->data = new stdClass();
                    $suggestion->data->q = $q;
                    $suggestion->data->search_request = '';
                    $suggestion->data->category = $param['name'];
                    $suggestion->data->type = 'link';
                    $suggestion->data->url = get_permalink();
                    $output->suggestions[] = $suggestion;
                }
            }
            wp_reset_postdata();
        }
    }
}

// translate month names
$months = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni',
    'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
foreach ($months as $k => $month) {
    if (strpos(strtolower($month), strtolower($q)) === 0) {
        $suggestion = new stdClass();
        $suggestion->value = 'Reisen im ' . $month;
        $suggestion->data = new stdClass();
        $suggestion->data->q = $q;
        $date = new DateTime();
        $date->setDate($date->format('Y'), ($k + 1), 1);
        $suggestion->data->search_request = 'pm-dr=' . $date->format('Ymd') . '-' . $date->format('Ymt');
        $suggestion->data->category = 'Reisezeiten';
        $suggestion->data->type = 'search';
        $output->suggestions[] = $suggestion;
    }
}


if (count($output->suggestions) == 0) {
    $suggestion = new stdClass();
    $suggestion->value = 'Keine Reisen gefunden';
    $suggestion->data = new stdClass();
    $suggestion->data->q = $q;
    $suggestion->data->type = 'nothing_found';
    $suggestion->data->category = 'Es tut uns leid';
    $output->suggestions[] = $suggestion;
}

echo json_encode($output);

