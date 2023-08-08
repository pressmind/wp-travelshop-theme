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
 *            ],
 *            'view' => 'Teaser1'
 *           ];
 * </code>
 * @var array $args
 */
?>
<section class="content-block content-block-pagination">
    <div class="row">
        <div class="col-12">
            <nav aria-label="">
                <ul class="ajax-enabled-pagination pagination justify-content-center">

                    <li class="page-item<?php echo ($args['current_page'] == 1) ? ' disabled' : ''; ?>">
                        <a class="page-link page-link-chevron"
                           href="?action=search&<?php echo BuildSearch::getCurrentQueryString($args['current_page'] - 1, $args['page_size'], ['view' => $args['view']); ?><?php echo isset($args['uid']) ? '#' . $args['uid'] : '';?>">
                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-left-bold"></use></svg>

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
                                    href="?action=search&<?php echo BuildSearch::getCurrentQueryString($page, $args['page_size'], ['view' => $args['view']]); ?><?php echo isset($args['uid']) ? '#' . $args['uid'] : '';?>"><?php echo $page; ?></a>
                        </li>
                    <?php } ?>
                    <?php if($args['pages'] != $to) { ?>
                        <li class="page-item disabled">
                            <a class="page-link page-link-dots">...</a>
                        </li>
                    <?php } ?>
                    <li class="page-item<?php echo ($args['current_page'] == $args['pages']) ? ' disabled' : ''; ?>"><a
                                class="page-link page-link-chevron"
                                href="<?php echo ($args['current_page'] >= $args['pages']) ? '#' : '?action=search&' . BuildSearch::getCurrentQueryString($args['current_page'] + 1, $args['page_size'], ['view' => $args['view']); ?><?php echo isset($args['uid']) ? '#' .  $args['uid'] : '';?>">
                            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-right-bold"></use></svg>

                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</section>