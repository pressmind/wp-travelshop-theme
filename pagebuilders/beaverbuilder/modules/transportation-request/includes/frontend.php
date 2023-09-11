<?php

/**
 * This file should be used to render each module instance.
 * You have access to two variables in this file:
 *
 * $module An instance of your module class.
 * $settings The module's settings.
 *
 * Example:
 */
$args = [];
$args['emails'] = $settings->email;
$args['maincolor'] = $settings->maincolor;
$args['show_options'] = $settings->show_options;
$args['additional_options'] = $settings->additional_options;
load_template(get_template_directory() . '/template-parts/layout-blocks/transportation-request.php', false,  $args);