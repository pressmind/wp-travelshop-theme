<?php

/**
 * @var array $args
 */

/**
 * @var Custom\MediaType\Reise $moc
 */
$moc = $args['moc'];

/**
 * @var Pressmind\ORM\Object\MediaObject $mo
 */
$mo = $args['mo'];
?>

<div class="nice-accordion">
    <div class="panel-group accordion-main" role="tablist" aria-multiselectable="true">
        <?php if (empty($moc->highlights_default) === false) { ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h2 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent=".accordion-main" href="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-star" width="20"
                            height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#607D8B" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                        </svg>
                        Highlights
                    </a>
                </h2>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="detail-reise-content">
                        <div class="row">
                            <?php if (empty($moc->bilder_default[3]) === false && is_object($moc->bilder_default[3])) { ?>
                            <div class="col-md-6 col-lg-5">
                                <img class="w-100 h-auto" src="<?php echo $moc->bilder_default[3]->getUri('detail'); ?>"
                                    data-toggle="tooltip" data-placement="bottom" data-html="true"
                                    alt="<?php echo $moc->bilder_default[3]->alt; ?>" title="<?php
                                             $caption = [];
                                             $caption[] = !empty($moc->bilder_default[3]->caption) ? $moc->bilder_default[3]->caption : '';
                                             $caption[] = !empty($moc->bilder_default[3]->copyright) ? '<small>' . $moc->bilder_default[3]->copyright . '</small>' : '';
                                             echo implode('<br>', array_filter($caption));
                                             ?>" />
                            </div>
                            <?php } ?>

                            <div class="col-md-6 col-lg-7">
                                <ul class="checked-list">
                                    <?php
                                        if(is_array($moc->highlights_default)){
                                            foreach ($moc->highlights_default as $highlight) {
                                                echo '<li>' . $highlight->item->name . '</li>';
                                            }
                                        }
                                        ?>
                                </ul>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
        <?php } ?>
        <?php if (empty($moc->leistungen_default) === false) { ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h2 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent=".accordion-main"
                        href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sun" width="20"
                            height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#607D8B" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <circle cx="12" cy="12" r="4" />
                            <path
                                d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                        </svg>
                        <?php echo strip_tags((string)$moc->leistungen_headline_default); ?>
                    </a>
                </h2>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="panel-body">
                    <div class="detail-reise-content">
                        <?php
                            echo str_replace('<ul>', '<ul class="checked-list">', $moc->leistungen_default);
                            ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php
        // Accommodation
        // object link example
        $uc = 0;
        if(is_array($moc->unterkunftsbeschreibungen_default)){
            foreach ($moc->unterkunftsbeschreibungen_default as $unterkunft_link) {
                $unterkunft_mo = new \Pressmind\ORM\Object\MediaObject($unterkunft_link->id_media_object_link, true);
                // if the linked object is not available (in most cases it must be public)
                if (empty($unterkunft_mo->id)) {
                    continue;
                }
                $uc++;
            }
        }

        if ($uc > 0) { ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree">
                <h2 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent=".accordion-main"
                        href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="20"
                            height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#607D8B" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <polyline points="5 12 3 12 12 3 21 12 19 12" />
                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                        </svg>
                        Unterkunft
                    </a>
                </h2>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                <div class="panel-body">

                    <?php
                        foreach ($moc->unterkunftsbeschreibungen_default as $unterkunft_link) {

                            $unterkunft_mo = new \Pressmind\ORM\Object\MediaObject($unterkunft_link->id_media_object_link, true);

                            // if the linked object is not available (in most cases it must be public)
                            if (empty($unterkunft_mo->id)) {
                                continue;
                            }

                            /**
                             * this is for better code complementation in lovely phpstorm
                             * @var $unterkunft_moc \Custom\MediaType\Unterkunft
                             */
                            $unterkunft_moc = $unterkunft_mo->getDataForLanguage(TS_LANGUAGE_CODE);

                            ?>
                    <b><?php echo $unterkunft_moc->headline_default; ?></b>
                    <?php echo $unterkunft_moc->beschreibung_text_default; ?>
                    <?php } ?>

                </div>
            </div>
        </div>
        <?php } ?>

        <?php
        // object link example
        if (empty($moc->beschreibung_text_default) === false) { ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingFour">
                <h2 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent=".accordion-main"
                        href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-2" width="20"
                            height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#607D8B" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="18" y1="6" x2="18" y2="6.01" />
                            <path d="M18 13l-3.5 -5a4 4 0 1 1 7 0l-3.5 5" />
                            <polyline points="10.5 4.75 9 4 3 7 3 20 9 17 15 20 21 17 21 15" />
                            <line x1="9" y1="4" x2="9" y2="17" />
                            <line x1="15" y1="15" x2="15" y2="20" />
                        </svg><?php echo !empty(strip_tags((string)$moc->beschreibung_headline_default)) ? strip_tags((string)$moc->beschreibung_headline_default) : 'Beschreibung'; ?>
                    </a>
                </h2>
            </div>
            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                <div class="panel-body">

                    <div class="detail-reise-content">
                        <?php
                            // Set the span style to the correct semantic tag, for example h5

                            $style_search = [];
                            $style_search[] = '/<span[^>]*?class="Head_1"[^>]*>(.*?)<\/span>/';
                            $style_replace[] = '<h5>$1</h5>';
                            $style_search[] = '/\<ul\>/';
                            $style_replace[] = '<ul class="checked-list">';

                            echo preg_replace($style_search, $style_replace, $moc->beschreibung_text_default);

                            ?>
                    </div>

                </div>
            </div>
        </div>
        <?php } ?>


        <?php
        // object link example
        $uc = 0;
        if(is_array($moc->textbaustein_default)){
            foreach ($moc->textbaustein_default as $textbaustein_link) {
                $textbaustein_mo = new \Pressmind\ORM\Object\MediaObject($textbaustein_link->id_media_object_link, true);
                // if the linked object is not available (in most cases it must be public)
                if (empty($textbaustein_mo->id)) {
                    continue;
                }
                $uc++;
            }
        }

        if ($uc > 0) { ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingFive">
                <h2 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent=".accordion-main"
                        href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle"
                            width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#607D8B" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <circle cx="12" cy="12" r="9" />
                            <line x1="12" y1="8" x2="12.01" y2="8" />
                            <polyline points="11 12 12 12 12 16 13 16" />
                        </svg>
                        Hinweise
                    </a>
                </h2>
            </div>
            <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                <div class="panel-body">

                    <div class="detail-reise-content">
                        <?php
                            foreach ($moc->textbaustein_default as $textbaustein_link) {

                                $textbaustein_mo = new \Pressmind\ORM\Object\MediaObject($textbaustein_link->id_media_object_link, true);

                                // if the linked object is not available (in most cases it must be public)
                                if (empty($textbaustein_mo->id)) {
                                    continue;
                                }

                                /**
                                 * this is for better code complementation in lovely phpstorm
                                 * @var $textbaustein_moc \Custom\MediaType\Textbaustein
                                 */
                                $textbaustein_moc = $textbaustein_mo->data[0];
                                ?>
                        <div class="detail-reise-content" id="reise-hinweis">
                            <p><?php echo $textbaustein_moc->text_default; ?></p>
                        </div>
                        <?php
                            }
                            ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

