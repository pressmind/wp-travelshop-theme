<?php

use Pressmind\Registry;

/**
 * @TODO
 *  - check if the duration is in the range and hide the other option values
 *  - the ranges are working only with mongo at this moment. change this.
 * @var $args ['duration_min']
 * @var $args ['duration_max']
 */
?>

<div class="list-filter-box list-filter-box-checkboxes list-filter-box-sorting">
    <div class="list-filter-box-title">
        <strong>Dauer</strong>
        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-down-bold"></use></svg>

    </div>
    <div class="list-filter-box-body">
        <select class="form-control mb-0" name="pm-du">
            <option value="">Dauer beliebig</option>
            <?php
            $config = Registry::getInstance()->get('config');
            foreach ($config['data']['search_mongodb']['search']['touristic']['duration_ranges'] as $range) {
                ?>
                <option value="<?php echo implode('-', $range);?>"<?php echo !empty($_GET['pm-du']) && $_GET['pm-du'] == implode('-', $range) ? ' selected' : ''; ?>>
                    <?php
                        if(next($config['data']['search_mongodb']['search']['touristic']['duration_ranges'] )){
                            echo implode('-', $range).' Tage';
                        }else{
                            echo $range[0].' Tage und mehr';
                        }
                    ?>
                </option>
               <?php
            }
            ?>
        </select>
    </div>
</div>