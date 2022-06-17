 <?php
/**
 * @todo optimize id, data tags in checkboxes
 * @var string $name
 * @var string $fieldname (fieldname_sectioname)
 * @var string $behavior (fieldname_sectioname)
 * @var $args['categories']
 */

 $selected = array();
 if(empty($_GET['pm-c'][$fieldname]) === false && preg_match_all("/[a-zA-Z0-9\-]+(?=[,|\+]?)/", $_GET['pm-c'][$fieldname], $matches) > 0){
     $selected = empty($matches[0]) ? array() : $matches[0];
 }

if (empty($args['categories'][$fieldname][0]) === false) {
    ?>
    <div class="list-filter-box category-tree">
        <div class="list-filter-box-title">
            <strong><?php echo $name; ?></strong>
        </div>
        <div class="category-tree-field-items list-filter-box-body">
            <input type="hidden" name="<?php echo $fieldname;?>-behavior" value="<?php echo empty($behavior) ? 'OR' : $behavior; ?>">
            <?php
            $childs = [];
            if(!empty($args['categories'][$fieldname][1])){
                foreach ($args['categories'][$fieldname][1] as $item) {
                    $childs[$item->id_parent][] = $item;
                }
            }
            foreach ($args['categories'][$fieldname][0] as $item) {
                $uuid = 'ti-'.uniqid();
                $has_childs = !empty($childs[$item->id_item]) && count($childs[$item->id_item]) > 1;
                // open the second level if neccessary
                $is_open = '';
                if(empty($selected) === false && $has_childs === true){
                    foreach ($childs[$item->id_item] as $child_item){
                        if(in_array($child_item->id_item, $selected) === true){
                            $is_open = ' is--open';
                            break;
                        }
                    }
                }
                ?>
                <div class="form-check <?php echo $has_childs ? 'has-second-level' : ''; echo $is_open;?>">

                    <input class="form-check-input" type="checkbox"
                           id="<?php echo $uuid; ?>"
                           data-id-parent=""
                           data-id="<?php echo $item->id_item; ?>"
                           data-name="<?php echo $fieldname;?>"
                    <?php echo in_array($item->id_item, $selected) ? 'checked' : '';?>
                            <?php echo !empty($is_open) ? 'disabled' : '';?>
                    ><span><i
                        ><svg class="icon icon-tabler icon-tabler-check"><use xlink:href="/wp-content/themes/travelshop/assets/img/icon-lib.svg#icon-tabler-check"></use></svg></i></span>
                    <label class="form-check-label" for="<?php echo $uuid; ?>">
                        <?php echo $item->name; ?>
                        <span class="small">(<?php echo $item->count_in_search; ?>)</span>
                    </label>
                    <?php if ($has_childs === true) { ?>
                        <button type="button" class="toggle-second-level" >
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler-dots-circle-horizontal" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z"/>
                                <circle cx="12" cy="12" r="9" />
                                <line x1="8" y1="12" x2="8" y2="12.01" />
                                <line x1="12" y1="12" x2="12" y2="12.01" />
                                <line x1="16" y1="12" x2="16" y2="12.01" />
                            </svg>
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
                                           ><span><i>
                                            <svg class="icon icon-tabler icon-tabler-check"><use xlink:href="/wp-content/themes/travelshop/assets/img/icon-lib.svg#icon-tabler-check"></use></svg>
                                        </i></span>
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
            }
            ?>
        </div>
    </div>
<?php } ?>