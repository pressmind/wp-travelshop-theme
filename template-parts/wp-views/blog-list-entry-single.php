<article class="blog-entry-single">
    <div class="blog-list-entry">

        <?php
        $post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large');
        ?>


        <div class="blog-list-entry-header">

            <h1 class="blog-list-entry-title">
                <?php echo get_the_title(); ?>
            </h1>

            <?php
            $post_categories = wp_get_post_categories(get_the_ID());
            $post_tags = wp_get_post_tags(get_the_ID());
            ?>

            <div class="blog-list-entry-details small d-flex flex-row flex-wrap gap-2">

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

                ?>


                <?php if ( $post_date ) { ?>
                    <div class="blog-list-entry-details-item">
                        <div class="blog-list-entry-details-item-inner">
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
                    </div>
                <?php } ?>

                <?php if ( $post_author_name ) { ?>
                    <div class="blog-list-entry-details-item"><div class="blog-list-entry-details-item-inner">Autor: <a href="<?php echo $post_author_link; ?>" title="<?php echo $post_author_name; ?>"><?php echo $post_author_name; ?></a></div></div>
                <?php } ?>



                <?php if ( $post_comments ) { ?>
                    <div class="blog-list-entry-details-item">
                        <div class="blog-list-entry-details-item-inner">
                            <?php
                            $post_comments_text = count($post_comments) . ' Kommentare';

                            if ( count($post_comments) == 1 ) {
                                $post_comments_text = count($post_comments) . ' Kommentar';
                            }
                            ?>
                            <a href="<?php echo get_the_permalink(); ?>#post-comments" title="<?php echo $post_comments_text; ?>"><?php echo $post_comments_text; ?></a>
                        </div>
                    </div>
                <?php } ?>

            </div>

        </div>

        <?php if ( $post_thumbnail ) { ?>
            <div class="blog-list-entry-thumbnail">
                <div class="media-cover media-border-radius media-hover-scale ratio-16x9">
                    <img src="<?php echo $post_thumbnail; ?>" alt="<?php echo get_the_title(); ?>" />
                </div>
            </div>
        <?php } ?>

        <div class="blog-list-entry-body">
            <div class="blog-list-entry-content">
                <?php the_content(); ?>
            </div>



            <?php if ( $post_categories || $post_tags ) { ?>

            <div class="blog-list-entry-crosslinks">

                <?php if ( $post_categories ) { ?>
                    <?php
                    $post_categories_html = '';
                    foreach ( $post_categories as $category ) {
                        $post_category = get_category($category);

                        $post_categories_html .= '<a class="badge badge-pill badge-secondary" href="'.get_category_link( $post_category->term_id ).'" title="'.$post_category->name.'">'.$post_category->name.'</a>';

                    }
                    ?>
                    <div>
                        Kategorien: <?php echo $post_categories_html; ?>
                    </div>
                <?php } ?>

                <?php if ( $post_tags ) { ?>
                    <?php
                    $post_tags_html = '';

                    foreach ( $post_tags as $tag ) {

                        $post_tags_html .= '<a class="badge badge-pill badge-secondary" href="'.get_tag_link( $tag->term_id ).'" title="'.$tag->name.'">'.$tag->name.'</a>';

                    }
                    ?>
                    <div>
                        Stichworte: <?php echo $post_tags_html; ?>
                    </div>
                <?php } ?>
            </div>

            <?php } ?>

        </div>



    </div>



    <?php if ( (bool) get_the_author_meta( 'description' ) && post_type_supports( get_post_type(), 'author' ) ) : ?>

        <div class="blog-list-entry blog-list-entry-author">
            <div class="blog-list-entry-body">


                <div class="author-bio <?php echo get_option( 'show_avatars' ) ? 'show-avatars' : ''; ?>">
                    <div class="author-bio-image">
                        <div class=" media-cover ratio-1x1 media-circle">
                            <?php echo get_avatar( get_the_author_meta( 'ID' ), '85' ); ?>
                        </div>
                    </div>
                    <div class="author-bio-content">
                        <h4 class="author-title">
                            <a href="<?php echo $post_author_link; ?>" title="<?php echo $post_author_name; ?>"><?php echo $post_author_name; ?></a>
                        </h4>

                        <?php
                        $author_website = get_the_author_meta('url');
                        $author_social = [];

                        if ( get_the_author_meta('facebook') ) {
                            $author_social['facebook'] = get_the_author_meta('facebook');
                        }

                        if ( get_the_author_meta('twitter') ) {
                            $author_social['twitter'] = get_the_author_meta('twitter');
                        }

                        if ( get_the_author_meta('instagram') ) {
                            $author_social['instagram'] = get_the_author_meta('instagram');
                        }

                        if ( get_the_author_meta('youtube') ) {
                            $author_social['youtube'] = get_the_author_meta('youtube');
                        }

                        if ( get_the_author_meta('linkedin') ) {
                            $author_social['linkedin'] = get_the_author_meta('linkedin');
                        }

                        if ( get_the_author_meta('pinterest') ) {
                            $author_social['pinterest'] = get_the_author_meta('pinterest');
                        }
                        ?>
                        <?php if ( $author_website || !empty($author_social) ) { ?>
                            <div class="author-links social-links d-flex flex-row gap-1 align-items-center">

                                <?php
                                if ( !empty($author_social) ) {
                                    foreach ( $author_social as $key => $social ) {
                                        ?>
                                        <a href="<?php echo $social; ?>" target="_blank" class="social-link social-link-<?php echo $key; ?>">
                                            <?php
                                            switch ( $key ) {
                                                case 'facebook':
                                                    echo '<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="'.get_stylesheet_directory_uri().'/assets/img/social-media-sprite.svg#social-facebook"></use></svg>';
                                                    break;

                                                case 'instagram':
                                                    echo '<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="'.get_stylesheet_directory_uri().'/assets/img/social-media-sprite.svg#social-instagram"></use></svg>';
                                                    break;

                                                case 'twitter':
                                                    echo '<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="'.get_stylesheet_directory_uri().'/assets/img/social-media-sprite.svg#social-twitter"></use></svg>';
                                                    break;

                                                case 'youtube':
                                                    echo '<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="'.get_stylesheet_directory_uri().'/assets/img/social-media-sprite.svg#social-youtube"></use></svg>';
                                                    break;

                                                case 'pinterest':
                                                    echo '<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="'.get_stylesheet_directory_uri().'/assets/img/social-media-sprite.svg#social-pinterest"></use></svg>';
                                                    break;

                                                case 'linkedin':
                                                    echo '<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="'.get_stylesheet_directory_uri().'/assets/img/social-media-sprite.svg#social-linkedin"></use></svg>';
                                                    break;
                                            }
                                            ?>
                                        </a>
                                        <?php
                                    }
                                }
                                ?>

                                <?php if ( $author_website ) { ?>
                                    <a href="<?php echo $author_website; ?>" target="_blank" class="social-link">
                                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#globe"></use></svg>
                                    </a>
                                <?php } ?>

                            </div>
                        <?php } ?>

                        <p class="author-description"> <?php the_author_meta( 'description' ); ?></p><!-- .author-description -->
                    </div>
                </div>
            </div>

        </div>
    <?php endif; ?>

    <div class="blog-list-entry blog-list-entry-related">
        <div class="blog-list-entry-body">
            <h3>
                Weitere Beiträge
            </h3>

            <div class="related-posts">
                <div class="row">
                    <?php

                    $related = get_posts( array( 'category__in' => wp_get_post_categories(get_the_ID()), 'numberposts' => 3, 'post__not_in' => array(get_the_ID()) ) );
                    if( $related ) foreach( $related as $post ) {
                        setup_postdata($post); ?>

                        <div class="col-12 col-md-4">
                            <article class="post-item">
                                <?php
                                $post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large');
                                ?>

                                <div class="row">

                                    <?php if ( $post_thumbnail ) { ?>
                                    <div class="col-4 col-md-12">
                                        <div class="blog-list-entry-thumbnail">
                                            <a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>" class="media-cover media-hover-scale media-border-radius ratio-16x9">
                                                <img src="<?php echo $post_thumbnail; ?>" alt="<?php echo get_the_title(); ?>" />
                                            </a>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <div class="<?php if ( $post_thumbnail ) { ?>col-8<?php } else { ?>col-12<?php } ?> col-md-12">
                                        <h1 class="blog-list-entry-title related">
                                            <a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                                                <?php echo get_the_title(); ?>
                                            </a>
                                        </h1>

                                        <div class="blog-list-entry-details small d-flex flex-row flex-wrap gap-2">

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

                                            ?>


                                            <?php if ( $post_date ) { ?>
                                                <div>
                                                    <a href="<?php echo $post_date_link; ?>" title="<?php echo $post_date; ?>"><?php echo $post_date; ?></a><?php if ( $post_author_name ) { ?>&nbsp;von <a href="<?php echo $post_author_link; ?>" title="<?php echo $post_author_name; ?>"><?php echo $post_author_name; ?></a><?php } ?>
                                                </div>
                                            <?php } ?>

                                        </div>

                                        <?php if ( !$post_thumbnail ) { ?>
                                            <?php
                                            $post_excerpt = get_the_excerpt();

                                            if ( $post_excerpt ) {
                                                ?>
                                                <div class="blog-list-entry-excerpt">
                                                    <?php echo substr($post_excerpt, 0, 120) . '...'; ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        <?php } ?>
                                    </div>
                                </div>



                            </article>
                        </div>

                    <?php }
                    wp_reset_postdata(); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="blog-list-entry blog-list-entry-postnav">
        <div class="blog-list-entry-body">
            <?php
            // Previous/next post navigation.
            $post_next_label     = 'Nächster Artikel';
            $post_prev_label = 'Vorheriger Artikel';

            $post_nav_arrow_prev = '<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="'.get_stylesheet_directory_uri(). '/assets/img/phosphor-sprite.svg#caret-left-bold"></use></svg>';
            $post_nav_arrow_next = '<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="'.get_stylesheet_directory_uri(). '/assets/img/phosphor-sprite.svg#caret-right-bold"></use></svg>';


            $post_nav = get_the_post_navigation(
                array(
                    'next_text' => '<p class="meta-nav">' . $post_nav_arrow_next . $post_next_label . '</p><p class="post-title">%title</p>',
                    'prev_text' => '<p class="meta-nav">' . $post_prev_label . $post_nav_arrow_prev . '</p><p class="post-title">%title</p>',
                    'screen_reader_text' => __( 'A' )
                )
            );

            $post_nav = str_replace('<h2 class="screen-reader-text">A</h2>', '', $post_nav);

            echo $post_nav;
            ?>
        </div>
    </div>

    <?php
    $post_comments = get_comments( array('post_id' => get_the_ID() ) );
    ?>

    <?php
    if ( $post_comments ) {
        $post_comments_text = count($post_comments) . ' Kommentare';

        if ( count($post_comments) == 1 ) {
            $post_comments_text = count($post_comments) . ' Kommentar';
        }
    } else {
        $post_comments_text = '0 Kommentare';
    }
    ?>
    <div class="blog-list-entry blog-list-entry-comments">
        <div class="blog-list-entry-body">
            <h3>
                <?php echo $post_comments_text; ?> zu "<?php echo get_the_title(); ?>"
            </h3>

            <div class="blog-list-entry-comments-list">
                <?php comments_template(); ?>
            </div>
        </div>
    </div>
</article>
