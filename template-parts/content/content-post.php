<?php
use Pressmind\Travelshop\Template;
?>

<div class="row align-items-center">
    <div class="col">
        <?php the_breadcrumb(null);?>
    </div>
    <div class="col-auto">
        <?php
        // = = = > simple share button < = = =
        $share_args = [
            'title' => 'Beitrag',
            'type' => 'Beitrag',
            'title_prefix' => 'Teile diesen ',
            'name' => '',
            'text' => 'Ich empfehle den Beitrag',
            'buttons' => [
                'facebook' => true,
                'facebook-messenger' => true,
                'twitter' => true,
                'whatsapp' => true,
                'telegram' => true,
                'mail' => true,
                'copy' => true,
            ]
        ];

        $share_object = [
            'title' => get_the_title(),
            'image' => [
                'url_thumbnail' => get_the_post_thumbnail_url(get_the_ID()),
                'caption' => ''
            ]
        ];
        echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/link-sharing.php', ['share_options' => $share_args, 'object' => $share_object]);
        ?>
    </div>
</div>
<main>
    <div class="content-main content-main--posts" id="content-main">
        <div class="container">
            <div class="content-block content-block-blog">
                <div class="row">
                    <div class="col-12 col-md-9">
                        <?php get_template_part( 'template-parts/wp-views/blog-list-entry-single' );  ?>
                    </div>
                    <div class="col-12 col-md-3">
                        <?php get_sidebar(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>