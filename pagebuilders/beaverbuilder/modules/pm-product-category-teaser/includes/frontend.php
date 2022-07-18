<?php
/**
 * @var object $settings defined by beaver builder module
 */

$args = [];
$args['headline'] = $settings->headline;
$args['text'] = $settings->text;
$args['view'] = 'Teaser4';
$args['teaser_count_desktop'] = $settings->teaser_count_desktop;

global $config;
foreach($settings->teasers as $teaser){
// bind the beaver builder settings to the query string api
    $search = [];
    $search['pm-ot'] = !empty($teaser->{'pm-ot'}) ? $teaser->{'pm-ot'} : ''; // id_object_type

    // ot must be set, if is empty, we display the default type for better beaver builder ux
    if(empty($search['pm-ot'])){
        $search['pm-ot'] = !empty($config['data']['primary_media_type_ids'][0]) ? $config['data']['primary_media_type_ids'][0] : array_key_first($config['data']['media_types']) ;
    }

    $search['pm-vi'] = !empty($teaser->{'pm-vi'}) ? implode(',', $teaser->{'pm-vi'}) : ''; // visibility
    $search['pm-l'] = !empty($teaser->page) && !empty($teaser->items_per_page) ? $teaser->page.','.$teaser->items_per_page : '';
    $search['pm-o'] = (!empty($teaser->order_by) && !empty($teaser->order)) ? (($teaser->order_by == 'rand') ? 'rand' : $teaser->order_by.'-'.$teaser->order): '';
    $search['pm-po'] = !empty($teaser->{'pm-po'}) ? $teaser->{'pm-po'} : ''; // id_pool
    $search['pm-t'] = !empty($teaser->{'pm-t'}) ? $teaser->{'pm-t'} : ''; // fulltext term
    $search['pm-id'] = !empty($teaser->{'pm-id'}) ? $teaser->{'pm-id'} : ''; // ids
    $search['pm-vr'] = !empty($teaser->{'pm-vr'}) ? $teaser->{'pm-vr'} : ''; // valid from, valid to range
    $search['pm-du'] = !empty($teaser->{'pm-du'}) ? $teaser->{'pm-du'} : ''; // duration range
    $search['pm-pr'] = !empty($teaser->{'pm-pr'}) ? $teaser->{'pm-pr'} : ''; // price range
    $search['pm-dr'] = !empty($teaser->{'pm-dr'}) ? $teaser->{'pm-dr'} : ''; // travel date range
    foreach($teaser as $k => $v){ // categories
        if(!empty($v) && preg_match('/^category_(?:([0-9]+))?_([0-9]+)\-([a-z0-9\_]+)$/', $k, $matches) > 0){
            $search['pm-c'][$matches[3]] = $v;
        }
    }

    // @TODO not used!
    //$args['view'] = !empty($teaser->{'pm-ot'}) ? $teaser->{'view_'. $teaser->{'pm-ot'}} : '';

    $arg_teaser = [];
    $arg_teaser['headline'] = $teaser->headline;
    $arg_teaser['text'] = $teaser->text;
    $arg_teaser['link'] = $teaser->link;
    $arg_teaser['link_target'] = $teaser->link_target;
    $arg_teaser['image'] = $teaser->image_src;
    $arg_teaser['image_alt'] = $teaser->image_alt_text;
    $arg_teaser['search'] = array_filter($search);


    $args['teasers'][] = $arg_teaser;

}


load_template_transient(get_template_directory() . '/template-parts/layout-blocks/product-category-teaser.php', false,  $args);
