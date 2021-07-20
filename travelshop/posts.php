<?php
get_header();
?>
    <main>

        <div class="content-main content-main--posts">

            <div class="container">

                <div class="content-block content-block-blog--header">
                    <div class="row">
                        <div class="col-12">
                            <h1>
                                Blog
                            </h1>
                        </div>
                    </div>
                </div>

                <div class="content-block content-block-blog">
                    <div class="row">
                        <div class="col-12 col-md-9">
                            <div class="posts-list">
                                <?php
                                // -- wp query, all posts
                                $args = array(
                                    'posts_per_page' => -1,
                                    'post_type' => 'post'
                                );

                                $the_query = new WP_Query($args);

                                if ( $the_query->have_posts() ):
                                ?>

                                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                                    <?php get_template_part( 'template-parts/wp-views/blog-list-entry' );  ?>

                                <?php endwhile; else : ?>

                                    Keine Beiträge gefunden.

                                <?php endif; ?>
                            </div>
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
