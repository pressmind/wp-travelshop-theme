<div class="blog-list-entry">

    <?php
    $post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large');
    ?>

    <?php if ( $post_thumbnail ) { ?>
        <div class="blog-list-entry--thumbnail">
            <a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                <img src="<?php echo $post_thumbnail; ?>" alt="<?php echo get_the_title(); ?>" />
            </a>
        </div>
    <?php } ?>

    <div class="blog-list-entry--body">
        <div class="blog-list-entry--header">

            <h3 class="blog-list-entry--title">
                <a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                    <?php echo get_the_title(); ?>
                </a>
            </h3>

            <div class="blog-list-entry--details">

                <?php
                // Date
                $post_date = get_the_date();
                $post_date_link =  get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j'));

                $post_author_name = get_the_author_meta('display_name');

                if ( $post_author_name ) {
                    $post_author_id = get_the_author_meta('ID');
                    $post_author_nicename = get_the_author_meta('user_nicename');
                    $post_author_link = get_author_posts_url($post_author_id, $post_author_nicename);
                }

                $post_comments = get_comments( array('post_id' => get_the_ID() ) );

                ?>


                <?php if ( $post_date ) { ?>
                    <div>
                        <a href="<?php echo $post_date_link; ?>" title="<?php echo $post_date; ?>"><?php echo $post_date; ?></a><?php if ( $post_author_name ) { ?>&nbsp;von <a href="<?php echo $post_author_link; ?>" title="<?php echo $post_author_name; ?>"><?php echo $post_author_name; ?></a><?php } ?>
                    </div>
                <?php } ?>

                <?php if ( $post_comments ) { ?>
                    <div>
                        <?php
                        $post_comments_text = count($post_comments) . ' Kommentare';

                        if ( count($post_comments) == 1 ) {
                            $post_comments_text = count($post_comments) . ' Kommentar';
                        }
                        ?>
                        <a href="<?php echo get_the_permalink(); ?>#post-comments" title="<?php echo $post_comments_text; ?>">
                            <?php echo $post_comments_text; ?>
                        </a>
                    </div>
                <?php } ?>

            </div>

        </div>



        <?php
        $post_excerpt = get_the_excerpt();

        if ( $post_excerpt ) {
            ?>
            <div class="blog-list-entry--excerpt">
                <?php echo $post_excerpt; ?>
            </div>
            <?php
        }
        ?>

        <div class="blog-list-entry--more">
            <a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                Weiterlesen
            </a>
        </div>
    </div>



</div>
