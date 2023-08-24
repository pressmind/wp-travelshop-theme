<?php

class TSWPCategoryHeader extends FLBuilderModule {

    /**
     * @method __construct
     */
    public function __construct() {
        parent::__construct(array(
            'name'            => __( 'Category Header', 'fl-builder' ),
            'description'     => __( 'customizable category header', 'fl-builder' ),
            'category'        => __( 'Content Modules', 'fl-builder' ),
            'group'        => __( 'Travelshop', 'fl-builder' ),
            'editor_export'   => false,
            'partial_refresh' => true,
            'icon'            => 'slides.svg',
            'dir'           => BB_MODULE_TS_DIR . 'modules/category-header/',
            'url'           => BB_MODULE_TS_URL . 'modules/category-header/',
        ));
    }

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('TSWPCategoryHeader', array(

    'common' => array(
        'title'    => __( 'Common', 'fl-builder' ),
        'sections' => array(
            'media' => array(
                'title' => __('Hintergrund', 'fl-builder' ),
                'fields' => array(
                    'background_height' => array(
                        'type' => 'unit',
                        'label' => __('Height', 'fl-builder'),
                        'description' => 'px',
                        'placeholder' => 400,
                        'default' => 400,
                        'responsive'  => true,
                        'help' => 'The height of the whole element.'
                    ),
                    'media_type' => array(
                        'type' => 'select',
                        'label' => __('Media-Type', 'fl-builder'),
                        'default' => 'image',
                        'options' => array(
                            'image' => 'Image',
                            'video' => 'Video'
                        ),
                        'toggle' => array(
                            'image' => array(
                                'fields' => array('image', 'image_alt_text')
                            ),
                            'video' => array(
                                'fields' => array('video')
                            )
                        )
                    ),
                    'video'    => array(
                        'type'          => 'video',
                        'label'         => __('Video', 'fl-builder'),
                    ),
                    'image'    => array(
                        'type'          => 'photo',
                        'label'         => __('Image', 'fl-builder'),
                        'show_remove'   => true,
                        'help' => 'To know: the selected image size has no effect. The bigslide-version is used by template.'
                    ),
                    'image_alt_text'     => array(
                        'type'    => 'text',
                        'label'   => __( 'alt-text', 'fl-builder' ),
                        'default' => '',
                        'help' => 'Nice stuff for search engines'

                    ),
                    'background_overlay_type' => array(
                        'type' => 'select',
                        'label' => __('Overlay shade type', 'fl-builder'),
                        'options' => array(
                            'none' => 'None',
                            'color' => 'Color',
                            'gradient' => 'Gradient'
                        ),
                        'default' => 'none',
                        'toggle' => array(
                            'none' => array(
                                'fields' => array()
                            ),
                            'color' => array(
                                'fields' => array('background_overlay_color')
                            ),
                            'gradient' => array(
                                'fields' => array('background_overlay_gradient')
                            )
                        )
                    ),
                    'background_overlay_color' => array(
                        'type' => 'color',
                        'label' => __('Overlay shade color', 'fl-builder'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'help' => 'Tip: use the alpha channel to create transparent overlays!'
                    ),
                    'background_overlay_gradient' => array(
                        'type' => 'gradient',
                        'label' => __('Overlay gradient', 'fl-builder'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'help' => 'Tip: use the alpha channel to create transparent overlays!',
                        'preview' => array(
                            'type'     => 'css',
                            'selector' => '.category-header-overlay',
                            'property' => 'background-image',
                        ),
                    ),
                )
            ),
            'content'    => array(
                'title'  => __( 'Content', 'fl-builder' ),
                'fields' => array(

                    'headline'     => array(
                        'type'    => 'text',
                        'label'   => __( 'Headline', 'fl-builder' ),
                        'default' => 'Headline',
                        'help' => 'Tip: if this field is empty, the whole content box is hidden/disabled.'
                    ),

                    'headline_type' => array(
                        'type' => 'select',
                        'label' => __('Headline type', 'fl-builder'),
                        'options' => array(
                            'h1' => 'H1',
                            'h2' => 'H2',
                            'h3' => 'H3',
                            'h4' => 'H4',
                            'h5' => 'H5',
                            'h6' => 'H6',
                        ),
                        'default' => 'h1'
                    ),

                    'subline'     => array(
                        'type'    => 'text',
                        'label'   => __( 'Subline', 'fl-builder' ),
                        'default' => 'Subline',
                    ),

                    'subline_type' => array(
                        'type' => 'select',
                        'label' => __('Subline type', 'fl-builder'),
                        'options' => array(
                            'h1' => 'H1',
                            'h2' => 'H2',
                            'h3' => 'H3',
                            'h4' => 'H4',
                            'h5' => 'H5',
                            'h6' => 'H6',
                        ),
                        'default' => 'h2'
                    ),

                    'text'     => array(
                        'type'    => 'editor',
                        'media_buttons' => false,
                        'wpautop'       => true,
                        'label'   => __( 'Text', 'fl-builder' ),
                        'default' => 'Some more informations',
                        'help' => 'Tip: use list\'s in this field. the bullets have nice check-icons. Pro Tip: use the &lt;hr&gt; element in src-editor.'
                    ),
                ),
            ),

            'position' => array(
              'title' => __('Position Content-Box', 'fl-builder'),
              'fields' => array(
                  'content_alignment_vertical' => array(
                      'type' => 'select',
                      'label' => __('Vertical', 'fl-builder'),
                      'options' => array(
                          'top' => 'Top',
                          'middle' => 'Middle',
                          'bottom' => 'Bottom',
                      ),
                      'responsive' => true,
                      'default' => 'middle'
                  ),
                  'content_alignment_horizontal' => array(
                      'type' => 'select',
                      'label' => __('Horizontal', 'fl-builder'),
                      'options' => array(
                          'left' => 'Left',
                          'center' => 'Center',
                          'right' => 'Right'
                      ),
                      'responsive' => true,
                      'default' => 'center'
                  ),
              )
            ),

            'style' => array(
                'title' => __('Style Content-Box', 'fl-builder'),
                'fields' => array(
                    'content_box_text_align' => array(
                        'type' => 'select',
                        'label' => __('Text align', 'fl-builder'),
                        'options' => array(
                            'text-left' => 'left',
                            'text-center' => 'center',
                            'text-right' => 'right'
                        ),
                        'default' => 'text-left'
                    ),
                    'content_box_type' => array(
                        'type' => 'select',
                        'label' => __('Box-Style', 'fl-builder'),
                        'options' => array(
                            'transparent' => 'Transparent',
                            'boxed' => 'Boxed',
                            'docked' => 'Docked'
                        ),
                        'default' => 'transparent',
                        'toggle' => array(
                            'boxed' => array(
                                'fields' => array('content_box_background', 'content_box_max_height', 'content_box_break')
                            ),
                            'docked' => array(
                                'fields' => array('content_box_background', 'content_box_max_height')
                            )
                        )
                    ),
                    'content_box_break' => array(
                        'type' => 'select',
                        'label' => __('Break content box under image/video on mobile devices', 'fl-builder'),
                        'options' => array(
                            'break' => 'yes',
                            'no-break' => 'no'
                        ),
                        'default' => 'break'
                    ),
                    'content_box_background' => array(
                        'type' => 'select',
                        'label'         => __( 'Content box theme', 'fl-builder' ),
                        'default'       => 'white',
                        'options' => array(
                            'white' => 'White',
                            'primary' => 'Primary'
                        ),
                    ),
                    'content_box_max_height' => array(
                        'type' => 'unit',
                        'label' => __('Content box max width', 'fl-builder'),
                        'description' => 'px',
                        'placeholder' => 380,
                        'default' => 380,
                    ),

                )
            )

        ),
    ),


));
