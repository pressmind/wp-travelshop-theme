<?php
/**
 * @var $args | mediaobject data
 */

if(empty($args['cheapest_price']) || !empty($args['booking_on_request'])){
    return;
}
?>

<div class="detail-header-info-bottom">
    <?php // Random Availability
    $randint = random_int(1, 9);
    ?>
    <div class="detail-header-info-cta">
        <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/booking-button.php', [
            'cheapest_price' => $args['cheapest_price'],
            'url' => $args['url'],
            'modal_id' => $args['id_modal_price_box'],
            'disable_id' => true
        ]);?>
    </div>
    <div class="detail-header-info-status">
        <?php if($randint < 10) { ?>
            <!-- Toggle in badge the class "active" to toggle status with animation -->
            <div class="status active <?php echo $randint <= 3 ? 'alert' : ''; ?>">Nur noch <?php echo $randint < 10 ? $randint == 1 ? '1 Platz' : $randint . ' Plätze ' : ''; ?> frei</div>
        <?php } ?>
    </div>
</div>