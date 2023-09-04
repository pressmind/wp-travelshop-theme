<?php
/**
 * @var object $settings defined by beaver builder module
 */

$args = [];
$args['uid'] = $module->node;

foreach($settings->slides as $slide){

    if($slide->slide_type == 'content'){
        $args['items'][] = [
            'type' => $slide->slide_type,
            'title' => $slide->headline,
            'text' => $slide->text,
            'image_post_id' => $slide->image,
            'media_type' => $slide->media_type,
            'video' => $slide->video,
            'image' => $slide->image_src,
            'image_alt_tag' => $slide->image_alt_text,
            'btn_link' => $slide->btn_link,
            'btn_link_target' => $slide->btn_link_target,
            'btn_label' => $slide->btn_label,
        ];
    }else if($slide->slide_type == 'product'){
        $args['items'][] = [
            'type' => $slide->slide_type,
            'pm-id' => trim($slide->{'pm-id'}),
            'image_type' => $slide->product_image_type,
            'image' => $slide->product_custom_image_src,
            'image_alt_tag' => $slide->product_custom_image_alt_text,
        ];
    }
}
load_template_transient(get_template_directory() . '/template-parts/layout-blocks/content-slider.php', false,  $args);
