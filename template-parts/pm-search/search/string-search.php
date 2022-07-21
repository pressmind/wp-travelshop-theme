<?php
/**
 * @var $args['name']
 */
?>
<div class="list-filter-box form-group mb-md-0 string-search">
    <label for=""><?php echo empty($args['name']) ? 'Suche' : $args['name'];?></label>
    <input class="form-control auto-complete" type="search" data-autocomplete="true" placeholder="Suchbegriff..." aria-label="Search" name="pm-t" value="<?php echo !empty($_GET['pm-t']) ? $_GET['pm-t'] : '';?>">
    <div class="lds-dual-ring"></div>
    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x string-search-clear" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#0066ff" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <line x1="18" y1="6" x2="6" y2="18" />
        <line x1="6" y1="6" x2="18" y2="18" />
    </svg>
</div>