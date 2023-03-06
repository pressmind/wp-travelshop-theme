<?php
/**
 * @var array $args
 */
?>

<div class="detail-box detail-box--contact">
    <div class="detail-box-title">
        <div class="h4">
            Persönliche Beratung
        </div>
    </div>
    <div class="detail-box-body">
        <div class="detail-contact-wrapper">
            <a class="hotline-link" href="tel:<?php echo do_shortcode('[ts-company-hotline]');?>">
                <span class="hotline-icon">
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#phone-call"></use></svg>
                </span>

                <div class="hotline-info">
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

            <a class="whatsapp-link" href="https://wa.me/<?php echo do_shortcode('[ts-company-hotline]');?>" target="_blank">
                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#whatsapp"></use></svg>

                WhatsApp
            </a>
        </div>
    </div>
</div>
