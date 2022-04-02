<?php
if (has_nav_menu('primary') === true) {
    ?>
    <nav class="navbar navbar-expand-lg offcanvas" id="navbar">
        <button class="offcanvas-close">
            <span>Menü schließen</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="30" height="30"
                 viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round"
                 stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
        <div class="navbar-offcanvas">
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
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="icon icon-tabler icon-tabler-caret-down" width="20" height="20"
                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="#ccc" fill="#ccc"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M18 15l-6 -6l-6 6h12" transform="rotate(180 12 12)"/>
                                    </svg>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <?php
                                    foreach ($item->wpse_children as $child_items) {
                                        ?>
                                        <a class="dropdown-item <?php if ( !empty($menu_items['active_ids']) && in_array( $child_items->ID, $menu_items['active_ids']) ) { echo "active"; } ?>"
                                           href="<?php echo $child_items->url ?>">
                                            <svg class="icon icon-tabler icon-tabler-caret-right">
                                                <use xlink:href="/wp-content/themes/travelshop/assets/img/icon-lib.svg#icon-tabler-caret-right"></use>
                                            </svg>
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
        </div>
    </nav>
<?php } else { ?>
    <nav class="navbar navbar-expand-lg offcanvas" id="navbar">
        <small style="padding: 1rem; display: inline-block;">menu: ‚Desktop Horizontal Menu‘ not configured</small>
    </nav>
<?php } ?>