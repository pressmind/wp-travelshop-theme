<?php
use Pressmind\HelperFunctions;
use Pressmind\Travelshop\PriceHandler;
use Pressmind\Travelshop\Template;

/**
 * @var $args | mediaobject data
 */
?>

<div class="detail-header-info-bottom">


    <?php
    // = = = > load the on request row (only shown if the full product is on request < = = =
    echo Template::render(APPLICATION_PATH . '/template-parts/pm-views/detail-blocks/booking-on-request-box.php', $args);
    ?>

    <?php
    if(!empty($args['cheapest_price']) && empty($args['booking_on_request'])){
    ?>
    <div class="detail-header-info-chosen-date">
        <div class="detail-header-info-chosen-date-icon">
            <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/transport-icon.php', ['transport_type' => $args['cheapest_price']->transport_type]); ?>
        </div>
        <div class="detail-header-info-chosen-date-info">
            <div class="detail-header-info-chosen-date-data">
                <div class="small-title">
                    Gewähltes Angebot
                </div>
                <div>
                    <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/travel-date-range.php', [
                        'date_departure' => $args['cheapest_price']->date_departure,
                        'date_arrival' => $args['cheapest_price']->date_arrival
                    ]);?>
                </div>
            </div>

            <button type="button" data-action="detail-change-date" class="detail-header-info-chosen-date-edit">
                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#pencil"></use></svg>
            </button>
        </div>
    </div>

    <?php // Random Availability
    $randint = random_int(1, 9);
    ?>
    <?php if($randint < 10) { ?>
        <div class="detail-header-info-status">
            <!-- Toggle in badge the class "active" to toggle status with animation -->
            <div class="status <?php echo $randint <= 3 ? 'danger' : ''; ?>">Nur noch <?php echo $randint < 10 ? $randint == 1 ? '1 Platz' : $randint . ' Plätze ' : ''; ?> frei</div>
        </div>
    <?php } ?>
    <div class="detail-header-info-cta">
        <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/booking-button.php', [
            'cheapest_price' => $args['cheapest_price'],
            'size' => 'lg',
            'url' => $args['url'],
            'disable_id' => true
        ]);?>
    </div>
    <?php } ?>
</div>