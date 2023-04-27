<?php
if(!function_exists('time2str')) {
    function time2str($ts)
    {
        if(!ctype_digit($ts))
            $ts = date($ts);
        $diff = time() - $ts;
        if($diff <= 3)
            return 'Jetzt';
        elseif($diff > 0)
        {
            $day_diff = floor($diff / 86400);
            if($day_diff == 0)
            {
                if($diff < 60) return 'gerade eben';
                if($diff < 120) return 'vor 1 Minute';
                if($diff < 3600) return 'vor ' . floor($diff / 60) . ' Minuten';
                if($diff < 7200) return 'vor 1 Stunde';
                if($diff < 86400) return 'vor ' . floor($diff / 3600) . ' Stunden';
            }
            if($day_diff == 1) return 'Gestern';
            if($day_diff < 7) return 'vor ' . $day_diff . ' Tagen';
            if($day_diff < 31) return 'vor ' . ceil($day_diff / 7) . ' Wochen';
            if($day_diff < 60) return 'letzten Monat';
            return date('d.m.Y, H:i:s', $ts);
        }
        else
        {
            $diff = abs($diff);
            $day_diff = floor($diff / 86400);
            if($day_diff == 0)
            {
                if($diff < 120) return 'in a minute';
                if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
                if($diff < 7200) return 'in an hour';
                if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';
            }
            if($day_diff == 1) return 'Tomorrow';
            if($day_diff < 4) return date('l', $ts);
            if($day_diff < 7 + (7 - date('w'))) return 'next week';
            if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
            if(date('n', $ts) == date('n') + 1) return 'next month';
            return date('F Y', $ts);
        }
    }
}
echo isset($args['timeStamp']) ? time2str($args['timeStamp']) : '-';