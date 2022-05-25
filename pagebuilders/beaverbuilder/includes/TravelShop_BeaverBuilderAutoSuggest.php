<?php

/**
 *  This class hijacks the BeaverBuilder ajax call on the suggest field
 */
final class TravelShop_BeaverBuilderAutoSuggest {

    static public function handle(){
        if(!empty($_POST['fl_builder_data']['action']) && $_POST['fl_builder_data']['action'] == 'get_autosuggest_values'){
            self::get_values($_POST['fl_builder_data']['fields']);
        }elseif(!empty($_GET['fl_action']) && $_GET['fl_action'] == 'fl_builder_autosuggest'){
            self::suggest();
        }
    }

	/**
	 * Checks for an auto suggest request. If one is found
	 * the data will be echoed as a JSON response.
	 ** @return array
	 */
	static public function suggest() {
	    if ( isset( $_REQUEST['fl_as_action'] ) && isset( $_REQUEST['fl_as_query'] ) ) {
	        // category_1234_123-zielgebiet_default
	        if(preg_match('/^category_(?:([0-9]+))?_([0-9]+)\-([a-z0-9\_]+)$/', $_REQUEST['fl_as_action'], $matches) > 0){
	            return self::get_categories($matches[1], $matches[2]);
            }
		}
	}


	/**
	 * Returns the values for all suggest fields in a settings form.
	 * @param array $fields
	 * @return array
	 */
	static public function get_values( $fields ) {
		$values = array();
		// the field must match, otherwise this is not our call and we return silent.
        // category_1234123_-zielgebiet_default
        if(preg_match('/^category_(?:([0-9]+))?_([0-9]+)\-([a-z0-9\_]+)$/', $fields[0]['action'], $matches) > 0){
            foreach ( $fields as $field ) {
                if(preg_match('/^category_(?:([0-9]+))?_([0-9]+)\-([a-z0-9\_]+)$/', $field['action'], $matches) > 0) {
                    $values[ $field['name'] ] = self::get_value(explode(',', $field['value']), $matches[1], $matches[2]);
                }
            }
            echo json_encode($values);
            exit;
        }

	}


    /**
     * Returns the stored values by id
     * @param array $id_items
     * @param int $id_object_type
     * @param int $id_tree
     * @return false|string|string[]
     * @throws Exception
     */
	public static function get_value($id_items, $id_object_type, $id_tree){

        $search = new Pressmind\Search(
            [
                Pressmind\Search\Condition\Visibility::create(TS_VISIBILTY),
               // Pressmind\Search\Condition\ObjectType::create($id_object_type),
            ]
        );

        $tree = new Pressmind\Search\Filter\Category($id_tree, $search);
        $treeItems = $tree->getResult();

        $categories = \Pressmind\Travelshop\CategoryTreeTools::flatten($treeItems);
        $categories[] = [
            'name' => 'search_behavior-AND',
            'value' => 'search-behavior-AND',
        ];
        $categories[] = [
            'name' => 'search-behavior-OR',
            'value' => 'search-behavior-OR',
        ];
	    $output = [];
	    foreach($id_items as $id_item){
            foreach($categories as $category){
                if($category['value'] == $id_item){
                    $tmp = new stdClass();
                    $tmp->value = $id_item;
                    $tmp->name = $category['name'];
                    $output[] = $tmp;
                    break;
                }
            }
        }

       return  str_replace( "'", '&#39;', json_encode( $output ) );

    }


	/**
     * Returns a flat tree list as array
	 * @return array
	 */
	static public function get_categories($id_object_type, $id_tree) {

        $search = new Pressmind\Search(
            [
                Pressmind\Search\Condition\Visibility::create(TS_VISIBILTY),
                //Pressmind\Search\Condition\ObjectType::create($id_object_type),
            ]
        );

        $tree = new Pressmind\Search\Filter\Category($id_tree, $search);
        $treeItems = $tree->getResult('name');
        $output = \Pressmind\Travelshop\CategoryTreeTools::flatten($treeItems);
        $output[] = [
            'name' => 'search_behavior-AND',
            'value' => 'search-behavior-AND',
        ];
        $output[] = [
            'name' => 'search-behavior-OR',
            'value' => 'search-behavior-OR',
        ];
		echo json_encode($output);
		exit;
	}


}
