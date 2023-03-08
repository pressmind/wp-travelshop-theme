<?php
function checklist_formatter($content, $responsive = false) {

    $iconClass = '';
    $checkIcon = '<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="/wp-content/themes/travelshop/assets/img/phosphor-sprite.svg#check-bold"></use></svg>';
    $checkListClass = 'checklist';

    print_r($responsive);

    if ( $responsive ) {
        $checkListClass .= ' checklist-responsive';
    }

    return str_replace(['<ul>','<li>'], ['<ul class="checklist">','<li>'.$checkIcon], $content);
}
