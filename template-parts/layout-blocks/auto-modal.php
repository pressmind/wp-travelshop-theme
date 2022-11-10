<?php
use Pressmind\Travelshop\Template;
if(defined('TS_POPUP') && TS_POPUP['active'] && (TS_POPUP['output'] == 'home' ? is_front_page() : (TS_POPUP['output'] == 'all' ? true : is_page(TS_POPUP['output'])))) {
ob_start();
?>
<div id="auto-modal-content" data-multiple="<?php echo TS_POPUP['multiple'] ? 'true' : 'false'; ?>" data-type="<?php echo TS_POPUP['type']; ?>" data-delay="<?php echo TS_POPUP['delay']; ?>">
    <p>
        <?php echo TS_POPUP['text']; ?>
    </p>
    <a class="btn btn-primary" href="<?php echo TS_POPUP['button']['link'] ?>" target="<?php echo TS_POPUP['button']['target'] ?>">
        <?php echo TS_POPUP['button']['text'] ?>
    </a>
</div>
<?php
$modal_content = ob_get_contents();
ob_end_clean();



// = = = > load booking offers modal window < = = =
$args_modal = [];
$args_modal['title'] = isset(TS_POPUP['heading']) ? TS_POPUP['heading'] : 'Bevor Sie gehen...';
$args_modal['id_modal'] = 'automodal';
$args['hide_options'] = false;
$args_modal['content'] = $modal_content;

echo Template::render(APPLICATION_PATH . '/template-parts/layout-blocks/modalscreen.php', $args_modal);
}