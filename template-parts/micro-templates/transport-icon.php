<?php
/**
 * <code>
 * $args['transport_type']
 * </code>
 * @var array $args
 */
?>
<?php if($args['transport_type'] == 'FLUG'){ ?>
    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#plane-tilt"></use></svg>
<?php }elseif($args['transport_type'] == 'BUS'){ ?>
    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#bus"></use></svg>
<?php }elseif($args['transport_type'] == 'PKW'){ ?>
    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#car"></use></svg>
<?php }else{ ?>
    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#calendar"></use></svg>
<?php } ?>