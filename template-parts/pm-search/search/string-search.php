<?php
use Pressmind\Travelshop\Template;
/**
 * @var $args['name']
 */
?>

<div class="search-field-input search-field-input--fulltext" data-search-placeholder="<?php echo $args['placeholder']; ?>">

    <div class="input-icon">
        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#magnifying-glass"></use></svg>
    </div>
    <input class="search-field-input-field string-search-trigger" readonly type="search"  placeholder="<?php echo empty($args['name']) ? 'Suchbegriff' : $args['name'];?>" aria-label="Search" value="<?php echo !empty($_GET['pm-t']) ? $_GET['pm-t'] : '';?>">
    <div class="lds-dual-ring"></div>
</div>

<?php
// -- search overlay
echo Template::render(APPLICATION_PATH . '/template-parts/pm-search/search/string-search-overlay.php', ['args' => $args['args'] ]);
?>