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
    </div>
    <div class="list-filter-box-body">
        <?php
        foreach ($args['transport_types'] as $item) {
            $uuid = 'tr-' . uniqid();
            ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="<?php echo $uuid; ?>"
                       data-id="<?php echo $item->name; ?>"
                    <?php echo in_array($item->name, $selected) ? 'checked' : ''; ?><?php echo !empty($is_open) ? 'disabled' : ''; ?>><span><i
                    ><svg class="icon icon-tabler icon-tabler-check"><use
                                    xlink:href="/wp-content/themes/travelshop/assets/img/icon-lib.svg#icon-tabler-check"></use></svg></i></span>
                <label class="form-check-label" for="<?php echo $uuid; ?>">
                    <?php echo ucfirst(strtolower($item->name)); ?>
                </label>
            </div>
            <?php
        }
        ?>
    </div>
</div>