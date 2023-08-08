<?php
function remove_empty_paragraphs($string) {

    $output = '';

    $stringParts = explode('<p>', str_replace('</p>', '', $string));

    foreach ( $stringParts as $part ) {
        if ( !empty($part) && $part !== '' ) {
            if ( substr($part, 0, 1) === '<' ) {
                $output .= $part;
            } else {
                $output .= "<p>" . $part ."</p>";
            }
        }
    }

    return $output;
}