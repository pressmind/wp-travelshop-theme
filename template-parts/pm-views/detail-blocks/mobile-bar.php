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
                <button class="btn btn-link px-0 border-0" type="button">
                    Termine & Preise
                </button>
            </div>
        </div>

    </div>
</div>
