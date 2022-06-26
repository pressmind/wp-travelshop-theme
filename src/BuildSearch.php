<?php

class BuildSearch
{

    /**
     * Contains the current GET request as validated array
     * @var array
     */
    private static $validated_search_parameters = [];
    private static $page_size = 10;
    private static $page = 1;

    /**
     * @deprecated
     * Building a pressmind MYSQL search query
     * based on GET or POST request
     *
     *
     * Possible Parameters
     * $request['pm-id'] media object id/s  separated by comma
     * $request['pm-ot'] object Type ID
     * $request['pm-t'] term
     * $request['pm-c'] category id's separated by comma (search with "or") or plus (search with "and")   e.g. pm-c[land_default]=xxx,yyyy = or Suche, + and Suche
     * $request['pm-pr'] price range 123-1234
     * $request['pm-dr'] date range 20200101-20200202
     * $request['pm-vi'] visibiltiy
     * $request['pm-st'] state
     * $request['pm-bs'] booking state (date)
     * $request['pm-po'] pool
     * $request['pm-br'] brand
     * $request['pm-vr'] valid from, valid to range
     * $request['pm-l'] limit 0,10
     * $request['pm-o'] order
     * @param $request
     * @return \Pressmind\Search
     */
    public static function fromRequest($request, $prefix = 'pm', $paginator = true, $page_size = 10)
    {

        array_walk_recursive($request, function($key, &$item){
            $item = urldecode($item);
        });

        $validated_search_parameters = [];
        $conditions = array();

        // set the default visibility
        $conditions[] = Pressmind\Search\Condition\Visibility::create(TS_VISIBILTY);

        if (isset($request[$prefix.'-ot'])) {
            $id_object_type = self::extractObjectType($request[$prefix.'-ot']);
            if($id_object_type !== false){
                $conditions[] = Pressmind\Search\Condition\ObjectType::create($id_object_type);
                $validated_search_parameters[$prefix.'-ot'] = is_array($id_object_type) ? implode(',',$id_object_type) : $id_object_type;

            }
        }


        if (empty($request[$prefix.'-t']) === false){
            $term = $request[$prefix.'-t'];
            $conditions[] = Pressmind\Search\Condition\Fulltext::create($term, ['fulltext'], 'AND', 'NATURAL LANGUAGE MODE');
            $validated_search_parameters[$prefix.'-t'] = $request[$prefix.'-t'];
        }


        if (isset($request[$prefix.'-pr']) === true && preg_match('/^([0-9]+)\-([0-9]+)$/', $request[$prefix.'-pr']) > 0) {
            list($price_range_from, $price_range_to) = explode('-', $request[$prefix.'-pr']);
            $price_range_from = empty(intval($price_range_from)) ? 1 : intval($price_range_from);
            $price_range_to = empty(intval($price_range_to)) ? 99999 : intval($price_range_to);
            $conditions[] = Pressmind\Search\Condition\PriceRange::create($price_range_from, $price_range_to);
            $validated_search_parameters[$prefix.'-pr'] = $price_range_from.'-'.$price_range_to;

        }

        if (isset($request[$prefix.'-du']) === true && preg_match('/^([0-9]+)\-([0-9]+)$/', $request[$prefix.'-du']) > 0) {
            list($duration_range_from, $duration_range_to) = explode('-', $request[$prefix.'-du']);
            $duration_range_from = empty(intval($duration_range_from)) ? 1 : intval($duration_range_from);
            $duration_range_to = empty(intval($duration_range_to)) ? 99999 : intval($duration_range_to);
            $conditions[] = Pressmind\Search\Condition\DurationRange::create($duration_range_from, $duration_range_to);
            $validated_search_parameters[$prefix.'-du'] = $duration_range_from.'-'.$duration_range_to;
        }


        if (isset($request[$prefix.'-dr']) === true) {
            $dateRange = self::extractDaterange($request[$prefix.'-dr']);
            if($dateRange !== false){
                list($from, $to) = $dateRange;
                $conditions[] = Pressmind\Search\Condition\DateRange::create($from, $to);
                $validated_search_parameters[$prefix.'-dr'] = $from->format('Y-m-d').'-'.$to->format('Y-m-d');
            }
        }


        if (
            (isset($request[$prefix.'-c']) === true && is_array($request[$prefix.'-c']) == true) ||
            (isset($request[$prefix.'-cl']) === true && is_array($request[$prefix.'-cl']) == true)
        ) {

            // handle the linked object feature
            $search_items = [];
            if(isset($request[$prefix.'-c']) === true && is_array($request[$prefix.'-c']) == true){
               $search_items['c'] = $request[$prefix.'-c'];
            }

            // this items are linked to the media object and requires a modified search condition
            if(isset($request[$prefix.'-cl']) === true && is_array($request[$prefix.'-cl']) == true){
                $search_items['cl'] = $request[$prefix.'-cl'];
            }

            foreach($search_items as $type => $search_item){

                foreach($search_item as $property_name => $item_ids){

                    if(preg_match('/^[0-9a-zA-Z\-\_]+$/', $property_name) > 0){ // valid property name

                        if(preg_match('/^[0-9a-zA-Z\-\,]+$/', $item_ids) > 0){ // search by OR, marked by ","
                            $delimiter = ',';
                            $operator = 'OR';
                        }elseif(preg_match('/^[0-9a-zA-Z\-\+]+$/', $item_ids) > 0){ // search by AND, marked by "+"
                            $delimiter = '+';
                            $operator = 'AND';
                        }else{ // not valid
                            continue;
                        }

                        $item_ids = explode($delimiter,$item_ids);
                        $conditions[] = Pressmind\Search\Condition\Category::create($property_name, $item_ids, $operator, ($type == 'cl'));
                        $validated_search_parameters[$prefix.'-'.$type][$property_name] = implode($delimiter, $item_ids);
                    }

                }

            }


        }


        if (empty($request[$prefix.'-ho']) === false){
            if(preg_match('/^[0-9\,]+$/', $request[$prefix.'-ho']) > 0){
                $occupancies = explode(',', $request[$prefix.'-ho']);
                $conditions[] = Pressmind\Search\Condition\HousingOption::create($occupancies);
                $validated_search_parameters[$prefix.'-ho'] = implode(',', $occupancies);
            }
        }


        $order = array();
        $allowed_orders = array('rand', 'price-desc', 'price-asc', 'date_departure-asc', 'date_departure-desc', 'name-asc', 'name-desc', 'code-asc', 'code-desc');

        if (empty($request[$prefix.'-o']) === false && in_array($request[$prefix.'-o'], $allowed_orders) === true) {

            if($request[$prefix.'-o'] == 'rand'){
                $order = array('' => 'RAND()');
            }else{
                list($property, $direction) =  explode('-', $request[$prefix.'-o']);
                $order = array($property => $direction);

                // we need a price range to order by price, so we have to change the search
                if($property == 'price' && empty($price_range_from) && empty($price_range_to)){
                    $conditions[] = Pressmind\Search\Condition\PriceRange::create(1, 9999);
                    $validated_search_parameters[$prefix.'-pr'] = '1-9999';
                }
            }

            $validated_search_parameters[$prefix.'-o'] = $request[$prefix.'-o'];
        }

        if (empty($request[$prefix.'-id']) === false){
            if(preg_match('/^[0-9\,]+$/', $request[$prefix.'-id']) > 0){
                $ids = explode(',', $request[$prefix.'-id']);
                $conditions[] = Pressmind\Search\Condition\MediaObjectID::create($ids);
                $validated_search_parameters[$prefix.'-id'] = implode(',', $ids);

            }
        }

        if (empty($request[$prefix.'-po']) === false){
            if(preg_match('/^[0-9\,]+$/', $request[$prefix.'-po']) > 0){
                $pools = explode(',', $request[$prefix.'-po']);
                $conditions[] = Pressmind\Search\Condition\Pool::create($pools);
                $validated_search_parameters[$prefix.'-po'] = implode(',', $pools);

            }
        }

        if (empty($request[$prefix.'-st']) === false){
            if(preg_match('/^[0-9\,]+$/', $request[$prefix.'-st']) > 0){
                $states = explode(',', $request[$prefix.'-st']);
                $conditions[] = Pressmind\Search\Condition\State::create($states);
                $validated_search_parameters[$prefix.'-st'] = implode(',', $states);

            }
        }

        if (empty($request[$prefix.'-br']) === false){
            if(preg_match('/^[0-9\,]+$/', $request[$prefix.'-br']) > 0){
                $brands = explode(',', $request[$prefix.'-br']);
                $conditions[] = Pressmind\Search\Condition\Brand::create($brands);
                $validated_search_parameters[$prefix.'-br'] = implode(',', $brands);

            }
        }

        if (empty($request[$prefix.'-tr']) === false){
            $transport_types = self::extractTransportTypes($request[$prefix.'-tr']);
            if(!empty($transport_types)){
                $conditions[] = Pressmind\Search\Condition\Transport::create($transport_types);
                $validated_search_parameters[$prefix.'-tr'] = implode(',', $transport_types);
            }
        }

        if (empty($request[$prefix.'-vi']) === false){
            if(preg_match('/^[0-9\,]+$/', $request[$prefix.'-vi']) > 0){
                $visibilities = explode(',', $request[$prefix.'-vi']);
                $conditions[] = Pressmind\Search\Condition\Visibility::create($visibilities);
                $validated_search_parameters[$prefix.'-vi'] = implode(',', $visibilities);

            }
        }

        // Booking State (based on date)
        if (empty($request[$prefix.'-bs']) === false){
            if(preg_match('/^[0-9\,]+$/', $request[$prefix.'-bs']) > 0){
                $booking_states = explode(',', $request[$prefix.'-bs']);
                $conditions[] = Pressmind\Search\Condition\BookingState::create($booking_states);
                $validated_search_parameters[$prefix.'-bs'] = implode(',', $booking_states);
            }
        }

        if (isset($request[$prefix.'-vr']) === true) {
            $dateRange = self::extractDaterange($request[$prefix.'-vr']);
            if($dateRange !== false){
                list($from, $to) = $dateRange;
                $conditions[] = Pressmind\Search\Condition\Validity::create($from, $to);
                $validated_search_parameters[$prefix.'-dr'] = $from->format('Ymd').'-'.$to->format('Ymd');
            }
        }

        self::$validated_search_parameters = $validated_search_parameters;

        $Search = new Pressmind\Search($conditions, [
            'start' => 0,
            'length' => 1000
        ], $order);


        if($paginator){
            $page = 0;
            //$page_size = 10;
            if (isset($request[$prefix.'-l']) === true && preg_match('/^([0-9]+)\,([0-9]+)$/', $request[$prefix.'-l'], $m) > 0) {
                $page = intval($m[1]);
                $page_size = intval($m[2]);
            }

            $Search->setPaginator(Pressmind\Search\Paginator::create($page_size, $page));
        }
        return $Search;

    }

