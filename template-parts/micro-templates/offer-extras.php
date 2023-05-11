<?php

use Pressmind\Travelshop\PriceHandler;
use Pressmind\Travelshop\Template;

/**
 * <code>
 * $args['cheapest_price'] CheapestPriceSpeed
 * $args['available_options']
 * </code>
 * @var array $args
 */

if (empty($args['cheapest_price']->id_included_options)) {
    return;
}

$included_options = explode(',', $args['cheapest_price']->id_included_options);
$required_groups = [];
$IncludedOptions = [];
foreach ($included_options as $included_option) {
    /**
     * @var \Pressmind\ORM\Object\Touristic\Option $Option
     */
    foreach ($args['available_options'] as $Option) {
        if ($included_option === $Option->id) {
            $IncludedOptions[] = $Option;
        }
    }
}


/**
 * @var \Pressmind\ORM\Object\Touristic\Option $Option
 */

$lines = [];
foreach ($args['available_options'] as $Option) {
    if (in_array($Option->id, $included_options)) {
        continue;
    }
    foreach ($IncludedOptions as $includedOption) {
        if ($includedOption->required === true && $Option->required === true && $includedOption->required_group === $Option->required_group) {
            $price_value = $Option->price - $includedOption->price;
            if($price_value == 0){
                $lines[] = $Option->name . '  <br>';
            }else{
                $lines[] = $Option->name . (($price_value > 0) ? 'zzgl. ' : 'abzgl. ') . PriceHandler::format($price_value). '<br>';
            }

        }
    }
}

if (!empty($lines)) {
    ?>
        <div>
            Alternativ buchbar:
        <ul>
            <?php
            foreach ($lines as $line) {
                echo '<li>' . $line . '</li>';
            }
            ?>
        </ul>
        </div>
    <?php
}