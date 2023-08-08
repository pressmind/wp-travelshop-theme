<?php
/**
 * <code>
 *  $args['query'] // get_posts() arg list
 *  $args['headline'] // headline
 *  $args['text'] // introtext
 * </code>
 * @var array $args
 */

if(empty($args['query'])){
    $args['query'] = array('numberposts' => 6, 'order' => 'asc');
}
$postobjects = get_posts($args['query']);

if(count($postobjects) == 0){
    '<!-- module image-teaser: no posts found for this query -->';
    return;
}
?>
<section class="content-block content-block-teaser-group">
    <?php if(!empty($args['headline']) || !empty($args['text'])){?>
    <div class="row row-introduction">
            <div class="col-12">
                <?php if(!empty($args['headline'])){?>
                    <h2 class="mt-0"><?php echo $args['headline']; ?></h2>
                <?php } ?>
                <?php if(!empty($args['text'])){?>
                    <p><?php echo $args['text']; ?></p>
                <?php } ?>
            </div>
    </div>
    <?php } ?>
    <div class="row row-products">
        <?php
        foreach($postobjects as $p){
            load_template(get_template_directory().'/template-parts/wp-views/image-teaser-view.php', false, $p);
        }
        ?>
    </div>
</section>