    /**
     *
     * Building a pressmind search query based
     * on GET or POST request based on
     *
     * Remember: the mongodb does not contain the same search paramentes like the mysql search!
     *
     * Possible Parameters
     * $request['pm-id'] media object id/s  separated by comma
     * $request['pm-ot'] object Type ID
     * $request['pm-t'] term
     * $request['pm-co'] code/s separated by comma
     * $request['pm-c'] category id's separated by comma (search with "or") or plus (search with "and")   e.g. pm-c[land_default]=xxx,yyyy = or Suche, + and Suche
     * $request['pm-pr'] price range 123-1234
     * $request['pm-dr'] date range 20200101-20200202
     * $request['pm-l'] limit 0,10
     * $request['pm-o'] order
     * @param $request
     * @param string $prefix
     * @param bool $paginator
     * @param int $page_size
     * @param array $custom_conditions
     * @return \Pressmind\Search\MongoDB
     */
    public static function fromRequestMongoDB($request, $prefix = 'pm', $paginator = true, $page_size = 10, $custom_conditions = [])
    {

        array_walk_recursive($request, function($key, &$item){
            $item = urldecode($item);
        });

        $validated_search_parameters = [];
        $conditions = array();
        $order = array('price_total' => 'asc');

        if (isset($request[$prefix.'-ot'])) {
            $id_object_type = self::extractObjectType($request[$prefix.'-ot']);
            if($id_object_type !== false){
                $conditions[] = new \Pressmind\Search\Condition\MongoDB\ObjectType($id_object_type);
                $validated_search_parameters[$prefix.'-ot'] = is_array($id_object_type) ? implode(',', $id_object_type) : $id_object_type;
            }
        }

        if (empty($request[$prefix.'-t']) === false){
            $term = $request[$prefix.'-t'];
            $order = array('score' => 'desc');
            if(defined('TS_FULLTEXT_SEARCH') && !empty(TS_FULLTEXT_SEARCH['atlas']['active'])){
                $conditions[] = new \Pressmind\Search\Condition\MongoDB\AtlasLuceneFulltext($term, !empty(TS_FULLTEXT_SEARCH['atlas']['definition']) ? TS_FULLTEXT_SEARCH['atlas']['definition'] : []);
            }else{
                $conditions[] = new \Pressmind\Search\Condition\MongoDB\Fulltext($term);
            }
            $validated_search_parameters[$prefix.'-t'] = $request[$prefix.'-t'];
        }

        if (empty($request[$prefix.'-co']) === false && preg_match('/^([0-9\-_A-Za-z\,]+)$/', $request[$prefix.'-du']) > 0){
            $codes = explode(',', $request[$prefix.'-co']);
            $conditions[] = new \Pressmind\Search\Condition\MongoDB\Code($codes);
            $validated_search_parameters[$prefix.'-co'] = $request[$prefix.'-co'];
        }

        if (isset($request[$prefix.'-pr']) === true && preg_match('/^([0-9]+)\-([0-9]+)$/', $request[$prefix.'-pr']) > 0) {
            list($price_range_from, $price_range_to) = explode('-', $request[$prefix.'-pr']);
            $price_range_from = empty(intval($price_range_from)) ? 1 : intval($price_range_from);
            $price_range_to = empty(intval($price_range_to)) ? 99999 : intval($price_range_to);
            $conditions[] = new \Pressmind\Search\Condition\MongoDB\PriceRange($price_range_from, $price_range_to);
            $validated_search_parameters[$prefix.'-pr'] = $price_range_from.'-'.$price_range_to;

        }

        if (isset($request[$prefix.'-du']) === true && preg_match('/^([0-9]+)\-([0-9]+)$/', $request[$prefix.'-du']) > 0) {
            list($duration_range_from, $duration_range_to) = explode('-', $request[$prefix.'-du']);
            $duration_range_from = empty(intval($duration_range_from)) ? 1 : intval($duration_range_from);
            $duration_range_to = empty(intval($duration_range_to)) ? 99999 : intval($duration_range_to);
            $conditions[] = new \Pressmind\Search\Condition\MongoDB\DurationRange($duration_range_from,$duration_range_to);
            $validated_search_parameters[$prefix.'-du'] = $duration_range_from.'-'.$duration_range_to;
        }


        if (isset($request[$prefix.'-dr']) === true) {
            $dateRange = self::extractDaterange($request[$prefix.'-dr']);
            if($dateRange !== false){
                list($from, $to) = $dateRange;
                $conditions[] = new \Pressmind\Search\Condition\MongoDB\DateRange($from, $to);
                $validated_search_parameters[$prefix.'-dr'] = $from->format('Ymd').'-'.$to->format('Ymd');
            }
        }


        if (isset($request[$prefix.'-c']) === true && is_array($request[$prefix.'-c']) === true) {
            $search_item = $request[$prefix.'-c'];
            foreach($search_item as $property_name => $item_ids){
                if(preg_match('/^[0-9a-zA-Z\-\_]+$/', $property_name) > 0){ // valid property name
                    if(preg_match('/^[0-9a-zA-Z\-\,]+$/', $item_ids) > 0){ // search by OR, marked by ","
                        $delimiter = ',';
                        $operator = 'OR';
                    }elseif(preg_match('/^[0-9a-zA-Z\-\+]+$/', $item_ids) > 0){ // search by AND, marked by "+"
                        $delimiter = '+'; // be ware, this sign is reserverd by php. urls must use the escaped sign %2B
                        $operator = 'AND';
                    }else{ // not valid
                        echo 'operator not valid';
                        continue;
                    }
                    $item_ids = explode($delimiter,$item_ids);
                    $conditions[] = new \Pressmind\Search\Condition\MongoDB\Category($property_name, $item_ids, $operator);
                    $validated_search_parameters[$prefix.'-c'][$property_name] = implode($delimiter, $item_ids);
                }
            }
        }


        if (empty($request[$prefix.'-ho']) === false){
            if(preg_match('/^[0-9\,]+$/', $request[$prefix.'-ho']) > 0){
                $occupancies = array_map('intval', explode(',', $request[$prefix.'-ho']));
                $conditions[] = new \Pressmind\Search\Condition\MongoDB\Occupancy($occupancies);
                $validated_search_parameters[$prefix.'-ho'] = implode(',', $occupancies);
            }
        }

        if (empty($request[$prefix.'-id']) === false){
            if(preg_match('/^[0-9\,]+$/', $request[$prefix.'-id']) > 0){
                $ids = array_map('intval', explode(',', $request[$prefix.'-id']));
                $conditions[] = new \Pressmind\Search\Condition\MongoDB\MediaObject($ids);
                $validated_search_parameters[$prefix.'-id'] = implode(',', $ids);

            }
        }

        if(defined('TS_SEARCH_GROUP_KEYS') && !empty(TS_SEARCH_GROUP_KEYS)){
            $conditions[] = new \Pressmind\Search\Condition\MongoDB\Group(TS_SEARCH_GROUP_KEYS);
        }

        $allowed_orders = array('rand', 'price-desc', 'price-asc', 'date_departure-asc', 'date_departure-desc', 'score-asc', 'score-desc');
        if (empty($request[$prefix.'-o']) === false && in_array($request[$prefix.'-o'], $allowed_orders) === true) {

            if($request[$prefix.'-o'] == 'rand'){
                $order = array('rand' => '');
            }else{
                list($property, $direction) =  explode('-', $request[$prefix.'-o']);
                $property = $property == 'price' ? 'price_total' : $property;
                $order = array($property => $direction);
            }

            $validated_search_parameters[$prefix.'-o'] = $request[$prefix.'-o'];
        }

        $conditions = array_merge($conditions, $custom_conditions);

        $Search = new Pressmind\Search\MongoDB($conditions, $order, TS_LANGUAGE_CODE);

        self::$validated_search_parameters = $validated_search_parameters;

        if($paginator){ // @TODO this needs a refactoring
            $page = 0;
            //$page_size = 10;
            if (isset($request[$prefix.'-l']) === true && preg_match('/^([0-9]+)\,([0-9]+)$/', $request[$prefix.'-l'], $m) > 0) {
                $page = intval($m[1]);
                $page_size = intval($m[2]);
            }

            $Search->setPaginator(Pressmind\Search\Paginator::create($page_size, $page));
        }

        return $Search;

    }


