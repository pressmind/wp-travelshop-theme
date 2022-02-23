<?php
use \Pressmind\Travelshop\Search;
get_header();
?>
    <main>
        <?php
        /**
         * it's possible to load each of these layout-blocks with a shortcode, like
         * echo do_shortcode('[ts-layoutblock f="search-header"]');
         * @see readme-shortcodes.md
         */

        $args = Search::getResult(['pm-ot' => TS_TOUR_PRODUCTS],2, 12, true, true, TS_TTL_FILTER, TS_TTL_SEARCH);
        $args['headline'] = 'Finde deine Traumreise!';
        load_template_transient(get_template_directory().'/template-parts/layout-blocks/search-header.php', false, $args);
        ?>
        <div class="content-main">
            <div class="container">
                <?php
                $args = [
                    'headline' => 'Beliebte Reiseziele',
                    'text' => 'Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip.'
                ];
                load_template_transient(get_template_directory().'/template-parts/layout-blocks/image-teaser.php', false, $args);
                ?>
                <hr class="mt-0 mb-0">
                <?php
                $args = [
                    'headline' => 'Reise-Empfehlungen',
                    'text' => 'Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip.',
                    'link_top' => true,
                    'link_bottom' => true,
                    'link_teaser' => true,
                    'link_top_text' => 'Alle [TOTAL_RESULT] Reisen zum Thema anzeigen',
                    'link_bottom_text' => 'Alle [TOTAL_RESULT] Reisen zum Thema anzeigen',
                    'link_teaser_text' => 'Alle [TOTAL_RESULT] Reisen zum Thema anzeigen',
                    'search' => [
                            'pm-l' => '0,3',
                            'pm-o' => 'rand',
                            'pm-ot' => TS_TOUR_PRODUCTS
                    ]
                ];
                load_template_transient(get_template_directory().'/template-parts/layout-blocks/product-teaser.php', false, $args);
                ?>
                <hr class="mt-0 mb-0">
                <?php
                $args = [];
                $args['headline'] = 'Die besten Reiseziele für jeden Monat';
                $args['text'] = 'Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip.';
                $args['id_object_type'] = TS_TOUR_PRODUCTS;
                load_template_transient(get_stylesheet_directory() . '/template-parts/layout-blocks/month-teaser.php', false, $args);
                ?>
                <hr class="mt-0 mb-0">
                <?php
                $args = [
                    'headline' => 'Reise-Themen',
                    'text' => 'Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip.',
                    'teaser_count_desktop' => 3,
                    'teasers' => [
                        [
                            'headline' => 'Fernreise',
                            'image' => get_stylesheet_directory_uri().'/assets/img/slide-1-mobile.jpg',
                            'link' => '#',
                            'link_target' => '_self',
                            'search' => [
                                'pm-li' => '0,4',
                                'pm-o' => 'rand',
                                'pm-ot' => TS_TOUR_PRODUCTS
                            ]
                        ],
                        [
                            'headline' => 'Kurzreise',
                            'image' => get_stylesheet_directory_uri().'/assets/img/slide-1-mobile.jpg',
                            'link' => '#',
                            'link_target' => '_self',
                            'search' => [
                                'pm-li' => '0,4',
                                'pm-o' => 'rand',
                                'pm-ot' => TS_TOUR_PRODUCTS
                            ]
                        ],
                        [
                        'headline' => 'Abenteuer',
                        'image' => get_stylesheet_directory_uri().'/assets/img/slide-1-mobile.jpg',
                        'link' => '#',
                        'link_target' => '_self',
                        'search' => [
                            'pm-li' => '0,4',
                            'pm-o' => 'rand',
                            'pm-ot' => TS_TOUR_PRODUCTS
                        ]
                    ]
                    ]
                ];
                load_template_transient(get_template_directory().'/template-parts/layout-blocks/product-category-teaser.php', false, $args);
                ?>
                <hr class="mt-0 mb-0">
                <?php
                $args = [
                    'headline' => 'Info Teaser',
                    'text' => 'Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip.'
                ];
                load_template_transient(get_template_directory().'/template-parts/layout-blocks/info-teaser.php', false, $args);?>
                <hr class="mt-0 mb-0">
                <?php
                    $args = [
                            'headline' => 'Icon-Teaser',
                            'text' => 'Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip.',
                            'teasers' => [
                                            [
                                                'headline' => 'Das ist ein USP',
                                                'text' => 'Das ist ein dazugehöriger Text zum USP.',
                                                'priority' => 'icon-inner-primary',
                                                'btn_link' => '#',
                                                'btn_link_target' => '_self',
                                                'btn_label' => 'Mehr erfahren',
                                                'svg_icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bell" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path><path d="M9 17v1a3 3 0 0 0 6 0v-1"></path></svg>',
                                            ],
                                            [
                                                'headline' => 'Das ist ein USP',
                                                'text' => 'Das ist ein dazugehöriger Text zum USP.',
                                                'priority' => 'icon-inner-secondary',
                                                'btn_link' => '#',
                                                'btn_link_target' => '_self',
                                                'btn_label' => 'Mehr erfahren',
                                                'svg_icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-headset" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">                            <path stroke="none" d="M0 0h24v24H0z"></path><rect x="4" y="13" rx="2" width="4" height="6"></rect><rect x="16" y="13" rx="2" width="4" height="6"></rect><path d="M4 15v-3a8 8 0 0 1 16 0v3"></path><path d="M18 19a6 3 0 0 1 -6 3"></path></svg>',
                                            ],
                                            [
                                                'headline' => 'Das ist ein USP',
                                                'text' => 'Das ist ein dazugehöriger Text zum USP.',
                                                'priority' => 'icon-inner-primary',
                                                'btn_link' => '#',
                                                'btn_link_target' => '_self',
                                                'btn_label' => 'Mehr erfahren',
                                                'svg_icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-thumb-up" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><path d="M7 11v 8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-7a1 1 0 0 1 1 -1h3a4 4 0 0 0 4 -4v-1a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1 -2 2h-7a3 3 0 0 1 -3 -3"></path></svg>',
                                            ],
                                            [
                                                'headline' => 'Das ist ein USP',
                                                'text' => 'Das ist ein dazugehöriger Text zum USP.',
                                                'priority' => '',
                                                'btn_link' => '#',
                                                'btn_link_target' => '_self',
                                                'btn_label' => 'Mehr erfahren',
                                                'svg_icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plane-departure" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><path d="M15 12h5a2 2 0 0 1 0 4h-15l-3 -6h3l2 2h3l-2 -7h3z" transform="rotate(-15 12 12) translate(0 -1)"></path><line x1="3" y1="21" x2="21" y2="21"></line></svg>',
                                            ],
                                        ]
                            ];

                load_template_transient(get_template_directory().'/template-parts/layout-blocks/icon-teaser.php', false, $args);
                ?>


                <?php
                $args = [
                    'items' => [
                        [
                            'headline' => 'Der 100. Auszubildene',
                            'text' => '2018 können wir unseren 100. Auszubildenden bei uns begrüßen.',
                            'date' => ' Juni 2018',
                            'dot_type' => 'default',
                            'dot_color' => '',
                            'dot_svg' => ''
                        ],
                        [
                            'headline' => 'Schiffsreisen',
                            'text' => 'Wir ergänzen unser Reiseportfolio um Schiffreisen und bieten unseren Kunden somit die Möglichkeit auch Übersee mit unseren Bussen zu verreisen.',
                            'date' => ' Mai 2015',
                            'dot_type' => 'default',
                            'dot_color' => '#ab5252',
                            'dot_svg' => ''
                        ],
                        [
                            'headline' => 'Foto Blog und Ausstellung',
                            'text' => 'Die schönsten Reiseimpressionen veröffentlichen wir in einem Reiseblog, der 2011 sogar zu einer Ausstellung führt.',
                            'date' => ' April 2011',
                            'dot_type' => 'svg',
                            'dot_color' => '#06f',
                            'dot_svg' => '<svg enable-background="new 0 0 430.23 430.23" version="1.1" viewBox="0 0 430.23 430.23" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m217.88 159.67c-24.237 0-43.886 19.648-43.886 43.886 0 24.237 19.648 43.886 43.886 43.886 24.237 0 43.886-19.648 43.886-43.886s-19.648-43.886-43.886-43.886zm0 66.873c-12.696 0-22.988-10.292-22.988-22.988s10.292-22.988 22.988-22.988 22.988 10.292 22.988 22.988-10.292 22.988-22.988 22.988z"/><path d="m392.9 59.357-285.26-32.391c-11.071-1.574-22.288 1.658-30.824 8.882-8.535 6.618-14.006 16.428-15.151 27.167l-5.224 42.841h-16.197c-22.988 0-40.229 20.375-40.229 43.363v213.68c-0.579 21.921 16.722 40.162 38.644 40.741 0.528 0.014 1.057 0.017 1.585 0.01h286.82c22.988 0 43.886-17.763 43.886-40.751v-8.359c7.127-1.377 13.888-4.224 19.853-8.359 8.465-7.127 13.885-17.22 15.151-28.212l24.033-212.11c2.45-23.041-14.085-43.768-37.094-46.499zm-42.841 303.54c0 11.494-11.494 19.853-22.988 19.853h-286.82c-10.383 0.305-19.047-7.865-19.352-18.248-0.016-0.535-9e-3 -1.07 0.021-1.605v-38.661l80.98-59.559c9.728-7.469 23.43-6.805 32.392 1.567l56.947 50.155c8.648 7.261 19.534 11.32 30.825 11.494 8.828 0.108 17.511-2.243 25.078-6.792l102.92-59.559v101.36zm0-125.91-113.89 66.351c-9.78 5.794-22.159 4.745-30.825-2.612l-57.469-50.678c-16.471-14.153-40.545-15.021-57.992-2.09l-68.963 50.155v-148.9c0-11.494 7.837-22.465 19.331-22.465h286.82c12.28 0.509 22.197 10.201 22.988 22.465v87.771zm59.057-133.96c-7e-3 0.069-0.013 0.139-0.021 0.208l-24.555 212.11c0.042 5.5-2.466 10.709-6.792 14.106-2.09 2.09-6.792 3.135-6.792 4.18v-184.42c-0.825-23.801-20.077-42.824-43.886-43.363h-249.73l4.702-40.751c1.02-5.277 3.779-10.059 7.837-13.584 4.582-3.168 10.122-4.645 15.674-4.18l284.74 32.914c11.488 1.091 19.918 11.29 18.827 22.78z"/></svg>'
                        ]
                    ]
                ];
                load_template_transient(get_template_directory().'/template-parts/layout-blocks/history.php', false, $args);
                ?>

                <?php
                $args = [
                    'headline' => 'Unsere Reiseexperten',
                    'text' => 'Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip.',
                    'items' => [
                        [
                            'image' => get_stylesheet_directory_uri().'/assets/img/slide-1.webp',
                            'name' => 'Max Mustermann',
                            'position' => 'Reiseexperte',
                            'text' => 'Das ist ein Beschreibungstext, dieser kann über die Person gehen, oder einen Tipp enthalten.',
                            'mail' => 'max@travelshop.de',
                            'phone' => '+49 180 654 321'
                        ],
                        [
                            'image' => get_stylesheet_directory_uri().'/assets/img/slide-1.webp',
                            'name' => 'Martin Mustermann',
                            'position' => 'Reiseleiter',
                            'text' => '',
                            'mail' => 'martin@travelshop.de',
                            'phone' => '+49 180 654 321'
                        ],
                        [
                            'image' => get_stylesheet_directory_uri().'/assets/img/slide-1.webp',
                            'name' => 'Martina Mustermann',
                            'position' => 'Buchhaltung',
                            'text' => '',
                            'mail' => 'martina@travelshop.de',
                            'phone' => '+49 180 654 321'
                        ]
                    ]
                ];
                load_template_transient(get_template_directory().'/template-parts/layout-blocks/team.php', false, $args);
                ?>
            </div>
        </div>
        <?php
        $args = [
                'headline' => 'Exploring the world is wonderful!',
                'subline' => 'love holiday',
                'lead' => 'relax',
                'text' => 'write some more text in this line',
                'btn_link' => '#',
                'btn_label' => 'Join our trips',
                'bg_image_src' => get_stylesheet_directory_uri().'/assets/img/slide-1.webp',
                'bg_image_alt_text' => '',
        ];
        load_template_transient(get_template_directory().'/template-parts/layout-blocks/jumbotron.php', false, $args);
        ?>
    </main>
<?php
get_footer();
