<?php
use Pressmind\Travelshop\Template;
/**
 * Don't use WordPress functions in this template (for better performance it's called by ajax without the wp bootstrap)
 *
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

$args['view'] = 'Teaser1';
if(!empty($_GET['view']) && preg_match('/^[0-9A-Za-z\_]+$/', $_GET['view']) !== false){
    $args['view'] = $_GET['view'];
}
?>
<?php if ( $view !== 'Calendar1' ) { ?>
    <div class="list-filter-toggle mb-4">
        <button class="btn btn-block btn-secondary list-filter-open">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-adjustments-alt" width="30"
                height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <rect x="4" y="8" width="4" height="4" />
                <line x1="6" y1="4" x2="6" y2="8" />
                <line x1="6" y1="12" x2="6" y2="20" />
                <rect x="10" y="14" width="4" height="4" />
                <line x1="12" y1="4" x2="12" y2="14" />
                <line x1="12" y1="18" x2="12" y2="20" />
                <rect x="16" y="5" width="4" height="4" />
                <line x1="18" y1="4" x2="18" y2="5" />
                <line x1="18" y1="9" x2="18" y2="20" />
            </svg>
            <span>Reisen filtern</span>
        </button>
    </div>
<?php } ?>
<?php if(!isset($args['calendarpage'])) { ?>
<section class="content-block content-block-list-header">
    <div class="list-header-title h2 mt-0 mb-0 float-lg-left">

            <strong>
                <?php
                echo $args['total_result'] . ' ' . (($args['total_result'] > 1 || $args['total_result'] == 0) ? 'Reisen' : 'Reise');
                ?>
            </strong> gefunden

    </div>
    <div class="pm-switch-result-view">
        <label class="pm-switch">
            <input class="pm-switch-checkbox" type="checkbox" value="Teaser3" <?php echo $args['view'] == 'Teaser3' ? 'checked' : '';?>>
            <span class="pm-switch-slider">
               <svg class="layout-list"><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#rows"></use></svg>
                <svg class="layout-grid"><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#squares-four"></use></svg>
            </span>
        </label>
    </div>
</section>
<?php } ?>
<section class="content-block content-block-travel-cols">
    <div class="spinner">
        <div class="sk-folding-cube">
            <div class="sk-cube1 sk-cube"></div>
            <div class="sk-cube2 sk-cube"></div>
            <div class="sk-cube4 sk-cube"></div>
            <div class="sk-cube3 sk-cube"></div>
        </div>
        <div class="msg" data-text="Suche Angebote...">Suche Angebote...</div>
        <img class="brand" src="<?php echo SITE_URL;?>/wp-content/themes/travelshop/assets/img/travelshop-logo.svg">
    </div>
    <?php if($args['view'] == 'Calendar1') { ?>
        <div class="product-calendar-wrap">
            <div class="product-calendar-group">
                <div class="product-calendar-group-items">
                    <?php
                        $currentMonth = 0;
                        foreach ($args['items'] as $item) {
                            // var_dump($item['cheapest_price']->date_departures[0]); 
                            if($currentMonth != $item['cheapest_price']->date_departures[0]->format('m')) { ?>
                            <div class="product-calendar-group-title">
                                <h3><?php
                                    echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/month-name.php', [
                                        'date' => $item['cheapest_price']->date_departures[0]]);
                                    ?>
                                </h3>
                            </div>
                            <div class="product-calendar-items-title  d-none d-lg-block">
                                <div class="row">
                                    <div class="col-3">Reisezeitraum</div>
                                    <div class="col-4">Reise</div>
                                    <div class="col-2">Dauer</div>
                                    <div class="col-3 text-right">Preis</div>
                                </div>
                            </div>
                            <?php }
                            $currentMonth = $item['cheapest_price']->date_departures[0]->format('m');
                            $item['class'] = 'col-12 col-md-6 col-lg-4';
                            echo Template::render(__DIR__.'/../pm-views/'.$args['view'].'.php', $item);
                        }
                        ?>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div id="pm-search-result" class="row row-products">
            <?php
            foreach ($args['items'] as $item) {
                $item['class'] = 'col-12 col-md-6 col-lg-4';
                echo Template::render(__DIR__.'/../pm-views/'.$args['view'].'.php', $item);
            }
            if($args['total_result'] == 0){
                ?>
            <div class="col-12">
                <p>Zu Ihrer Suchanfrage wurden keine Ergebnisse gefunden. Bitte ändern Sie Ihre Suchanfrage.</p>
                <a href="#" onclick="document.location.href = window.location.href.split('?')[0]">Suche zurücksetzen</a>
            </div>
            <?php
            }
            ?>
        </div>
    <?php } ?>
</section>
<?php
// Pagination
if ($args['pages'] > 1) {
    echo Template::render(__DIR__.'/result-pagination.php', $args);
}

/**
 * if the search is cached, we display a short information about the content age
 */
if($args['cache']['is_cached']){
    $cachetime = new DateTime($args['cache']['info']);
    $cachetime->setTimezone(new DateTimeZone('Europe/Berlin'));
    echo '<section><div class="small mb-2">Stand: '.$cachetime->format('d.m.Y H:i:s').'</div></section>';
}
if(!empty($_GET['debug'])) {
    echo '<pre>';
    echo "Filter:\n";
    echo "Duration:".$args['mongodb']['duration_filter_ms']."\n";
    echo $args['mongodb']['aggregation_pipeline_filter'];
    echo "\n";
    echo "Search:\n";
    echo "Duration:".$args['mongodb']['duration_search_ms']."\n";
    echo $args['mongodb']['aggregation_pipeline_search'];
    echo '</pre>';
}