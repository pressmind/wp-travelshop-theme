<?php
/**
 * THIS FILE IS A DIRTY DRAFT!!!
 * it's possible to add two types of itineraries in pressmind:
 *
 * 1. the very complex one: booking package specific itineraries
 *    which has a dependencies to the travel duration and dates
 *    and can contain different variants and travel bricks.
 *
 * or
 *
 * 2. the easy one: media object specific itineraries
 *    which has  -- NO -- dependencies to travel duration or dates
 *
 * THIS FILE handles type 2, the "easy one"
 */

/**
 * @var array $args
 */

if (empty($args['media_object']->getItinerarySteps())) {
    return;
}

$valid = false;
foreach ($args['media_object']->getItinerarySteps() as $key => $step) {
    foreach ($step->sections as $section) {
        if(!empty(strip_tags($section->content->headline))){
            $valid = true;
        }
    }
}

if(!$valid){
    return;
}


?>
<div class="accordion-group">
    <div class="accordion-header">
        <h2 class="h3">Reiseverlauf</h2>

        <button class="accordion-toggle btn btn-light" data-toggle="open">
            Alle <span class="txt-open">öffnen</span><span class="txt-close">schließen</span>
        </button>
    </div>
    <section class="itinerary">
        <?php
        foreach ($args['media_object']->getItinerarySteps() as $key => $step) {
            foreach ($step->sections as $section) {
                if(empty(strip_tags($section->content->headline))){
                    continue;
                }
                ?>
                <div class="itinerary-step">
                    <h3>
                        <?php echo $section->content->headline; ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus itinerary-step-open" width="30" height="30" viewBox="0 0 24 24" stroke-width="2.5" stroke="#06f" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                    </h3>
                    <div class="itinerary-step-more">
                        <div class="itinerary-step-desc">
                            <?php echo $section->content->description; ?>
                        </div>
                        <div class="<?php echo count($step->document_media_objects) > 1 ? 'itinerary-step-gallery' : ''; ?> it-gallery-<?php echo $key; ?>">
                            <?php foreach($step->document_media_objects as $picture) { ?>
                                <a href="<?php echo $picture->getUri('detail_gallery'); ?>" data-lightbox="itinerary-step-<?php echo $step->id; ?>">
                                    <img src="<?php echo $picture->getUri('teaser'); ?>" alt="<?php echo $picture->alt; ?>" loading="lazy" />
                                    <div class="itinerary-step-gallery-image-copyright">
                                        <?php echo $picture->copyright; ?>
                                    </div>
                                </a>
                            <?php }
                            ?>
                        </div>
                        <!-- <div class="itinerary-step-catering">
                            Hier kommt die Verpflegung hin
                        </div>-->
                    </div>
                </div>
            <?php }
        }?>

    </section>
</div>