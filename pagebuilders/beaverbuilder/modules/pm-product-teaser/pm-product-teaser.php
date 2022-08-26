<?php

class TSPMProductTeaser extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Product Teaser', 'fl-builder' ),
			'description'     => __( 'Product teaser based on pressmind media objects', 'fl-builder' ),
			'category'        => __( 'pressmind Teaser', 'fl-builder' ),
			'group'        => __( 'Travelshop', 'fl-builder' ),
			'editor_export'   => false,
			'partial_refresh' => true,
			'icon'            => 'schedule.svg',
            'dir'           => BB_MODULE_TS_DIR . 'modules/pm-product-teaser/',
            'url'           => BB_MODULE_TS_URL . 'modules/pm-product-teaser/',
		));
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('TSPMProductTeaser', array(

    'common' => array(
        'title'    => __( 'Common', 'fl-builder' ),
        'sections' => array(
            'common'    => array(
                'title'  => __( 'Common', 'fl-builder' ),
                'fields' => array(
                    'headline'     => array(
                        'type'    => 'text',
                        'label'   => __( 'Headline', 'fl-builder' ),
                        'default' => 'Reise-Empfehlungen',
                        'help' => 'Tip: use the shortcode [TOTAL_RESULT] in this field to display the amount of found products'

                    ),

                    'text' => array(
                        'type'    => 'editor',
                        'media_buttons' => false,
                        'wpautop'       => false,
                        'label'   => __( 'Text', 'fl-builder' ),
                        'help' => 'Tip: use the shortcode [TOTAL_RESULT] in this field to display the amount of found products',
                        'default' => 'Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip. ',
                    ),
                ),
            ),
            'more_button'    => array(
                'title'  => __( 'More Buttons', 'fl-builder' ),
                'fields' => array(
                    'link_top'  => array(
                        'type' => 'select',
                        'label' => __('Button as small link, position top', 'fl-builder'),
                        'default'       => 'true',
                        'options'       => array(
                            'true'      => __( 'Yes', 'fl-builder' ),
                            'false'      => __( 'No', 'fl-builder' )
                        ),
                        'toggle'        => array(
                            'true'      => array(
                                'fields'        => array( 'link_top_text'),
                            ),
                        ),
                    ),
                    'link_top_text' => array(
                        'type' => 'text',
                        'label' => __('Label', 'fl-builder'),
                        'default' => 'Alle [TOTAL_RESULT] Reisen zum Thema anzeigen'
                    ),
                    'link_teaser'  => array(
                        'type' => 'select',
                        'label' => __('Button as fat teaser, inline', 'fl-builder'),
                        'default'       => 'false',
                        'options'       => array(
                            'true'      => __( 'Yes', 'fl-builder' ),
                            'false'      => __( 'No', 'fl-builder' )
                        ),
                        'toggle'        => array(
                            'true'      => array(
                                'fields'        => array( 'link_teaser_text'),
                            ),
                        ),
                    ),
                    'link_teaser_text' => array(
                        'type' => 'text',
                        'label' => __('Label', 'fl-builder'),
                        'default' => 'Alle [TOTAL_RESULT] Reisen zum Thema anzeigen'
                    ),
                    'link_bottom'  => array(
                        'type' => 'select',
                        'label' => __('Big button, position bottom', 'fl-builder'),
                        'default'       => 'true',
                        'options'       => array(
                            'true'      => __( 'Yes', 'fl-builder' ),
                            'false'      => __( 'No', 'fl-builder' ),
                        ),
                        'toggle'        => array(
                            'true'      => array(
                                'fields'        => array( 'link_bottom_text'),
                            ),
                        ),
                    ),
                    'link_bottom_text' => array(
                        'type' => 'text',
                        'label' => __('Label', 'fl-builder'),
                        'default' => ' Alle [TOTAL_RESULT] Reisen zum Thema anzeigen'
                    ),
                    'pagination_bottom'  => array(
                        'type' => 'select',
                        'label' => __('Pagination at bottom', 'fl-builder'),
                        'default'       => 'false',
                        'options'       => array(
                            'true'      => __( 'Yes', 'fl-builder' ),
                            'false'      => __( 'No', 'fl-builder' ),
                        ),
                    ),
                ),
            ),


        ),
    ),
	'content2'    => array(
		'title' => __( 'Content', 'fl-builder' ),
		'file'  => get_stylesheet_directory() . '/pagebuilders/beaverbuilder/includes/ui_media_object_settings.php',
	),



));
