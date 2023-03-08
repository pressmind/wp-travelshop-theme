<?php
function remove_empty_paragraphs($string) {
    // -- regex pattern to remove empty paragraphs
    $pattern = '#<p>[0-9 /]+/[0-9 /]+</p>#';

    $return = trim($string);

    // -- easy replacement
    $return = str_replace("<p></p>", "", $return);

    // -- return with used regular expression $pattern
    return preg_replace($pattern, '', $return);
}