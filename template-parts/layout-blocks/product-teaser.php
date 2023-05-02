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
if($args['showVisited'] == 'false') {
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
} else { ?>
<script>

</script>
<?php } ?>
<section<?php !empty($args['uid']) ? ' id="' . $args['uid'] . '"' : ''; ?>
        class="content-block content-block-travel-cols">
    <div class="row row-introduction <?php if (isset($args['link_top']) && $args['link_top'] === true) { ?>align-items-baseline<?php } ?>">
        <?php if (!empty($args['headline']) || !empty($args['intro'])){ ?>

        <div class="col-12 <?php if (isset($args['link_top']) && $args['link_top'] === true) { ?>col-md<?php } ?>">
            <?php if (!empty($args['headline'])) { ?>
                <h2 class="mt-0">
                    <?php echo str_replace('[TOTAL_RESULT]', $result['total_result'] ?? 'X', $args['headline']); ?>
                </h2>
            <?php } ?>
        </div>
        <?php if (isset($has_more_items) && $has_more_items === false) { ?>
    </div>
    <div class="row">
        <?php } ?>
        <?php if ($args['showVisited'] == 'false' && isset($args['link_top']) && $args['link_top'] === true && $has_more_items === true) { ?>
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
    <div class="row">
        <div class="col-12">
            <?php if (!empty($args['text'])) { ?>
                <p>
                    <?php echo str_replace('[TOTAL_RESULT]', $result['total_result'] ?? 'X', $args['text']); ?>
                </p>
            <?php } ?>
        </div>
        <?php } ?>
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

        if($args['showVisited'] == 'false') {
            $view = 'Teaser1';
            if (!empty($args['view']) && preg_match('/^[0-9A-Za-z\_]+$/', $args['view']) !== false) {
                $view = $args['view'];
            }
            foreach ($result['items'] as $item) {
                echo Template::render(get_stylesheet_directory() . '/template-parts/pm-views/' . $view . '.php', $item);
            }
            if (isset($args['link_teaser']) && $args['link_teaser'] === true && $has_more_items === true) {
            ?>
            <div class="col-12 col-md-6 col-lg-3 card-travel-wrapper-link text-center pb-3">
                <a class="btn-further btn-teaser-link d-none d-md-flex" href="<?php echo $more_results_link; ?>"
                   title="<?php echo str_replace('[TOTAL_RESULT]', $result['total_result'], $args['link_teaser_text']); ?>">
                    <?php echo str_replace('[TOTAL_RESULT]', $result['total_result'], $args['link_teaser_text']); ?>
                    <span class="icon icon-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right"
                             width="16" height="16" viewBox="0 0 24 24" stroke-width="3" stroke="#007BFF" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <polyline points="9 6 15 12 9 18"></polyline>
                        </svg>
                    </span>
                </a>
            </div>
            <?php
        }
        ?>
    </div>

    <?php if (isset($args['link_bottom']) && $args['link_bottom'] === true && $has_more_items === true) { ?>
        <div class="row">
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
    <?php }} else {
        $random_hash_class = 'visitedproducts-' . preg_replace('/[0-9_\/]+/','', base64_encode(random_bytes(6))); ?>
          <div class="<?php echo $random_hash_class; ?> container row"></div>
        <script>
            let relatedList = JSON.parse(window.localStorage.getItem('relatedList'));
            let visitedlist  = relatedList?.filter(x => x?.type == 'viewed');
            let query_string = 'action=visitedItems&pm-o=list&view=Teaser1';
            let idString = '&pm-id=';
            let timeString = '&pm-time=';
            visitedlist.sort((a,b) => { return a.created + b.created }).forEach(function (item, key) {
                if (key !== visitedlist.length - 1) {
                    idString += item.id_media_object + ',';
                    timeString += item.created + ',';
                } else {
                    idString += item.id_media_object;
                    timeString += item.created;
                }
            });
            query_string = query_string + idString + timeString;
            jQuery.ajax({
                url: '/wp-content/themes/travelshop/pm-ajax-endpoint.php?' + query_string,
                method: 'POST',
            }).done(function (htmlData) {
                jQuery('.<?php echo $random_hash_class; ?>').html(htmlData.html);
            });
        </script>
    <?php } ?>
</section>