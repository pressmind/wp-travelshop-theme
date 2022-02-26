<?php
/**
 * @TODO: use a fulltext search engine, like lucence
 * @TODO: add categories
 * Don't use WordPress functions in this template (for better performance it's called by ajax without the wp bootstrap)
 * this file is required in pm-ajax-endpoint.php
 */
$output = new stdClass();
$output->suggestions = [];
$id_object_types = empty($_GET['pm-ot']) ? false : BuildSearch::extractObjectType($_GET['pm-ot']);
if ($id_object_types !== false && preg_match('/^[a-zA-Z0-9äöüÄÖÜß\s]+$/', $_GET['pm-t']) !== false) {
    $conditions = [];
    $conditions[] = Pressmind\Search\Condition\Visibility::create(TS_VISIBILTY);
    $conditions[] = Pressmind\Search\Condition\ObjectType::create($id_object_types);
    $conditions[] = Pressmind\Search\Condition\Fulltext::create($_GET['pm-t'] . '*', ['fulltext'], 'AND', 'BOOLEAN MODE');
    $search = new Pressmind\Search($conditions, [
        'start' => 0,
        'length' => 10
    ], []);
    $mediaObjects = $search->getResults();
    $total_result = $search->getTotalResultCount();
    if ($total_result > 0) {
        $suggestion = new stdClass();
        $suggestion->value = 'Nach "' . $_GET['pm-t'] . '" suchen';
        $suggestion->data = new stdClass();
        $suggestion->data->q = $_GET['pm-t'];
        $suggestion->data->search_request = 'pm-t=' . $_GET['pm-t'];
        $suggestion->data->category = '';
        $suggestion->data->type = 'search';
        $output->suggestions[] = $suggestion;
        foreach ($mediaObjects as $mediaObject) {
            $suggestion = new stdClass();
            $suggestion->value = $mediaObject->name;
            $suggestion->data = new stdClass();
            $suggestion->data->q = $_GET['pm-t'];
            $suggestion->data->search_request = '';
            $suggestion->data->category = 'Reisen';
            $suggestion->data->type = 'link';
            $suggestion->data->url = SITE_URL . $mediaObject->getPrettyUrl(TS_LANGUAGE_CODE);
            $output->suggestions[] = $suggestion;
        }
    }
    // translate month names
    $months = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni',
        'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
    foreach ($months as $k => $month) {
        if (strpos(strtolower($month), strtolower($_GET['pm-t'])) === 0) {
            $suggestion = new stdClass();
            $suggestion->value = 'Reisen im ' . $month;
            $suggestion->data = new stdClass();
            $suggestion->data->q = $_GET['pm-t'];
            $date = new DateTime();
            $date->setDate($date->format('Y'), ($k + 1), 1);
            $suggestion->data->search_request = 'pm-dr=' . $date->format('Ymd') . '-' . $date->format('Ymt');
            $suggestion->data->category = 'Reisezeiten';
            $suggestion->data->type = 'search';
            $output->suggestions[] = $suggestion;
        }
    }
}
if (count($output->suggestions) == 0) {
    $suggestion = new stdClass();
    $suggestion->value = 'Keine Reisen gefunden';
    $suggestion->data = new stdClass();
    $suggestion->data->q = $_GET['pm-t']; // @TODO works?
    $suggestion->data->category = '';
    $suggestion->data->type = 'nothing_found';
    $output->suggestions[] = $suggestion;
}
echo json_encode($output);
