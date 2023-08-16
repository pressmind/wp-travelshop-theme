<?php
get_header();
?>

    <main>

        <div class="content-main content-main--posts" id="content-main">

            <div class="container">

                <div class="content-block content-block-blog-header">
                    <div class="row row-introduction">
                        <div class="col-12">
                            <h1 ><?php echo get_the_archive_title() ?></h1>
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
                        </div>
                    </div>
                </div>

                <div class="content-block content-block-blog">
                    <div class="row">
                        <div class="col-12 col-md-9">
                            <div class="posts-list" data-columns="<?php echo BLOG_LIST_COLUMNS; ?>">
                                <?php if ( have_posts() ): ?>
                                    <?php
                                    // -- wp query, all posts
                                    global $wp;

                                    $count = get_option('posts_per_page', 10);
                                    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                                    $offset = ($paged - 1) * $count;

                                    $current_cat_ID = get_query_var('cat');

                                    $get_permalink =  home_url( $wp->request );
                                    $get_permalink_split = explode('/page/', $get_permalink);

                                    $get_permalink = $get_permalink_split[0];

                                    // get searchquery
                                    $search_query = get_search_query();

                                    $count_posts = $wp_query->found_posts;
                                    ?>
                                    <?php while ( have_posts() ) : the_post(); ?>

                                        <?php get_template_part( 'template-parts/wp-views/blog-list-entry' );  ?>

                                    <?php endwhile; else: ?>

                                    Keine Beiträge gefunden.

                                <?php endif; ?>
                                <?php wp_reset_postdata(); ?>
                            </div>
                            <?php if ( $count_posts > $count ) { ?>
                                <div class="posts-pagination">
                                    <nav>
                                        <ul class="pagination justify-content-center">

                                            <?php
                                            $prev_page = $paged - 1;
                                            $prev_page_str = '';

                                            if ( $prev_page < 1 ) {
                                                $prev_page = 1;
                                            }

                                            if ( $prev_page >= 1 ) {
                                                $prev_page_str = '/page/' . $prev_page;
                                            }
                                            ?>

                                            <li  class="page-item <?php if ( $paged == 1 ) { echo 'disabled'; } ?>">
                                                <a href="<?php echo $get_permalink . $prev_page_str; ?>" class="page-link page-link-chevron">
                                                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-left-bold"></use></svg>

                                                </a>
                                            </li>

                                            <?php

                                            $pager_active_class = '';

                                            for ( $i = 1; $i <= $wp_query->max_num_pages; $i++ ) {
                                                if ( $i == $paged ) {
                                                    $pager_active_class = 'active';
                                                } else {
                                                    $pager_active_class = '';
                                                }
                                                ?>
                                                <li class="page-item <?php echo $pager_active_class; ?>">
                                                    <a href="<?php echo $get_permalink; ?>/page/<?php echo $i; ?>" class="page-link "><?php echo $i; ?></a>

                                                </li>
                                                <?php
                                            }

                                            ?>

                                            <?php if ( $wp_query->max_num_pages > 1 ) { ?>
                                                <?php
                                                $next_page = $paged + 1;

                                                if ( $next_page > $wp_query->max_num_pages ) {
                                                    $next_page = $wp_query->max_num_pages;
                                                }
                                                ?>
                                                <li  class="page-item <?php if ( $paged == $wp_query->max_num_pages ) { echo 'disabled'; } ?>">
                                                    <a href="<?php echo $get_permalink; ?>/page/<?php echo $next_page; ?>" class="page-link page-link-chevron">
                                                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-right-bold"></use></svg>

                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </nav>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-12 col-md-3">
                            <?php get_sidebar(); ?>
                        </div>
                    </div>
                </div>

            </div><!-- .container -->
        </div>

    </main>
<?php
get_footer();
