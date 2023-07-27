<div class="stars-wrapper">
    <?php
    for ( $i = 0; $i < 5; $i++ ) {
        $ratingItemClass = '';

        if ( $i < $args['rating'] ) {
            $ratingItemClass = 'is-full';
        }

        if ( ( $args['rating'] - $i ) == 0.5 ) {
            $ratingItemClass = 'is-half';
        }
        ?>
        <div class="star-item <?php echo $ratingItemClass; ?>">
            <div class="icon">
                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#star-filled"></use></svg>
            </div>
        </div>
        <?php
    }
    ?>
</div>