<?php
/**
 * @var $args['name']
 */
?>
<div class="list-filter-box form-group mb-lg-0 string-search">
    <label for=""><?php echo empty($args['name']) ? 'Suche' : $args['name'];?></label>
    <div>
        <input class="form-control auto-complete" type="search" data-autocomplete="true" placeholder="Suchbegriff..." aria-label="Search" name="pm-t" value="<?php echo !empty($_GET['pm-t']) ? $_GET['pm-t'] : '';?>">
        <div class="lds-dual-ring"></div>
        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#magnifying-glass"></use></svg>
    </div>
</div>