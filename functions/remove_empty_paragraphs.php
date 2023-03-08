<?php
function remove_empty_paragraphs($string) {
    // -- regex pattern to remove empty paragraphs
    $output = preg_replace( '#<p>\s*</p>#', '', $string );

    return preg_replace('#<p>(\s|&nbsp;)*+(<br\s*/*>)?(\s|&nbsp;)*</p>#i', '', $output);
}