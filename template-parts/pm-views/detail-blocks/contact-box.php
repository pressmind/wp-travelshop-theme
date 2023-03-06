<?php
/**
 * @var array $args
 */
?>

<div class="detail-box detail-box--contact">
    <div class="detail-box-body">
        <div class="detail-contact-wrapper">
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
                    <div class="hotline-openings">
                        <?php
                        $opening_times = wpsf_get_setting('travelshop_wpsf', 'contact_hotline', 'ts-company-opening-info');

                        foreach ( $opening_times as $opening ) {
                            echo "<div class='hotline-openings-item'>";
                            echo $opening['sub-text'];
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>

            </a>
        </div>
    </div>
</div>
<div class="box-contact">
    <div class="box-contact-phone">
        <strong>Persönliche Beratung</strong><br />
        <a href="#">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="20px" height="20px" viewBox="0 0 24 24" stroke-width="0" stroke="#000" fill="#06f" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
            </svg>
            <span>+49 (12) 345 678</span>
        </a><br />
        <small>Mo - Fr : 10:00 - 18:00 Uhr </small>
    </div>
    <div class="box-contact-whatsapp">
        <a href="#">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-whatsapp" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#27ae60" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                <path d="M9 10a0.5 .5 0 0 0 1 0v-1a0.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a0.5 .5 0 0 0 0 -1h-1a0.5 .5 0 0 0 0 1" />
            </svg>
        </a><br />
        <small>WhatsApp</small>
    </div>
</div>
