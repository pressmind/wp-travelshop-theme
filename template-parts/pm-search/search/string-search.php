<?php
/**
 * @var $args['name']
 */
?>
<div class="list-filter-box form-group mb-md-0">
    <label for=""><?php echo empty($args['name']) ? 'Suche' : $args['name'];?></label>
    <input class="form-control auto-complete" type="search" data-autocomplete="true" placeholder="Suchbegriff..."
           aria-label="Search" name="pm-t" value="<?php echo !empty($_GET['pm-t']) ? $_GET['pm-t'] : ''; //@todo save?>">
</div>