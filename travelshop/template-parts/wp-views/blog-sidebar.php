<div class="blog-sidebar">

    <div class="teaser teaser-blog-sidebar teaser-blog-sidebar--search">
        <div class="teaser-body">
            <?php echo get_search_form(); ?>
        </div>
    </div>

    <div class="teaser teaser-blog-slidebar">
        <div class="teaser-body">
            <h4>Kategorien</h4>

            <div class="post-categories">
                <?php
                $categories = get_categories();
                $current_cat_ID = get_query_var('cat');

                foreach ( $categories as $category ) {
                    $category_link = get_category_link( $category );
                    ?>
                    <div class="post-tag">
                        <a href="<?php echo $category_link; ?>" title='<?php echo $category->name; ?>' class='<?php echo $category->slug; ?>'>

                            <?php if ( $current_cat_ID === $category->term_id ) { ?><strong><?php } ?>
                                <?php echo $category->name; ?> (<?php echo $category->count; ?>)
                            <?php if ( $current_cat_ID === $category->term_id ) { ?></strong><?php } ?>

                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>

        </div>
    </div>

    <div class="teaser teaser-blog-slidebar">
        <div class="teaser-body">
            <h4>Stichworte</h4>

            <div class="post-tags">

                <?php

                $tags = get_tags();
                $current_tag_ID = get_queried_object()->term_id;


                foreach ( $tags as $tag ) {

                    $tag_link = get_tag_link( $tag->term_id );
                    ?>
                    <a class="badge <?php if ( $current_tag_ID === $tag->term_id ) { ?> badge-primary <?php } else { ?> badge-secondary <?php } ?>" href="<?php echo $tag_link; ?>" title='<?php echo $tag->name; ?>' class='<?php echo $tag->slug; ?>'>
                        <?php echo $tag->name; ?>
                    </a>
                    <?php
                }
                ?>
            </div>

        </div>
    </div>

</div>