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
    <nav>
        <ul class="nav flex-row">
            <?php
            wp_nav_menu(
                array(
                    'container' => '',
                    'depth' => 1,
                    'items_wrap' => '%3$s',
                    'theme_location' => $args['menu_location'],
                )
            );
            ?>
            <?php if (!empty(get_privacy_policy_url())) { ?>
                <li>
                    <?php the_privacy_policy_link(); ?>
                </li>
            <?php } ?>
            <?php if (TS_COOKIE_CONSENT === TRUE) { ?>
                <li>
                    <a href="#" data-cc="c-settings">Cookie-Einstellungen ändern</a>
                </li>
            <?php } ?>
        </ul>
    </nav>
<?php } ?>