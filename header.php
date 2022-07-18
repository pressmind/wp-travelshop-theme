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
    <?php if(TS_COOKIE_CONSENT){
    ?><script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/cookieconsent.min.js"></script>
    <?php } ?>
    <link rel="preload" as="image" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/travelshop-logo.svg">
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
<?php
load_template_transient(get_template_directory().'/template-parts/layout-blocks/cookie-consent.php', false);
?>
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
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/travelshop-logo.svg" height="24" width="142"
                         class="d-inline-block align-middle" alt="<?php echo get_bloginfo( 'name' );?>">
                </a>
            </div>
            <div class="col align-self-center p-0">
                <?php load_template_transient(get_template_directory().'/template-parts/header/menu.php', false); ?>
            </div>
            <?php if(!empty(TS_SINGLE_SEARCH)){?>
            <div class="col-auto align-self-center  d-none d-lg-block col-search" id="search">
                <form class="form-string-search input-group my-2 my-lg-0" action="<?php echo site_url().'/'.TS_SINGLE_SEARCH['route'].'/'; ?>" method="GET">
                    <input type="hidden" name="pm-ot" value="<?php echo TS_SINGLE_SEARCH['search']['pm-ot'];?>">
                    <input class="form-control auto-complete" type="search" data-autocomplete="true" placeholder="<?php echo TS_SINGLE_SEARCH['placeholder'];?>"
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
            <?php } ?>


            <div class="col-auto align-self-center">
                <div class="travelshop_hotline_batch">
                    <small>Service-Hotline</small><br/>
                    <a href="tel:<?php echo do_shortcode('[ts-company-hotline]');?>"><?php echo do_shortcode('[ts-company-hotline]');?></a>
                    <a class="phone-link" href="tel:<?php echo do_shortcode('[ts-company-hotline]');?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="35"
                             height="35" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="col-auto align-self-center p-r-0">
                <a href="/calendar" title="Reisekalender" class="calendar calendar-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <rect x="4" y="5" width="16" height="16" rx="2"></rect>
                        <line x1="16" y1="3" x2="16" y2="7"></line>
                        <line x1="8" y1="3" x2="8" y2="7"></line>
                        <line x1="4" y1="11" x2="20" y2="11"></line>
                        <rect x="8" y="15" width="2" height="2"></rect>
                    </svg>
                </a>
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