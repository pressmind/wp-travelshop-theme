<?php
use Pressmind\Travelshop\RouteHelper;
use Pressmind\Travelshop\Search;
use Pressmind\Travelshop\Template;

/**
 * <code>
 *  $args['headline']
 *  $args['search_box'] = 'default_search_box'
 *  $args['search_box_tab'] = 0
 *  $args['class'] // main-color, silver, transparent
 * </code>
 * @var array $args
 */
// NO WORDPRESS FUNCTIONS HERE! (also used in ajax calls)

$current_tab = 0;
if(isset($args['search_box_tab'])){
    $current_tab = $args['search_box_tab'];
}

if(empty($args['search_box'])){
    $args['search_box'] = 'default_search_box';
}

if(empty(TS_SEARCH[$args['search_box']]['tabs'][$current_tab]['search'])){
    return;
}

$result = Search::getResult(TS_SEARCH[$args['search_box']]['tabs'][$current_tab]['search'],2, 12, true, true, TS_TTL_FILTER, TS_TTL_SEARCH);
$args = array_merge($args, $result);
?>
<form id="main-search" method="GET" action="<?php echo SITE_URL . '/' . trim(RouteHelper::get_url_by_object_type($args['id_object_type']) . '/','/'); ?>">
    <input type="hidden" name="pm-ot" value="<?php echo implode(',',$args['id_object_type']); ?>">
    <div class="search-wrapper--inner search-box">
        <div class="search-box-fields search-box-fields--gap">
            <?php
            foreach(TS_SEARCH[$args['search_box']]['tabs'][$current_tab]['fields'] as $field){
                if($field['fieldname'] == 'string_search'){
                    ?>
                    <div class="search-bar-fields-search">
                        <div class="search-box-field search-box-field--fulltext">
                            <?php
                            echo Template::render(APPLICATION_PATH . '/template-parts/pm-search/search/string-search.php', ['name' => $field['name']]);
                            ?>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="search-bar-fields-pickers">
            <?php
            foreach(TS_SEARCH[$args['search_box']]['tabs'][$current_tab]['fields'] as $field){
                if($field['fieldname'] !== 'string_search')  {

                    if($field['fieldname'] == 'date_picker'){
                        ?>
                        <div class="search-box-field search-box-field--datepicker travelshop-datepicker">
                            <?php
                            echo Template::render(APPLICATION_PATH . '/template-parts/pm-search/search/date-duration-picker.php', ['name' => $field['name'], 'departure_min' => $args['departure_min'], 'departure_max' => $args['departure_max'], 'departure_dates' => $args['departure_dates'], 'use_ajax' => 1]);
                            ?>
                        </div>
                        <?php
                    }else{
                        // draw category tree based search fields
                        echo Template::render(APPLICATION_PATH . '/template-parts/pm-search/search/category-tree-dropdown.php', array_merge($args, ['name' => $field['name'], 'fieldname' => $field['fieldname'], 'behavior' => $field['behavior']]));
                    }
                }
            }
            ?>
            </div>
        </div>
        <div class="search-box-submit">
            <a class="btn btn-primary btn-block" data-instant data-instant-intensity="0" href="<?php echo '/' . trim(TS_SEARCH[$args['search_box']]['tabs'][$current_tab]['route'],'/'). '/'; ?>">
                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#magnifying-glass"></use></svg>

                <img class="loader" src="<?php echo WEBSERVER_HTTP; ?>/wp-content/themes/travelshop/assets/img/loading-dots.svg">
                <span class="search-bar-total-count" data-default="Suchen" data-total-count-singular="Reise anzeigen"
                      data-total-count-plural="Reisen anzeigen">
                    <?php echo empty($args['total_result']) ? 'Suchen' : $args['total_result'] . ' Reisen anzeigen'; ?></span>
            </a>
        </div>
    </div>
</form>
