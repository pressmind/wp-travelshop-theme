<?php
/**
 * @param $args array
 */

use Pressmind\Travelshop\Template;
use Pressmind\Travelshop\RouteHelper;
use Pressmind\Travelshop\Search;
?>

<div class="string-search-overlay">
    <div class="string-search-overlay-input">
        <div class="input-wrapper position-relative">
            <div class="input-icon">
                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#magnifying-glass"></use></svg>
            </div>
            <input class="form-control auto-complete auto-complete-overlay"  data-containerclass="autoCompleteContainerClass--SearchBar--1" type="search" data-autocomplete="true" placeholder="Wo soll es hingehen?" aria-label="Search" name="pm-t" value="<?php echo !empty($_GET['pm-t']) ? $_GET['pm-t'] : '';?>">
            <div class="lds-dual-ring"></div>
        </div>

        <button type="button" class="string-search-overlay-close d-lg-none">
            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#arrow-left"></use></svg>
        </button>
    </div>
    <div class="string-search-overlay-results" >
    </div>
</div>

<div class="string-search-overlay-backdrop"></div>