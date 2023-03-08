<?php
function remove_empty_paragraphs($string) {
    // -- regex pattern to remove empty paragraphs
    $fix_empty_paragraphs = array(
        '<p>['    => '[',
        ']</p>'   => ']',
        ']<br />' => ']'
    );
    return strtr( $string, $fix_empty_paragraphs );
}