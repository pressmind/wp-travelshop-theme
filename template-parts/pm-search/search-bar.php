<?php
/**
 *  <code>
 *  $args['headline']
 *  $args['search_box'] = 'default_search_box'
 *  $args['class'] // main-color, silver, transparent
 * </code>
 * @var array $args
 */
?>
<div class="search-wrapper">
    <?php if(!empty($args['headline'])){?>
        <div class="h1 text-md-center mt-0 mb-2 mb-4">
            <?php echo $args['headline'];?>
        </div>
    <?php } ?>
    <?php
    require 'search/searchbar-tabs.php';
    require 'search/searchbar-form.php';
    ?>
</div>