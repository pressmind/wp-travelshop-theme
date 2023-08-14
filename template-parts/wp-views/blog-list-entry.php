<article class="blog-list-entry">

    <?php
    $post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large');
    ?>

    <?php if ( $post_thumbnail ) { ?>
        <div class="blog-list-entry-thumbnail">
            <a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                <img src="<?php echo $post_thumbnail; ?>" alt="<?php echo get_the_title(); ?>" />
            </a>
        </div>
    <?php } ?>

    <div class="blog-list-entry-body">
        <div class="blog-list-entry-header">

            <h1 class="blog-list-entry-title h3">
                <a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>" class="media-cover ratio-16x9">
                    <?php echo get_the_title(); ?>
                </a>
            </h1>

            <div class="blog-list-entry-details">

                <?php
                // Date
                $post_date = get_the_date();
                $post_date_link =  get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j'));

                $post_author_name = get_the_author_meta('display_name');

                if ( $post_author_name ) {
                    $post_author_id = get_the_author_meta('ID');
                    $post_author_nicename = get_the_author_meta('user_nicename');
                    $post_author_link = get_author_posts_url($post_author_id, $post_author_nicename);
                }


                $post_comments = get_comments( array('post_id' => get_the_ID() ) );

                $post_categories = wp_get_post_categories(get_the_ID());

                ?>


                <?php if ( $post_date ) { ?>
                    <div>
                        <a href="<?php echo $post_date_link; ?>" title="<?php echo $post_date; ?>"><?php echo $post_date; ?></a>

                        <?php
                        if ( $post_categories ) {
                            $post_categories_html = '';
                            $iterate_cats = 0;
                            foreach ( $post_categories as $category ) {
                                $post_category = get_category($category);

                                if ( $iterate_cats > 0 ) {
                                    $post_categories_html .= ', ';
                                }
                                $post_categories_html .= '<a href="'.get_category_link( $post_category->term_id ).'" title="'.$post_category->name.'">'.$post_category->name.'</a>';

                                $iterate_cats++;

                            }

                            if ( !empty($post_categories_html) ) {
                                echo 'in ' . $post_categories_html;
                            }
                        }
                        ?>
                    </div>
                <?php } ?>

                <?php if ( $post_author_name ) { ?>&nbsp;
                    <div>
                        Autor: <a href="<?php echo $post_author_link; ?>" title="<?php echo $post_author_name; ?>"><?php echo $post_author_name; ?></a>
                    </div>
                <?php } ?>
                <?php if ( $post_comments ) { ?>
                    <div>
                        <?php
                        $post_comments_text = count($post_comments) . ' Kommentare';

                        if ( count($post_comments) == 1 ) {
                            $post_comments_text = count($post_comments) . ' Kommentar';
                        }
                        ?>
                        <a href="<?php echo get_the_permalink(); ?>#post-comments" title="<?php echo $post_comments_text; ?>">
                            <?php echo $post_comments_text; ?>
                        </a>
                    </div>
                <?php } ?>

            </div>

        </div>



        <?php
        $post_excerpt = get_the_excerpt();

        if ( $post_excerpt ) {
            ?>
            <div class="blog-list-entry-excerpt">
                <?php echo $post_excerpt; ?>
            </div>
            <?php
        }
        ?>

        <div class="blog-list-entry-more">
            <a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                Weiterlesen
            </a>
        </div>
    </div>



</article>
