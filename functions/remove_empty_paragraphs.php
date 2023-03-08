<?php
function remove_empty_paragraphs($string) {
    $pattern = "/<p[^>]*><\\/p[^>]*>/";

    // -- easy replacement
    $string = str_replace("<p></p>", "", $string);

    // -- return with used regular expression $pattern
    return preg_replace($pattern, '', $string);
}