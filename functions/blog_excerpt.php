<?php
add_filter(
    'excerpt_length',
    function ( $length ) {
        // Number of words to display in the excerpt.
        return defined('BLOG_EXCERPT_WORDS') ? BLOG_EXCERPT_WORDS : 55;
    },
    500
);