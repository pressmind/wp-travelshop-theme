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
    $args['query'] = array('numberposts' => 8, 'order' => 'desc');
} else {
    $args['query'] = array('numberposts' => $args['query']['posts_per_page'], 'order' => $args['query']['order']);
}
$postsObject = get_posts($args['query']);

if(count($postsObject) == 0){
    '<!-- module info-teaser: no posts found for this query -->';
    return;
}


$layout_type = isset($args['layout_type']) ? $args['layout_type'] : 'default';
$columns = isset($args['display_on_desktop']) ? (int)$args['display_on_desktop'] : 3;
$mobile_slider = false;
if ( !isset($args['mobile_slider']) ) {
    $args['mobile_slider'] = 'no';
}

if ( $layout_type !== 'slider' && $args['mobile_slider'] === 'yes' ) {
    $mobile_slider = true;
}

if ( !isset($args['uid']) ) {
    $args['uid'] =  (rand(0, 9999) * rand(0, 9999));
}
?>
<section class="content-block content-block-teaser-group" id="teaser-group-<?php echo $args['uid']; ?>">
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
        <div class="col-12">
            <div class="position-relative">
                <?php
                $wrapper = 'row';
                $item_wrapper = 'col-12 col-md-6 col-xl-4';

                if ( $columns === 4 ) {
                    $item_wrapper = 'col-12 col-md-6 col-xl-3';
                }

                if ( $columns === 2 ) {
                    $item_wrapper = 'col-12 col-md-6';
                }

                if ( $layout_type === 'slider' ) {
                    $wrapper = 'item-slider-wrapper';
                    $item_wrapper = 'slider-item';
                }

                if ( $layout_type === 'default' && $mobile_slider ) {
                    $wrapper = 'item-slider-wrapper item-slider-wrapper--mobile';
                    $item_wrapper = 'slider-item';
                }
                ?>

                <div class="<?php echo $wrapper; ?>" data-columns="<?php echo $columns; ?>">
                    <?php
                    foreach($postsObject as $p){
                        $p->class = $item_wrapper;
                        load_template(get_template_directory().'/template-parts/wp-views/info-teaser-view.php', false, $p);
                    }
                    ?>
                </div>


                <?php if ( $layout_type === 'slider' || $mobile_slider ) { ?>
                    <?php load_template( get_stylesheet_directory().'/template-parts/micro-templates/slider-controls.php', false, []); ?>
                <?php } ?>
            </div>
        </div>
    </div>
</section>