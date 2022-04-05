<?php
namespace Pressmind\Travelshop;

class RouteHelper{

    /**
     * @TODO this needs a rework, check all usages
     * @param $id_object_type
     * @return string | false
     */
    public static function get_url_by_object_type($id_object_type, $language = 'default'){
        if(false === $route = self::get_route_by_object_type($id_object_type, $language)){
            return false;
        }
        return $route['route'];
    }

    public static function get_route_by_object_type($id_object_type, $language = 'default'){
        if(!is_array($id_object_type)){
            $id_object_type = [$id_object_type];
        }
        asort($id_object_type);
        $hash = implode('-', $id_object_type);
        foreach(TS_SEARCH_ROUTES as $k => $v){
            $ot = !is_array($v['pm-ot']) ? explode(',', $v['pm-ot']) : $v['pm-ot'];
            asort($ot);
            if($hash == implode('-', $ot)){
                return isset($v['languages'][$language]) ? $v['languages'][$language] : false;
            }
        }
        return false;
    }
}