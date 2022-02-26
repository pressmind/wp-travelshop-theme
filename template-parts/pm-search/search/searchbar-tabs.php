<?php
/**
 *  <code>
 *  $args['headline']
 *  $args['search_box'] = 'default_search_box'
 * $args['search_box_tab']
 *  $args['class'] // main-color, silver, transparent
 * </code>
 * @var array $args
 */

if(empty($args['search_box']) === true || empty(TS_SEARCH[$args['search_box']]['tabs'])){
    return;
}
$current_tab = 0;
if(isset($args['search_box_tab'])){
    $current_tab = $args['search_box_tab'];
}
?>
<div class="search-wrapper--tabs">
    <?php
        // check if the searchbox is on the current view
        $no_active_route = true;
        foreach(TS_SEARCH[$args['search_box']]['tabs'] as $k => $tab){
            if($tab['route'] == trim($_SERVER['REQUEST_URI'], '/')){
                $no_active_route = false;
            }
        }
        foreach(TS_SEARCH[$args['search_box']]['tabs'] as $k => $tab){
            ?>
            <button class="search-wrapper--tabs_btn  <?php echo $tab['route'] == trim($_SERVER['REQUEST_URI'], '/') || $no_active_route && $k == $current_tab ? 'is--active' : ''; ?>" data-pm-tab="<?php echo $k; ?>"  data-pm-box="<?php echo $args['search_box']; ?>">
                <?php echo $tab['name'];?>
            </button>
            <?php
        }
    ?>
</div>