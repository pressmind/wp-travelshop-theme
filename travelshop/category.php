<?php
get_header();
?>
    <main>

        <div class="content-main content-main--posts">

            <div class="container">

                <div class="content-block content-block-blog--header">
                    <div class="row">
                        <div class="col-12">
                            <h1><?php echo get_the_archive_title() ?></h1>
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
