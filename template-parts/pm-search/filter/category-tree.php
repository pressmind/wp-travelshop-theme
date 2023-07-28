<?php
use Pressmind\Travelshop\Template;
/**
 * @todo optimize id, data tags in checkboxes
 * @var string $name
 * @var string $fieldname (fieldname_sectioname)
 * @var string $behavior (fieldname_sectioname)
 * @var string $type
 * @var int $preview
 * @var $args['categories']
 */

 $selected = array();
 if(empty($_GET['pm-c'][$fieldname]) === false && preg_match_all("/[a-zA-Z0-9\-]+(?=[,|\+]?)/", $_GET['pm-c'][$fieldname], $matches) > 0){
     $selected = empty($matches[0]) ? array() : $matches[0];
 }


if (empty($args['categories'][$fieldname][0]) === false) {
    ?>
    <div <?php echo ($type !== null && $type === 'expand') ? 'data-expanded="false"' : ''; ?>class="list-filter-box category-tree <?php echo ($type !== null && $type === 'expand') ? 'category-tree-expand' : ''; ?>">
        <div class="list-filter-box-title">
            <strong><?php echo $name; ?></strong>
            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-down-bold"></use></svg>

        </div>
        <?php
        if ( $search && $type !== 'expand') {
            ?>
            <div class="list-filter-box-search">
                <div class="input-group">
                    <input class="form-control" type="search" placeholder="<?php echo $name; ?> suchen" />
                    <div class="input-group-append">
                        <button class="input-group-btn" aria-label="Suchen">
                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#magnifying-glass"></use></svg>
                        </button>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="category-tree-field-items list-filter-box-body">
            <input type="hidden" name="<?php echo $fieldname;?>-behavior" value="<?php echo empty($behavior) ? 'OR' : $behavior; ?>">
            <?php if ( $search ) { ?>
            <div class="form-check-fallback d-none">
                Keine passenden Ergebnisse gefunden.<br>
                <a href="#" class="reset-filter-search">
                    Suche zurücksetzen
                </a>
            </div>
            <?php } ?>
            <?php
            $childs = [];
            if(!empty($args['categories'][$fieldname][1])){
                foreach ($args['categories'][$fieldname][1] as $item) {
                    $childs[$item->id_parent][] = $item;
                }
            }
            $expand = false;
            $dataPreview = '';
            $dataPreviewClass = '';
            $iterateItems = 1;

            if ( ($type !== null && $type === 'expand') ) {
                $expand = true;
                $dataPreview = 'true';
                $dataPreviewClass = '';
            }

            foreach ($args['categories'][$fieldname][0] as $item) {
                $uuid = 'ti-'.uniqid();
                $has_childs = !empty($childs[$item->id_item]) && count($childs[$item->id_item]) > 1;
                // open the second level if neccessary
                $is_open = '';
                if(empty($selected) === false && $has_childs === true){
                    foreach ($childs[$item->id_item] as $child_item){
                        if(in_array($child_item->id_item, $selected) === true){
                            $is_open = ' is-open';
                            break;
                        }
                    }
                }

                if ( $expand && $iterateItems > $preview ) {
                    $dataPreview = 'false';
                    $dataPreviewClass = 'd-none';
                }
                ?>
                <div data-preview="<?php echo $dataPreview; ?>" data-name="<?php echo $item->name; ?>" data-name-lowercase="<?php echo strtolower($item->name); ?>" class="form-check <?php echo $dataPreviewClass; ?> <?php echo $has_childs ? 'has-second-level' : ''; echo $is_open;?>">

                    <input class="form-check-input" type="checkbox"
                           id="<?php echo $uuid; ?>"
                           data-id-parent=""
                           data-id="<?php echo $item->id_item; ?>"
                           data-name="<?php echo $fieldname;?>"
                    <?php echo in_array($item->id_item, $selected) ? 'checked' : '';?>
                            <?php echo !empty($is_open) ? 'disabled' : '';?>
                    >
                    <span>
                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#check-bold"></use></svg>
                    </span>
                    <label class="form-check-label" for="<?php echo $uuid; ?>">
                        <?php
                        if ( $type === 'stars' ) {
                            echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/stars.php', [
                                'rating' => floatval($item->name),
                                'name' => $item->name,
                            ]);
                        } else {
                            echo $item->name;
                        }
                        ?>
                        <span class="small">(<?php echo $item->count_in_search; ?>)</span>
                    </label>
                    <?php if ($has_childs === true) { ?>
                        <button type="button" class="toggle-second-level" >
                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-down-bold"></use></svg>
                        </button>
                        <div class="list-filter-second-level">
                            <?php foreach ($childs[$item->id_item] as $child_item) {
                                $uuid = 'ti-'.uniqid();
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           id="<?php echo $uuid; ?>"
                                           data-id-parent="<?php echo $item->id_item; ?>"
                                           data-id="<?php echo $child_item->id_item; ?>"
                                           data-name="<?php echo $fieldname;?>"
                                        <?php echo in_array($child_item->id_item, $selected) ? 'checked' : '';?>
                                           >
                                    <span>
                                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#check-bold"></use></svg>
                                    </span>
                                    <label class="form-check-label" for="<?php echo $uuid; ?>">
                                        <?php echo $child_item->name; ?>
                                        <span class="small">(<?php echo $child_item->count_in_search; ?>)</span>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <?php
                $iterateItems++;
            }
            ?>
        </div>
        <?php
        if ($type !== null && $type === 'expand') {
            ?>
            <div class="list-filter-box-footer">
                <button type="button" class="category-tree-field-items-expand" data-more="Alle anzeigen" data-less="Weniger anzeigen">
                    Alle anzeigen
                </button>
            </div>
            <?php
        }
        ?>
    </div>
<?php } ?>