<?php
get_header();

global $wp_query;

?>
    <main>

        <div class="content-main content-main--posts">

            <div class="container">

                <div class="content-block content-block-blog--header">
                    <div class="row">
                        <div class="col-12">
                                <h1>
                                    <?php
                                    $found_posts = $wp_query->found_posts;
                                    ?>

                                    <?php echo $found_posts; ?> <?php if ( $wp_query->found_posts == 1 ) { echo "Beitrag"; } else { echo "Beiträge"; }?> für <?php echo get_search_query(); ?> gefunden
                                </h1>
                        </div>
                    </div>
                </div>


                <div class="content-block content-block-blog">
                    <div class="row">
                        <div class="col-12 col-md-9">
                            <div class="posts-list">
                                <?php if ( have_posts() ): ?>
                                <?php while ( have_posts() ) : the_post(); ?>

                                    <?php get_template_part( 'template-parts/wp-views/blog-list-entry' );  ?>

                                <?php endwhile; else: ?>

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
