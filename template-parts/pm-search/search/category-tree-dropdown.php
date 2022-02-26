<?php
/**
 * @todo optimize id & data tags in checkboxes
 * $args['name']
 * $args['fieldname'] fieldname_sectionname
 * $args['behavior'] AND | OR
 * $args['categories'] (from main search result)
 * @var $args
 */

$selected = array();
if (empty($_GET['pm-c'][$args['fieldname']]) === false && preg_match_all("/[a-zA-Z0-9\-]+(?=[,|\+]?)/", $_GET['pm-c'][$args['fieldname']], $matches) > 0) {
    $selected = empty($matches[0]) ? array() : $matches[0];
}
if (empty($args['categories'][$args['fieldname']][0]) === false) {
    ?>
    <div class="col-12 col-md-3">
        <div>
            <div class="form-group mb-md-0 category-tree">
                <label for=""><?php echo $args['name']; ?></label>
                <div class="dropdown">
                    <button class="dropdownReiseziel select-from-control dropdown-toggle" type="button"
                            data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <span class="selected-options" data-placeholder="bitte wählen">bitte wählen</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x dropdown-clear"
                             width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-select"
                         aria-labelledby="dropdownReiseziel">
                        <div class="category-tree-field-items multi-level-checkboxes">
                            <input type="hidden" name="<?php echo $args['fieldname'];?>-behavior" value="<?php echo empty($args['behavior']) ? 'OR' : $args['behavior']; ?>">
                            <?php
                            $childs = [];
                            if (!empty($args['categories'][$args['fieldname']][1])) {
                                foreach ($args['categories'][$args['fieldname']][1] as $item) {
                                    $childs[$item->id_parent][] = $item;
                                }
                            }
                            foreach ($args['categories'][$args['fieldname']][0] as $item) {
                                $uuid = 'ti-' . uniqid();
                                $has_childs = !empty($childs[$item->id_item]) && count($childs[$item->id_item]) > 1;
                                ?>
                                <div class="form-check <?php echo $has_childs ? 'has-second-level' : ''; ?>">
                                    <input class="form-check-input" type="checkbox"
                                           data-id-parent="" data-id="<?php echo $item->id_item; ?>"
                                           data-name="<?php echo $args['fieldname']; ?>"
                                           id="<?php echo $uuid; ?>"
                                        <?php echo in_array($item->id_item, $selected) ? 'checked' : ''; ?>><span><i>
                                            <svg class="icon icon-tabler icon-tabler-check"><use xlink:href="/wp-content/themes/travelshop/assets/img/icon-lib.svg#icon-tabler-check"></use></svg>
                                        </i></span>
                                    <label class="form-check-label" for="<?php echo $uuid; ?>">
                                        <?php echo $item->name; ?>
                                    </label>
                                    <?php /* if ($has_childs === true) { ?>

                                <div class="list-filter-second-level">
                                    <?php foreach ($childs[$item->id_item] as $child_item) {
                                        $uuid = 'ti-'.uniqid();
                                        ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   id="<?php echo $uuid; ?>"
                                                   data-id-parent="<?php echo $item->id_item; ?>"
                                                   data-id="<?php echo $child_item->id_item; ?>"
                                                   data-name="<?php echo $args['fieldname']; ?>"><span><i><svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-check" width="12"
                                                            height="12" viewBox="0 0 24 24" stroke-width="3"
                                                            stroke="#ffffff" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z"/>
  <path d="M5 12l5 5l10 -10"/>
</svg></i></span>
                                            <label class="form-check-label"
                                                   for="<?php echo $uuid; ?>">
                                                <?php echo $child_item->name; ?>                                            </label>
                                        </div>
                                    <?php } ?>


                                </div>

                            <?php } */ ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <button class="btn btn-primary btn-block mt-3 filter-prompt">
                            Auswahl übernehmen
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php } ?>