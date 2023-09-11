<?php
/**
 * @var object $settings defined by beaver builder module
 * @var object $module defined by beaver builder module
 */

$args = [];
$args = (array)$settings;
$args['uid'] = $module->node;

load_template_transient(get_template_directory() . '/template-parts/layout-blocks/ts-image-teaser.php', false,  $args);