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
    <a href="" title="<?php echo $share_title; ?>" class="btn btn-link">
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
                            <a href="" class="share-button">
                                Facebook
                            </a>
                        <?php } ?>

                        <?php if ( isset($args['share_options']['buttons']['twitter']) && $args['share_options']['buttons']['twitter'] ) { ?>
                            <a href="" class="share-button">
                                Twitter
                            </a>
                        <?php } ?>

                        <?php if ( isset($args['share_options']['buttons']['whatsapp']) && $args['share_options']['buttons']['whatsapp'] ) { ?>
                            <a href="" class="share-button">
                                WhatsApp
                            </a>
                        <?php } ?>

                        <?php if ( isset($args['share_options']['buttons']['telegram']) && $args['share_options']['buttons']['telegram'] ) { ?>
                            <a href="" class="share-button">
                                Telegram
                            </a>
                        <?php } ?>

                        <?php if ( isset($args['share_options']['buttons']['mail']) && $args['share_options']['buttons']['mail'] ) { ?>
                            <a href="" class="share-button">
                                Mail
                            </a>
                        <?php } ?>
                    </div>

                    <?php if ( isset($args['share_options']['buttons']['copy']) && $args['share_options']['buttons']['copy'] ) { ?>
                        <div class="share-copy">
                            <div class="input-group input-group-copy">
                                <input type="text" readonly class="form-control" value="<?php echo $args['url']; ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="share-page--copy">

                                        <div class="icon">
                                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#copy"></use></svg>
                                        </div>
                                    </button>
                                </div>

                                <div class="share-copy-info">
                                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#check"></use></svg>
                                    Der Link wurde kopiert
                                </div>
                            </div>

                        </div>
                    <?php } ?>
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
