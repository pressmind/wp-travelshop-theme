<?php
use Pressmind\Travelshop\Template;
if(defined('TS_USERLEAVES_POPUP') && TS_USERLEAVES_POPUP['active'] && (TS_USERLEAVES_POPUP['output'] == 'home' ? is_front_page() : (TS_USERLEAVES_POPUP['output'] == 'all' ? true : is_page(TS_USERLEAVES_POPUP['output'])))) {
ob_start();
?>
<div id="leave-modal-content" data-multiple="<?php echo TS_USERLEAVES_POPUP['multiple'] ? 'true' : 'false'; ?>" data-delay="<?php echo TS_USERLEAVES_POPUP['delay']; ?>">
    <p>
        <?php echo TS_USERLEAVES_POPUP['text']; ?>
    </p>
    <a class="btn btn-primary" href="<?php echo TS_USERLEAVES_POPUP['button']['link'] ?>" target="<?php echo TS_USERLEAVES_POPUP['button']['target'] ?>">
        <?php echo TS_USERLEAVES_POPUP['button']['text'] ?>
    </a>
</div>
<?php
$modal_content = ob_get_contents();
ob_end_clean();



// = = = > load booking offers modal window < = = =
$args_modal = [];
$args_modal['title'] = isset(TS_USERLEAVES_POPUP['heading']) ? TS_USERLEAVES_POPUP['heading'] : 'Bevor Sie gehen...';
$args_modal['id_modal'] = 'userleavesmodal';
$args['hide_options'] = false;
$args_modal['content'] = $modal_content;

echo Template::render(APPLICATION_PATH . '/template-parts/layout-blocks/modalscreen.php', $args_modal);
}