<?php
function remove_empty_paragraphs($string) {
    $return = "<h1>   </h1>" . $string;

    return $return;
    // -- regex pattern to remove empty paragraphs
    $pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/";

    $return = trim($string);

    // -- easy replacement
    $return = str_replace("<p></p>", "", $return);

    // -- return with used regular expression $pattern
    return preg_replace($pattern, '', $return);
}