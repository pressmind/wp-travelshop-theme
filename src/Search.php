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
     * @param int[] $allowed_visibilities e.g. 30 = public, 60 = hidden
     * @return array
     * @throws \Exception
     */
    public static function getResult($request, $occupancy = 2, $page_size = 12, $getFilters = false, $returnFiltersOnly = false, $ttl_filter = null, $ttl_search = null, $output = null, $preview_date = null, $custom_conditions = [], $allowed_visibilities = [30])
    {
        $cache_key = md5(serialize(func_get_args()));
        if(isset(self::$_run_time_cache_full[$cache_key])){
            return self::$_run_time_cache_full[$cache_key];
        }
        $duration_filter_ms = null;
        $duration_search_ms = null;
        if (empty($request['pm-ho']) === true && !empty($occupancy)) {
            // if the price duration slider is active, we have to set the housing occupancy search
            // (to display the correct search result with the correct cheapest price inside)
            $request['pm-ho'] = $occupancy;
        }
        $id_object_type = empty($request['pm-ot']) ? false : \BuildSearch::extractObjectType($request['pm-ot']);
        $order = empty($request['pm-o']) ? 'price-asc' : $request['pm-o'];
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
            if(!empty($occupancy)){
                $FilterCondition[] = new \Pressmind\Search\Condition\MongoDB\Occupancy($occupancy);
            }
            $FilterCondition = array_merge($FilterCondition, $custom_conditions);
            $filter = new \Pressmind\Search\MongoDB($FilterCondition, ['price_total' => 'asc'], TS_LANGUAGE_CODE);
            $start_time = microtime(true);
            if(isset(self::$_run_time_cache_filter[$cache_key])){
                $result_filter = self::$_run_time_cache_filter[$cache_key];
            }else{
                $result_filter = $filter->getResult(true, true, $ttl_filter, null, $preview_date, $allowed_visibilities);
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
            $result = $search->getResult(true, false, $ttl_search, $output, $preview_date, $allowed_visibilities);
            $end_time = microtime(true);
            $duration_search_ms = ($end_time - $start_time) * 1000;
            foreach ($result->documents as $document) {
                $document = json_decode(json_encode($document), true);
                $item = (array)$document['description'];
                $item['id_media_object'] = $document['id_media_object'];
                $item['id_object_type'] = $document['id_object_type'];
                $item['url'] = $document['url'];
                $item['recommendation_rate'] = !empty($document['recommendation_rate']) ? $document['recommendation_rate'] : null;
                $item['dates_per_month'] = [];
                $item['fst_date_departure'] = !empty($document['fst_date_departure']) ? new \DateTime($document['fst_date_departure']) : null;
                $item['possible_durations'] = !empty($document['possible_durations']) ? $document['possible_durations'] : [];
                $item['last_modified_date'] = $document['last_modified_date'];
                $item['sales_priority'] = !empty($document['sales_priority']) ? $document['sales_priority'] : null;
                if (!empty($document['prices'])) {
                    if(!is_array($document['prices']['date_departures'])){
                        $document['prices']['date_departures'] = [$document['prices']['date_departures']];
                    }
                    $item['cheapest_price'] = new \stdClass();
                    $item['cheapest_price']->duration = $document['prices']['duration'];
                    $item['cheapest_price']->price_total = (float)$document['prices']['price_total'];
                    $item['cheapest_price']->price_regular_before_discount = $document['prices']['price_regular_before_discount'];
                    $item['cheapest_price']->earlybird_discount = $document['prices']['earlybird_discount'];
                    $item['cheapest_price']->earlybird_discount_f = $document['prices']['earlybird_discount_f'];
                    $item['cheapest_price']->earlybird_name = empty($document['prices']['earlybird_name']) ? null : $document['prices']['earlybird_name'];
                    $item['cheapest_price']->date_departures = [];
                    if (!empty($document['prices']['date_departures'])) {
                        foreach ($document['prices']['date_departures'] as $date_departure) {
                            $item['cheapest_price']->date_departures[] = new \DateTime($date_departure);
                        }
                    }
                    $item['cheapest_price']->guaranteed_departures = [];
                    if (!empty($document['prices']['guaranteed_departures'])) {
                        foreach ($document['prices']['date_departures'] as $guaranteed_departure) {
                            $item['cheapest_price']->guaranteed_departures[] = new \DateTime($guaranteed_departure);
                        }
                    }
                    $item['cheapest_price']->earlybird_discount_date_to = $document['prices']['earlybird_discount_date_to'] != null ? new \DateTime($document['prices']['earlybird_discount_date_to']) : null;
                    $item['cheapest_price']->option_board_type = $document['prices']['option_board_type'];
                    $item['cheapest_price']->transport_type = $document['prices']['transport_type'];
                } else {
                    $item['cheapest_price'] = null;
                    $document['prices'] = null;
                }
                if (!empty($document['dates_per_month'])) {
                    $document['dates_per_month'] = array_filter($document['dates_per_month'], function($item) {
                        return !empty($item['five_dates_in_month']);
                    });
                    $document['dates_per_month'] = array_values($document['dates_per_month']);
                    $item['dates_per_month'] = $document['dates_per_month'];
                    foreach ($document['dates_per_month'] as $k => $month) {
                        foreach ($month['five_dates_in_month'] as $k1 => $date) {
                            $item['dates_per_month'][$k]['five_dates_in_month'][$k1]['date_departure'] = new \DateTime($date['date_departure']);
                            $item['dates_per_month'][$k]['five_dates_in_month'][$k1]['date_arrival'] = new \DateTime($date['date_arrival']);
                            $item['dates_per_month'][$k]['five_dates_in_month'][$k1]['duration'] = $date['duration'];
                            $item['dates_per_month'][$k]['five_dates_in_month'][$k1]['price_total'] = (float)$date['price_total'];
                            $item['dates_per_month'][$k]['five_dates_in_month'][$k1]['price_regular_before_discount'] = $date['price_regular_before_discount'];
                            $item['dates_per_month'][$k]['five_dates_in_month'][$k1]['durations_from_this_departure'] = $date['durations_from_this_departure'];
                            $item['dates_per_month'][$k]['five_dates_in_month'][$k1]['active'] = false;
                            if(!empty($document['fst_date_departure']) && $item['dates_per_month'][$k]['five_dates_in_month'][$k1]['date_departure']->format('Y-m-d') === $item['fst_date_departure']->format('Y-m-d')){
                                $item['dates_per_month'][$k]['five_dates_in_month'][$k1]['active'] = true;
                            }
                            if(!empty($item['cheapest_price']->price_total) && empty($document['fst_date_departure']) && $item['dates_per_month'][$k]['five_dates_in_month'][$k1]['price_total'] === $item['cheapest_price']->price_total){
                                $item['dates_per_month'][$k]['five_dates_in_month'][$k1]['active'] = true;
                            }
                        }
                    }
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

        $board_types = [];
        if(!empty($result_filter->boardTypesGrouped)){
            $matching_board_types_map = [];
            if(!$returnFiltersOnly){
                $matching_board_types = json_decode(json_encode($result->boardTypesGrouped));
                foreach($matching_board_types as $item){
                    if(empty($item->_id)){
                        continue;
                    }
                    $matching_board_types_map[$item->_id] = $item;
                }
            }
            foreach(json_decode(json_encode($result_filter->boardTypesGrouped)) as $item){
                if(empty($item->_id)){
                    continue;
                }
                $item->count_in_system = $item->count;
                $item->count_in_search = 0;
                $item->name = $item->_id;
                if(isset($matching_board_types_map[$item->_id])){
                    $item->count_in_search = $matching_board_types_map[$item->_id]->count;
                }
                $board_types[$item->_id] = $item;
            }
        }

        $transport_types = [];
        if(!empty($result_filter->transportTypesGrouped)){
            $matching_transport_types_map = [];
            if(!$returnFiltersOnly){
                $matching_transport_types = json_decode(json_encode($result->transportTypesGrouped));
                foreach($matching_transport_types as $item){
                    $matching_transport_types_map[$item->_id] = $item;
                }
            }
            foreach(json_decode(json_encode($result_filter->transportTypesGrouped)) as $item){
                if(empty($item->_id)){
                    continue;
                }
                $item->count_in_system = $item->count;
                $item->count_in_search = 0;
                $item->name = $item->_id;
                if(isset($matching_transport_types_map[$item->_id])){
                    $item->count_in_search = $matching_transport_types_map[$item->_id]->count;
                }
                $transport_types[$item->_id] = $item;
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
                        if(isset($filter_departures[$date_departure->format('Y-m-d')])){
                            $filter_departures[$date_departure->format('Y-m-d')]->count_in_system++;
                            $filter_departures[$date_departure->format('Y-m-d')]->date = $date_departure->format('Y-m-d');
                        }else{
                            $filter_departures[$date_departure->format('Y-m-d')] = new \stdClass();
                            $filter_departures[$date_departure->format('Y-m-d')]->count_in_system = 1;
                            $filter_departures[$date_departure->format('Y-m-d')]->count_in_search = 0;
                            $filter_departures[$date_departure->format('Y-m-d')]->date = $date_departure->format('Y-m-d');
                        }
                    }
                }
            }

            if(!$returnFiltersOnly) {
                foreach ($result->documents as $document) {
                    $document = json_decode(json_encode($document), true);
                    if (!empty($document['prices']['date_departures'])) {
                        if (!is_array($document['prices']['date_departures'])) {
                            $document['prices']['date_departures'] = [$document['prices']['date_departures']];
                        }
                        foreach ($document['prices']['date_departures'] as $date_departure) {
                            $date_departure = new \DateTime($date_departure);
                            if (isset($filter_departures[$date_departure->format('Y-m-d')])) {
                                $filter_departures[$date_departure->format('Y-m-d')]->count_in_search++;
                            }
                        }
                    }
                }
            }
            usort($filter_departures, function($a, $b) {
                return $a->date <=> $b->date;
            });
            $end_time = microtime(true);
            $departure_filter_ms = ($end_time - $start_time)  * 1000;


           // echo '<pre>';
           // print_r($filter_departures);
           // echo '</pre>';
           // exit;
//
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
            'order' => $order,
            'categories' => $categories,
            'board_types' => $board_types,
            'transport_types' => $transport_types,
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
                'aggregation_pipeline_filter' => !empty($filter) ? $filter->buildQueryAsJson($getFilters, $output, $preview_date, $allowed_visibilities) : null,
                'aggregation_pipeline_search' => !empty($search) ? $search->buildQueryAsJson($getFilters, $output, $preview_date, $allowed_visibilities) : null
            ]
        ];
        self::$_run_time_cache_full[$cache_key] = $result;
        return $result;
    }
}