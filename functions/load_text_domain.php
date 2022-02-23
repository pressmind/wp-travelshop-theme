<?php
if (!MULTILANGUAGE_SITE) {
    add_filter('override_load_textdomain', '__return_true');
    add_filter('gettext', function ($translation, $text, $domain) {
        return $text;
    }, 10, 3);
}