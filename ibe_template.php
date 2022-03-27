<?php
/**
 * Tipp:
 * All IBE request params are redirected to this page, so add you're own or use the existing
 * params to change request based logo or contact infos on this page
 * try: echo print_r($_GET);
 */

require_once('../../../wp-load.php');
?>
<!DOCTYPE html>
<html lang="de">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/scss/ibe_template.min.css">
    <title>Travelshop - Buchung</title>

    <!--###PRESSMIND_IBE_HEADER_CSS###-->
    <!--###PRESSMIND_IBE_HEADER_SCRIPTS###-->

</head>

<body>

<header class="header-main">
    <div class="container">

        <div class="row header-main-row">
            <div class="col-auto align-self-center d-block d-lg-none">
                <button class="toggler navbar-toggler offcanvas-toggler" type="button" data-target="#navbar"
                        aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="28"
                         height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#607D8B" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"/>
                        <line x1="4" y1="6" x2="20" y2="6"/>
                        <line x1="4" y1="12" x2="20" y2="12"/>
                        <line x1="4" y1="18" x2="20" y2="18"/>
                    </svg>
                </button>
            </div>
            <div class="col-auto align-self-center ">
                <a class="navbar-brand" href="<?php echo site_url(); ?>">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/travelshop-logo.svg" height="24"
                         class="d-inline-block align-middle" alt="">
                </a>
            </div>
            <div class="col align-self-center ">

                <?php
                if (has_nav_menu('ibe_head') === true) {
                    ?>
                    <nav class="navbar navbar-expand-lg offcanvas" id="navbar">
                        <button class="offcanvas-close">
                            <i class="la la-times"></i> Menü schließen
                        </button>
                        <div class="navbar-offcanvas">
                            <ul class="navbar-nav mr-auto ml-auto">

                                <?php
                                $menu_items = nav_menu_2_tree('ibe_head');
                                if (isset($menu_items)) {
                                    foreach ($menu_items['navigation'] as $item) {
                                        // Top Level
                                        if (empty($item->wpse_children) === true) { // Level 1
                                            ?>
                                            <li class="nav-item <?php if ( !empty($menu_items['active_ids']) && in_array( $item->ID, $menu_items['active_ids']) ) { echo "active"; } ?>">
                                                <a class="nav-link"
                                                   href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
                                            </li>
                                            <?php
                                        } else { // Level 2
                                            ?>
                                            <li class="nav-item dropdown <?php if ( !empty($menu_items['active_ids']) && in_array( $item->ID, $menu_items['active_ids']) ) { echo "active"; } ?>">
                                                <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown"
                                                   role="button"
                                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <?php echo $item->title; ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="icon icon-tabler icon-tabler-caret-down" width="20" height="20"
                                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="#ccc" fill="#ccc"
                                                         stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M18 15l-6 -6l-6 6h12" transform="rotate(180 12 12)"/>
                                                    </svg>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                    <?php
                                                    foreach ($item->wpse_children as $child_items) {
                                                        ?>
                                                        <a class="dropdown-item <?php if ( !empty($menu_items['active_ids']) && in_array( $child_items->ID, $menu_items['active_ids']) ) { echo "active"; } ?>"
                                                           href="<?php echo $child_items->url ?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                 class="icon icon-tabler icon-tabler-caret-right" width="15" height="15"
                                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="#ccc" fill="#ccc"
                                                                 stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M18 15l-6 -6l-6 6h12" transform="rotate(90 12 12)"/>
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
                        <small style="padding: 1rem; display: inline-block;">menu: ‚IBE Template Head Menu‘ not
                            configured</small>
                    </nav>
                <?php } ?>
            </div>
            <div class="col-auto align-self-center">
                <div class="ibe_template_hotline">
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
        </div>
    </div>
    <div class="modal fade" id="offanvas-backdrop">
        <div class="modal-dialog modal-xl" style="opacity: 0;">
            <div class="modal-content"></div>
        </div>
    </div>
</header>

<main>
    <div class="container">
        ###PRESSMIND_IBE_CONTENT###
    </div>
</main>

<footer>
    <div class="ibe_above_footer">
        <div class="container">
            <div class="ibe_trust_item">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shield-lock" width="300"
                         height="300" viewBox="0 0 24 24" stroke-width="1.5" stroke="#6c757d" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3"/>
                        <circle cx="12" cy="11" r="1"/>
                        <line x1="12" y1="12" x2="12" y2="14.5"/>
                    </svg>
                </div>
                <span>SSL-Schutz</span>
            </div>
            <div class="ibe_trust_item">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-discount" width="300"
                         height="300" viewBox="0 0 24 24" stroke-width="1.5" stroke="#6c757d" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <line x1="9" y1="15" x2="15" y2="9"/>
                        <circle cx="9.5" cy="9.5" r=".5" fill="currentColor"/>
                        <circle cx="14.5" cy="14.5" r=".5" fill="currentColor"/>
                        <circle cx="12" cy="12" r="9"/>
                    </svg>
                </div>
                <span>Bester Preis</span>
            </div>
            <div class="ibe_trust_item">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-credit-card" width="300"
                         height="300" viewBox="0 0 24 24" stroke-width="1.5" stroke="#6c757d" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <rect x="3" y="5" width="18" height="14" rx="3"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                        <line x1="7" y1="15" x2="7.01" y2="15"/>
                        <line x1="11" y1="15" x2="13" y2="15"/>
                    </svg>
                </div>
                <span>Sichere Zahlung</span>
            </div>
            <div class="ibe_trust_item">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="300"
                         height="300" viewBox="0 0 24 24" stroke-width="1.5" stroke="#6c757d" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <polyline points="3 7 12 13 21 7"/>
                    </svg>
                </div>
                <span>Reise-Infos</span>
            </div>
        </div>
    </div>
    <div class="footer-main">
        <div class="container">
            <div class="row footer-boxes">

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="h5">
                        Kontakt
                    </div>

                    <p>
                        <strong>Touroperator GmbH</strong><br>
                        Urlaubsgasse 1<br>
                        54321 Musterstadt
                    </p>
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="16" height="16" viewBox="0 4 25 24" stroke-width="2" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                        </svg> <a href="tel:01234">01234 567889</a><br>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="16" height="16" viewBox="0 2 24 24" stroke-width="1.5" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <polyline points="3 7 12 13 21 7" />
                        </svg> <a href="mailto:info@example.de">info@example.de</a>
                    </p>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 offset-lg-6">
                    <?php
                    if (has_nav_menu('ibe_footer')) {

                        $locations = get_nav_menu_locations(); //get all menu locations
                        $footer_1_menu = wp_get_nav_menu_object($locations['ibe_footer']);

                        ?>
                        <div class="h5">
                            <?php echo !empty($footer_1_menu->name) ? $footer_1_menu->name : ''; ?>
                        </div>

                        <nav class="nav flex-column">
                            <ul class="">
                                <?php
                                wp_nav_menu(
                                    array(
                                        'container' => '',
                                        'depth' => 1,
                                        'items_wrap' => '%3$s',
                                        'theme_location' => 'ibe_footer',
                                    )
                                );
                                ?>
                            </ul>
                        </nav>

                    <?php } else { ?>
                        <nav class="navbar flex-column">
                            <small style="padding: 1rem; display: inline-block;">menu: ‚IBE Template Footer Menu‘ not
                                configured</small>
                        </nav>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

</footer>

<!--###PRESSMIND_IBE_FOOTER_SCRIPTS###-->

<?php
// don't load bootstrap or jquery here, it's already loaded during the <!--###PRESSMIND_IBE_FOOTER_SCRIPTS###--> tag above
?>
</body>
</html>