<?php
function remove_empty_paragraphs($string) {
    echo "<pre>";
        print_r($string);
    echo "</pre>";

    $output = '';

    $stringParts = explode('<p>', str_replace('</p>', '', $string));

    foreach ( $stringParts as $part ) {
        echo "<pre>";
        print_R($part);
        echo "</pre>";
        if ( substr($part, 0, 1) === '<' ) {
            $output .= $part;
        } else {
            $output .= "<p>" . $part ."</p>";
        }
    }

    echo "<pre>";
    print_r($output);
    echo "</pre>";
}