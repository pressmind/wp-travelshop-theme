<?php
get_header();
?>
    <!-- BREADCRUMB: START -->
<?php the_breadcrumb(null);?>
    <!-- BREADCRUMB: END -->

    <main>

        <div class="content-main content-main--posts" id="content-main">

            <div class="container">

                <div class="content-block content-block-blog-header">
                    <div class="row row-introduction">
                        <div class="col-12">
                            <h1><?php echo get_the_archive_title() ?></h1>
                        </div>
                    </div>
                </div>

                <div class="content-block content-block-blog">
                    <div class="row">
                        <div class="col-12 col-md-9">
                            <div class="posts-list" data-columns="<?php echo BLOG_LIST_COLUMNS; ?>">
                                <?php
                                // -- wp query, all posts
                                global $wp;

                                $count = get_option('posts_per_page', 10);
                                $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                                $offset = ($paged - 1) * $count;

                                $current_cat_ID = get_query_var('cat');
                                $get_permalink = get_category_link($current_cat_ID);


                                // get searchquery
                                $search_query = get_search_query();

                                $count_posts = $wp_query->found_posts;
                                ?>
                                <?php if ( have_posts() ): ?>
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
                                                    <a href="<?php echo $get_permalink; ?>page/<?php echo $i; ?>" class="page-link "><?php echo $i; ?></a>

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
                                                    <a href="<?php echo $get_permalink; ?>page/<?php echo $next_page; ?>" class="page-link page-link-chevron">
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
