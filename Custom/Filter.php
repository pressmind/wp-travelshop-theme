<?php

namespace Custom;

use Pressmind\ORM\Object\Itinerary\Step\Port;
use Pressmind\ORM\Object\MediaObject;
use Pressmind\ORM\Object\MediaObject\DataType\Picture;

class Filter
{

    /**
     * @var MediaObject
     */
    public $mediaObject = null;

    /**
     * This filter is created to use in
     * mongodb search index creation context
     * @param $str
     * @return string
     */
    public static function strip($str)
    {
        return trim(strip_tags((string)$str));
    }

    /**
     * This filter is created to use in
     * mongodb search index creation context
     * @param $array
     * @return array|null
     */
    public static function firstPicture($array, $derivative, $section = null)
    {
        if(empty($array)){
            return null;
        }
        foreach($array as $fst_valid_picture){
            if(!$fst_valid_picture->disabled){
                $Picture = new Picture();
                $Picture->fromArray($fst_valid_picture);
                return [
                    'url' => $Picture->getUri($derivative, false, $section),
                    'size' => $Picture->getSizes($derivative, false),
                    'copyright' => $Picture->copyright,
                    'caption' => $Picture->caption
                ];
            }
        }
        return null;
    }

    /**
     * This filter is created to use in
     * mongodb search index creation context
     * @param $array
     * @return mixed|null
     */
    public static function lastTreeItemAsString($array)
    {
        if (!empty($array) && !empty($array[array_key_last($array)]->item->name)) {
            return $array[array_key_last($array)]->item->name;
        }
        return null;
    }

    /**
     * This filter is created to use in
     * mongodb search index creation context
     * @param $array
     * @return mixed|null
     */
    public static function firstTreeItemAsString($array)
    {
        if (!empty($array) && !empty($array[array_key_first($array)]->item->name)) {
            return $array[array_key_first($array)]->item->name;
        }
        return null;
    }


    /**
     * This filter is created to use in
     * mongodb search index creation context
     * @param array $groups
     * @param MediaObject $mediaObject
     * @return mixed|null
     */
    public static function treeToGroup($groups, $mediaObject)
    {
        return $groups;
    }

    /**
     * Puts all itinerary ports into one string
     * @param $value
     * @param $separator
     * @return string
     * @throws \Exception
     */
    public function getPortsFromItinerary($value, $separator = ', ')
    {
        $v = [];
        foreach( $this->mediaObject->getItinerarySteps() as $step){
           foreach($step->ports as $port){
               $Port = new \Pressmind\ORM\Object\Port($port->id_port);
               $v[] = $Port->name;
            }
        }
        return implode($separator, $v);
    }



}