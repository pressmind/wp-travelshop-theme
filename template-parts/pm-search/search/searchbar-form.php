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
        <div class="row">
            <?php
            foreach(TS_SEARCH[$args['search_box']]['tabs'][$current_tab]['fields'] as $field){

                if($field['fieldname'] == 'date_picker'){
                    ?>
                    <div class="col-12 col-md-3 travelshop-datepicker">
                        <?php
                        echo Template::render(APPLICATION_PATH . '/template-parts/pm-search/search/date-picker.php', ['name' => $field['name'], 'departure_min' => $args['departure_min'], 'departure_max' => $args['departure_max'], 'departure_dates' => $args['departure_dates']]);
                        ?>
                    </div>
                <?php
                }else if($field['fieldname'] == 'string_search'){
                    ?>
                    <div class="col-12 col-md-3">
                        <?php
                        echo Template::render(APPLICATION_PATH . '/template-parts/pm-search/search/string-search.php', ['name' => $field['name']]);
                        ?>
                    </div>
                    <?php
                }else{
                    // draw category tree based search fields
                    echo Template::render(APPLICATION_PATH . '/template-parts/pm-search/search/category-tree-dropdown.php', array_merge($args, ['name' => $field['name'], 'fieldname' => $field['fieldname'], 'behavior' => $field['behavior']]));
                }
            }
            ?>
            <div class="col-12 col-md-3 mb-md-0">
                <div class="form-group mb-0">
                    <label class="d-none d-md-block">&nbsp;</label>
                    <a class="btn btn-primary btn-block" data-instant data-instant-intensity="0" href="<?php echo SITE_URL . '/' . trim(TS_SEARCH[$args['search_box']]['tabs'][$current_tab]['route'],'/'). '/'; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="20"
                             height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <circle cx="10" cy="10" r="7"/>
                            <line x1="21" y1="21" x2="15" y2="15"/>
                        </svg>
                        <img class="loader" src="<?php echo WEBSERVER_HTTP; ?>/wp-content/themes/travelshop/assets/img/loading-dots.svg">
                        <span class="search-bar-total-count" data-default="Suchen" data-total-count-singular="Reise anzeigen"
                              data-total-count-plural="Reisen anzeigen">
                            <?php echo empty($args['total_result']) ? 'Suchen' : $args['total_result'] . ' Reisen anzeigen'; ?></span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</form>
