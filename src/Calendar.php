<?php

namespace Pressmind\Travelshop;

class Calendar
{

    /**
     *
     *
     * if you plan to set different fieldnames for each object type as the media object name,
     * you can specify a map like this:
     *
     * $calendar_titles = [
     *   607 => 'headline_default',
     *   608 => 'title_default',
     *   {ID_OBJECT_TYPE} => {FIELDNAME} (see database table objectdata_{ID_OBJECT_TYPE})
     * ];
     * @param int $id_object_type
     * @param array $calendar_titles
     */
    public static function get($id_object_type = null, $calendar_titles = [])
    {

        /**
         * Get the database and config instance from the pressmind sdk
         */
        $db = \Pressmind\Registry::getInstance()->get('db');
        $config = \Pressmind\Registry::getInstance()->get('config');

        // if we want to display object type specific titles, we habe to build a join for each object type table
        $joins = [];
        $field_titles = [];
        foreach ($config['data']['primary_media_type_ids'] as $id_object_type) {
            if (empty($calendar_titles[$id_object_type])) {
                continue;
            }
            $field_titles[] = 'mo' . $id_object_type . '.' . $calendar_titles[$id_object_type];
            $joins[] = 'left join objectdata_' . $id_object_type . ' mo' . $id_object_type . ' on (mo.id = mo' . $id_object_type . '.id_media_object)';

        }

        $title = 'mo.name';
        if (!empty($field_titles)) {
            $title = 'concat_ws("", ' . implode(',', $field_titles) . ') as name';
        }

        $sql = 'select distinct  mo.id, ps.date_departure,
                            id_object_type, ' . $title . '
                        from pmt2core_cheapest_price_speed ps
                            inner join pmt2core_media_objects mo on (mo.id = ps.id_media_object)
                            ' . implode('', $joins) . '
                        where 
                            date_departure > now() 
                            and mo.visibility = 30
                            order by date_departure limit 500;';
        $items = $db->fetchAll($sql);
        return $items;

    }

    /**
     * @deprecated (but still in use and no replacement yet)
     * @return array
     * @throws \Exception
     */
    public static function getTravelMonthRanges($occupancies = [2]){
        $db = \Pressmind\Registry::getInstance()->get('db');
        $items = $db->fetchAll('select min(date_departure) as min_date,
                                group_concat(id_media_object) as id_media_objects
                                FROM pmt2core_cheapest_price_speed
                                where date_departure > now()
                                and option_occupancy in("'.implode('","', $occupancies).'")
                                GROUP BY YEAR(date_departure)*100 + MONTH(date_departure);'
        );
        $output = [];
        foreach($items as $item){
            $date = new \DateTime($item->min_date);
            $output[] = [
                'from' => new \DateTime($date->format('Y-m-01')),
                'to' => new \DateTime($date->format('Y-m-t')),
                'id_media_objects' => array_unique(explode(',', $item->id_media_objects))
            ];
        }
        return $output;
    }

}