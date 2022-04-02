<footer class="footer-main">
    <div class="travelshop_above_footer">
        <div class="container">
            <div class="travelshop_trust_item">
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
            <div class="travelshop_trust_item">
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
            <div class="travelshop_trust_item">
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
            <div class="travelshop_trust_item">
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
    <div class="travelshop_main_footer">
        <div class="container">
            <div class="row footer-boxes">
                <div class="col-12 col-sm-6 col-lg-3 address">
                    <div class="h5">
                        Kontakt
                    </div>
                    <p>
                        <strong><?php echo do_shortcode('[ts-company-name]');?></strong><br>
                        <?php echo do_shortcode('[ts-company-zip]');?>
                        <?php echo do_shortcode('[ts-company-city]');?>
                    </p>
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="16" height="16" viewBox="0 4 25 24" stroke-width="2" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                        </svg> <a href="tel:<?php echo do_shortcode('[ts-company-hotline]');?>"><?php echo do_shortcode('[ts-company-hotline]');?></a><br>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="16" height="16" viewBox="0 2 24 24" stroke-width="1.5" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <polyline points="3 7 12 13 21 7" />
                        </svg> <a href="mailto:<?php echo do_shortcode('[ts-company-mail]');?>"><?php echo do_shortcode('[ts-company-email]');?></a>
                    </p>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <?php
                    $args = [
                        'menu_location' => 'footer_column_1'
                    ];
                    load_template_transient(get_template_directory().'/template-parts/footer/menu.php', false, $args);
                    ?>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <?php
                    $args = [
                      'menu_location' => 'footer_column_2'
                    ];
                    load_template_transient(get_template_directory().'/template-parts/footer/menu.php', false, $args);
                    ?>
                    <div class="h5">
                        Searchroutes
                    </div>
                    <?php
                    // For Example purposes only, output all search routes
                    echo do_shortcode('[ts-searchroutes]');
                    ?>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="h5">
                        <?php echo do_shortcode('[ts-company-name]');?>
                    </div>
                    <p>
                        <?php echo do_shortcode('[ts-company-name]');?>  möchte Menschen zusammenbringen, um gemeinsame unvergessliche, glückliche Reiseerlebnisse zu genießen.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="travelshop_meta_footer">
        <div class="container">
            <?php
            $args = [
                'menu_location' => 'footer_meta_menu'
            ];
            load_template_transient(get_template_directory().'/template-parts/footer/meta_menu.php', false, $args);
            ?>
        </div>
    </div>
</footer>
<?php
wp_footer();
?>
</body>
</html>