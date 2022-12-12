<?php
/**
 * @var object $settings defined by beaver builder module
 */

$args = [];
$args['items'] = [];
$args['expandfirst'] = $settings->expandfirst;
$args['renderschema'] = $settings->renderschema;
if (!empty($settings->questions) ) {
    foreach ( $settings->questions as $item ) {
        $args['items'][] = [
            'question' => $item->question,
            'answer' => $item->answer
        ];
    }
}
load_template_transient(get_template_directory() . '/template-parts/layout-blocks/schema-accordion.php', false,  $args);