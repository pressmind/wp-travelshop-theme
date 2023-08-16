<?php
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// var_dump($actual_link);
// @todo: build links to share pages with text

print_r($args);
if ( !isset( $args['share_options'] ) ) {
    $args['share_options'] = [
        'title' => 'Reisetipp',
        'title_prefix' => 'Teile diese',
        'type' => 'Reise',
        'name' => '',
        'text' => 'Ich empfehle die Reise',
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
}


$args['share_options']['title_prefix'] = ( !isset($args['share_options']['title_prefix']) && !empty($args['share_options']['title_prefix']) ) ? $arg['share_options']['title_prefix'] : 'Teile diese ';

$share_title = !empty($args['share_options']['type']) ? $args['share_options']['title_prefix'] . $args['share_options']['type'] : 'Seite teilen';
?>

<div class="page-share">
    <a href="" title="<?php echo $share_title; ?>" class="btn btn-link btn-link-light page-share-toggler px-0" data-share-link="<?php echo $actual_link; ?>">
        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#share-network"></use></svg>
        Teilen
    </a>

    <div class="page-share-fallback">
        <div class="page-share-fallback-inner">
            <div class="page-share-fallback-content">
                <div class="page-share-fallback-header">
                    <div class="h4">
                        <?php echo $share_title; ?>
                    </div>

                    <button class="close-share" data-type="close-popup" type="button">
                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
                    </button>
                </div>
                <div class="page-share-fallback-body">

                    <?php if ( isset($args['object']) && !empty($args['object']) ) { ?>
                        <?php if ( (isset($args['object']['title']) && !empty($args['object']['title'])) && (isset($args['object']['image']) && !empty($args['object']['image'])) ) { ?>
                        <div class="share-object">

                            <div class="share-object-image">
                                <img src="<?php echo $args['object']['image']['url_thumbnail']; ?>" alt="<?php echo $args['object']['image']['caption']; ?>" />
                            </div>

                            <div class="share-object-body">
                                <strong><?php echo $args['object']['title']; ?></strong>
                            </div>
                        </div>
                        <?php } ?>
                    <?php } ?>

                    <div class="share-buttons">
                        <?php if ( isset($args['share_options']['buttons']['facebook']) && $args['share_options']['buttons']['facebook'] ) { ?>
                            <div class="share-buttons-col">
                                <a target="_blank" href="" title="Auf Facebook teilen" class="share-button">
                                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/share-sprite.svg#share-facebook"></use></svg>

                                    Facebook
                                </a>
                            </div>
                        <?php } ?>
                        <?php if ( isset($args['share_options']['buttons']['facebook-messenger']) && $args['share_options']['buttons']['facebook-messenger'] ) { ?>
                            <div class="share-buttons-col">
                                <a target="_blank" href="" title="Per Messenger teilen" class="share-button">
                                    <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"  focusable="false" style="display: block; height: 32px; width: 32px;"><radialGradient id="a" cx="19.25%" cy="99.446619%" r="108.96%"><stop offset="0" stop-color="#09f"></stop><stop offset=".6098" stop-color="#a033ff"></stop><stop offset=".9348" stop-color="#ff5280"></stop><stop offset="1" stop-color="#ff7061"></stop></radialGradient><g fill="none" transform="translate(4 4)"><path d="m12 0c-6.759 0-12 4.95256076-12 11.6389677 0 3.4976898 1.434 6.5214217 3.768 8.6092365.195.1739846.315.4199627.321.6839393l.066 2.1358106c.021.6809396.723 1.1249002 1.347.8489247l2.382-1.0499069c.201-.089992.429-.1049907.642-.0479957 1.095.2999734 2.259.461959 3.474.461959 6.759 0 12-4.9525607 12-11.6389677 0-6.68640701-5.241-11.6419675-12-11.6419675z" fill="url(#a)"></path><path d="m4.794 15.0436658 3.525-5.59150411c.561-.89092099 1.761-1.10990157 2.604-.47995744l2.805 2.10281355c.258.1919829.612.1919829.867-.0029998l3.786-2.87374511c.504-.38396594 1.164.22198032.828.75893269l-3.528 5.58850432c-.561.890921-1.761 1.1099016-2.604.4799575l-2.805-2.1028135c-.258-.191983-.612-.191983-.867.0029997l-3.786 2.8737451c-.504.383966-1.164-.2189805-.825-.7559329z" fill="#fff"></path></g></svg>
                                    Messenger
                                </a>
                            </div>
                        <?php } ?>

                        <?php if ( isset($args['share_options']['buttons']['twitter']) && $args['share_options']['buttons']['twitter'] ) { ?>
                            <div class="share-buttons-col">
                                <a target="_blank" href="" title="Auf Twitter teilen" class="share-button">
                                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/share-sprite.svg#share-twitter"></use></svg>
                                    Twitter
                                </a>
                            </div>
                        <?php } ?>

                        <?php if ( isset($args['share_options']['buttons']['whatsapp']) && $args['share_options']['buttons']['whatsapp'] ) { ?>
                            <div class="share-buttons-col">
                                <a target="_blank" href="" title="per WhatsApp teilen" class="share-button">
                                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/share-sprite.svg#share-whatsapp"></use></svg>
                                    WhatsApp
                                </a>
                            </div>
                        <?php } ?>

                        <?php if ( isset($args['share_options']['buttons']['telegram']) && $args['share_options']['buttons']['telegram'] ) { ?>
                            <div class="share-buttons-col">
                                <a target="_blank" href="" title="Per Telegram teilen" class="share-button">
                                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/share-sprite.svg#share-telegram"></use></svg>
                                    Telegram
                                </a>
                            </div>
                        <?php } ?>

                        <?php if ( isset($args['share_options']['buttons']['mail']) && $args['share_options']['buttons']['mail'] ) { ?>
                            <div class="share-buttons-col">
                                <a target="_blank" href="" title="Per E-Mail senden" class="share-button">
                                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#envelope"></use></svg>
                                    per E-Mail senden
                                </a>
                            </div>
                        <?php } ?>


                        <?php if ( isset($args['share_options']['buttons']['copy']) && $args['share_options']['buttons']['copy'] ) { ?>
                            <div class="share-buttons-col">
                                <a href="" title="Link kopieren" data-link="<?php echo $actual_link; ?>" class="share-button share-button--copy">
                                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#copy"></use></svg>
                                    Link kopieren
                                </a>
                            </div>

                            <div class="share-copy-info share-copy-info--success" style="display: none;">
                                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#check"></use></svg>
                                Link kopiert
                            </div>

                            <div class="share-copy-info share-copy-info--error hide" style="display: none;">
                                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#warning-circle"></use></svg>
                                Kopieren fehlgeschlagen
                            </div>
                        <?php } ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
