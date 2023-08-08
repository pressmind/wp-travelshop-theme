<?php

namespace Pressmind\Travelshop;

use Pressmind\ORM\Object\CheapestPriceSpeed;

final class PriceHandler
{

    /**
     * Normalizes different offer types
     * @param CheapestPriceSpeed $cheapest_price
     * @return false|array{price_total: string ,price_before_discount: string, price_delta: string, valid_to: \DateTime, type: string}
     */
    public static function getDiscount($cheapest_price, $earlybird_name = 'Frühbucher', $pseudo_price_name = 'Ihr Vorteil'){

        $output = [];

        // detect valid earlybird discount
        if(!empty($cheapest_price->earlybird_discount)){
            // is earlybird
            $output['price_before_discount'] = self::format($cheapest_price->price_regular_before_discount);
            $output['price_delta'] = '-'.$cheapest_price->earlybird_discount.'%';
            $output['valid_to'] = $cheapest_price->earlybird_discount_date_to;
            $output['name'] = empty($cheapest_price->earlybird_name) ? $earlybird_name : $cheapest_price->earlybird_name;
            $output['type'] = 'earlybird';
            return $output;
        }

        if(!empty($cheapest_price->earlybird_discount_f)){
            // is earlybird with a fixed price
            $output['price_before_discount'] = self::format($cheapest_price->price_regular_before_discount);
            $output['price_delta'] = '-'.self::format($cheapest_price->earlybird_discount_f);
            $output['valid_to'] = $cheapest_price->earlybird_discount_date_to;
            $output['name'] = empty($cheapest_price->earlybird_name) ? $earlybird_name : $cheapest_price->earlybird_name;
            $output['type'] = 'earlybird';
            return $output;
        }


        if (!empty($cheapest_price->price_option_pseudo) &&
            $cheapest_price->price_option_pseudo > $cheapest_price->price_total) {

            // is a pseudo price offer
            $percent_discount = round((100 / $cheapest_price->price_option_pseudo) * ($cheapest_price->price_option_pseudo - $cheapest_price->price_total));
            $output['price_before_discount'] = self::format($cheapest_price->price_option_pseudo);
            $output['price_delta'] = '-'.$percent_discount.'%';
            $output['valid_to'] = null;
            $output['name'] = $pseudo_price_name;
            $output['type'] = 'pseudo';
            return $output;
        }


        return false;

    }

    /**
     * @param float $price
     * @return string
     */
    public static function format($price){

        $price = number_format($price, TS_PRICE_DECIMALS, TS_PRICE_DECIMAL_SEPARATOR, TS_PRICE_THOUSANDS_SEPARATOR);

        if(TS_PRICE_CURRENCY_POSITION == 'LEFT'){
            return TS_PRICE_CURRENCY.'&nbsp;'.$price;
        }

        return $price.'&nbsp;'.TS_PRICE_CURRENCY;
    }


    /**
     * Returns a compressed information string about the maximum discount
     * Example return value: "Kinderrabatt: 0‑2 Jahre: bis zu 100%; 2‑13 Jahre: bis zu 8%"
     *
     * @TODO
     * - this example can not handle fixed vs. percent discounts at this moment
     *  (can not find out the bigger discount if the scale table has both
     *  - for use in production check thi customer data-enviroment
     *
     * @param \Pressmind\ORM\Object\Touristic\Option\Discount\Scale[] $OptionDiscountScales
     * @return string
     */
    public static function getCheapestOptionDiscount($OptionDiscountScales){


            $today = new \DateTime();

            $group = [];
            foreach($OptionDiscountScales as $Scale){

                // is valid
                if($today < $Scale->valid_from || $today > $Scale->valid_to){
                    continue;
                }

                if(empty($group[$Scale->age_from.'-'.$Scale->age_to])){ // if is not set
                    $group[$Scale->age_from.'-'.$Scale->age_to] = $Scale;
                }elseif($group[$Scale->age_from.'-'.$Scale->age_to]->value < $Scale->value){ // if is bigger discount
                    $group[$Scale->age_from.'-'.$Scale->age_to] = $Scale;
                }

            }

            ksort($group);

        $age_group = [];
        foreach($group as $Scale){

            $str = $Scale->age_from.'&#8209;'.$Scale->age_to. '&nbsp;Jahre: bis zu ';

            if($Scale->type == 'P'){
                $str .= str_replace('.', ',', $Scale->value).'%';
            }elseif($Scale->type  == 'F'){
                $str .= self::format($Scale->value);
            }else{ // not known, continue
                continue;
            }

            if($Scale->age_to <= 17){
                $age_group['childs'][] = $str;
            }else{
                $age_group['others'][] = $str;
            }

        }

        $output = '';
        if(!empty($age_group['childs'])){
            $output .= 'Kinderrabatt: '.implode('; ',$age_group['childs']);
        }

        if(!empty($age_group['others'])){
            $output .= 'Weitere altersbezogene Rabatte: '.implode('; ',$age_group['others']);
        }

        return $output;

    }

}