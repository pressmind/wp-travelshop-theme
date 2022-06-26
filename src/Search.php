<?php

namespace Pressmind\Travelshop;

class Search
{

    private static $_run_time_cache_full = [];
    private static $_run_time_cache_filter = [];
    private static $_run_time_cache_search = [];

    /**
     * @param array $request
     * @param int $occupancy
     * @param int $page_size
     * @param false $getFilters
     * @param false $returnFiltersOnly
     * @param null $ttl_filter
     * @param null $ttl_search
     * @param null $output
     * @param \DateTime|null $preview_date
     * @param array $custom_conditions
     * <code>
     * return ['total_result' => 100,
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
     * @return array
     * @throws \Exception
     */
    public static function getResult($request, $occupancy = 2, $page_size = 12, $getFilters = false, $returnFiltersOnly = false, $ttl_filter = null, $ttl_search = null, $output = null, $preview_date = null, $custom_conditions = [])
    {
        $cache_key = md5(serialize(func_get_args()));
        if(isset(self::$_run_time_cache_full[$cache_key])){
            return self::$_run_time_cache_full[$cache_key];
        }
        $duration_filter_ms = null;
        $duration_search_ms = null;
        if (empty($request['pm-ho']) === true) {
            // if the price duration slider is active, we have to set the housing occupancy search
            // (to display the correct search result with the correct cheapest price inside)
            $request['pm-ho'] = $occupancy;
        }
        $id_object_type = empty($request['pm-ot']) ? false : \BuildSearch::extractObjectType($request['pm-ot']);
        if($getFilters){
            $FilterCondition = [];
            if(!empty($request['pm-ot'])){
                if(!$id_object_type) {
                    $FilterCondition[] = new \Pressmind\Search\Condition\MongoDB\ObjectType($id_object_type);
                }
            }
            if(defined('TS_SEARCH_GROUP_KEYS') && !empty(TS_SEARCH_GROUP_KEYS)){
                $FilterCondition[] = new \Pressmind\Search\Condition\MongoDB\Group(TS_SEARCH_GROUP_KEYS);
            }
            $FilterCondition[] = new \Pressmind\Search\Condition\MongoDB\Occupancy($occupancy);
            $FilterCondition = array_merge($FilterCondition, $custom_conditions);
            $filter = new \Pressmind\Search\MongoDB($FilterCondition, ['price_total' => 'asc'], TS_LANGUAGE_CODE);
            $start_time = microtime(true);
            if(isset(self::$_run_time_cache_filter[$cache_key])){
                $result_filter = self::$_run_time_cache_filter[$cache_key];
            }else{
                $result_filter = $filter->getResult(true, true, $ttl_filter);
                self::$_run_time_cache_filter[$cache_key] = $result_filter;
            }
            $end_time = microtime(true);
            $duration_filter_ms = ($end_time - $start_time)  * 1000;
        }
        $items = [];
        if(!$returnFiltersOnly) {
            if(isset(self::$_run_time_cache_search[$cache_key])){
                $search = self::$_run_time_cache_search[$cache_key];
            }else {
                $search = \BuildSearch::fromRequestMongoDB($request, 'pm', true, $page_size, $custom_conditions);
                self::$_run_time_cache_search[$cache_key] = $search;
            }
            $start_time = microtime(true);
            $result = $search->getResult(true, false, $ttl_search, $output);
            $end_time = microtime(true);
            $duration_search_ms = ($end_time - $start_time) * 1000;
            foreach ($result->documents as $document) {
                $document = json_decode(json_encode($document), true);
                $item = (array)$document['description'];
                $item['id_media_object'] = $document['id_media_object'];
                $item['id_object_type'] = $document['id_object_type'];
                $item['url'] = $document['url'];
                $item['dates_per_month'] = [];
                if (!empty($document['dates_per_month'])) {
                    $item['dates_per_month'] = $document['dates_per_month'];
                    foreach ($document['dates_per_month'] as $k => $month) {
                        foreach ($month['five_dates_in_month'] as $k1 => $date) {
                            $item['dates_per_month'][$k]['five_dates_in_month'][$k1]['date_departure'] = new \DateTime($date['date_departure']);
                            $item['dates_per_month'][$k]['five_dates_in_month'][$k1]['date_arrival'] = new \DateTime($date['date_arrival']);
                        }
                    }
                }
                $item['possible_durations'] = !empty($document['possible_durations']) ? $document['possible_durations'] : [];
                $item['last_modified_date'] = $document['last_modified_date'];
                if (!empty($document['prices'])) {
                    if(!is_array($document['prices']['date_departures'])){
                        $document['prices']['date_departures'] = [$document['prices']['date_departures']];
                    }
                    $item['cheapest_price'] = new \stdClass();
                    $item['cheapest_price']->duration = $document['prices']['duration'];
                    $item['cheapest_price']->price_total = $document['prices']['price_total'];
                    $item['cheapest_price']->price_regular_before_discount = $document['prices']['price_regular_before_discount'];
                    $item['cheapest_price']->earlybird_discount = $document['prices']['earlybird_discount'];
                    $item['cheapest_price']->earlybird_discount_f = $document['prices']['earlybird_discount_f'];
                    $item['cheapest_price']->date_departures = [];
                    if (!empty($document['prices']['date_departures'])) {
                        foreach ($document['prices']['date_departures'] as $date_departure) {
                            $item['cheapest_price']->date_departures[] = new \DateTime($date_departure);
                        }
                    }
                    $item['cheapest_price']->earlybird_discount_date_to = new \DateTime($document['prices']['earlybird_discount_date_to']);
                    $item['cheapest_price']->option_board_type = $document['prices']['option_board_type'];
                } else {
                    $item['cheapest_price'] = null;
                    $document['prices'] = null;
                }
                $item['departure_date_count'] = $document['departure_date_count'];
                $item['possible_durations'] = !empty($document['possible_durations']) ? $document['possible_durations'] : [];
                //$item['best_price_meta'] = $document['best_price_meta'];
                $item['meta']['findings'] = [];
                if(!empty($document['highlights']) && is_array($document['highlights'])){
                    foreach($document['highlights'] as $finding){
                        $finding_str = '';
                        foreach($finding['texts'] as $str){
                            if($str['type'] == 'hit'){
                                $finding_str .= '<b>'.$str['value'].'</b>';
                            }else{
                                $finding_str .= $str['value'];
                            }
                        }
                        $item['meta']['findings'][] = ['score' => $finding['score'], 'value' => $finding_str];
                    }
                }
                $item['meta']['score'] = !empty($document['score']) ? $document['score'] : null;
                $items[] = $item;
            }
        }
        $categories = [];
        if(!empty($result_filter->categoriesGrouped)){
            $matching_categories_map = [];
            if(!$returnFiltersOnly){
                $matching_categories = json_decode(json_encode($result->categoriesGrouped));
                foreach($matching_categories as $item){
                    $matching_categories_map[$item->_id->field_name][$item->_id->id_item] = $item;
                }
            }
            foreach(json_decode(json_encode($result_filter->categoriesGrouped)) as $item){
                $item->_id->count_in_system = $item->count;
                $item->_id->count_in_search = 0;
                if(isset($matching_categories_map[$item->_id->field_name][$item->_id->id_item])){
                    $item->_id->count_in_search = $matching_categories_map[$item->_id->field_name][$item->_id->id_item]->count;
                }
                $categories[$item->_id->field_name][$item->_id->level][$item->_id->id_item] = $item->_id;
            }
        }
        if(TS_CALENDAR_SHOW_DEPARTURES === true && empty($result_filter) === false){
            $start_time = microtime(true);
            $filter_departures = [];
            foreach ($result_filter->documents as $document) {
                $document = json_decode(json_encode($document), true);
                if (!empty($document['prices']['date_departures'])) {
                    if(!is_array($document['prices']['date_departures'])){
                        $document['prices']['date_departures'] = [$document['prices']['date_departures']];
                    }
                    foreach ($document['prices']['date_departures'] as $date_departure) {
                        $date_departure = new \DateTime($date_departure);
                        $filter_departures[] = $date_departure->format('Y-m-d');
                    }
                }
            }

            $filter_departures = array_unique($filter_departures);
            sort($filter_departures);
            $end_time = microtime(true);
            $departure_filter_ms = ($end_time - $start_time)  * 1000;
        }

        $result = [
            'total_result' => !empty($result->total) ? $result->total : null,
            'current_page' => !empty($result->currentPage) ? $result->currentPage : null,
            'pages' => !empty($result->pages) ? $result->pages : null,
            'page_size' => $page_size,
            'query_string' => \BuildSearch::getCurrentQueryString(),
            'cache' => [
                'is_cached' => false,
                'info' => []
            ],
            'id_object_type' => !$id_object_type ? [] : $id_object_type,
            'categories' => $categories,
            'duration_min' => !empty($result_filter->minDuration) ? $result_filter->minDuration : null,
            'duration_max' => !empty($result_filter->maxDuration) ? $result_filter->maxDuration : null,
            'departure_min' => !empty($result_filter->minDeparture) ? new \DateTime($result_filter->minDeparture) : null,
            'departure_max' => !empty($result_filter->maxDeparture) ? new \DateTime($result_filter->maxDeparture) : null,
            'price_min' => !empty($result_filter->minPrice) ? $result_filter->minPrice  : null,
            'price_max' => !empty($result_filter->maxPrice) ? $result_filter->maxPrice : null,
            'departure_dates' => !empty($filter_departures) ? $filter_departures : null,
            'items' => $items,
            'mongodb' => [
                'duration_filter_ms' => $duration_filter_ms,
                'duration_search_ms' => $duration_search_ms,
                'aggregation_pipeline_filter' => !empty($filter) ? $filter->buildQueryAsJson($getFilters) : null,
                'aggregation_pipeline_search' => !empty($search) ? $search->buildQueryAsJson($getFilters) : null
            ]
        ];
        self::$_run_time_cache_full[$cache_key] = $result;
        return $result;
    }
}