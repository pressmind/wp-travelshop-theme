<?php
/**
 * <code>
 * $args = ['total_result' => 100,
 *            'current_page' => 1,
 *            'pages' => 10,
 *            'page_size' => 10,
 *            'cache' => [
 *              'is_cached' => false,
 *              'info' => []
 *            ],
 *            'id_object_type' => 123 | [124, 134],
 *            'duration_min' => 3,
 *            'duration_max' => 5
 *            'price_min' => 100
 *            'price_max' => 200
 *            'categories' => []
 *            'items' => [],
 *            'mongodb' => [
 *              'aggregation_pipeline' => ''
 *            ]
 *           ];
 * </code>
 * @var array $args
 */
?>
<div class="content-block content-block-list-filter">
    <form id="filter" action="" method="GET">
        <input type="hidden" name="pm-ot" value="<?php echo implode(',', $args['id_object_type']); ?>">
        <div class="list-filter">
            <div class="list-filter-header">

                <div class="h4">Suche verfeinern</div>

                <button class="list-filter-close" data-type="close-popup" type="button">
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
                </button>
            </div>
            <div class="list-filter-boxes">
                <?php
                // require 'search/string-search.php';
                // echo '<hr />';
                $args['name'] = 'Zeitraum';
                $args['use_ajax'] = 1;
                ?>
                <div class="list-filter-box list-filter-box-date-range-picker travelshop-datepicker">
                <?php
                require 'search/date-range-picker.php';
                ?>
                </div>
                <?php
                require 'filter/order.php';
                require 'filter/price-range.php';
                require 'filter/duration-range.php';
                require 'filter/transport_type.php';
                require 'filter/board_type.php';
                foreach(TS_FILTERS as $filter){

                    $fieldname = $filter['fieldname'];
                    $name = $filter['name'];
                    $behavior = $filter['behavior'];
                    $type = isset($filter['type']) ? $filter['type'] : null;
                    $preview = isset($filter['preview']) ? $filter['preview'] : 5;
                    require 'filter/category-tree.php';
                }
                ?>
            </div>

            <div class="list-filter-footer">
                <div class="list-filter-box list-filter-box-submit">
                    <button type="button" class="btn btn-primary btn-block filter-prompt">Filter anwenden</button>
                </div>
            </div>
        </div>

    </form>
</div>