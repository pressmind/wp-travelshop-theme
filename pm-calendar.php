<?php
/**
 * @var WP_Query $wp_query
 */
use \Pressmind\Travelshop\Search;
get_header();
?>
    <main>
        <?php
            $output = 'date_list';
            $request = [];
            $request = array_merge($_GET, ['pm-ot' => $wp_query->get('pm-ot')]);
            $request['pm-o'] = 'date_departure-asc';
            $_GET['view'] = 'Calendar1';
            $result = Search::getResult($request,2, 12, true, false, TS_TTL_FILTER, TS_TTL_SEARCH, $output);
            $result['calendarpage'] = true;
            ?>
        <div class="content-main" id="content-main">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1>Reisekalender</h1>

                        <?php
                        $args = [];
                        $args['headline'] = '';
                        $args['text'] = '';
                        $args['id_object_type'] = TS_TOUR_PRODUCTS;
                        $args['calendar'] = true;
                        load_template_transient(get_stylesheet_directory() . '/template-parts/layout-blocks/month-badge.php', false, $args);
                        ?>

                        <div id="search-result">
                            <?php
                            // this content will be replaced by ajax during the search, @see travelshop/assets/js/ajax.js
                            load_template_transient(get_stylesheet_directory() . '/template-parts/pm-search/result.php', false, $result);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php
get_footer();