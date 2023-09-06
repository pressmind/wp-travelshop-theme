<?php
/**
 * This modal can be called from two different ways:
 *
 * 1. From this generic WordPress Shortcode
 *      @example : [ts-modal id_post="124" name="Datenschutz"]
 *      @see /src/Shortcodes.php:modal()
 *
 * 2. From a cf7 form by this shortcode:
 *      @example [modal privacy post-id:542 "Datenschutz"]
 *      @see /functions/contactform7_modal_tag.php
 *
 * @var array $args{name:string,title:string,content:string,id_post:int,div_only:boolean,id_modal:string};
 */

$id_modal = !empty($args['id_modal']) ? $args['id_modal'] : null;
$id_modal = !empty($args['id_post']) ? $args['id_post'] : $id_modal;
if(empty($id_modal)){
    echo 'error: id_modal or id_post most be set';
    return;
}

if(isset($args['div_only']) && $args['div_only'] === false){
    ?>
    <a href="<?php echo get_permalink($args['id_post']);?>" data-modal="true" data-modal-id="modal-id-post-<?php echo $id_modal;?>"><?php echo $args['name'];?></a>
    <?php
}
?>
<div class="modal-forms modal-wrapper" id="modal-id-post-<?php echo $id_modal;?>">
    <div class="modal-inner">
        <div class="modal-content">
            <div class="modal-header">
                <div class="h4">
                    <?php echo $args['title'];?>
                </div>

                <button class="modal-close" type="button">
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="/wp-content/themes/travelshop/assets/img/phosphor-sprite.svg#x"></use></svg>
                </button>
            </div>

            <div class="modal-body">
                <?php echo $args['content']; ?>
            </div>
        </div>
    </div>
</div>

