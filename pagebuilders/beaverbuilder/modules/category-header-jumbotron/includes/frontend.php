<?php
/**
 * @var object $settings defined by beaver builder module
 * @var object $module defined by beaver builder module
 */

$args = (array)$settings;
$args['uid'] = $module->node;
$args['background_overlay_gradient'] = FLBuilderColor::gradient($settings->background_overlay_gradient);
// inherit values to mobile if not set explicit
if (empty($args['content_alignment_vertical_responsive'])) {
    $args['content_alignment_vertical_responsive'] = $args['content_alignment_vertical'];
}
if (empty($args['content_alignment_vertical_medium'])) {
    $args['content_alignment_vertical_medium'] = $args['content_alignment_vertical'];
}
if (empty($args['content_alignment_horizontal_responsive'])) {
    $args['content_alignment_horizontal_responsive'] = $args['content_alignment_horizontal'];
}
if (empty($args['content_alignment_horizontal_medium'])) {
    $args['content_alignment_horizontal_medium'] = $args['content_alignment_horizontal'];
}
load_template_transient(get_template_directory() . '/template-parts/layout-blocks/category-header-jumbotron.php', false,  $args);
