<?php
/**
 * Template Name: Blog
 * Template Post Type: page
 */
get_header();
the_breadcrumb(null);
?>
    <main>
        <div class="content-main content-main--posts" id="content-main">
            <div class="container">
                <div class="content-block content-block-blog--header">
                    <div class="row">
                        <div class="col-12">
                            <h1>
                                <?php the_title(); ?>
                            </h1>
                            <div class="content">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-block content-block-blog">
                    <div class="row">
                        <div class="col-12 col-md-9">
                            <div class="posts-list">
                                <?php
                                // -- wp query, all posts
                                $count = get_option('posts_per_page', 10);
                                $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                                $offset = ($paged - 1) * $count;

                                $args = array(
                                    'posts_per_page' => $count,
                                    'paged' => $paged,
                                    'offset' => $offset,
                                    'post_type' => 'post'
                                );

                                $the_query = new WP_Query($args);
                                $count_posts = $the_query->found_posts;

                                if ($the_query->have_posts()):
                                    ?>

                                    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

                                    <?php get_template_part('template-parts/wp-views/blog-list-entry'); ?>

                                <?php endwhile; else : ?>

                                    Keine Beiträge gefunden.

                                <?php endif; ?>
                                <?php wp_reset_postdata(); ?>
                            </div>

                            <?php if ($count_posts > $count) { ?>
                                <div class="posts-pagination">
                                    <nav>
                                        <ul class="pagination">
                                            <?php
                                            $prev_page = $paged - 1;
                                            $prev_page_str = '';

                                            if ($prev_page < 1) {
                                                $prev_page = 1;
                                            }

                                            if ($prev_page >= 1) {
                                                $prev_page_str = 'page/' . $prev_page;
                                            }
                                            ?>

                                            <li class="page-item <?php if ($paged == 1) {
                                                echo 'disabled';
                                            } ?>">
                                                <a href="<?php echo get_permalink(get_the_ID()) . $prev_page_str; ?>"
                                                   class="page-link">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="icon icon-tabler icon-tabler-chevron-left" width="16"
                                                         height="16" viewBox="0 2 24 24" stroke-width="2"
                                                         stroke="#607D8B" fill="none" stroke-linecap="round"
                                                         stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <polyline points="15 6 9 12 15 18"></polyline>
                                                    </svg>
                                                </a>
                                            </li>

                                            <?php

                                            $pager_active_class = '';

                                            for ($i = 1; $i <= $the_query->max_num_pages; $i++) {
                                                if ($i == $paged) {
                                                    $pager_active_class = 'active';
                                                } else {
                                                    $pager_active_class = '';
                                                }
                                                ?>
                                                <li class="page-item <?php echo $pager_active_class; ?>">
                                                    <a href="<?php echo get_permalink(get_the_ID()); ?>page/<?php echo $i; ?>"
                                                       class="page-link "><?php echo $i; ?></a>

                                                </li>
                                                <?php
                                            }

                                            ?>

                                            <?php if ($the_query->max_num_pages > 1) { ?>
                                                <?php
                                                $next_page = $paged + 1;

                                                if ($next_page > $the_query->max_num_pages) {
                                                    $next_page = $the_query->max_num_pages;
                                                }
                                                ?>
                                                <li class="page-item <?php if ($paged == $the_query->max_num_pages) {
                                                    echo 'disabled';
                                                } ?>">
                                                    <a href="<?php echo get_permalink(get_the_ID()); ?>page/<?php echo $next_page; ?>"
                                                       class="page-link">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                             class="icon icon-tabler icon-tabler-chevron-right"
                                                             width="16" height="16" viewBox="0 2 24 24" stroke-width="2"
                                                             stroke="#607D8B" fill="none" stroke-linecap="round"
                                                             stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <polyline points="9 6 15 12 9 18"></polyline>
                                                        </svg>
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
            </div>
        </div>
    </main>
<?php
get_footer();
