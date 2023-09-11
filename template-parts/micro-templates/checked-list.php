<?php
/**
 * @var array $args['value']
 * @var array $args['responsive']
 */

if(empty($args['value'])){
    return;
}
echo str_replace([
        '<ul>', // TODO
        '<li>'
    ],
    [   '<ul class="checklist'.(!empty($args['responsive']) ? ' checklist checklist-responsive' : '').'">',
        '<li><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="/wp-content/themes/travelshop/assets/img/phosphor-sprite.svg#check-bold"></use></svg>'
    ],
    $args['value']
);