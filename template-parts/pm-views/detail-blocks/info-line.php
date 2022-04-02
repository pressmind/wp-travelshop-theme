<?php
/**
 * <code>
 * $args['id_media_object']
 * $args['code']
 * $args['is_cached_since']
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
    ?>
    <br>Programmänderungen vorbehalten.
</div>
