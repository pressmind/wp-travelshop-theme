<?php

namespace Custom;

use Pressmind\ORM\Object\MediaObject;
use Pressmind\ORM\Object\MediaObject\DataType\Picture;

class Filter
{

    /**
     * This filter is created to use in
     * mongodb search index creation context
     * @param $str
     * @return string
     */
    public static function strip($str)
    {
        return trim(strip_tags($str));
    }

    /**
     * This filter is created to use in
     * mongodb search index creation context
     * @param $array
     * @return array|null
     */
    public static function firstPicture($array, $derivate, $section = null)
    {
        if (!empty($array[0])) {
            $Picture = new Picture();
            $Picture->fromArray($array[0]);
            return [
                'url' => $Picture->getUri($derivate, false, $section),
                'size' => $Picture->getSizes($derivate, false),
                'copyright' => $Picture->copyright,
                'caption' => $Picture->caption
            ];
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
     * @param array $groups
     * @param MediaObject $mediaObject
     * @return mixed|null
     */
    public static function treeToGroup($groups, $mediaObject)
    {
        return $groups;
    }


}