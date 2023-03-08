<?php
if (has_nav_menu('primary') === true) {
    ?>
    <nav class="navbar navbar-expand-lg" id="navbar">
        <ul class="navbar-nav mr-auto ml-auto">

                <?php
                $menu_items = nav_menu_2_tree('primary');

                if (isset($menu_items)) {
                    foreach ($menu_items['navigation'] as $item) {
                        // Top Level
                        if (empty($item->wpse_children) === true) { // Level 1
                            ?>
                            <li class="nav-item <?php if ( !empty($menu_items['active_ids']) && in_array( $item->ID, $menu_items['active_ids']) ) { echo "active"; } ?>">
                                <a class="nav-link"
                                   href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
                            </li>
                            <?php
                        } else { // Level 2
                            ?>
                            <li class="nav-item dropdown <?php if ( !empty($menu_items['active_ids']) && in_array( $item->ID, $menu_items['active_ids']) ) { echo "active"; } ?>">
                                <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown"
                                   role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo $item->title; ?>

                                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#carent-down-bold"></use></svg>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <?php
                                    foreach ($item->wpse_children as $child_items) {
                                        ?>
                                        <a class="dropdown-item <?php if ( !empty($menu_items['active_ids']) && in_array( $child_items->ID, $menu_items['active_ids']) ) { echo "active"; } ?>"
                                           href="<?php echo $child_items->url ?>">
                                            <?php echo $child_items->title; ?>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </li>
                            <?php
                        }
                    }
                }
                ?>
            </ul>
    </nav>
<?php } else { ?>
    <nav class="navbar navbar-expand-lg offcanvas" id="navbar">
        <small style="padding: 1rem; display: inline-block;">menu: ‚Desktop Horizontal Menu‘ not configured</small>
    </nav>
<?php } ?>