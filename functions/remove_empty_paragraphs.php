<?php
function remove_empty_paragraphs($string) {
    echo "<pre>",
    var_dump($string);
    echo "</pre>";
    // -- regex pattern to remove empty paragraphs
    $pattern = "/\s?<p>(\s|&nbsp;)*<\/p>/";

    $return = trim($string);

    // -- easy replacement
    $return = str_replace("<p></p>", "", $return);

    // -- return with used regular expression $pattern
    return preg_replace($pattern, '', $return);
}