<?php
/**
 * WordPress Settings Framework
 *
 * @author  Gilbert Pellegrom, James Kemp
 * @link    https://github.com/gilbitron/WordPress-Settings-Framework
 * @license MIT
 */

/**
 * Define your settings
 *
 * The first parameter of this filter should be wpsf_register_settings_[options_group],
 * in this case "my_example_settings".
 *
 * Your "options_group" is the second param you use when running new WordPressSettingsFramework()
 * from your init function. It's important as it differentiates your options from others.
 *
 * To use the tabbed example, simply change the second param in the filter below to 'wpsf_tabbed_settings' | wpsf_tabless_settings
 * and check out the tabbed settings function on line 156.
 */

add_filter('wpsf_register_settings_travelshop_wpsf', function ($wpsf_settings) {
    // Tabs
    $wpsf_settings['tabs'] = array(
        array(
            'id' => 'contact',
            'title' => 'Kontaktdaten',
        )
    );

    // Settings
    $wpsf_settings['sections'] = array(
        array(
            'tab_id' => 'contact',
            'section_id' => 'contact',
            'section_title' => 'Kontaktdaten',
            'section_order' => 10,
            'fields' => array(
                array(
                    'id' => 'ts-company-name',
                    'title' => 'Company Name',
                    'desc' => 'Shortcode: [ts-company-name]',
                    'type' => 'text',
                    'default' => 'Travelshop GmbH',
                ),
                array(
                    'id' => 'ts-company-nick-name',
                    'title' => 'Company Nick Name',
                    'desc' => 'Shortcode: [ts-company-nick-name] (fallback to ts-company-name if empty)',
                    'type' => 'text',
                    'default' => '',
                ),
                array(
                    'id' => 'ts-company-street',
                    'title' => 'Street',
                    'desc' => 'Shortcode: [ts-company-street]',
                    'type' => 'text',
                    'default' => 'Example 123',
                ),
                array(
                    'id' => 'ts-company-zip',
                    'title' => 'Zip',
                    'desc' => 'Shortcode: [ts-company-zip]',
                    'type' => 'text',
                    'default' => '54321',
                ),
                array(
                    'id' => 'ts-company-city',
                    'title' => 'City',
                    'desc' => 'Shortcode: [ts-company-city]',
                    'type' => 'text',
                    'default' => 'HolidayCity',
                ),
                array(
                    'id' => 'ts-company-country',
                    'title' => 'Country',
                    'desc' => 'Shortcode: [ts-company-country]',
                    'type' => 'text',
                    'default' => 'Deutschland',
                ),
                array(
                    'id' => 'ts-company-phone',
                    'title' => 'Phone (Office)',
                    'desc' => 'Shortcode: [ts-company-phone]',
                    'type' => 'text',
                    'default' => '09876-123456',
                ),
                array(
                    'id' => 'ts-company-fax',
                    'title' => 'Fax',
                    'desc' => 'Shortcode: [ts-company-fax]',
                    'type' => 'text',
                    'default' => 'Deutschland',
                ),
                array(
                    'id' => 'ts-company-email',
                    'title' => 'Email',
                    'desc' => 'Shortcode: [ts-company-email]',
                    'type' => 'text',
                    'default' => '....@travelshop-theme.de',
                ),
            ),
        ),
        array(
            'tab_id' => 'contact',
            'section_id' => 'hotline',
            'section_title' => 'Hotline',
            'section_order' => 10,
            'fields' => array(
                array(
                    'id' => 'ts-company-hotline',
                    'title' => 'Hotline',
                    'desc' => 'Shortcode: [ts-company-hotline]',
                    'type' => 'text',
                    'default' => '09876-123456',
                ),

                array(
                    'id' => 'ts-company-hotline-info',
                    'title' => 'Hotline Info',
                    'desc' => 'Shortcode: [ts-company-hotline-info]',
                    'type' => 'text',
                    'default' => 'Buchungshotline:',
                ),

                array(
                    'id' => 'ts-company-opening-info',
                    'title' => 'Hotline Opening Times',
                    'desc' => 'Shortcode: [ts-company-hotline-opening-times]',
                    'type' => 'group',
                    'subfields' => array(
                        // accepts most types of fields
                        array(
                            'id' => 'sub-text',
                            'title' => 'Open from/to',
                            'desc' => '',
                            'placeholder' => 'Mo. bis Fr. 8:00 - 17:00 Uhr',
                            'type' => 'text',
                            'default' => 'Mo. bis Fr. 8:00 - 17:00 Uhr',
                        ),
                    )
                ),
                array(
                    'id' => 'ts-company-hotline-info-2',
                    'title' => 'Hotline Info 2',
                    'desc' => 'Shortcode: [ts-company-hotline-info-2]',
                    'type' => 'text',
                    'default' => '10 cent pro Minute',
                ),

            ),
        ),
        array(
            'tab_id' => 'contact',
            'section_id' => 'socialmedia',
            'section_title' => 'Socialmedia',
            'section_order' => 10,
            'fields' => array(
                array(
                    'id' => 'ts-company-facebook',
                    'title' => 'Facebook',
                    'desc' => 'Shortcode: [ts-company-facebook]',
                    'type' => 'text',
                    'default' => 'https://...',
                ),

                array(
                    'id' => 'ts-company-twitter',
                    'title' => 'Twitter',
                    'desc' => 'Shortcode: [ts-company-twitter]',
                    'type' => 'text',
                    'default' => 'https://...',
                ),

                array(
                    'id' => 'ts-company-insta',
                    'title' => 'Insta',
                    'desc' => 'Shortcode: [ts-company-insta]',
                    'type' => 'text',
                    'default' => 'https://...',
                ),

                array(
                    'id' => 'ts-company-youtube',
                    'title' => 'YouTube',
                    'desc' => 'Shortcode: [ts-company-youtube]',
                    'type' => 'text',
                    'default' => 'https://...',
                ),

                array(
                    'id' => 'ts-company-qualitybus',
                    'title' => 'QualityBus',
                    'desc' => 'Shortcode: [ts-company-qualitybus]',
                    'type' => 'text',
                    'default' => 'https://...',
                ),
            ),
        ),

    );

    for($tab_index = 1; $tab_index <= 3; $tab_index++) {
        $tab =  array(
            'id' => 'search_tab'.$tab_index,
            'title' => 'Suche Tab #'.$tab_index
        );
        $wpsf_settings['tabs'][] = $tab;
        $search_tab_fields =  array(
            'tab_id' => 'search_tab'.$tab_index,
            'section_id' => 'section1',
            'section_title' => 'Auto-Complete Vorschläge',
            'section_order' => 1,
            'fields' => array(
                array(
                    'id' => 'items',
                    'title' => 'Teaser',
                    'desc' => 'Diese Teaser werden als erstes im Auto-Complete angezeigt und sollen auf Landingpages mit aktuellen Kampagnen verlinken.',
                    'type' => 'group',
                    'subfields' => array(
                        array(
                            'id' => 'text',
                            'title' => 'Titel',
                            'desc' => '',
                            'placeholder' => 'Sylt',
                            'type' => 'text',
                            'default' => '',
                        ),
                        array(
                            'id' => 'subtext',
                            'title' => 'Subtitel',
                            'desc' => '',
                            'placeholder' => 'Die schönste Insel der Welt',
                            'type' => 'text',
                            'default' => '',
                        ),
                        array(
                            'id' => 'badge',
                            'title' => 'Badge',
                            'desc' => '',
                            'placeholder' => 'DEAL',
                            'type' => 'text',
                            'default' => '',
                        ),
                        array(
                            'id' => 'image',
                            'title' => 'Bild',
                            'desc' => 'ID des Bildes der WordPress Media Library',
                            'placeholder' => '123',
                            'type' => 'number',
                            'default' => '0',
                        ),
                        array(
                            'id' => 'link',
                            'title' => 'Link zur Landingpage',
                            'desc' => '',
                            'placeholder' => 'https://...',
                            'type' => 'text',
                            'default' => ''
                        )
                    )
                ),


                array(
                    'id'        => 'teaser_group',
                    'title'     => 'Teaser Gruppen',
                    'desc'      => '',
                    'type'      => 'group',
                    'subfields' => array(
                        // accepts most types of fields.
                        array(
                            'id' => 'title',
                            'title' => 'Titel',
                            'desc' => '',
                            'placeholder' => 'Beliebte Reiseziele',
                            'type' => 'text',
                            'default' => ''
                        ),
                        array(
                            'id' => 'more_link',
                            'title' => 'Mehr Link',
                            'desc' => '',
                            'placeholder' => 'https://...',
                            'type' => 'text',
                            'default' => '/reiseziele/'
                        ),
                        array(
                            'id' => 'more_link_text',
                            'title' => 'Mehr Link Text',
                            'desc' => '',
                            'type' => 'text',
                            'default' => 'Weitere Reiseziele anzeigen'
                        ),
                        array(
                            'id' => 'items',
                            'title' => 'Teaser',
                            'desc' => '',
                            'type' => 'group',
                            'subfields' => array(
                                array(
                                    'id' => 'title',
                                    'title' => 'Titel',
                                    'desc' => '',
                                    'placeholder' => 'Spanien',
                                    'type' => 'text',
                                    'default' => '',
                                ),
                                array(
                                    'id' => 'image',
                                    'title' => 'Bild',
                                    'desc' => 'ID des Bildes der WordPress Media Library',
                                    'placeholder' => '123',
                                    'type' => 'number',
                                    'default' => '0',
                                ),
                                array(
                                    'id' => 'link',
                                    'title' => 'Link',
                                    'desc' => '',
                                    'placeholder' => 'https://...',
                                    'type' => 'text',
                                    'default' => ''
                                )
                            )
                        ),

                    ),
                ),


                array(
                    'id' => 'show_all_link',
                    'title' => 'Zeige alles Link',
                    'desc' => '',
                    'placeholder' => '/suche/',
                    'type' => 'text',
                    'default' => '/suche/'
                ),
                array(
                    'id' => 'show_all_text',
                    'title' => 'Zeige alles Text',
                    'desc' => '',
                    'placeholder' => 'Nicht sicher? Alle Reisen anzeigen',
                    'type' => 'text',
                    'default' => 'Nicht sicher? Alle Reisen anzeigen'
                ),
            )
        );
        $wpsf_settings['sections'][] = $search_tab_fields;
    }

    return $wpsf_settings;
});

