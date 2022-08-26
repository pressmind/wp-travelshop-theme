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
        <div class="modal-title"><?php echo $args['title'];?></div>
        <button type="button" class="modal-close"><span></span></button>
        <div class="modal-body-outer">
            <div class="modal-body">
                <div class="modal-loader">
                    <div class="spinner">
                        <div class="sk-folding-cube">
                            <div class="sk-cube1 sk-cube"></div>
                            <div class="sk-cube2 sk-cube"></div>
                            <div class="sk-cube4 sk-cube"></div>
                            <div class="sk-cube3 sk-cube"></div>
                        </div>
                        <div class="msg" data-text="Suche Angebote...">Suche Angebote...</div>
                        <img class="brand" src="<?php echo SITE_URL;?>/wp-content/themes/travelshop/assets/img/travelshop-logo.svg">
                    </div>
                </div>
                <?php echo $args['content']; ?>
            </div>
        </div>
    </div>
</div>

