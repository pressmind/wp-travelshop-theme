<?php
get_header();
?>
    <main>
        <?php
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();
                load_template( get_stylesheet_directory().'/template-parts/content/content-'.get_post_type().'.php');
            }
        }
        ?>
    </main>
<?php
get_footer();