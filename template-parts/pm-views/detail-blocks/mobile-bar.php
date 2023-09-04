<?php
use Pressmind\HelperFunctions;
use Pressmind\Travelshop\PriceHandler;
use Pressmind\Travelshop\Template;

/**
 * @var array $args
 */
if(empty($args['cheapest_price'])){
    return;
}
?>
<div class="detail-mobile-bar">

    <div class="container">
        <span class="mobile-bar-title"><?php echo $args['headline'] ?></span>
        <p>
            <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration.php', [
                    'duration' => $args['cheapest_price']->duration]);
            ?>
            -
            <?php
            echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/price.php',  [
                'cheapest_price' => $args['cheapest_price'],
            ]);
            ?>
            <?php if (($discount = PriceHandler::getDiscount($args['cheapest_price'])) !== false) {
                echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/discount.php', [
                    'cheapest_price' => $args['cheapest_price'],
                    'discount' => $discount,
                ]);
                ?>
            <?php } ?>
        </p>
        <div class="mobile-bar-cta">
            <div class="mobile-bar-date">
                        <span class="date">
                            <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/transport-icon.php', ['transport_type' => $args['cheapest_price']->transport_type]);?>
                            <a class="show-dates booking-btn" data-modal="true" data-anchor="<?php echo $args['cheapest_price']->id; ?>">
                                 <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/travel-date-range.php', [
                                     'date_departure' => $args['cheapest_price']->date_departure,
                                     'date_arrival' => $args['cheapest_price']->date_arrival
                                 ]);?>
        <div class="detail-mobile-bar-row d-flex  flex-row justify-content-between align-items-center flex-nowrap">
            <div class="detail-mobile-bar-info">
                <div class="detail-mobile-bar-info--title mx-0 my-0 h4" title="<?php echo trim($args['headline']); ?>"><?php echo trim($args['headline']); ?></div>

                <?php
                if ( !empty($args['destination_attributes']) || !empty($args['travel_type_attributes']) ) {
                    ?>
                    <div class="detail-mobile-bar-info--attributes">
                        <?php if ( !empty($args['travel_type_attributes']) ) { ?>
                            <a href="<?php echo $args['travel_type_attributes']->url; ?>" title="<?php echo $args['travel_type_attributes']->name; ?>" target="_blank">
                                <?php echo $args['travel_type_attributes']->name; ?>
                            </a>
                            <?php if ( !empty($args['destination_attributes']) ) { ?>
                                <span class="attribute-sep">&middot;</span>
                            <?php } ?>
                        <?php } ?>
                        <?php if ( !empty($args['destination_attributes']) ) { ?>
                            <a href="<?php echo $args['destination_attributes']->url; ?>" title="<?php echo $args['destination_attributes']->name; ?>" target="_blank">
                                <?php echo $args['destination_attributes']->name; ?>
                            </a>
                        <?php } ?>
                    </div>
                    <?php
                }
                ?>
            </div>

            <div class="detail-mobile-bar-booking">
                <button class="btn btn-link px-0 border-0 text-primary font-weight-bold" type="button">
                    Termine & Preise
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-right-bold"></use></svg>

                </button>
            </div>
        </div>

    </div>
</div>
