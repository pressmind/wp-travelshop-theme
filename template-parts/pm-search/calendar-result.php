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

$view = 'Teaser1';
if(!empty($_GET['view']) && preg_match('/^[0-9A-Za-z\_]+$/', $_GET['view']) !== false){
    $view = $_GET['view'];
}
?>
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
<section class="content-block content-block-list-header">
    <div class="list-header-title h2 mt-0 mb-0 float-lg-left">
        <p>
            <strong>
                <?php
                echo $args['total_result'] . ' ' . (($args['total_result'] > 1 || $args['total_result'] == 0) ? 'Reisen' : 'Reise');
                ?>
            </strong> gefunden
        </p>
    </div>
    <div class="pm-switch-result-view">
        <label class="pm-switch">
            <input class="pm-switch-checkbox" type="checkbox" value="Teaser3" <?php echo $view == 'Teaser3' ? 'checked' : '';?>>
            <span class="pm-switch-slider">
                 <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-list" width="20"
                      height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                      stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <rect x="4" y="4" width="16" height="6" rx="2" />
                    <rect x="4" y="14" width="16" height="6" rx="2" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-grid" width="20"
                    height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <rect x="4" y="4" width="6" height="6" rx="1" />
                    <rect x="14" y="4" width="6" height="6" rx="1" />
                    <rect x="4" y="14" width="6" height="6" rx="1" />
                    <rect x="14" y="14" width="6" height="6" rx="1" />
                </svg>

            </span>
        </label>
    </div>
</section>
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
    <div id="pm-search-result" class="row">
        <?php
        foreach ($args['items'] as $item) {
            $item['class'] = 'col-12 col-md-6 col-lg-4';
            echo Template::render(__DIR__.'/../pm-views/'.$view.'.php', $item);
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
</section>
<?php
// Pagination
if ($args['pages'] > 1) {
    require 'result-pagination.php';
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