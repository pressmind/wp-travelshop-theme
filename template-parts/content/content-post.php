<?php the_breadcrumb(null);?>
<main>
    <div class="content-main content-main--posts" id="content-main">
        <div class="container">
            <div class="content-block content-block-blog">
                <div class="row">
                    <div class="col-12 col-md-9">
                        <?php get_template_part( 'template-parts/wp-views/blog-list-entry-single' );  ?>
                    </div>
                    <div class="col-12 col-md-3">
                        <?php get_sidebar(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>