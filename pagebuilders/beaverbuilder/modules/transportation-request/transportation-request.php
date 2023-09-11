<?php

/**
 * This is an example module with only the basic
 * setup necessary to get it working.
 *
 * @class FLBasicExampleModule
 */
class FLBasicExampleModule extends FLBuilderModule {

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Transportation Request', 'fl-builder'),
            'description'   => __('Form to send a transportation request', 'fl-builder'),
            'category'		=> __('Travelshop', 'fl-builder'),
            'dir'           => BB_MODULE_TS_DIR . 'modules/transportation-request/',
            'url'           => BB_MODULE_TS_URL . 'modules/transportation-request/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ));
    }
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLBasicExampleModule', array(
    'general'       => array( // Tab
        'title'         => __('General', 'fl-builder'), // Tab title
        'sections'      => array( // Tab Sections
            'general'       => array( // Section
                'title'         => __('Empfänger', 'fl-builder'), // Section Title
                'fields'        => array( // Section Fields
                    'email'     => array(
                        'type'          => 'text',
                        'label'         => __('Email-Adressen', 'fl-builder')
                    ),
                    'show_options' => array(
                        'type'          => 'select',
                        'label'         => __( 'Zusätzliche Ausstattungsoptionen', 'fl-builder' ),
                        'default'       => 'false',
                        'options'       => array(
                            'false'      => __( 'Nein', 'fl-builder' ),
                            'true'      => __( 'Ja', 'fl-builder' )
                        ),
                        'toggle'        => array(
                            'true'      => array(
                                'fields'        => array( 'additional_options' ),
                            ),
                        )
                    ),
                    'additional_options'     => array(
                        'type'          => 'text',
                        'label'         => __('Ausstattungsoptionen', 'fl-builder'),
                        'placeholder'   => __( 'Option 1; Option 2; Option 3', 'fl-builder' ),
                        'help'          => __( 'List, separated with semicolon', 'fl-builder' )
                    ),
                    'maincolor'    => array(
                        'type'          => 'color',
                        'label'         => __('Hauptfarbe', 'fl-builder'),
                        'default'       => 'e30613',
                        'show_reset'    => true,
                        'preview'         => array(
                            'type'            => 'css',
                            'selector'        => '.fl-example-text',
                            'property'        => 'color'
                        )
                    ),
                )
            )
        )
    )
));