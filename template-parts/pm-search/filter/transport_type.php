<?php
/**
 * @var $args ['transport_types']
 */

if (empty($args['transport_types']) && count($args['transport_types']) > 1) {
    return;
}

$selected = [];
if (empty($_GET['pm-tr']) === false) {
    $selected = BuildSearch::extractTransportTypes($_GET['pm-tr']);
}
?>
<div class="list-filter-box transport-type">
    <div class="list-filter-box-title">
        <strong>Anreiseart</strong>
        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-down-bold"></use></svg>

    </div>
    <div class="list-filter-box-body">
        <?php
        foreach ($args['transport_types'] as $item) {
            $uuid = 'tr-' . uniqid();
            ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="<?php echo $uuid; ?>"
                       data-id="<?php echo $item->name; ?>"
                    <?php echo in_array($item->name, $selected) ? 'checked' : ''; ?><?php echo !empty($is_open) ? 'disabled' : ''; ?>>
                <span>
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#check-bold"></use></svg>
                </span>
                <label class="form-check-label" for="<?php echo $uuid; ?>">
                    <?php echo ucfirst(strtolower($item->name)); ?>
                    <span class="small">(<?php echo $item->count_in_search; ?>)</span>
                </label>
            </div>
            <?php
        }
        ?>
    </div>
</div>