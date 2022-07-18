<?php
/**
 * @TODO: use a fulltext search engine, like lucence
 * @TODO: add categories
 * this file is required in pm-ajax-endpoint.php
 */

$output = new stdClass();
$output->suggestions = [];
$suggestionsSorted = [];
// Categories
$categories = $args['categories']['zielgebiet_default'];

foreach($args['params'] as $param) {
    if($param->type == 'media_object') {
        foreach($args['items'] as $key => $item) {
            $suggestion = new stdClass();
            $suggestion->type = $param->type;
            $suggestion->value = $item[$param->mongo_fieldname];
            $suggestion->img = $item['image']['url'];
            $suggestion->price = $item['cheapest_price']->price_total;
            $suggestion->data = new stdClass();
            $suggestion->data->q = $_GET['pm-t'];
            $suggestion->data->search_request = '';
            $suggestion->data->category = $param->name;
            $suggestion->data->type = 'link';
            $suggestion->data->url = SITE_URL . $item['url'];
            $suggestionsSorted[$item['id_object_type']][] = $suggestion;
        }
    }
    if($param->type == 'category_tree') {
        foreach($args['categories'] as $key => $cat) {
            if($key == $param->fieldname) {
                foreach($cat as $key2 => $catItem) {
                    foreach($catItem as $key3 => $catResult) {
                        if($catResult->count_in_search > 0) {
                            $suggestion = new stdClass();
                            $suggestion->type = $param->type;
                            $suggestion->value = implode(' › ', (array) $catResult->path_str);
                            $suggestion->data = new stdClass();
                            $suggestion->data->q = $_GET['pm-t'];
                            $suggestion->data->search_request = '';
                            $suggestion->data->category = $param->name;
                            $suggestion->data->type = 'link';
                            $suggestion->data->url = site_url() . '/' . $searchRoute . '/?pm-c['.$param->fieldname.']='.$catResult->id_item;
                            $suggestionsSorted[$catResult->name][] = $suggestion;
                        }
                    }
                }
            }
        }
    }
    if($param->type == 'wordpress') {
        $args = $param->args;
        $query = new WP_Query( $args );
        if($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();
                if(stripos(get_the_title(), $_GET['pm-t']) !== false) {
                    $suggestion = new stdClass();
                    $suggestion->type = $param->type;
                    $suggestion->value = get_the_title();
                    $suggestion->data = new stdClass();
                    $suggestion->data->q = $_GET['pm-t'];
                    $suggestion->data->search_request = '';
                    $suggestion->data->category = $param->name;
                    $suggestion->data->type = 'link';
                    $suggestion->data->url = get_permalink(); // TODO Generate URL
                    $suggestionsSorted[get_the_ID()][] = $suggestion;
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
    if (strpos(strtolower($month), strtolower($_GET['pm-t'])) === 0) {
        $suggestion = new stdClass();
        $suggestion->value = 'Reisen im ' . $month;
        $suggestion->data = new stdClass();
        $suggestion->data->q = $_GET['pm-t'];
        $date = new DateTime();
        $date->setDate($date->format('Y'), ($k + 1), 1);
        $suggestion->data->search_request = 'pm-dr=' . $date->format('Ymd') . '-' . $date->format('Ymt');
        $suggestion->data->category = 'Reisezeiten';
        $suggestion->data->type = 'search';
        $output->suggestions[] = $suggestion;
    }
}

foreach($suggestionsSorted as $key => $suggestionGroup) {
    foreach ($suggestionGroup as $key2 => $suggestion) {
        $output->suggestions[] = $suggestion;
    }
}

if (count($output->suggestions) == 0) {
    $suggestion = new stdClass();
    $suggestion->value = 'Keine Reisen gefunden';
    $suggestion->data = new stdClass();
    $suggestion->data->q = $_GET['pm-t']; // @TODO works?
    $suggestion->data->category = '';
    $suggestion->data->type = 'nothing_found';
    $suggestion->data->category = 'Es tut uns leid';
    $output->suggestions[] = $suggestion;
}
sleep(0.25);
echo json_encode($output);

