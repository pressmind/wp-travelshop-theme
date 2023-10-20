<?php
/**
 * This files add the menu meta box "pressmind Categories" to the admin menu panel
 */
// TODO: Crashes Wordpress Menu Functionality
// Display meta informations for the pressmind tree specific menu item
add_action( 'wp_nav_menu_item_custom_fields', function($item_id, $item) {
    global $config;
    if($item->object != 'pmt2core_category_trees'){
        return;
    }
    $id_tree = get_post_meta( $item_id, '_menu_item_object_id', true );

    ?>
    <div style="clear: both;">
        <span class="description">pressmind Category: <?php echo $item->attr_title; ?> (ID: <?php echo $id_tree; ?>)
            <br>Post Type ID: <?php echo $item_id; ?></span><br />
    </div>
    <?php
}, 10, 2 );

add_filter('nav_menu_meta_box_object', function($object) {
    add_meta_box('custom-menu-metabox', __('pressmind Categories'), function(){
        global $nav_menu_selected_id, $db, $config;
        $current_tab = 'tab1';
        $removed_args = array('action', 'customlink-tab', 'edit-menu-item', 'menu-item', 'page-tab', '_wpnonce');
        ?>
        <div id="pressmind-tree" class="categorydiv">
            <ul id="pressmind-tree-tabs" class="pressmind-tree-tabs add-menu-item-tabs">
                <?php

                $primary_object_types = $config['data']['primary_media_type_ids'];

                if(empty($primary_object_types)){
                    $primary_object_types = [];
                    $primary_object_types[] = array_key_first($config['data']['media_types']);
                }


                $tab = 0;
                foreach($primary_object_types as $id_object_type){
                    $tab++;
                    $name = empty($config['data']['media_types'][$id_object_type]) ? 'error - primary type is not included in media type, see pm-config.php' : $config['data']['media_types'][$id_object_type];
                    ?>
                    <li <?php echo('tab'.$tab == $current_tab ? ' class="tabs"' : ''); ?>>
                        <a class="nav-tab-link" data-type="tabs-panel-pressmind-tree-<?php echo 'tab'.$tab; ?>"
                           href="<?php if ($nav_menu_selected_id) echo esc_url(add_query_arg('pressmind-tree-tab', 'tab'.$tab, remove_query_arg($removed_args))); ?>#tabs-panel-pressmind-tree-<?php echo 'tab'.$tab; ?>">
                            <?php echo $name; ?>
                        </a>
                    </li>
                    <?php
                }
                ?>

            </ul>
            <?php
                $tab = 0;
                foreach($primary_object_types as $id_object_type){
                    $tab++;
                    $object_type_name = empty($config['data']['media_types'][$id_object_type]) ? 'error - primary type is not included in media type, see pm-config.php' : $config['data']['media_types'][$id_object_type];

                    $trees = $db->fetchAll('select distinct var_name, ti.id_tree as id, ct.name from pmt2core_media_object_tree_items ti
                            left join pmt2core_media_objects mo on(mo.id = ti.id_media_object)
                            left join pmt2core_category_trees ct on (ct.id = ti.id_tree)
                            where
                             id_object_type = '.$id_object_type.'
                            order by ct.name asc');
                    ?>
            <div id="tabs-panel-pressmind-tree-<?php echo 'tab'.$tab; ?>"
                 class="tabs-panel tabs-panel-view-<?php echo 'tab'.$tab; ?> <?php echo('tab'.$tab == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive'); ?>">
                <ul id="pressmind-tree-checklist-<?php echo 'tab'.$tab; ?>" class="categorychecklist form-no-clear">
                    <?php
                    $c = 1000;
                    foreach ($trees as &$tree) {
                        $c++;
                        ?>
                        <li>
                            <label class="menu-item-title">
                                <input type="checkbox" class="menu-item-checkbox" name="menu-item[-<?php echo $c; ?>][menu-item-object-id]" value="<?php echo $tree->id;?>"> <?php echo $tree->var_name; ?>
                            </label>
                            <input type="hidden" class="menu-item-title" name="menu-item[-<?php echo $c; ?>][menu-item-title]" value="<?php echo $tree->name;?>">
                            <input type="hidden" class="menu-item-attr-title" name="menu-item[-<?php echo $c; ?>][menu-item-attr-title]" value="<?php echo $object_type_name.'/'.$tree->var_name;?>">
                            <input type="hidden" class="menu-item-xfn" name="menu-item[-<?php echo $c; ?>][menu-item-xfn]" value="<?php echo $id_object_type;?> <?php echo $tree->var_name;?>">
                            <input type="hidden" class="menu-item-object" name="menu-item[-<?php echo $c; ?>][menu-item-object]" value="pmt2core_category_trees">
                            <input type="hidden" class="menu-item-description" name="menu-item[-<?php echo $c; ?>][menu-item-description]" value="">
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>

           <?php } ?>

            <p class="button-controls wp-clearfix">
			<span class="list-controls">
				<a href="<?php echo esc_url(add_query_arg(array('pressmind-tree-tab' => 'all', 'selectall' => 1,), remove_query_arg($removed_args))); ?>#pressmind-tree"
                   class="select-all"><?php _e('Select All'); ?></a>
			</span>
                <span class="add-to-menu">
				<input type="submit"<?php wp_nav_menu_disabled_check($nav_menu_selected_id); ?> class="button-secondary submit-add-to-menu right"
                       value="<?php esc_attr_e('Add to Menu'); ?>" name="add-pressmind-tree-menu-item"
                       id="submit-pressmind-tree"/>
				<span class="spinner"></span>
			</span>
            </p>
        </div>
        <?php
    }, 'nav-menus', 'side', 'default');

    return $object;
}, 10, 1);


