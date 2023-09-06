<?php
add_filter(
    'excerpt_length',
    function ( $length ) {
        // Number of words to display in the excerpt.
        return BLOG_EXCERPT_WORDS;
    },
    500
);