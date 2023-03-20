<?php

namespace Pressmind\Travelshop;

class Template
{
    /**
     * @param string $file
     * @param array $args
     */
    public static function render($file, $args){
        ob_start();
        require $file;
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    /**
     * Cut a string after a defined length and a defined word
     * @param $str
     * @param $length
     * @param string $suffix
     * @return string
     */
    public static function cutTextAfter($str, $length, $suffix = '...'){
        $str = trim(strip_tags((string)$str));
        if(strlen($str) > $length){
            $suffix = '...';
        }
        $r = explode('||', wordwrap($str,$length, '||'));
        return $r[0].$suffix;
    }

    /**
     * @param string $url e.g. https://www.foo.de/?a=1&b=2&c=3
     * @param array $modified_parameters e.g. ['c' => 7]
     * @return string
     */
    public static function modifyUrl($url, $modified_parameters = [], $reset_parameters = false){
        $queryParams = [];
        $r = parse_url($url);
        if(!empty($r['query']) && !$reset_parameters){
            parse_str($r['query'], $queryParams);
        }
        $r['query'] = http_build_query(array_filter(array_merge($queryParams, $modified_parameters)));
        return (!empty($r['scheme']) ? $r['scheme'].'://' : '').(!empty($r['host']) ? $r['host'] :'').(!empty($r['path']) ? $r['path'] : '').(!empty($r['query']) ? '?'.$r['query'] : '');

    }

}