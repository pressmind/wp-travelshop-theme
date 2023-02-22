<?php
/**
 * <code>
 *  $args['headline']
 *  $args['text']
 *  $args['teasers'][][ // list of teasers
                        [headline] => We make it!
                        [text] => Some example text
                        [priority] => // icon-inner-secondary, icon-inner-primary, ''
                        [btn_link] =>
                        [btn_link_target] => _self
                        [btn_link_nofollow] => no
                        [btn_label] => Jetzt entdecken
                        [svg_icon] => Jetzt entdecken

 *                  ]
 *

 * </code>
 * @var array $args
 */

?>
<section class="content-block content-block-teaser-group">
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
        if(!empty($args['teasers'])){
            foreach($args['teasers'] as $teaser){
                $teaser = (array)$teaser;
        ?>
        <div class="col-12 col-sm-6 col-lg-3">
            <article class="teaser icon-teaser">
                <div class="teaser-icon">
                <?php if(!empty($teaser['svg_icon'])){?>
                    <div class="icon-inner <?php echo !empty($teaser['priority']) ? $teaser['priority'] : '';?>">
                        <?php echo $teaser['svg_icon']; ?>
                    </div>
                <?php } ?>
                </div>
                <div class="teaser-body">
                    <?php if(!empty($teaser['headline'])){?>
                    <h1 class="teaser-title h5">
                        <?php echo $teaser['headline'];?>
                    </h1>
                <?php } ?>
                <?php if(!empty($teaser['text'])){?>
                    <p>
                        <?php echo $teaser['text'];?>
                    </p>
                <?php } ?>
                <?php if(!empty($teaser['btn_link'])){?>
                    <a href="<?php echo $teaser['btn_link'];?>" target="<?php echo !empty($teaser['btn_link_target']) ? $teaser['btn_link_target'] : '_self';?>"
                       class="btn btn-primary btn-block">
                        <span><?php echo !empty($teaser['btn_label']) ? $teaser['btn_label'] : 'Button';?></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-caret-right"
                             width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18 15l-6 -6l-6 6h12" transform="rotate(90 12 12)" />
                        </svg>
                    </a>
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