<div id="string-search-placeholder-storage" class="d-none">
    <?php
        for($tab_index = 1; $tab_index <= 3; $tab_index++){ ?>
        <div class="string-search-placeholder-tab" id="searchStorage_search-<?php echo $tab_index; ?>">
            <div class="string-search-placeholder">
                <?php
                $search_teaser_items = wpsf_get_setting('travelshop_wpsf', 'search_tab'.$tab_index.'_section1', 'items');
                if (!empty($search_teaser_items)) { ?>
                    <div class="string-search-placeholder-group">
                        <div class="string-search-placeholder-items">
                            <div class="items-wrapper">
                                <?php foreach ($search_teaser_items as $item) { ?>
                                    <div class="search-item search-item-teaser">
                                        <?php
                                        $imageSrc = '/placeholder.svg?wh=128x128';
                                        if ($item['image']) {
                                            $src = wp_get_attachment_image_src($item['image'], 'thumbnail');
                                            $imageSrc = empty($src[0]) ? $imageSrc : $src[0];
                                        }
                                        ?>
                                        <a href="<?php echo $item['link']; ?>" title="<?php echo $item['text']; ?>">
                                            <div class="search-item-image">
                                                <img src="<?php echo $imageSrc; ?>" alt="<?php echo $item['text']; ?>"
                                                     loading="lazy"/>
                                            </div>
                                            <div class="search-item-body">
                                                <div class="search-item-title">
                                                    <?php echo $item['text']; ?>
                                                </div>
                                                <?php if (!empty($item['subtext'])) { ?>
                                                    <div class="search-item-sub-title">
                                                        <?php echo $item['subtext']; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <?php if (!empty($item['badge'])) { ?>
                                                <div class="search-item-badge">
                                                    <?php echo $item['badge']; ?>
                                                </div>
                                            <?php } ?>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php
                $teaser_groups = wpsf_get_setting('travelshop_wpsf', 'search_tab'.$tab_index.'_section1', 'teaser_group');
                if (!empty($teaser_groups)) {
                    foreach($teaser_groups as $teaser_group){ ?>
                    <div class="string-search-placeholder-group">
                        <div class="h5 string-search-placeholder-title">
                            <?php echo $teaser_group['title']; ?>
                        </div>
                        <div class="string-search-placeholder-items">
                            <div class="items-wrapper">
                                <?php foreach ($teaser_group['items'] as $item) { ?>
                                    <div class="search-item">
                                        <?php
                                        $imageSrc = '/placeholder.svg?wh=128x128';
                                        if ($item['image']) {
                                            $src = wp_get_attachment_image_src($item['image'], 'thumbnail');
                                            $imageSrc = empty($src[0]) ? $imageSrc : $src[0];
                                        }
                                        ?>
                                        <a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>">
                                            <div class="search-item-image">
                                                <img src="<?php echo $imageSrc; ?>" alt="<?php echo $item['title']; ?>"
                                                     loading="lazy"/>
                                            </div>
                                            <div class="search-item-body">
                                                <div class="search-item-title">
                                                    <?php echo $item['title']; ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                        if(!empty($teaser_group['more_link'])){ ?>
                        <div class="string-search-placeholder-link">
                            <a href="<?php echo $teaser_group['more_link']; ?>" title="Weitere Reiseziele anzeigen"><?php echo $teaser_group['more_link_text']; ?></a>
                        </div>
                            <?php } ?>
                    </div><?php
                    }
                }
                ?>
            </div>
            <?php
            $show_all_link = wpsf_get_setting('travelshop_wpsf', 'search_tab'.$tab_index.'_section1', 'show_all_text');
            if(!empty($show_all_link)){ ?>
            <div class="string-search-placeholder-footer">
                    <a href="<?php echo  wpsf_get_setting('travelshop_wpsf', 'search_tab'.$tab_index.'_section1', 'show_all_link'); ?>"
                       title="">
                        <svg>
                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                 href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#sparkle"></use>
                        </svg>
                        <?php echo $show_all_link; ?>
                    </a>
                </div>
            <?php } ?>
        </div>
<?php } ?>
</div>