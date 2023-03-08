<?php
/**
 * @var $args mediaObject
 */
?>
<div class="detail-box detail-box-transparent detail-box-services">
    <div class="detail-box-title">
        <h2 class="h5 mb-0">Leistungen</h2>
    </div>
    <div class="detail-box-body">
        <?php echo checklist_formatter($args['services_included'], true); ?>
    </div>
</div>