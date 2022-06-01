<?php
/**
 * <code>
 * $args['id_media_object']
 * $args['code']
 * $args['is_cached_since']
 * $args['valid_from']
 * $args['valid_to']
 * </code>
 * @var array $args
 */
?>
<div class="small mb-2">
    ID/Code:
    <?php
    echo $args['id_media_object'];
    if(!empty($args['code'])){
        echo '/'.$args['code'];
    }
    /**
     * if the media object is cached, we display a short information about the content age
     */
    if(!empty($args['is_cached_since'])){
        echo '| Stand/Cache: '.$args['is_cached_since'];
    }
    /**
     * if we are running with crs imported data we can display the created date
     */
    if(!empty($args['booking_package_created_date'])){
        echo '<br>Preise & Verfügbarkeiten Stand: '.$args['booking_package_created_date'];
    }

    if(!empty($args['valid_from'])){
        echo '<br>Buchbar ab: '.$args['valid_from']->format('d.m.Y H:i');
    }

    if(!empty($args['valid_to'])){
        echo '<br>Buchbar bis: '.$args['valid_to']->format('d.m.Y H:i');
    }


    ?>
    <br>Programmänderungen vorbehalten.
</div>
