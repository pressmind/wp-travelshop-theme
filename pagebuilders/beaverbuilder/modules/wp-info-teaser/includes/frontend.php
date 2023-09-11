<?php
/**
 * @var object $settings defined by beaver builder module
 */
$args = [];
$args['query'] = FLBuilderLoop::query( $settings )->query;
$args['headline'] = $settings->headline;
$args['text'] = $settings->text;
$args['uid'] = $module->node;
$args['layout_type'] = $settings->layout_type;
$args['display_on_desktop'] = $settings->display_on_desktop;
$args['mobile_slider'] = $settings->mobile_slider;
load_template_transient(get_template_directory() . '/template-parts/layout-blocks/info-teaser.php', false,  $args);
