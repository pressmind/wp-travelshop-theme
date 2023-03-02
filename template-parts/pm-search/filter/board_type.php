<?php
/**
 * @var $args ['board_types']
 */

if (empty($args['board_types'])) {
    return;
}

$selected = [];
if (empty($_GET['pm-bt']) === false) {
    $selected = BuildSearch::extractBoardTypes($_GET['pm-bt']);
}
?>
<div class="list-filter-box board-type">
    <div class="list-filter-box-title">
        <strong>Verpflegung</strong>
    </div>
    <div class="list-filter-box-body">
        <?php
        foreach ($args['board_types'] as $item) {
            $uuid = 'bt-' . uniqid();
            ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="<?php echo $uuid; ?>"
                       data-id="<?php echo $item->name; ?>"
                    <?php echo in_array($item->name, $selected) ? 'checked' : ''; ?><?php echo !empty($is_open) ? 'disabled' : ''; ?>>
                <span>
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#check-bold"></use></svg>
                </span>
                <label class="form-check-label" for="<?php echo $uuid; ?>">
                    <?php echo $item->name; ?>
                </label>
            </div>
            <?php
        }
        ?>
    </div>
</div>