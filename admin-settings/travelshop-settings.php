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
        ),
        array(
            'id' => 'search',
            'title' => 'Suche'
        ),
        array(
            'id' => 'search_tabTwo',
            'title' => 'Suche Tab #2'
        ),
        array(
            'id' => 'search_tabThree',
            'title' => 'Suche Tab #3'
        ),
        array(
            'id' => 'search_tabFour',
            'title' => 'Suche Tab #4'
        )
        /*
        array(
            'id' => 'tab_2',
            'title' => __('Tab 2'),
        ),
        */
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


        array(
            'tab_id' => 'tab_1',
            'section_id' => 'section_2',
            'section_title' => 'Section 2',
            'section_order' => 10,
            'fields' => array(
                array(
                    'id' => 'text-2',
                    'title' => 'Text',
                    'desc' => 'This is a description.',
                    'type' => 'text',
                    'default' => 'This is default',
                ),
            ),
        ),

        array(
            'tab_id' => 'search',
            'section_id' => 'search',
            'section_title' => 'Volltextsuche',
            'section_order' => 1,
            'fields' => array(



                array(
                    'id' => 'search-teaser-items',
                    'title' => 'Platzhalter Teaser',
                    'desc' => 'Shortcode: [ts-search-teaser-items]',
                    'type' => 'group',
                    'subfields' => array(
                        array(
                            'id' => 'text',
                            'title' => 'Titel',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => 'Spanien',
                        ),
                        array(
                            'id' => 'subtext',
                            'title' => 'Subtitel',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => 'Spanien',
                        ),
                        array(
                            'id' => 'badge',
                            'title' => 'Badge',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => '',
                        ),
                        array(
                            'id' => 'image',
                            'title' => 'Image',
                            'desc' => 'Needs id of media library item',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => '0',
                        ),
                        array(
                            'id' => 'link',
                            'title' => 'Link',
                            'desc' => 'Needs link of specific site',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => ''
                        )
                    )
                ),

                array(
                    'id' => 'search-title',
                    'title' => 'Titel ( Gruppe 1 )',
                    'desc' => 'Shortcode: [ts-search-title]<br>Title appears on top of fulltext search placeholder items',
                    'type' => 'text',
                    'default' => 'Aktuell beliebt'
                ),

                array(
                    'id' => 'search-items',
                    'title' => 'Platzhalter Elemente ( Gruppe 1 )',
                    'desc' => 'Shortcode: [ts-search-items]',
                    'type' => 'group',
                    'subfields' => array(
                        array(
                            'id' => 'text',
                            'title' => 'Titel',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => 'Spanien',
                        ),
                        array(
                            'id' => 'image',
                            'title' => 'Image',
                            'desc' => 'Needs id of media library item',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => '0',
                        ),
                        array(
                            'id' => 'link',
                            'title' => 'Link',
                            'desc' => 'Needs link of specific site',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => ''
                        )
                    )
                ),
                array(
                    'id' => 'search-group-link',
                    'title' => 'Mehr Link ( Gruppe 1 )',
                    'desc' => 'Shortcode: [ts-search-group-link]<br>Title appears on top of fulltext search placeholder items',
                    'type' => 'text',
                    'default' => '/reiseziele/'
                ),

                array(
                    'id' => 'search-group-link-text',
                    'title' => 'Mehr Link Text( Gruppe 1 )',
                    'desc' => 'Shortcode: [ts-search-group-link-text]<br>Title appears on top of fulltext search placeholder items',
                    'type' => 'text',
                    'default' => 'Weitere Reiseziele anzeigen'
                ),


                array(
                    'id' => 'search-group-two-title',
                    'title' => 'Titel ( Gruppe 2 )',
                    'desc' => 'Shortcode: [ts-search-group-two-title]<br>Title appears on top of fulltext search placeholder items',
                    'type' => 'text',
                    'default' => 'Aktuell beliebt'
                ),

                array(
                    'id' => 'search-group-two-items',
                    'title' => 'Platzhalter Elemente ( Gruppe 2 )',
                    'desc' => 'Shortcode: [ts-search-group-two-items]',
                    'type' => 'group',
                    'subfields' => array(
                        array(
                            'id' => 'text',
                            'title' => 'Titel',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => 'Spanien',
                        ),
                        array(
                            'id' => 'image',
                            'title' => 'Image',
                            'desc' => 'Needs id of media library item',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => '0',
                        ),
                        array(
                            'id' => 'link',
                            'title' => 'Link',
                            'desc' => 'Needs link of specific site',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => ''
                        )
                    )
                ),
                array(
                    'id' => 'search-group-two-link',
                    'title' => 'Mehr Link ( Gruppe 2 )',
                    'desc' => 'Shortcode: [ts-group-two-link]',
                    'type' => 'text',
                    'default' => '/reiseziele/'
                ),

                array(
                    'id' => 'search-group-two-link-text',
                    'title' => 'Mehr Link Text( Gruppe 2 )',
                    'desc' => 'Shortcode: [ts-group-two-link-text]',
                    'type' => 'text',
                    'default' => 'Weitere Reiseziele anzeigen'
                ),

                array(
                    'id' => 'search-link-text',
                    'title' => 'Suchlink Text',
                    'desc' => 'Shortcode: [ts-search-link-text]<br>Link text to search page',
                    'type' => 'text',
                    'default' => 'Nicht sicher? Alle Reisen anzeigen'
                ),
                array(
                    'id' => 'search-link',
                    'title' => 'Suchlink',
                    'desc' => 'Shortcode: [ts-search-link]<br>Link to search page',
                    'type' => 'text',
                    'default' => '/suche/'
                ),

            )
        ),

        array(
            'tab_id' => 'search_tabTwo',
            'section_id' => 'search_tabTwo',
            'section_title' => 'Volltextsuche',
            'section_order' => 1,
            'fields' => array(



                array(
                    'id' => 'search-teaser-items',
                    'title' => 'Platzhalter Teaser',
                    'desc' => 'Shortcode: [ts-search-teaser-items]',
                    'type' => 'group',
                    'subfields' => array(
                        array(
                            'id' => 'text',
                            'title' => 'Titel',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => 'Spanien',
                        ),
                        array(
                            'id' => 'subtext',
                            'title' => 'Subtitel',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => 'Spanien',
                        ),
                        array(
                            'id' => 'badge',
                            'title' => 'Badge',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => '',
                        ),
                        array(
                            'id' => 'image',
                            'title' => 'Image',
                            'desc' => 'Needs id of media library item',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => '0',
                        ),
                        array(
                            'id' => 'link',
                            'title' => 'Link',
                            'desc' => 'Needs link of specific site',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => ''
                        )
                    )
                ),

                array(
                    'id' => 'search-title',
                    'title' => 'Titel ( Gruppe 1 )',
                    'desc' => 'Shortcode: [ts-search-title]<br>Title appears on top of fulltext search placeholder items',
                    'type' => 'text',
                    'default' => 'Aktuell beliebt'
                ),

                array(
                    'id' => 'search-items',
                    'title' => 'Platzhalter Elemente ( Gruppe 1 )',
                    'desc' => 'Shortcode: [ts-search-items]',
                    'type' => 'group',
                    'subfields' => array(
                        array(
                            'id' => 'text',
                            'title' => 'Titel',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => 'Spanien',
                        ),
                        array(
                            'id' => 'image',
                            'title' => 'Image',
                            'desc' => 'Needs id of media library item',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => '0',
                        ),
                        array(
                            'id' => 'link',
                            'title' => 'Link',
                            'desc' => 'Needs link of specific site',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => ''
                        )
                    )
                ),
                array(
                    'id' => 'search-group-link',
                    'title' => 'Mehr Link ( Gruppe 1 )',
                    'desc' => 'Shortcode: [ts-search-group-link]<br>Title appears on top of fulltext search placeholder items',
                    'type' => 'text',
                    'default' => '/reiseziele/'
                ),

                array(
                    'id' => 'search-group-link-text',
                    'title' => 'Mehr Link Text( Gruppe 1 )',
                    'desc' => 'Shortcode: [ts-search-group-link-text]<br>Title appears on top of fulltext search placeholder items',
                    'type' => 'text',
                    'default' => 'Weitere Reiseziele anzeigen'
                ),


                array(
                    'id' => 'search-group-two-title',
                    'title' => 'Titel ( Gruppe 2 )',
                    'desc' => 'Shortcode: [ts-search-group-two-title]<br>Title appears on top of fulltext search placeholder items',
                    'type' => 'text',
                    'default' => 'Aktuell beliebt'
                ),

                array(
                    'id' => 'search-group-two-items',
                    'title' => 'Platzhalter Elemente ( Gruppe 2 )',
                    'desc' => 'Shortcode: [ts-search-group-two-items]',
                    'type' => 'group',
                    'subfields' => array(
                        array(
                            'id' => 'text',
                            'title' => 'Titel',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => 'Spanien',
                        ),
                        array(
                            'id' => 'image',
                            'title' => 'Image',
                            'desc' => 'Needs id of media library item',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => '0',
                        ),
                        array(
                            'id' => 'link',
                            'title' => 'Link',
                            'desc' => 'Needs link of specific site',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => ''
                        )
                    )
                ),
                array(
                    'id' => 'search-group-two-link',
                    'title' => 'Mehr Link ( Gruppe 2 )',
                    'desc' => 'Shortcode: [ts-group-two-link]',
                    'type' => 'text',
                    'default' => '/reiseziele/'
                ),

                array(
                    'id' => 'search-group-two-link-text',
                    'title' => 'Mehr Link Text( Gruppe 2 )',
                    'desc' => 'Shortcode: [ts-group-two-link-text]',
                    'type' => 'text',
                    'default' => 'Weitere Reiseziele anzeigen'
                ),

                array(
                    'id' => 'search-link-text',
                    'title' => 'Suchlink Text',
                    'desc' => 'Shortcode: [ts-search-link-text]<br>Link text to search page',
                    'type' => 'text',
                    'default' => 'Nicht sicher? Alle Reisen anzeigen'
                ),
                array(
                    'id' => 'search-link',
                    'title' => 'Suchlink',
                    'desc' => 'Shortcode: [ts-search-link]<br>Link to search page',
                    'type' => 'text',
                    'default' => '/suche/'
                ),

            )
        ),

        array(
            'tab_id' => 'search_tabThree',
            'section_id' => 'search_tabThree',
            'section_title' => 'Volltextsuche',
            'section_order' => 1,
            'fields' => array(



                array(
                    'id' => 'search-teaser-items',
                    'title' => 'Platzhalter Teaser',
                    'desc' => 'Shortcode: [ts-search-teaser-items]',
                    'type' => 'group',
                    'subfields' => array(
                        array(
                            'id' => 'text',
                            'title' => 'Titel',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => 'Spanien',
                        ),
                        array(
                            'id' => 'subtext',
                            'title' => 'Subtitel',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => 'Spanien',
                        ),
                        array(
                            'id' => 'badge',
                            'title' => 'Badge',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => '',
                        ),
                        array(
                            'id' => 'image',
                            'title' => 'Image',
                            'desc' => 'Needs id of media library item',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => '0',
                        ),
                        array(
                            'id' => 'link',
                            'title' => 'Link',
                            'desc' => 'Needs link of specific site',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => ''
                        )
                    )
                ),

                array(
                    'id' => 'search-title',
                    'title' => 'Titel ( Gruppe 1 )',
                    'desc' => 'Shortcode: [ts-search-title]<br>Title appears on top of fulltext search placeholder items',
                    'type' => 'text',
                    'default' => 'Aktuell beliebt'
                ),

                array(
                    'id' => 'search-items',
                    'title' => 'Platzhalter Elemente ( Gruppe 1 )',
                    'desc' => 'Shortcode: [ts-search-items]',
                    'type' => 'group',
                    'subfields' => array(
                        array(
                            'id' => 'text',
                            'title' => 'Titel',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => 'Spanien',
                        ),
                        array(
                            'id' => 'image',
                            'title' => 'Image',
                            'desc' => 'Needs id of media library item',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => '0',
                        ),
                        array(
                            'id' => 'link',
                            'title' => 'Link',
                            'desc' => 'Needs link of specific site',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => ''
                        )
                    )
                ),
                array(
                    'id' => 'search-group-link',
                    'title' => 'Mehr Link ( Gruppe 1 )',
                    'desc' => 'Shortcode: [ts-search-group-link]<br>Title appears on top of fulltext search placeholder items',
                    'type' => 'text',
                    'default' => '/reiseziele/'
                ),

                array(
                    'id' => 'search-group-link-text',
                    'title' => 'Mehr Link Text( Gruppe 1 )',
                    'desc' => 'Shortcode: [ts-search-group-link-text]<br>Title appears on top of fulltext search placeholder items',
                    'type' => 'text',
                    'default' => 'Weitere Reiseziele anzeigen'
                ),


                array(
                    'id' => 'search-group-two-title',
                    'title' => 'Titel ( Gruppe 2 )',
                    'desc' => 'Shortcode: [ts-search-group-two-title]<br>Title appears on top of fulltext search placeholder items',
                    'type' => 'text',
                    'default' => 'Aktuell beliebt'
                ),

                array(
                    'id' => 'search-group-two-items',
                    'title' => 'Platzhalter Elemente ( Gruppe 2 )',
                    'desc' => 'Shortcode: [ts-search-group-two-items]',
                    'type' => 'group',
                    'subfields' => array(
                        array(
                            'id' => 'text',
                            'title' => 'Titel',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => 'Spanien',
                        ),
                        array(
                            'id' => 'image',
                            'title' => 'Image',
                            'desc' => 'Needs id of media library item',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => '0',
                        ),
                        array(
                            'id' => 'link',
                            'title' => 'Link',
                            'desc' => 'Needs link of specific site',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => ''
                        )
                    )
                ),
                array(
                    'id' => 'search-group-two-link',
                    'title' => 'Mehr Link ( Gruppe 2 )',
                    'desc' => 'Shortcode: [ts-group-two-link]',
                    'type' => 'text',
                    'default' => '/reiseziele/'
                ),

                array(
                    'id' => 'search-group-two-link-text',
                    'title' => 'Mehr Link Text( Gruppe 2 )',
                    'desc' => 'Shortcode: [ts-group-two-link-text]',
                    'type' => 'text',
                    'default' => 'Weitere Reiseziele anzeigen'
                ),

                array(
                    'id' => 'search-link-text',
                    'title' => 'Suchlink Text',
                    'desc' => 'Shortcode: [ts-search-link-text]<br>Link text to search page',
                    'type' => 'text',
                    'default' => 'Nicht sicher? Alle Reisen anzeigen'
                ),
                array(
                    'id' => 'search-link',
                    'title' => 'Suchlink',
                    'desc' => 'Shortcode: [ts-search-link]<br>Link to search page',
                    'type' => 'text',
                    'default' => '/suche/'
                ),

            )
        ),

        array(
            'tab_id' => 'search_tabFour',
            'section_id' => 'search_tabFour',
            'section_title' => 'Volltextsuche',
            'section_order' => 1,
            'fields' => array(



                array(
                    'id' => 'search-teaser-items',
                    'title' => 'Platzhalter Teaser',
                    'desc' => 'Shortcode: [ts-search-teaser-items]',
                    'type' => 'group',
                    'subfields' => array(
                        array(
                            'id' => 'text',
                            'title' => 'Titel',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => 'Spanien',
                        ),
                        array(
                            'id' => 'subtext',
                            'title' => 'Subtitel',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => 'Spanien',
                        ),
                        array(
                            'id' => 'badge',
                            'title' => 'Badge',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => '',
                        ),
                        array(
                            'id' => 'image',
                            'title' => 'Image',
                            'desc' => 'Needs id of media library item',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => '0',
                        ),
                        array(
                            'id' => 'link',
                            'title' => 'Link',
                            'desc' => 'Needs link of specific site',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => ''
                        )
                    )
                ),

                array(
                    'id' => 'search-title',
                    'title' => 'Titel ( Gruppe 1 )',
                    'desc' => 'Shortcode: [ts-search-title]<br>Title appears on top of fulltext search placeholder items',
                    'type' => 'text',
                    'default' => 'Aktuell beliebt'
                ),

                array(
                    'id' => 'search-items',
                    'title' => 'Platzhalter Elemente ( Gruppe 1 )',
                    'desc' => 'Shortcode: [ts-search-items]',
                    'type' => 'group',
                    'subfields' => array(
                        array(
                            'id' => 'text',
                            'title' => 'Titel',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => 'Spanien',
                        ),
                        array(
                            'id' => 'image',
                            'title' => 'Image',
                            'desc' => 'Needs id of media library item',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => '0',
                        ),
                        array(
                            'id' => 'link',
                            'title' => 'Link',
                            'desc' => 'Needs link of specific site',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => ''
                        )
                    )
                ),
                array(
                    'id' => 'search-group-link',
                    'title' => 'Mehr Link ( Gruppe 1 )',
                    'desc' => 'Shortcode: [ts-search-group-link]<br>Title appears on top of fulltext search placeholder items',
                    'type' => 'text',
                    'default' => '/reiseziele/'
                ),

                array(
                    'id' => 'search-group-link-text',
                    'title' => 'Mehr Link Text( Gruppe 1 )',
                    'desc' => 'Shortcode: [ts-search-group-link-text]<br>Title appears on top of fulltext search placeholder items',
                    'type' => 'text',
                    'default' => 'Weitere Reiseziele anzeigen'
                ),


                array(
                    'id' => 'search-group-two-title',
                    'title' => 'Titel ( Gruppe 2 )',
                    'desc' => 'Shortcode: [ts-search-group-two-title]<br>Title appears on top of fulltext search placeholder items',
                    'type' => 'text',
                    'default' => 'Aktuell beliebt'
                ),

                array(
                    'id' => 'search-group-two-items',
                    'title' => 'Platzhalter Elemente ( Gruppe 2 )',
                    'desc' => 'Shortcode: [ts-search-group-two-items]',
                    'type' => 'group',
                    'subfields' => array(
                        array(
                            'id' => 'text',
                            'title' => 'Titel',
                            'desc' => '',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => 'Spanien',
                        ),
                        array(
                            'id' => 'image',
                            'title' => 'Image',
                            'desc' => 'Needs id of media library item',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => '0',
                        ),
                        array(
                            'id' => 'link',
                            'title' => 'Link',
                            'desc' => 'Needs link of specific site',
                            'placeholder' => '',
                            'type' => 'text',
                            'default' => ''
                        )
                    )
                ),
                array(
                    'id' => 'search-group-two-link',
                    'title' => 'Mehr Link ( Gruppe 2 )',
                    'desc' => 'Shortcode: [ts-group-two-link]',
                    'type' => 'text',
                    'default' => '/reiseziele/'
                ),

                array(
                    'id' => 'search-group-two-link-text',
                    'title' => 'Mehr Link Text( Gruppe 2 )',
                    'desc' => 'Shortcode: [ts-group-two-link-text]',
                    'type' => 'text',
                    'default' => 'Weitere Reiseziele anzeigen'
                ),

                array(
                    'id' => 'search-link-text',
                    'title' => 'Suchlink Text',
                    'desc' => 'Shortcode: [ts-search-link-text]<br>Link text to search page',
                    'type' => 'text',
                    'default' => 'Nicht sicher? Alle Reisen anzeigen'
                ),
                array(
                    'id' => 'search-link',
                    'title' => 'Suchlink',
                    'desc' => 'Shortcode: [ts-search-link]<br>Link to search page',
                    'type' => 'text',
                    'default' => '/suche/'
                ),

            )
        ),

        /*
        array(
            'tab_id' => 'tab_2',
            'section_id' => 'section_3',
            'section_title' => 'Section 3',
            'section_order' => 10,
            'fields' => array(
                array(
                    'id' => 'text-3',
                    'title' => 'Text',
                    'desc' => 'This is a description.',
                    'type' => 'text',
                    'default' => 'This is default',
                ),
            ),
        ),
        */

    );

    return $wpsf_settings;
});

