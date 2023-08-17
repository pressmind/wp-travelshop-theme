<?php

use Pressmind\Travelshop\Search;
use Pressmind\Travelshop\Template;
use Pressmind\Travelshop\RouteHelper;

/**
 * <code>
 *  $args = (
 *          [headline] => [TOTAL_RESULT] Reise-Empfehlungen
 *          [text] => [TOTAL_RESULT] products found. Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip.
 *          [view] => Teaser1
 *          [link_top] => true,
 * [link_bottom] => true,
 * [link_teaser] => true,
 * [link_top_text] => 'Alle [TOTAL_RESULT] Reisen anzeigen',
 * [link_bottom_text] => 'Alle [TOTAL_RESULT] Reisen anzeigen',
 * [link_teaser_text] => 'Alle [TOTAL_RESULT] Reisen anzeigen',
 *          [search] => Array
 *                  (
 *                       [pm-ot] => 607
 *                       [pm-view] => Teaser1
 *                       [pm-vi] => 10
 *                       [pm-l] => 0,4
 *                       [pm-o] => price-desc
 *                       [...] => @link ../../docs/readme-querystring-api.md for all parameters
 *                  )
 *      )
 * </code>
 * @var array $args
 */

$page_size = 4;
if (!empty($args['search']['pm-l'])) {
    $page_size = explode(',', $args['search']['pm-l']);
    $page_size = (int)$page_size[1];
}

if (isset($_GET['pm-l'])) {
    $args['search']['pm-l'] = $_GET['pm-l'];
}

$result = Search::getResult(isset($args['search']) ? $args['search'] : [], 2, $page_size, false, false, TS_TTL_FILTER, TS_TTL_SEARCH);

if (count($result['items']) == 0) {
    if (isset($_GET['fl_builder'])) {
        ?>
        <div class="badge badge-info" style="padding: 10px;">product-teaser has zero items</div>
        <?php
    }
    return;
}
$has_more_items = count($result['items']) < $result['total_result'];
if (isset($args['has_more_items']) && $args['has_more_items'] === true) {
    $has_more_items = true;
}
$more_results_link = !empty($args['search']['pm-ot']) ? SITE_URL . '/' . trim(RouteHelper::get_url_by_object_type($args['search']['pm-ot']) . '/', '/') . '/?' . $result['query_string'] : '#ot-not-set';


$layout_type = isset($args['layout_type']) ? $args['layout_type'] : 'default';
$columns = isset($args['display_on_desktop']) ? (int)$args['display_on_desktop'] : 3;
$mobile_slider = false;
if ( !isset($args['mobile_slider']) ) {
    $args['mobile_slider'] = 'no';
}

if ( $layout_type !== 'slider' && $args['mobile_slider'] === 'yes' ) {
    $mobile_slider = true;
}

if (isset($args['pagination_bottom']) && $args['pagination_bottom'] == 'true' && $has_more_items === true) {
    $mobile_slider = false;
    $layout_type = 'default';
}

