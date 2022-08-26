<?php
/**
 * @var array $args
 */
echo '<pre>score: ' . $args['meta']['score'] . '</pre>';
foreach ($args['meta']['findings'] as $k => $v) {
    echo '<span data-score="' . $v['score'] . '">' . $v['value'];
    echo $k + 1 < count($args['meta']['findings']) ? ' ... ' : '';
    echo '</span>';
}

