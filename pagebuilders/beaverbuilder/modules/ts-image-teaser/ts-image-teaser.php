<?php

class TsImageTeaser extends FLBuilderModule {

    /**
     * @method __construct
     */
    public function __construct() {
        parent::__construct(array(
            'name'            => __( 'Image Teaser', 'fl-builder' ),
            'description'     => __( 'Image Teaser Element', 'fl-builder' ),
            'category'        => __( 'Custom content teaser', 'fl-builder' ),
            'group'        => __( 'Travelshop', 'fl-builder' ),
            'editor_export'   => false,
            'partial_refresh' => true,
            'icon'            => 'star-filled.svg',
            'dir'           => BB_MODULE_TS_DIR . 'modules/ts-image-teaser/',
            'url'           => BB_MODULE_TS_URL . 'modules/ts-image-teaser/',
        ));
    }

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('TsImageTeaser', array(

    'general' => array(
        'title'    => __( 'General', 'fl-builder' ),
        'sections' => array(
            'general'    => array(
                'title'  => __( 'General', 'fl-builder' ),
                'fields' => array(
                    'headline'     => array(
                        'type'    => 'text',
                        'label'   => __( 'Headline', 'fl-builder' ),
                        'default' => 'Headline',
                    ),

                    'text'     => array(
                        'type'    => 'editor',
                        'media_buttons' => false,
                        'wpautop'       => false,
                        'label'   => __( 'Text', 'fl-builder' ),
                        'default' => 'Some more informations'
                    ),

                    'button_text'     => array(
                        'type'    => 'text',
                        'label'   => __( 'Button Text', 'fl-builder' ),
                        'default' => '',
                    ),

                    'button_link'     => array(
                        'type'          => 'link',
                        'label'         => __('Button Link', 'fl-builder'),
                        'show_target'   => true,
                        'show_nofollow' => false,
                    ),
                ),
            ),

        ),
    ),
    'teasers' => array(
        'title'    => __( 'Teaser', 'fl-builder' ),
        'sections' => array(
            'common'    => array(
                'title'  => __( 'Teaser', 'fl-builder' ),
                'fields' => array(


                    'layout_type' => array(
                        'type' => 'select',
                        'label' => __('Layout', 'fl-builder'),
                        'options' => array(
                            'default' => 'Default ( Row with same sizes )',
                            'slider' => 'Item-Slider',
                        ),
                        'default' => 'default'
                    ),

                    'display_on_desktop' => array(
                        'type' => 'select',
                        'label' => __('Desktop Columns', 'fl-builder'),
                        'options' => array(
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                        ),
                        'default' => '3',
                    ),

                    'mobile_slider' => array(
                        'type' => 'select',
                        'label' => __('Mobile slider', 'fl-builder'),
                        'options' => array(
                            'default' => 'No',
                            'yes' => 'Yes'
                        ),
                        'default' => 'default',
                        'description' => 'This is only used if Layout is not "Item-Slider"',
                    ),

                    'teasers'     => array(
                        'type'          => 'form',
                        'label'         => __('Teaser', 'fl-builder'),
                        'form'          => 'ts-image-teaser-form', // ID from registered form below
                        'preview_text'  => 'headline', // Name of a field to use for the preview text
                        'multiple'      => true,
                        'limit'      => 99,
                    ),

                ),
            ),

        ),
    ),


));

FLBuilder::register_settings_form('ts-image-teaser-form', array(
    'title' => __('Teaser', 'fl-builder'),
    'tabs'  => array(
        'general'      => array( // Tab
            'title'         => __('General', 'fl-builder'), // Tab title
            'sections'      => array( // Tab Sections
                'general'       => array( // Section
                    'title'         => '', // Section Title
                    'fields'        => array( // Section Fields

                        'image' => array(
                            'type'          => 'photo',
                            'label'         => __('Image', 'fl-builder'),
                            'show_remove'   => true,
                        ),

                        'headline'       => array(
                            'type'          => 'text',
                            'label'         => __('Headline', 'fl-builder'),
                            'default'       => 'We make it! '
                        ),

                        'text'       => array(
                            'type'          => 'text',
                            'label'         => __('Text', 'fl-builder'),
                            'default'       => 'Some example text'
                        ),

                        'link_text'     => array(
                            'type'          => 'text',
                            'label'         => __('Link text', 'fl-builder'),
                            'default'       => 'Mehr erfahren'
                        ),

                        'link'     => array(
                            'type'          => 'link',
                            'label'         => __('Link', 'fl-builder'),
                            'show_target'   => true,
                            'show_nofollow' => false,
                        ),


                    )
                )
            )
        ),

    )
));