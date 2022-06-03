<?php
/**
 * <code>
 * $args = ['total_result' => 100,
 *            'current_page' => 1,
 *            'pages' => 10,
 *            'page_size' => 10,
 *            'cache' => [
 *              'is_cached' => false,
 *              'info' => []
 *            ],
 *            'items' => [],
 *            'mongodb' => [
 *              'aggregation_pipeline' => ''
 *            ]
 *           ];
 * </code>
 * @var array $args
 */
?>
<section class="content-block content-block-pagination">
    <div class="row">
        <div class="col-12">
            <nav aria-label="">
                <ul class="ajax-enabled-pagination pagination">

                    <li class="page-item<?php echo ($args['current_page'] == 1) ? ' disabled' : ''; ?>">
                        <a class="page-link"
                           href="?action=search&<?php echo BuildSearch::getCurrentQueryString($args['current_page'] - 1, $args['page_size']); ?><?php echo isset($args['uid']) ? '#' . $args['uid'] : '';?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left"
                                 width="16" height="16" viewBox="0 2 24 24" stroke-width="2" stroke="#607D8B"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <polyline points="15 6 9 12 15 18"/>
                            </svg>
                        </a>
                    </li>
                    <?php
                    // prevent result from overloading
                    if ($args['current_page'] > $args['pages']) {
                        $args['current_page'] = $args['pages'];
                    }
                    // show max five numerated pagination buttons
                    $from = 1;
                    $to = $args['pages'];
                    if ($args['pages'] > 5) {
                        $to = ceil($args['current_page'] / 5) * 5;
                        $to = $to > $args['pages'] ? $args['pages'] : $to;
                        $from = $to - 5 + 1;
                    }
                    for ($page = $from; $page <= $to; $page++) {
                        ?>
                        <li class="page-item<?php echo ($args['current_page'] == $page) ? ' active' : ''; ?>"><a
                                    class="page-link"
                                    href="?action=search&<?php echo BuildSearch::getCurrentQueryString($page, $args['page_size']); ?><?php echo isset($args['uid']) ? '#' . $args['uid'] : '';?>"><?php echo $page; ?></a>
                        </li>
                    <?php } ?>
                    <li class="page-item<?php echo ($args['current_page'] == $args['pages']) ? ' disabled' : ''; ?>"><a
                                class="page-link"
                                href="<?php echo ($args['current_page'] >= $args['pages']) ? '#' : '?action=search&' . BuildSearch::getCurrentQueryString($args['current_page'] + 1, $args['page_size']); ?><?php echo isset($args['uid']) ? '#' .  $args['uid'] : '';?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right"
                                 width="16" height="16" viewBox="0 2 24 24" stroke-width="2" stroke="#607D8B"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <polyline points="9 6 15 12 9 18"/>
                            </svg>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</section>