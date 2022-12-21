<?php

/**
 * <code>
 *  $args['menu_location'] // the menu location, like footer_column_1, footer_column_2
 * </code>
 * @var array $args
 */

if (has_nav_menu($args['menu_location'])) {

    $locations = get_nav_menu_locations(); //get all menu locations
    $footer_menu = wp_get_nav_menu_object($locations[$args['menu_location']]);

    ?>
    <div class="h5">
        <?php echo !empty($footer_menu->name) ? $footer_menu->name : ''; ?>
    </div>
    <nav class="nav flex-column">
        <ul class="">
            <?php
            wp_nav_menu(
                array(
                    'container' => '',
                    'depth' => 1,
                    'items_wrap' => '<div>%3$s</div>',
                    'theme_location' => $args['menu_location'],
                )
            );
            ?>
        </ul>
    </nav>
<?php } ?>