if ( !isset($args['uid']) ) {
    $args['uid'] =  (rand(0, 9999) * rand(0, 9999));
}
?>
<section id="product-teaser-<?php echo $args['uid']; ?>"
        class="content-block content-block-travel-cols">
    <?php if (!empty($args['headline']) || !empty($args['text'])){ ?>
        <div class="row row-introduction <?php if (isset($args['link_top']) && $args['link_top'] === true) { ?>align-items-baseline<?php } ?>">

            <div class="col-12 <?php if (isset($args['link_top']) && $args['link_top'] === true) { ?>col-md<?php } ?>">
                <?php if (!empty($args['headline'])) { ?>
                    <h2 class="mt-0">
                        <?php echo str_replace('[TOTAL_RESULT]', $result['total_result'], $args['headline']); ?>
                    </h2>
                <?php } ?>

                <?php if (!empty($args['text'])) { ?>
                    <p>
                        <?php echo str_replace('[TOTAL_RESULT]', $result['total_result'], $args['text']); ?>
                    </p>
                <?php } ?>
            </div>

            <?php if ($has_more_items === false) { ?>
            <?php } ?>
            <?php if (isset($args['link_top']) && $args['link_top'] === true && $has_more_items === true) { ?>
            <div class="col-12 col-md-auto pb-4">
                <a href="<?php echo $more_results_link; ?>"
                   title="<?php echo str_replace('[TOTAL_RESULT]', $result['total_result'], $args['link_top_text']); ?>"
                   class="btn-further">
                    <?php echo str_replace('[TOTAL_RESULT]', $result['total_result'], $args['link_top_text']); ?>
                    <svg style="display: none;">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                             href="/wp-content/themes/travelshop/assets/img/icon-sprite.svg#ui-icon-chevron-right"></use>
                    </svg>
                </a>
            </div>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="row row-products">
        <div class="col-12">
            <div class="position-relative">
                <?php
                $wrapper = 'row';
                $item_wrapper = 'col-12 col-md-6 col-xl-4';

                if ( $columns === 4 ) {
                    $item_wrapper = 'col-12 col-md-6 col-xl-3';
                }

                if ( $columns === 2 ) {
                    $item_wrapper = 'col-12 col-md-6';
                }

                if ( $layout_type === 'slider' ) {
                    $wrapper = 'item-slider-wrapper';
                    $item_wrapper = 'slider-item';
                }

                if ( $layout_type === 'default' && $mobile_slider ) {
                    $wrapper = 'item-slider-wrapper item-slider-wrapper--mobile';
                    $item_wrapper = 'slider-item';
                }
                ?>

                <div class="<?php echo $wrapper; ?>" data-columns="<?php echo $columns; ?>">
                    <?php

                    // Example 1: Using the the shortcode ts-list for displaying the product teasers
                    //echo do_shortcode( '[ts-list view="Teaser1" pm-ot="607" pm-l="1,4" pm-o="RAND"]');
                    // Note: the View-Template "Teaser1" can be found in travelshop/template-parts/pm-views/{OBJECT_TYPE_NAME}_{VIEWNAME}.php


                    // Example 2: Using the pressmind® web-core SDK (MySQL)
                    //$conditions = array();
                    //$conditions[] = Pressmind\Search\Condition\ObjectType::create(TS_TOUR_PRODUCTS);
                    //$search = new Pressmind\Search($conditions, ['start' => 0, 'length' => 4], ['' => 'RAND()']);
                    //$products = $search->getResults();
                    //foreach ($products as $product) {
                    //    echo  $product->render('Teaser1', TS_LANGUAGE_CODE);
                    //}

                    // Example 3: Use a $args['search] list (or $_GET)
                    // $search = BuildSearch::fromRequest(isset($args['search']) ? $args['search'] : [], 'pm', true, 4);
                    // $products = $search->getResults();

                    $view = 'Teaser1';
                    if (!empty($args['view']) && preg_match('/^[0-9A-Za-z\_]+$/', $args['view']) !== false) {
                        $view = $args['view'];
                    }
                    foreach ($result['items'] as $item) {
                        $item['class'] = $item_wrapper;
                        echo Template::render(get_stylesheet_directory() . '/template-parts/pm-views/' . $view . '.php', $item);
                    }
                    // @todo: integrate "link teaser"
                    ?>
                </div>

                <?php if ( $layout_type === 'slider' || $mobile_slider ) { ?>
                    <?php load_template( get_stylesheet_directory().'/template-parts/micro-templates/slider-controls.php', false, []); ?>
                <?php } ?>
            </div>
        </div>

    </div>

    <?php if (isset($args['link_bottom']) && $args['link_bottom'] === true && $has_more_items === true) { ?>
        <div class="row row-button">
            <div class="col-12 text-center pb-4">
                <a href="<?php echo $more_results_link; ?>"
                   title="<?php echo str_replace('[TOTAL_RESULT]', $result['total_result'], $args['link_bottom_text']); ?>"
                   class="btn btn-primary btn-lg btn-further btn-further-bottom">
                    <?php echo str_replace('[TOTAL_RESULT]', $result['total_result'], $args['link_bottom_text']); ?>
                    <span class="icon icon-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right"
                         width="16" height="16" viewBox="0 0 24 24" stroke-width="3" stroke="#FFFFFF" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <polyline points="9 6 15 12 9 18"></polyline>
                    </svg>
                </span>
                </a>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($args['pagination_bottom']) && $args['pagination_bottom'] == 'true' && $has_more_items === true) { ?>
        <?php
        $args['items'] = $result['items'];
        $args['current_page'] = isset($_GET['pm-l']) ? explode(',', $_GET['pm-l'])[0] : 1;
        $args['pages'] = ceil($result['total_result'] / $page_size);
        $args['page_size'] = $page_size;
        ?>
        <?php load_template_transient(get_template_directory() . '/template-parts/pm-search/result-pagination.php', false, $args); ?>
    <?php } ?>
</section>