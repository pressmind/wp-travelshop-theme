<?php
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// var_dump($actual_link);

if ( !isset ( $args['share_options'] ) ) {
    $args['share_options'] = [
        'title' => 'Reisetipp',
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

$share_title = !empty($args['share_options']['name']) ? $args['share_options']['name'] . ' teilen' : 'Seite teilen';
?>

<div class="page-share">
    <a href="" title="<?php echo $share_title; ?>" class="btn btn-link page-share-toggler px-0" data-share-link="<?php echo $actual_link; ?>">
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

                    <button class="close-share">
                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#x"></use></svg>
                    </button>
                </div>
                <div class="page-share-fallback-body">
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
<?php /*
<div class="share">
    <label class="btn btn-primary" style="display:inline-flex; align-items: center;" for="sharemodal">
        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#share-network"></use></svg>
        </svg> <span style="margin-left:.5rem;">Teilen</span>
    </label>
    <input class="d-none" id="sharemodal" type="checkbox" />
    <div class="share-box">
        <ul>
            <li>
                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $actual_link; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-facebook" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#597e8d" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                    </svg> Facebook
                </a>
            </li>
            <li class="d-md-none">
                <a data-action="share/whatsapp/share" href="whatsapp://send?text=Ich%20empfehle%3A%2F%2F<?php echo $actual_link; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-whatsapp" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#597e8d" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                        <path d="M9 10a0.5 .5 0 0 0 1 0v-1a0.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a0.5 .5 0 0 0 0 -1h-1a0.5 .5 0 0 0 0 1" />
                    </svg> WhatsApp
                </a>
            </li>
            <li>
                <a target="_blank" href="mailto:?subject=Reisetipp&amp;body=Ich%20empfehle%20die%20Reise%20<?php echo $actual_link; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#597e8d" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <rect x="3" y="5" width="18" height="14" rx="2" />
                        <polyline points="3 7 12 13 21 7" />
                    </svg> Mail
                </a>
            </li>
            <li>
                <a target="_blank" href="https://t.me/share/url?url=<?php echo $actual_link; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-telegram" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#597e8d" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" />
                    </svg> Telegram
                </a>
            </li>
        </ul>
    </div>
</div>
 */ ?>
