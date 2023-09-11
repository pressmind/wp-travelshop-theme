<?php
use Pressmind\HelperFunctions;
use Pressmind\Search\CheapestPrice;
use Pressmind\Travelshop\IB3Tools;
use Pressmind\Travelshop\Template;
use Pressmind\Travelshop\PriceHandler;


/**
 * @var array $args
 */

if(!empty($args['cheapest_price']) && empty($args['booking_on_request'])){
    return;
}
?>
<div class="detail-header-info-request">


            <div class="alert alert-danger">
                Diese Reise ist zur Zeit nicht online buchbar.
            </div>
            <p>Bitte senden Sie uns stattdessen eine <a href="#">Anfrage</a> oder nutzen Sie unseren telefonischen Kundenservice: <a href="tel://<?php echo do_shortcode('[ts-company-hotline]');?>"><?php echo do_shortcode('[ts-company-hotline]');?></a></p>

    <button class="btn btn-lg btn-block btn-primary">
        zur Anfrage

        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-right-bold"></use></svg>
    </button>

</div>