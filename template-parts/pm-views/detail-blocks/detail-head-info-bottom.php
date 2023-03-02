<?php
/**
 * @var $args | mediaobject data
 */

if(empty($args['cheapest_price']) || !empty($args['booking_on_request'])){
    return;
}
?>

<div class="detail-header-info-bottom">
    <div class="detail-header-info-cta">
        <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/booking-button.php', [
            'cheapest_price' => $args['cheapest_price'],
            'url' => $args['url'],
            'modal_id' => $args['id_modal_price_box'],
            'disable_id' => true
        ]);?>
    </div>
</div>