<?php
/**
 * @todo optimize id, data tags in checkboxes
 * @var string $label
 * @var string $filter_data (fieldname_sectioname)
 * @var string $filter_param (i.e. "pm-du")
 * @var string $behavior (fieldname_sectioname)
 * @var string $filter_val (fieldname_sectioname)
 * @var $args
 */
if (empty($args['filter_data'][$args['filter_val']][array_key_first($args['filter_data'][$args['filter_val']])]) === false) { ?>
    <div class="col-12 col-lg-3 <?php echo $args['filter_val']; ?>">
        <div>
            <div class="form-group mb-lg-0 category-tree">
                <label for=""><?php echo $args['label']; ?></label>
                <div class="dropdown">
                    <button class="select-from-control dropdown-toggle" type="button"
                            data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <span class="selected-options" data-placeholder="bitte wählen">bitte wählen</span>

                        <svg class="dropdown-clear input-clear"><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>

                        <?php echo isset($args['icon']) ? $args['icon'] : ''; ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-select">
                        <div class="category-tree-field-items multi-level-checkboxes">
                            <input type="hidden" name="<?php echo $args['filter_param']; ?>" value="<?php echo empty($args['behavior']) ? 'OR' : $args['behavior']; ?>">
                            <?php foreach ($args['filter_data'][$args['filter_val']] as $key => $item) {
                                $uuid = 'ti-' . uniqid(); ?>
                                <div class="form-check has-second-level">
                                    <input class="form-check-input" type="<?php echo $args['type'] ?? 'checkbox' ?>"
                                           value="<?php echo $args['filter_data'][$args['filter_val2'] ?? $args['filter_val']][$key]; ?>"
                                           name="<?php echo $args['filter_val2'] ?? $args['filter_val']; ?>"
                                           filter-type="<?php echo $args['filter_val']; ?>"
                                           filter-param="<?php echo $args['filter_param']; ?>"
                                           id="<?php echo $uuid; ?>"
                                        <?php echo isset($_GET[$args['filter_param']]) && in_array(strtoupper($args['filter_data'][$args['filter_val2'] ?? $args['filter_val']][$key]), explode(',', strtoupper($_GET[$args['filter_param']]))) ? 'checked' : ''; ?>>

                                        <span>
                                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/iconoir-sprite.svg#check"></use></svg>
                                        </span>

                                    <label class="form-check-label" for="<?php echo $uuid; ?>">
                                        <?php echo is_int($key) ? $item : $key; ?>
                                    </label>
                                </div>
                                <?php } ?>
                        </div>
                        <button class="btn btn-primary btn-block mt-2 filter-prompt">
                            Filter anwenden
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php } ?>