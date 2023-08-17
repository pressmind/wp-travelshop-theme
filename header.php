<?php
use Pressmind\Travelshop\Template;
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
    <?php if(TS_COOKIE_CONSENT){
    ?><script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/cookieconsent.min.js"></script>
    <?php } ?>
    <link rel="preload" as="image" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/travelshop-logo.svg">
    <link rel="preload" as="image" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg">
    <link rel="preload" as="image" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/slide-1.jpg" media="(min-width: 601px)">
    <link rel="preload" as="image" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/slide-1-mobile.jpg" media="(max-width: 600px)">
    <?php if(TS_PWA){
    ?><link rel="manifest" href="<?php echo get_stylesheet_directory_uri(); ?>/manifest-pwa.php">
    <?php } ?>
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
    <!-- <meta name="robots" content="index,follow"> -->
    <?php
    wp_head();
    ?>
    <script>
        var ts_ajax_check_availibility_endpoint = '<?php echo defined('TS_IBE3_CHECK_AVAILABILITY_URL') && !empty(TS_IBE3_CHECK_AVAILABILITY_URL) ? TS_IBE3_CHECK_AVAILABILITY_URL : '/wp-content/themes/travelshop/pm-ajax-endpoint.php'; ?>';
        var ts_pwa = <?php echo defined('TS_PWA') && TS_PWA === true ? 'true' : 'false'; ?>;
        <?php if(defined('TS_PARTNERLINK_PARAMETER_NAME')) {
            echo "const partnerParam = '" . TS_PARTNERLINK_PARAMETER_NAME . "';";
        } else {
            echo "const partnerParam = 'partnerid';";
        } ?>
        <?php if(defined('TS_PARTNERLINK_VALID_DAYS')) {
            echo "const partnerTimeout = " . TS_PARTNERLINK_VALID_DAYS . ";";
        } else {
            echo "const partnerTimeout = 30;";
        } ?>
    </script>
    <?php if(defined('TS_GTM_CODE')) { ?>
        <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','<?php echo TS_GTM_CODE; ?>');</script>
        <!-- End Google Tag Manager -->
    <?php } ?>
</head>
<body <?php body_class(); ?>>
<?php if(defined('TS_GTM_CODE')) { ?>
    <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo TS_GTM_CODE; ?>"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
<?php } ?>
<header class="header-main">
    <div class="container">
        <div class="row header-main-row align-items-center">
            <div class="col-auto d-block d-lg-none">
                <button class="header-action header-action--navtoggle toggler navbar-toggler" type="button">
                    <div class="header-action--icon">
                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#list"></use></svg>
                    </div>
                </button>
            </div>
            <div class="col col-lg-auto">
                <a class="navbar-brand" href="<?php echo site_url(); ?>">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/travelshop-logo.svg" height="24" width="142"
                         class="d-inline-block align-middle" alt="<?php echo get_bloginfo( 'name' );?>">
                </a>
            </div>
            <div class="col p-0 d-none d-lg-block">
                <?php load_template_transient(get_template_directory().'/template-parts/header/menu.php', false); ?>
            </div>
            <?php if(!empty(TS_SINGLE_SEARCH)){?>
            <div class="col-auto  d-none d-xl-block col-search" id="search">
                <form class="form-string-search input-group my-2 my-lg-0" action="<?php echo site_url().'/'.TS_SINGLE_SEARCH['route'].'/'; ?>" method="GET">
                    <input type="hidden" name="pm-ot" value="<?php echo TS_SINGLE_SEARCH['search']['pm-ot'];?>">

                    <div class="search-field-input search-field-input--fulltext" data-search-placeholder="search-1">

                        <div class="input-icon">
                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#magnifying-glass"></use></svg>
                        </div>
                        <input class="search-field-input-field string-search-trigger" readonly type="search"  placeholder="<?php echo TS_SINGLE_SEARCH['placeholder'];?>" aria-label="Search" value="<?php echo !empty($_GET['pm-t']) ? $_GET['pm-t'] : '';?>">
                        <div class="lds-dual-ring"></div>
                    </div>

                    <?php
                    // -- search overlay
                    echo Template::render(APPLICATION_PATH . '/template-parts/pm-search/search/string-search-overlay.php', ['args' => $args['args'] ]);
                    ?>
                </form>
            </div>
            <?php } ?>


            <div class="col-auto">
                <a class="hotline-link" href="tel:<?php echo do_shortcode('[ts-company-hotline]');?>">
                    <span class="hotline-icon">
                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#phone-call"></use></svg>
                    </span>

                    <div class="hotline-info">
                        <div class="hotline-title">
                            <?php echo do_shortcode('[ts-company-hotline-info]'); ?>
                        </div>
                        <div class="hotline-number">
                            <?php echo do_shortcode('[ts-company-hotline]');?>
                        </div>
                    </div>

                </a>
            </div>
            <div class="col-auto pr-0">
                <a href="/calendar" title="Reisekalender" class="header-action header-action--calendar">
                    <div class="header-action--icon">
                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#calendar-blank"></use></svg>
                    </div>
                </a>
            </div>
            <div class="col-auto d-block pr-0 d-xl-none">
                <button class="header-action header-action--search toggler search-toggler" type="button" data-target="#search" aria-controls="search"
                        aria-expanded="false" aria-label="Toggle Search">
                    <div class="header-action--icon">
                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#magnifying-glass"></use></svg>
                    </div>
                </button>
            </div>
            <div class="col-auto dropdown">
                <button class="header-action header-action--wishlist toggler wishlist-toggler" type="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" data-offset="40,20">
                    <div class="header-action--icon">
                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#heart-straight"></use></svg>
                    </div>

                    <span class="wishlist-count">0</span>
                </button>

                <div class="dropdown-menu dropdown-menu-right dropdown-menu-wishlist">
                    <div class="dropdown-menu-inner">
                        <div class="dropdown-menu-content">
                            <div class="dropdown-menu-header d-none">
                                <div class="h4">
                                    Merkliste
                                </div>

                                <button class="close-wishlist" data-type="close-popup" type="button">
                                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
                                </button>
                            </div>

                            <div class="dropdown-menu-body">
                                <div id="wishlist-result" class="wishlist-items">

                                    <div class="alert alert-info p-2 m-0" role="alert">
                                        Keine Reisen auf der Merkliste
                                    </div>
                                </div>
                            </div>

                            <div style="display: none;" class="dropdown-menu-footer">
                                <a href='#' class="btn btn-outline-primary btn-block">
                                    Zur Merkliste
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
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

<nav class="page-navigation-offcanvas d-flex flex-column d-xl-none">
    <?php

    if (has_nav_menu('primary') === true) {
        $navTree = nav_menu_2_tree('primary');
    } else {
        $navTree = null;
    }

    load_template( get_stylesheet_directory().'/template-parts/header/menu-offcanvas.php', true, $navTree);
    ?>
</nav>

<div class="offcanvas-backdrop"></div>

<div class="datepicker-backdrop"></div>