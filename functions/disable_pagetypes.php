<?php
add_action('template_redirect', function () {
    global $wp_query;

    if (!BLOG_ENABLE_AUTHORPAGE && is_author()) {
        $wp_query->set_404();
        status_header(404);
    }

    if (!BLOG_ENABLE_CATEGORYPAGE && is_category()) {
        $wp_query->set_404();
        status_header(404);
    }

});

