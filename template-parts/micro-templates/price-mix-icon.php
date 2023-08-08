<?php
/**
 * <code>
 * $args['price_mix']
 * </code>
 * @var array $args
 */
?>
<?php if($args['price_mix'] == 'date_housing'){?>
    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#bed"></use></svg>
<?php }elseif($args['price_mix'] == 'date_ticket'){?>
    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#ticket"></use></svg>
<?php }else{ ?>
    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#star"></use></svg>
<?php } ?>