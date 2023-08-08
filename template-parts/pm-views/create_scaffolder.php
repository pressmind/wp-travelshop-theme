<?php
/**
 * This file builds scaffolder templates for the pressmind web-core sdk installer. it's for theme-development only
 */
$prefix = 'Reise';
$files = [];
$files[] = [$prefix.'_Detail2.php', 'scaffolder/Detail2.txt'];

foreach($files as $file){
    $c = file_get_contents($file[0]);
    $c = str_replace(['Custom\MediaType\Reise'], ['Custom\MediaType\###CLASSNAME###'], $c);
    file_put_contents($file[1], $c);
}
