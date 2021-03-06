<?php
/**
 * @var PMTravelShop $PMTravelShop
 */
global $PMTravelShop;
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,width=device-width,user-scalable=0">
    <link rel="preload" as="image" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/travelshop-logo.svg">
    <link rel="preload" as="image" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/slide-1.jpg" media="(min-width: 601px)">
    <link rel="preload" as="image" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/slide-1-mobile.jpg" media="(max-width: 600px)">
    <link rel="manifest" href="<?php echo get_stylesheet_directory_uri(); ?>/manifest-pwa.php">
    <meta name="theme-color" content="#f4f4f4"/>
    <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_192.png" sizes="192x192" type="image/png">
    <link rel="apple-touch-icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_180.png" sizes="180x180" type="image/png" >
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/favicon.ico" type="image/x-icon">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/splash_2048.png" sizes="2048x2732" rel="apple-touch-startup-image" />
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/splash_1668.png" sizes="1668x2224" rel="apple-touch-startup-image" />
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/splash_1536.png" sizes="1536x2048" rel="apple-touch-startup-image" />
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/splash_1125.png" sizes="1125x2436" rel="apple-touch-startup-image" />
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/splash_1242.png" sizes="1242x2208" rel="apple-touch-startup-image" />
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/splash_750.png" sizes="750x1334" rel="apple-touch-startup-image" />
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/splash_640.png" sizes="640x1136" rel="apple-touch-startup-image" />

    <meta name="robots" content="index,follow">
    <?php wp_head(); ?>
</head>
<body>
<header class="header-main">
    <div class="container">
        <div class="row header-main-row">
            <div class="col-auto align-self-center d-block d-lg-none">
                <button class="toggler navbar-toggler offcanvas-toggler" type="button" data-target="#navbar"
                        aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"/>
                        <line x1="4" y1="6" x2="20" y2="6" />
                        <line x1="4" y1="12" x2="20" y2="12" />
                        <line x1="4" y1="18" x2="20" y2="18" />
                    </svg>
                </button>
            </div>
            <div class="col-auto align-self-center ">
                <a class="navbar-brand" href="<?php echo site_url(); ?>">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/travelshop-logo.svg" height="24"
                         class="d-inline-block align-middle" alt="<?php echo get_bloginfo( 'name' );?>">
                </a>
            </div>
            <div class="col align-self-center p-0">

                <?php
                if (has_nav_menu('primary') === true) {
                    ?>
                    <nav class="navbar navbar-expand-lg offcanvas" id="navbar">
                        <button class="offcanvas-close">
                            <span>Menü schließen</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </button>
                        <div class="navbar-offcanvas">
                            <ul class="navbar-nav mr-auto ml-auto">

                                <?php
                                $menu_items = wpse_nav_menu_2_tree('primary');
                                if(isset($menu_items)) {
                                    foreach ($menu_items as $item) {

                                        // Top Level
                                        if (empty($item->wpse_children) === true) { // Level 1
                                            ?>
                                            <li class="nav-item active">
                                                <a class="nav-link"
                                                href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
                                            </li>
                                            <?php
                                        } else { // Level 2
                                            ?>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                                role="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <?php echo $item->title; ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-caret-down" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ccc" fill="#ccc" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M18 15l-6 -6l-6 6h12" transform="rotate(180 12 12)" />
                                                    </svg>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                    <?php
                                                    foreach ($item->wpse_children as $child_items) {
                                                        ?>
                                                        <a class="dropdown-item"
                                                        href="<?php echo $child_items->url ?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-caret-right" width="15" height="15" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ccc" fill="#ccc" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M18 15l-6 -6l-6 6h12" transform="rotate(90 12 12)" />
                                                            </svg>
                                                            <?php echo $child_items->title; ?>
                                                        </a>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </nav>
                <?php } else { ?>
                    <nav class="navbar navbar-expand-lg offcanvas" id="navbar">
                        <small style="padding: 1rem; display: inline-block;">menu: ‚Desktop Horizontal Menu‘ not configured</small>
                    </nav>
                <?php } ?>
            </div>
            <div class="col-auto align-self-center  d-none d-lg-block col-search" id="search">
                <form class="form-string-search input-group my-2 my-lg-0" action="<?php echo site_url().'/'.$PMTravelShop->RouteProcessor->get_url_by_object_type(TS_TOUR_PRODUCTS).'/'; ?>" method="GET">
                    <input class="form-control auto-complete" type="search" data-autocomplete="true" placeholder="Suchbegriff..."
                           aria-label="Search" name="pm-t">
                    <div class="input-group-append">
                        <button class="btn btn-link" aria-label="Suchen">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z"/>
                                <circle cx="10" cy="10" r="7" />
                                <line x1="21" y1="21" x2="15" y2="15" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-auto align-self-center">
                <div class="travelshop_hotline_batch">
                    <small>Service-Hotline</small><br/>
                    <a href="#">+49 180 654 321</a>
                    <a class="phone-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="35"
                             height="35" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="col-auto align-self-center dropdown">
                <button class="toggler wishlist-toggler" type="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" data-offset="40,20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"/>
                        <path d="M12 20l-7 -7a4 4 0 0 1 6.5 -6a.9 .9 0 0 0 1 0a4 4 0 0 1 6.5 6l-7 7" />
                    </svg>
                    <span class="wishlist-count">0</span>
                </button>

                <div class="dropdown-menu dropdown-menu-right dropdown-menu-wishlist">
                    <div id="wishlist-result" class="wishlist-items">
                        <p>Keine Reisen auf der Merkliste</p>
                    </div>

                    <div style="display: none;" class="wishlist-actions">
                        <a href='#' class="btn btn-outline-primary btn-block">
                            Zur Merkliste
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-auto align-self-center d-none">
                <button class="toggler search-toggler" type="button" data-target="#search" aria-controls="search"
                        aria-expanded="false" aria-label="Toggle Search">
                    <i class="la la-search"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="offanvas-backdrop">
        <div class="modal-dialog modal-xl" style="opacity: 0;">
            <div class="modal-content"></div>
        </div>
    </div>
    <div class="modal fade" id="search-backdrop">
        <div class="modal-dialog modal-xl" style="opacity: 0;">
            <div class="modal-content"></div>
        </div>
    </div>
</header>