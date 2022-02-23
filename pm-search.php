<?php
/**
 * @var WP_Query $wp_query
 */
use \Pressmind\Travelshop\Search;
get_header();
?>
<main>
    <?php
    $args = $result = Search::getResult(array_merge($_GET, ['pm-ot' => (int)$wp_query->get('id_object_type')]),2, 12, true, false, TS_TTL_FILTER, TS_TTL_SEARCH);
    $args['headline'] = 'Finde deine Traumreise!';
    load_template(get_template_directory() . '/template-parts/layout-blocks/search-header.php', false, $result);
    ?>
    <?php the_breadcrumb(null); ?>
    <div class="content-main">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3">
                    <nav id="search-filter">
                        <?php
                            // this content will be replaced by ajax during the search, @see travelshop/assets/js/ajax.js
                            load_template(get_template_directory() . '/template-parts/pm-search/filter-vertical.php', false, $result);
                            ?>
                    </nav>
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <div id="search-result">
                        <?php
                            // this content will be replaced by ajax during the search, @see travelshop/assets/js/ajax.js
                            load_template(get_stylesheet_directory() . '/template-parts/pm-search/result.php', false, $result);
                            ?>
                    </div>
                </div>
            </div>
            <hr class="mt-0 mb-0">
            <?php load_template(get_template_directory() . '/template-parts/layout-blocks/info-teaser.php'); ?>
        </div>
    </div>
</main>
<?php
get_footer();