    /**
     * rebuild the SearchConditions without a defined list of attributes
     * @param array $removeItems
     * @param string $prefix
     * @param bool $paginator
     * @param int $page_size
     * @return \Pressmind\Search
     */
    public static function rebuild($removeItems = [], $prefix = 'pm', $paginator = true, $page_size = 10){

        $p = self::$validated_search_parameters;
        foreach($removeItems as $k){
            if(preg_match('/^([a-z\-]+)\[([a-zA-Z0-9\_]+)\]$/', $k, $matches) > 0){
                unset($p[$matches[1]][$matches[2]]);
            }else{
                unset($p[$k]);
            }
        }
        return self::fromRequest(array_filter($p), $prefix, $paginator, $page_size);

    }



    public static function getCurrentQueryString($page = null, $page_size = null, $prefix = 'pm'){

        $page = empty($page) ? self::$page : $page;
        $page_size = empty($page_size) ? self::$page_size : $page_size;
        return urldecode(http_build_query(self::$validated_search_parameters)).'&'.$prefix.'-l='.$page.','.$page_size;
    }


    /**
     * Accepts the following formats
     * YYYYMMDD-YYYYMMDD
     * or
     * {relative offset from today}-{relative offset from today} eg. "+90-+120" or "90-120"
     * or
     * {relative offset from today} e.g. "+90" means today-{today+offset}
     * @param $str
     * @return DateTime[]|bool
     * @throws Exception
     */
    public static function extractDaterange($str){
        if(preg_match('/^([0-9]{4}[0-9]{2}[0-9]{2})\-([0-9]{4}[0-9]{2}[0-9 ]{2})$/', $str, $m) > 0){
            return array(new DateTime($m[1]), new DateTime($m[2]));
        }elseif(preg_match('/^([\+\-]?[0-9]+)$/', $str, $m) > 0) {
            $to = new DateTime('now');
            $to->modify($m[1].' day');
            return array(new DateTime('now'), $to);
        }elseif(preg_match('/^([\+\-]?[0-9]+)\-([\+\-]?[0-9]+)$/', $str, $m) > 0) {
            $from = new DateTime('now');
            $from->modify($m[1].' day');
            $to = new DateTime('now');
            $to->modify($m[2].' day');
            return array($from, $to);
        }
        return false;
    }

    /**
     * @param $str
     * @return int[]|bool
     */
    public static function extractDurationRange($str){
        if(preg_match('/^([0-9]+)\-([0-9]+)$/', $str, $m) > 0){
            return array($m[1], $m[2]);
        }
        if(preg_match('/^([0-9]+)$/', $str, $m) > 0){
            return array($m[1], $m[1]);
        }
        return false;
    }


    /**
     * @param $str
     * @return int[]|bool
     */
    public static function extractPriceRange($str){
        if(preg_match('/^([0-9]+)\-([0-9]+)$/', $str, $m) > 0){
            return array($m[1], $m[2]);
        }
        return false;
    }

    /**
     * @param $str
     * @return int[]|bool
     */
    public static function extractObjectType($str){
        if(preg_match('/^([0-9\,]+)$/', $str, $m) > 0){
            return array_map('intval', explode(',',$str));
        }
        return false;
    }


    /**
     * @param $str
     * @return []
     */
    public static function extractTransportTypes($str){
        if(preg_match('/^[a-z,A-Z\,]+$/', $str) > 0){
            return explode(',', $str);
        }
        return [];
    }

}

