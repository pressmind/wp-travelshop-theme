<?php
/**
 * @var WP_Query $wp_query
 */
use \Pressmind\Travelshop\Search;
get_header();
?>
<main>
    <?php
    $args = [];
    $args['headline'] = 'Finde deine Traumreise!';
    $args['search_box'] = 'default_search_box';
    $args['search_box_tab'] = 0;
    load_template_transient(get_template_directory() . '/template-parts/layout-blocks/search-header.php', false, $args);
    $request = array_merge($_GET, ['pm-ot' => $wp_query->get('pm-ot')]);
    $output = null;
    $view = 'Teaser1';
    if(!empty($_GET['view']) && preg_match('/^[0-9A-Za-z\_]+$/', $_GET['view']) !== false){
        $view = $_GET['view'];
        if($view == 'Calendar1') {
            $output = 'date_list';
        }
    }
    $result = Search::getResult($request,2, 12, true, false, TS_TTL_FILTER, TS_TTL_SEARCH, $output);
    ?>
    <?php the_breadcrumb(null); ?>
    <div class="content-main">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3">
                    <nav id="search-filter">
                        <?php
                            // this content will be replaced by ajax during the search, @see travelshop/assets/js/ajax.js
                            load_template_transient(get_template_directory() . '/template-parts/pm-search/filter-vertical.php', false, $result);
                            ?>
                    </nav>
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <div id="search-result">
                        <?php
                            // this content will be replaced by ajax during the search, @see travelshop/assets/js/ajax.js
                            load_template_transient(get_stylesheet_directory() . '/template-parts/pm-search/result.php', false, $result);
                            ?>
                    </div>
                </div>
            </div>
            <hr class="mt-0 mb-0">
            <?php load_template_transient(get_template_directory() . '/template-parts/layout-blocks/info-teaser.php'); ?>
        </div>
    </div>
</main>
<?php
get_footer();