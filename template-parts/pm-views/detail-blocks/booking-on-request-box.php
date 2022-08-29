<?php
use Pressmind\HelperFunctions;
use Pressmind\Search\CheapestPrice;
use Pressmind\Travelshop\IB3Tools;
use Pressmind\Travelshop\Template;
use Pressmind\Travelshop\PriceHandler;


/**
 * @var array $args
 */

if($args['booking_on_request'] === false){
    return;
}
?>
<div class="row">
    <div class="col">
        <div class="booking-request">
            <div class="alert alert-danger">
                Diese Reise ist zur Zeit nicht online buchbar.
            </div>
            <p>Bitte senden Sie uns stattdessen eine <a href="#">Anfrage</a> oder nutzen Sie unseren telefonischen Kundenservice: <a href="tel://<?php echo do_shortcode('[ts-company-hotline]');?>"><?php echo do_shortcode('[ts-company-hotline]');?></a></p>
            <button class="btn btn-primary">Anfrage</button>
        </div>
    </div>
</div>