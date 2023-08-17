<?php

?>
<section class="content-block content-block-team content-block-teaser-group">
    <?php if(!empty($args['headline']) || !empty($args['text'])){ ?>
        <div class="row row-introduction">
            <div class="col-12">
                <?php if(!empty($args['headline'])){ ?>
                    <h2 class="mt-0">
                        <?php echo $args['headline'];?>
                    </h2>
                <?php } ?>
                <?php if(!empty($args['text'])){ ?>
                    <p><?php echo $args['text'];?></p>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <div class="row row-products">
        <?php
        if(!empty($args['items'])){
            $colClass = 'col-12 col-sm-6 col-lg-3';

            if ( count($args['items']) < 4 ) {
                $colClass = 'col-12 col-sm-6 col-lg-4';
            }
            foreach($args['items'] as $item){
                $item = (array)$item;

                if ( !empty($item['image_id'])){
                    $item['image'] = wp_get_attachment_image_url( $item['image_id'], 'thumbnail_original');
                };
                ?>
                <div class="<?php echo $colClass; ?>">
                    <article class="teaser team-teaser">
                        <?php
                        if ( !empty($item['image']) ) {
                            ?>
                            <div class="teaser-image">
                                <div class="media media-cover media-circle ratio-1x1">
                                    <img alt="<?php echo $item['name']; ?>" loading="lazy" src="<?php echo $item['image']; ?>" />
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                        <div class="teaser-body">
                            <?php if ( $item['name'] ) { ?>
                                <h1 class="teaser-title h5">
                                    <?php echo $item['name']; ?>

                                    <?php if ( $item['position'] ) { ?>
                                        <small><?php echo $item['position']; ?></small>
                                    <?php } ?>
                                </h1>
                            <?php } ?>

                            <?php if ( $item['text'] ) { ?>
                                <div class="teaser-body-text">
                                    <?php echo $item['text']; ?>
                                </div>
                            <?php } ?>

                            <?php if ( $item['mail'] || $item['phone'] ) { ?>
                                <div class="teaser-body-contact">
                                    <?php if ( $item['mail'] ) { ?>
                                        <a href="mailto:<?php echo $item['mail']; ?>" title="E-Mail an <?php echo $item['name']; ?>" class="icon-link justify-content-center">
                                            <div class="icon">
                                                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#envelope"></use></svg>
                                            </div>
                                            <?php echo $item['mail']; ?>
                                        </a>
                                    <?php } ?>

                                    <?php if ( $item['phone'] ) { ?>
                                        <a href="tel:<?php echo $item['phone']; ?>" title="Jetzt anrufen!" class="icon-link justify-content-center">
                                            <div class="icon">
                                                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#phone-call"></use></svg>
                                            </div>
                                            <?php echo $item['phone']; ?>
                                        </a>
                                    <?php } ?>
                                </div>
                            <?php } ?>

                            <?php if ( !empty($item['btn_link']) ) { ?>
                                <?php
                                $item['btn_text'] = $item['btn_text'] ? $item['btn_text'] : 'Über mich';
                                ?>
                                <div class="teaser-body-button">
                                    <a class="btn btn-primary" href="<?php echo $item['btn_link']; ?>" title="<?php echo $item['btn_text']; ?>">
                                        <?php echo $item['btn_text']; ?>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </article>
                </div>
                <?php
            }
        }
        ?>
    </div>
</section>