<div class="offcanvas-header">
    <button class="offcanvas-close">
        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
    </button>
</div>

<div class="offcanvas-inner">
    <?php
    if ( $args !== null ) {
        $navTree = $args;
        $activeIds = $navTree['active_ids'];

        foreach ( $navTree['navigation'] as $item ) {
            ?>
            <div class="nav-item">

                <a class="nav-link <?php echo in_array($item->ID, $activeIds) ? 'active' : ''; ?> <?php echo $item->wpse_children ? 'sub-layer-toggle' : ''; ?>"
                    <?php echo $item->wpse_children ? 'data-sub-layer="#sub-layer-' . $item->ID . '"' : ''; ?>
                   href="<?php echo $item->url; ?>"
                   target="<?php echo $item->target; ?>"
                   title="<?php echo !empty($item->attr_title) ? $item->attr_title : $item->title; ?>">

                    <?php echo $item->title; ?>

                    <?php
                    if ( $item->wpse_children ) {
                        ?>
                        <span class="icon">

                                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-right-bold"></use></svg>
                        </span>
                        <?php
                    }
                    ?>
                </a>

            </div>
            <?php
            if ( $item->wpse_children ) {
                ?>
                <div class="sub-layer" id="sub-layer-<?php echo $item->ID; ?>">

                    <div class="sub-layer-header">
                        <button type="button" class="sub-layer-back">
                            <span class="icon">
                                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-left-bold"></use></svg>
                            </span>
                            Zurück
                        </button>

                        <a class="parent-link <?php echo in_array($item->ID, $activeIds) ? 'active' : ''; ?>"
                           href="<?php echo $item->url; ?>"
                           target="<?php echo $item->target; ?>"
                           title="<?php echo !empty($item->attr_title) ? $item->attr_title : $item->title; ?>">

                            <?php echo $item->title; ?> anzeigen
                        </a>
                    </div>

                    <div class="sub-layer-items">
                        <?php foreach ( $item->wpse_children as $item ) { ?>
                            <a class="nav-link <?php echo in_array($item->ID, $activeIds) ? 'active' : ''; ?> <?php echo $item->wpse_children ? 'sub-layer-toggle' : ''; ?>"
                                <?php echo $item->wpse_children ? 'data-sub-layer="#sub-layer-' . $item->ID . '"' : ''; ?>
                               href="<?php echo $item->url; ?>"
                               target="<?php echo $item->target; ?>"
                               title="<?php echo !empty($item->attr_title) ? $item->attr_title : $item->title; ?>">

                                <?php echo $item->title; ?>
                                <?php
                                if ( $item->wpse_children ) {
                                    ?>
                                    <span class="icon">

                                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-right-bold"></use></svg>
                                    </span>
                                    <?php
                                }
                                ?>
                            </a>

                            <?php
                            if ( $item->wpse_children ) {
                                ?>
                                <div class="sub-layer" id="sub-layer-<?php echo $item->ID; ?>">

                                    <div class="sub-layer-header">
                                        <button type="button" class="sub-layer-back">
                                                <span class="icon">
                                                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-left-bold"></use></svg>
                                                </span>
                                            Zurück
                                        </button>

                                        <a class="parent-link <?php echo in_array($item->ID, $activeIds) ? 'active' : ''; ?>"
                                           href="<?php echo $item->url; ?>"
                                           target="<?php echo $item->target; ?>"
                                           title="<?php echo !empty($item->attr_title) ? $item->attr_title : $item->title; ?>">

                                            <?php echo $item->title; ?> anzeigen
                                        </a>
                                    </div>

                                    <div class="sub-layer-items">
                                        <?php foreach ( $item->wpse_children as $item ) { ?>
                                            <a class="nav-link <?php echo in_array($item->ID, $activeIds) ? 'active' : ''; ?> <?php echo $item->wpse_children ? 'sub-layer-toggle' : ''; ?>"
                                                <?php echo $item->wpse_children ? 'data-sub-layer="#sub-layer-' . $item->ID . '"' : ''; ?>
                                               href="<?php echo $item->url; ?>"
                                               target="<?php echo $item->target; ?>"
                                               title="<?php echo !empty($item->attr_title) ? $item->attr_title : $item->title; ?>">

                                                <?php echo $item->title; ?>
                                            </a>
                                        <?php } ?>
                                    </div>

                                </div>
                                <?php
                            }
                            ?>
                        <?php } ?>
                    </div>

                </div>
                <?php
            }
        }
    }
    ?>
</div>