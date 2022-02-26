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
            <div class="h4 mt-0 mb-4"><i class="la la-filter"></i> Suche verfeinern</div>
            <button class="list-filter-close">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="28" height="28"
                     viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round"
                     stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z"/>
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
            <div class="list-filter-boxes">
                <?php
                require 'filter/order.php';
                require 'filter/price-range.php';
                require 'filter/duration-range.php';
                foreach(TS_FILTERS as $filter){

                    $fieldname = $filter['fieldname'];
                    $name = $filter['name'];
                    $behavior = $filter['behavior'];
                    require 'filter/category-tree.php';
                }
                ?>
                <div class="list-filter-box list-filter-box-submit">
                    <button type="button" class="btn btn-primary btn-block filter-prompt">Filter anwenden</button>
                </div>
            </div>
        </div>

    </form>
</div>