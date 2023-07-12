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
    <div class="search-box-field search-box-field--category">

        <div class="search-field-input search-field-input--category category-tree-field-dropdown">
            <button class="category-tree-field-dropdown-toggle search-field-input-field" type="button">
                <span class="selected-options" data-placeholder="<?php echo $args['name']; ?>"><?php echo $args['name']; ?></span>

                <svg class="dropdown-clear input-clear"><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>

            </button>
            <?php // @todo: did some changes to quellcode to use different view types for dropdowns ?>
            <div class="category-tree-field-dropdown">
                <div class="category-tree-field-dropdown d-flex flex-row flex-nowrap justify-content-between">
                    <div class="h5 mb-0">
                        <?php echo $args['name']; ?>
                    </div>

                    <button type="button" class="close-category-dropdown d-flex d-lg-none">
                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="https://development-stanglmeier-de.pressmind.dev/wp-content/themes/travelshop/assets/img/phosphor-sprite.svg#x"></use></svg>
                    </button>
                </div>
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
                                <?php echo in_array($item->id_item, $selected) ? 'checked' : ''; ?>>

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

                <div class="category-tree-field-dropdown-footer">
                    <button class="btn btn-primary btn-block mt-3 filter-prompt">
                        Auswahl übernehmen
                    </button>
                </div>
            </div>
        </div>

        <div class="category-tree-field-backdrop"></div>
    </div>
<?php } ?>