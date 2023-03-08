<?php
function remove_empty_paragraphs($string) {
    echo "<pre>";
        print_r($string);
    echo "</pre>";

    $stringParts = explode('<p>', $string);

    echo "<pre>";
    print_r($stringParts);
    echo "</pre>";
}