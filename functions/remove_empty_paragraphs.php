<?php
function remove_empty_paragraphs($string) {

    $flags = PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY;
    $regex = '/(<[a-z0-9=\-:." ^\/]+\/>)|(<[^\/]+>[^<\/]+<\/[a-z0-9]+>)|(<[a-z0-9=\-:." ^\/]+>)/';
    $parts = preg_split( $regex, $string, -1, $flags);

    echo "<pre>";
        print_r($parts);
    echo "</pre>";

    // -- regex pattern to remove empty paragraphs
    $output = preg_replace( '#<p>\s*</p>#', '', $string );

    return preg_replace('#<p>(\s|&nbsp;)*+(<br\s*/*>)?(\s|&nbsp;)*</p>#i', '', $output);
}