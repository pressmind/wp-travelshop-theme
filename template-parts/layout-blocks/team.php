<?php

?>
<section class="content-block content-block-team content-block-teaser-group">
    <div class="row">
        <?php if(!empty($args['headline']) || !empty($args['text'])){ ?>
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
        <?php } ?>

        <?php
        if(!empty($args['items'])){
            $colClass = $args['classes'];

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
                                <div class="image-holder">
                                    <img alt="<?php echo $item['name']; ?>" loading="lazy" src="<?php echo $item['image']; ?>" />
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                        <div class="teaser-body">
                            <?php if ( $item['name'] ) { ?>
                                <h1>
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
                                        <a title="E-Mail an <?php echo $item['name']; ?>" href="mailto:<?php echo $item['mail']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="16" height="16" viewBox="0 2 24 24" stroke-width="1.5" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                                <polyline points="3 7 12 13 21 7"></polyline>
                                            </svg>
                                            <?php echo $item['mail']; ?>
                                        </a>
                                    <?php } ?>


                                    <?php if ( $item['phone'] ) { ?>
                                        <a title="Jetzt anrufen!" href="tel:<?php echo $item['phone']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="16" height="16" viewBox="0 4 25 24" stroke-width="2" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                            </svg>
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