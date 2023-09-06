<?php
/**
 * @var $args mediaObject
 */

use Pressmind\Travelshop\Template;

if(empty($args['services_included'])){
    return;
}
?>
<div class="detail-box detail-box-transparent detail-box-services">
    <div class="detail-box-title">
        <h2 class="h5 mb-0">Leistungen</h2>
    </div>
    <div class="detail-box-body">
        <?php
        echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/checked-list.php',
            [
                'value' => $args['services_included'],
                'responsive' => true,
            ]);

        ?>
    </div>
</div>