<?php
/*
 This is delivered if the user is offline (see assets/js/service-worker.js)
 */
if (!defined('ABSPATH')) {
    @ini_set('include_path', '../../../');
    require_once('../../../wp-load.php');
}
?>
<html>
<head>
    <title><?php echo get_bloginfo('name'); ?></title>
    <style>
        * {
            font-family: Arial, Helvetica;
        }
    </style>
</head>
<body>
    <div style="width: 400px;margin:0px auto">
        <div style="width: 250px;margin:0px auto">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                 x="0px" y="0px"
                 viewBox="0 0 489.6 489.6" style="enable-background:new 0 0 489.6 489.6;" xml:space="preserve">
                    <g>
                        <path d="M179.6,235.6c-33.7,10.3-65.5,28.5-92.2,55.1l46.6,46.6c13.9-13.9,30.1-24.8,47.6-32.5L179.6,235.6z"/>
                        <path d="M175.8,109C111.3,122,49.9,153.4,0,203.3l46.6,46.6c37.5-37.5,83.1-61.9,131.2-73.7L175.8,109z"/>
                        <path d="M313.8,109l-2,67.3c48.1,11.8,93.7,36.2,131.2,73.7l46.6-46.6C439.8,153.4,378.3,122,313.8,109z"/>
                        <path d="M307.9,304.8c17.5,7.7,33.7,18.6,47.7,32.6l46.6-46.6c-26.6-26.6-58.5-44.9-92.2-55.2L307.9,304.8z"/>
                    </g>
                <circle cx="244.8" cy="403.2" r="40"/>
                <g>
                    <path d="M260.6,330.4h-31.7c-8.3,0-15.1-6.6-15.3-14.9L206,62.2c-0.3-8.6,6.7-15.8,15.3-15.8h47c8.6,0,15.6,7.1,15.3,15.8
                            l-7.7,253.3C275.7,323.8,268.9,330.4,260.6,330.4z"/>
                </g>
            </svg>
        </div>
        <h1>Offline. Keine Internetverbindung vorhanden.</h1>
        <h2>Überprüfe deine Verbindung.</h2>
        <a href="/">Aktualisieren</a>
    </div>
</body>
</html>