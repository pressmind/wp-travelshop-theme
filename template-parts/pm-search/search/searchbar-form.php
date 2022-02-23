<?php
/**
 *  @var int $id_object_type
 * <code>
 *  $args[total_result] => 112
 *  $args[current_page] => 1
 *  $args[pages] => 10
 *  $args[page_size] => 12
 *  $args[id_object_type] => 2277
 *  $args[... some more values search result ...]
 * </code>
 * @var array $args
 */
use Pressmind\Travelshop\RouteHelper;

// NO WORDPRESS FUNCTIONS HERE! (also used in ajax calls)
?>
<form id="main-search" method="GET" action="<?php echo SITE_URL . '/' . trim(RouteHelper::get_url_by_object_type($args['id_object_type']) . '/','/'); ?>">
    <input type="hidden" name="pm-ot" value="<?php echo $args['id_object_type']; ?>">
    <div class="search-wrapper--inner search-box">
        <div class="row">
            <div class="col-12 col-md-3">
                <?php
                require 'string-search.php';
                ?>
            </div>
            <div class="col-12 col-md-3 travelshop-datepicker">
                <?php
                require 'date-picker.php';
                ?>
            </div>
            <?php
            // draw category tree based search fields
            if(empty(TS_SEARCH[$args['id_object_type']]) === false){
                foreach (TS_SEARCH[$args['id_object_type']] as $searchItem) {
                    list($fieldname, $name, $behavior) = array_values($searchItem);
                    require 'category-tree-dropdown.php';
                }
            } ?>
            <div class="col-12 col-md-3 mb-md-0">
                <div class="form-group mb-0">
                    <label class="d-none d-md-block">&nbsp;</label>
                    <a class="btn btn-primary btn-block"
                       href="<?php echo SITE_URL . '/' . trim(RouteHelper::get_url_by_object_type($args['id_object_type']),'/'). '/'; ?>">
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
