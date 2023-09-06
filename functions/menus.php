<?php

add_action('init', function () {
    $locations = array(
        'primary' => __('Desktop Horizontal Menu', 'travelshop'),
        'expanded' => __('Desktop Expanded Menu', 'travelshop'),
        'ibe_head' => __('IBE Template Head Menu', 'travelshop'),
        'ibe_footer' => __('IBE Template Footer Menu', 'travelshop'),
        'mobile' => __('Mobile Menu', 'travelshop'),
        'footer_column_1' => __('Footer Column 1', 'travelshop'),
        'footer_column_2' => __('Footer Column 2', 'travelshop'),
        'footer_meta_menu' => __('Footer Meta Menu', 'travelshop')
    );

    register_nav_menus($locations);
});


/**
 * @TODO: reduce sql queries
 * Modification of "Build a tree from a flat array in PHP"
 *
 * Authors: @DSkinner, @ImmortalFirefly and @SteveEdson
 *
 * @link https://stackoverflow.com/a/28429487/2078474
 */
function buildTree(array &$elements, $parentId = 0)
{
    global $PMTravelShop;
    $branch = array();
    foreach ($elements as &$element) {
        if ($element->menu_item_parent == $parentId) {
            $children = buildTree($elements, $element->ID);
            if ($children) {
                $element->wpse_children = $children;
            }

            // if the menu type object is based on pressmind category trees,
            // we have to get these items and mix it in the tree
            if($element->object == 'pmt2core_category_trees'){
                $id_tree = $element->object_id;

                // we have to use the xfn field for storing pressmind specific informations, not the best,
                // but a working way. wordpress docu see also add_menu_meta.php which writes into the xfn field.
                list($id_object_type, $var_name) = explode(' ', $element->xfn);

                $search = new Pressmind\Search(
                    [
                        Pressmind\Search\Condition\Visibility::create(TS_VISIBILTY),
                        Pressmind\Search\Condition\ObjectType::create($id_object_type),
                    ]
                );
                $tree = new Pressmind\Search\Filter\Category($id_tree, $search);
                $treeItems = $tree->getResult();

                if(empty($treeItems) === false){
                    $element->wpse_children = [];
                    foreach($treeItems as $item){
                        $tmp = new stdClass();
                        $tmp->url =  site_url() . '/' . Pressmind\Travelshop\RouteHelper::get_url_by_object_type($id_object_type) . '/?pm-c['.$var_name.']='.$item->id;
                        $tmp->title = $item->name;
                        $tmp->ID = null;
                        $element->wpse_children[] = $tmp;
                    }
                }

            }

            $branch[$element->ID] = $element;
            unset($element);
        }
    }
    return $branch;
}

function activeItem(array &$elements)
{
    // current id
    $current = get_the_ID();
    $item = null;

    foreach ( $elements as $element ) {
        if ( $element->object_id == $current ) {
            $item = $element;
        }
    }

    return $item;
}

function getActiveParents(array &$elements, $parentId) {

    $id = '';

    foreach ( $elements as &$element ) {
        if ( $element->ID == $parentId ) {
            $id .= $element->ID . ',';

            if ( $element->menu_item_parent != 0 ) {
                $id .=  getActiveParents($elements, $element->menu_item_parent) . ',';
            }
        }
    }


    return $id;
}

function activeIds(array &$elements, $currentId)
{
    $breadcrumb = array();
    $request_uri = $_SERVER['REQUEST_URI'];
    $request_uri = explode('?', $request_uri);
    $request_uri = $request_uri[0];

    foreach ( $elements as &$element ) {

        // -- check for individuel tree items
        if ( $element->object == 'custom' && $element->url == $request_uri ) {
            $parentId = $element->menu_item_parent;


            if ( !in_array($element->ID, $breadcrumb) ) {
                array_push($breadcrumb, $element->ID);
            }

            if ( $parentId != 0 ) {
                $activeParents = getActiveParents($elements, $element->menu_item_parent);
                $activeParents = explode(',', $activeParents);

                foreach ( $activeParents as $parent ) {
                    if ( $parent != null ) {
                        array_push($breadcrumb, $parent);
                    }
                }
            }
        }

        // -- check for object_id // pages&Posts
        if ( $element->object_id == $currentId ) {
            $parentId = $element->menu_item_parent;


            if ( !in_array($element->ID, $breadcrumb) ) {
                array_push($breadcrumb, $element->ID);
            }

            if ( $parentId != 0 ) {
                $activeParents = getActiveParents($elements, $element->menu_item_parent);
                $activeParents = explode(',', $activeParents);

                foreach ( $activeParents as $parent ) {
                    if ( $parent != null ) {
                        array_push($breadcrumb, $parent);
                    }
                }
            }
        }
    }

    return $breadcrumb;
}

/**
 * Transform a navigational menu to it's tree structure
 * @param string $menu_position
 * @return array|null $tree
 * @uses buildTree()
 * @uses wp_get_nav_menu_items()
 */
function nav_menu_2_tree($menu_position)
{
    global $wpdb;
    $locations = get_nav_menu_locations(); //get all menu locations
    $primary = wp_get_nav_menu_object($locations[$menu_position]);
    $sorted_menu_items = wp_get_nav_menu_items($primary);

    $newSort	=	array();
    $objectIds	=	array();

    /**
     * @var WP_Post $v
     */
    foreach($sorted_menu_items as $k => $v)
    {
        $objectIds[]	=	$v->object_id;
    }

    global $wpdb;

    $getSites	=	'
			SELECT
				`ID`
			FROM
				`wp_posts`
			WHERE
				`ID` IN ('.implode(',', $objectIds).') AND
				`post_status` = "publish"
			';

    $siteIDs	=	$wpdb->get_results($getSites, 'ARRAY_A');

    $newSiteIDs = [];
    //var_dump($siteIDs);
    foreach($siteIDs as $siteID) {
        //var_dump(get_post_meta($siteID['ID'], '_tt_user_roles_allowed'));
        $allowedRoles = get_post_meta($siteID['ID'], '_tt_user_roles_allowed');
        if(!empty($allowedRoles[0])) {
            if(is_user_logged_in()) {
                echo '<pre>';
                //var_dump($allowedRoles);
                echo '</pre>';
                $user = wp_get_current_user();
                $roles = ( array ) $user->roles;
                foreach($roles as $role) {
                    if(in_array($role, $allowedRoles[0])) {
                        array_push($newSiteIDs, $siteID['ID']);
                    }
                }
            }
        } else {
            array_push($newSiteIDs, $siteID['ID']);
        }
    }

    //var_dump($sorted_menu_items[1]->object_id);
    //var_dump($newSiteIDs);

    foreach($sorted_menu_items as $key => $menuit) {
        if(!in_array($menuit->object_id, $newSiteIDs)) {
            array_splice($sorted_menu_items, $key, 1);
        }
    }

    //var_dump($sorted_menu_items);

    $items = $sorted_menu_items;

    $tree = array();

    $tree['navigation'] = $items ? buildTree($items, 0) : null;
    $tree['active'] = $items ? activeItem($items) : null;
    $tree['active_ids'] = $items ? activeIds($items, get_the_ID()) : null;

    return $tree;
}