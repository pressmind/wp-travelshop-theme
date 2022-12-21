<footer class="footer-main">

    <div class="footer-main--trust">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="trust-item">
                        <div class="trust-item--icon">
                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/iconoir-sprite.svg#shield-check"></use></svg>
                        </div>
                        <div class="trust-item--title">
                            SSL-Schutz
                        </div>
                    </div>
                    <div class="trust-item">
                        <div class="trust-item--icon">
                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/iconoir-sprite.svg#percent"></use></svg>
                        </div>
                        <div class="trust-item--title">
                            Bester Preis
                        </div>
                    </div>
                    <div class="trust-item">
                        <div class="trust-item--icon">
                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/iconoir-sprite.svg#credit-card"></use></svg>
                        </div>
                        <div class="trust-item--title">
                            Sichere Zahlung
                        </div>
                    </div>
                    <div class="trust-item">
                        <div class="trust-item--icon">

                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/iconoir-sprite.svg#envelope"></use></svg>
                        </div>
                        <div class="trust-item--title">
                            Reise-Infos
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-main--boxes">
        <div class="container">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="h5">
                    Kontakt
                </div>
                <p>
                    <strong><?php echo do_shortcode('[ts-company-name]');?></strong><br>
                    <?php echo do_shortcode('[ts-company-zip]');?>
                    <?php echo do_shortcode('[ts-company-city]');?>
                </p>
                <p>
                    <a href="tel:<?php echo do_shortcode('[ts-company-hotline]');?>" title="<?php echo do_shortcode('[ts-company-name]');?> anrufen" class="icon-link">
                        <div class="icon">
                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/iconoir-sprite.svg#phone-call"></use></svg>
                        </div>
                        <?php echo do_shortcode('[ts-company-hotline]');?>
                    </a>

                    <a href="mailto:<?php echo do_shortcode('[ts-company-mail]');?>" title="E-Mail an <?php echo do_shortcode('[ts-company-name]');?>" class="icon-link">
                        <div class="icon">
                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/iconoir-sprite.svg#envelope"></use></svg>
                        </div>
                        <?php echo do_shortcode('[ts-company-email]');?>
                    </a>
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

    <div class="footer-main--meta">
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
<?php //load_template(get_template_directory() . '/template-parts/layout-blocks/auto-modal.php'); ?>
<?php
wp_footer();
?>
</body>
</html>