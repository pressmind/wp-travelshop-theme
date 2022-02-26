<?php
/**
 * <code>
 *  $args['headline']
 *  $args['search_box'] = 'default_search_box'
 *  $args['class'] // main-color, silver, transparent
 * </code>
 * @var array $args
 */
?>
<section class="layout-block layout-block-search-header">
    <div class="layout-block-search-header--search">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-11 col-xl-10">
                <?php require  get_template_directory().'/template-parts/pm-search/search-bar.php';?>
                </div>
            </div>
        </div>
    </div>
</section>