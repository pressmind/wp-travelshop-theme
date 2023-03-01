<?php
/**
 * <code>
 * $args['downloads']
 * </code>
 * @var array $args
 */


if(empty($args['downloads'])){
    return;
}
?>
<div class="small mb-2">
    <h3>Downloads:</h3>
    <ul>
    <?php
    foreach($args['downloads'] as $download){?>
        <li><a href="<?php echo $download['url'];?>" download><?php echo empty($download['file_name']) ?  $download['file_name'] : $download['description']; ?></a></li>
    <?php
    }
    ?>
    </ul>
</div>
