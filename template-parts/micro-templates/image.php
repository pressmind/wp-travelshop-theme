<?php
/**
 * <code>
 * $args['image']
 * $args['class']
 * </code>
 * @var array $args
 */

if (!empty($args['image']['url'])) { ?>
    <img src="<?php echo $args['image']['url']; ?>"
         title="<?php echo !empty($args['image']['copyright']) ? $args['image']['copyright'] : ''; ?>"
         alt="<?php echo !empty($args['image']['caption']) ? $args['image']['caption'] : ''; ?>"
         width="<?php echo $args['image']['size']['width']; ?>"
         height="<?php echo $args['image']['size']['height']; ?>"
         class="<?php echo $args['class'];?>"
         loading="lazy">
<?php } else { ?>
    <img src="/wp-content/themes/travelshop/placeholder.svg.php?wh=200x150&text=image missing" class="<?php echo $args['class'];?>">
<?php } ?>