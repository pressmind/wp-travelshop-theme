<?php

class TSWPInfoTeaser extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'WP Info teaser', 'fl-builder' ),
			'description'     => __( 'Info Teaser, based on post types', 'fl-builder' ),
			'category'        => __( 'WordPress Posts & Pages', 'fl-builder' ),
			'group'        => __( 'Travelshop', 'fl-builder' ),
			'editor_export'   => false,
			'partial_refresh' => true,
			'icon'            => 'schedule.svg',
            'dir'           => BB_MODULE_TS_DIR . 'modules/wp-info-teaser/',
            'url'           => BB_MODULE_TS_URL . 'modules/wp-info-teaser/',
		));
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('TSWPInfoTeaser', array(

    'common' => array(
        'title'    => __( 'Common', 'fl-builder' ),
        'sections' => array(
            'common'    => array(
                'title'  => __( 'Common', 'fl-builder' ),
                'fields' => array(
                    'headline'     => array(
                        'type'    => 'text',
                        'label'   => __( 'Headline', 'fl-builder' ),
                        'default' => 'Beliebte Reiseziele',
                    ),

                    'text'     => array(
                        'type'    => 'editor',
                        'media_buttons' => false,
                        'wpautop'       => false,
                        'label'   => __( 'Text', 'fl-builder' ),
                        'default' => 'Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip. ',
                    ),
                    'posts_per_page'     => array(
                        'type' => 'unit',
                        'label' => 'Items per page',
                        'default' => '10',
                        'placeholder' => '10',
                        'sanitize' => 'absint',
                        'slider' => array(
                            'min' => 1,
                            'max' => 100,
                            'step' => 1,
                        ),
                    ),

                ),
            ),

            'layout' => array(
                'title' => __('Layout', 'fl-builder'),
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
                        'description' => 'Only takes effect if Layout "Item-Slider" or "Default"'
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
                )
            ),
        ),
    ),
	'content'    => array(
		'title' => __( 'Content', 'fl-builder' ),
		'file'  => FL_BUILDER_DIR . 'includes/loop-settings.php',
	),

));
