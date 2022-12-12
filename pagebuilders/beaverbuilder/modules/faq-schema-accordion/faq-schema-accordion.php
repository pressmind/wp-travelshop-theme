<?php

class TSAccordion extends FLBuilderModule {

    /**
     * @method __construct
     */
    public function __construct() {
        parent::__construct(array(
            'name'            => __( 'Schema FAQ Accordion', 'fl-builder' ),
            'description'     => __( 'FAQ Accordion module with Schema output', 'fl-builder' ),
            'category'        => __( 'Content Modules', 'fl-builder' ),
            'group'        => __( 'Travelshop', 'fl-builder' ),
            'editor_export'   => false,
            'partial_refresh' => true,
            'icon'            => 'star-filled.svg',
            'dir'           => BB_MODULE_TS_DIR . 'modules/faq-schema-accordion/',
            'url'           => BB_MODULE_TS_URL . 'modules/faq-schema-accordion/',
        ));
    }

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('TSAccordion', array(

    'general' => array(
        'title'    => __( 'Items', 'fl-builder' ),
        'sections' => array(
            'common'    => array(
                'title'  => __( 'FAQ-Items', 'fl-builder' ),
                'fields' => array(
                    'expandfirst' => array(
                        'type'          => 'select',
                        'label'         => __( 'Expand first element?', 'fl-builder' ),
                        'default'       => 'false',
                        'options'       => array(
                            'true'      => __( 'Yes', 'fl-builder' ),
                            'false'      => __( 'No', 'fl-builder' )
                        ),
                    ),
                    'renderschema' => array(
                        'type'          => 'select',
                        'label'         => __( 'Render Schema-Markup?', 'fl-builder' ),
                        'default'       => 'false',
                        'options'       => array(
                            'true'      => __( 'Yes', 'fl-builder' ),
                            'false'      => __( 'No', 'fl-builder' )
                        ),
                    ),
                    'questions'     => array(
                        'type'          => 'form',
                        'label'         => __('Items', 'fl-builder'),
                        'form'          => 'faq-item-form', // ID from registered form below
                        'preview_text'  => 'question', // Name of a field to use for the preview text
                        'multiple'      => true,
                        'limit'      => 100,
                    ),

                ),
            ),

        ),
    ),


));

FLBuilder::register_settings_form('faq-item-form', array(
    'title' => __('FAQ', 'fl-builder'),
    'tabs'  => array(

        'general'      => array( // Tab
            'title'         => __('General', 'fl-builder'), // Tab title
            'sections'      => array( // Tab Sections
                'general'       => array( // Section
                    'title'         => '', // Section Title
                    'fields'        => array( // Section Fields
                        'question'       => array(
                            'type'          => 'text',
                            'label'         => __('Question', 'fl-builder'),
                            'default'       => '...'
                        ),
                        'answer'       => array(
                            'type'          => 'text',
                            'label'         => __('Answer', 'fl-builder'),
                            'default'       => '...'
                        )
                    )
                )
            )
        ),

    )
));
