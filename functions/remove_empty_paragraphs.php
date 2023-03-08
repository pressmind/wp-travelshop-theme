<?php
function remove_empty_paragraphs($string) {
    $pattern = "/<p[^>]*><\\/p[^>]*>/";

    return preg_replace($pattern, '', $string);
}