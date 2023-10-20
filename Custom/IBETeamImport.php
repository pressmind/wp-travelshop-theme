<?php

namespace Custom;

use Custom\MediaType\Reise;
use DateTime;
use Exception;
use Pressmind\DB\Adapter\AdapterInterface;
use Pressmind\Import\ImportInterface;
use Pressmind\Log\Writer;
use Pressmind\ORM\Object\AbstractObject;
use Pressmind\ORM\Object\CheapestPriceSpeed;
use Pressmind\ORM\Object\MediaObject;
use Pressmind\ORM\Object\Touristic;
use Pressmind\Registry;
use stdClass;

/**
 * Example: https://github.com/pressmind/web-core-skeleton-basic/blob/master/application/Custom/Hooks/ExampleCustomImportHook.php
 *
 * <code>
 * # pm-config.php
 * 'data' => [
 *      'media_type_custom_import_hooks' => [
 *           2277 => [
 *              0 => 'Custom\\IBETeamImport',
 *          ],
 *      ],
 * ]
 * </code>
 * @package Custom
 */
class IBETeamImport implements ImportInterface
{

    private $_endpoint_booking_packages;
    private $_endpoint_startingPoints;
    private $_endpoint_insurances;
    private $_endpoint_insurance_price_table_packages;

    /**
     * @var MediaObject
     */
    private $_mediaObject;

    /**
     * @var array
     */
    private $_errors = [];

    /**
     * @var array
     */
    private $_warnings = [];

    /**
     * @var array
     */
    private $_log = [];

    private $_starttime;

    /**
     * ExampleCustomImportHook constructor.
     * @param integer $id_media_object
     */
    public function __construct($id_media_object)
    {
        include_once 'ibeteam-config.php';
        $this->_endpoint_booking_packages = 'https://import-kuschick.pressmind-ibe-team.net/v'.IBETEAM_VERSION.'/kuschickImportApi/getBookingPackages';
        $this->_endpoint_startingPoints = 'https://import-kuschick.pressmind-ibe-team.net/v'.IBETEAM_VERSION.'/kuschickImportApi/getStartingPoints';
        $this->_endpoint_insurances = 'https://import-kuschick.pressmind-ibe-team.net/v'.IBETEAM_VERSION.'/kuschickImportApi/getInsurances';
        $this->_endpoint_insurance_price_table_packages = 'https://import-kuschick.pressmind-ibe-team.net/v'.IBETEAM_VERSION.'/kuschickImportApi/getInsurancePriceTablePackages';

        $this->_starttime = microtime(true);
        $this->_log[] = $this->getTimeAndHeap() . 'Custom Import for media object ' . $id_media_object . ' invoked';
        $this->_mediaObject = new MediaObject($id_media_object);
    }

    /**
     * @param $foreign_key Code oder MULTI ID: "H12321/P123,H12321/P124,H12345,P123465" (H = Hotel ID, P = Produkt ID, H/P = Hotel ID mit nur bestimmter Produkt ID (Reise))
     * @param $id_media_object
     * @return string
     */
    private function _getBookingPackageUrl($foreign_key, $id_media_object){
        if(IBETEAM_MAPPING_TYPE == 'BUSPRO_ID'){
            $param = 'id='.$foreign_key;
        }else{
            $param = 'code='.$foreign_key;
        }
        return $this->_endpoint_booking_packages.'?'.IBETEAM_MAPPING_TYPE.'='.$foreign_key.'&offset='.IBETEAM_OFFSET_DAYS.'&idMediaObject='.$id_media_object.'&client='.IBETEAM_CLIENT;
    }

    private function getTimeAndHeap()
    {
        $text = number_format(microtime(true) - $this->_starttime, 4) . ' sec | Heap: ';
        $text .= bcdiv(memory_get_usage(), (1000 * 1000), 2) . ' MByte | ';
        return $text;
    }


    private function _fetchJSON($url, $report_empty_data_as_error = true){

        $this->_log[] = $this->getTimeAndHeap() . 'fetching url: ' . $url;
        $this->_log[] = Writer::write($this->getTimeAndHeap() . ' Importer::importMediaObject(' . $this->_mediaObject->id . '): fetching url: ' . $url, Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 600);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if(strlen($result) > (30 * 1048576)){ // 30MB
            $msg = [];
            $msg[] = __CLASS__.': Error occurred, Importer::importMediaObject(' . $this->_mediaObject->id . '): ( filesize is greater than 30MB ('.(strlen($result) / 1048576).' MB)  '.$url;
            $msg[]  = 'curl info: '. print_r($info, true);
            $this->_errors[] = implode("\n", $msg);
            return false;
        }

        // process result
        $decoded_result = json_decode($result);

        if(json_last_error() > 0){
            $msg = [];
            $msg[] = __CLASS__.': Error occurred, Importer::importMediaObject(' . $this->_mediaObject->id . '): (JSON: '.json_last_error_msg().')! Can not read JSON from '.$url;
            $msg[]  = 'curl info: '. print_r($info, true);
            $msg[] = 'curl result: '.print_r($result, true);
            $this->_errors[] = implode("\n", $msg);
            return false;
        }

        if(empty($decoded_result->status) || $decoded_result->status != 'OK' || (empty($decoded_result->data) && $report_empty_data_as_error) ){

            $msg = [];
            $msg[] = __CLASS__.": Error occurred!";
            $msg[] = "id media object: ".$this->_mediaObject->id;
            $msg[] = "code: ".$this->_mediaObject->code;
            $msg[] = "visibility: ".$this->_mediaObject->visibility;
            $msg[] ="url: ".$this->_mediaObject->getPrettyUrl();
            $msg[] ="Fetching URL: ".$url;
            if(!empty($decoded_result->status)){
                $msg[] ="Status XML-Parser: ".$decoded_result->status;
            }
            if(!empty($decoded_result->files)) {
                $msg[] = "Files: " . print_r(json_decode(json_encode($decoded_result->files), true), true);
            }
            if(!empty($decoded_result->msg)) {
                $msg[] = "Msg: " . $decoded_result->msg;
            }
            if(!empty($decoded_result->infos)) {
                $msg[] = "Infos: " . implode("\n ", $decoded_result->infos);
            }
            if(!empty($decoded_result->trace)) {
                $msg[] = "Trace: " . $decoded_result->trace;
            }
            if(!empty($decoded_result->exportDateHotel)) {
                $msg[] = "exportDateHotel: " . $decoded_result->exportDateHotel;
            }
            if(!empty($decoded_result->exportDateZiel)) {
                $msg[] = "exportDateZiel: " . $decoded_result->exportDateZiel;
            }

            if(in_array($decoded_result->status, ['warning', 'info'])) {
                $this->_warnings[] = implode("\n", $msg);
            }else{
                $this->_errors[] = implode("\n", $msg);
            }
        }

        $this->_log[] = $this->getTimeAndHeap() . 'data fetched and decoded';

        return !empty($decoded_result->data) ? $decoded_result->data : [];

    }

    public function getCode(){
        $code = '';
        if(!defined('IBETEAM_CODE_FIELD') || empty(IBETEAM_CODE_FIELD)){
            echo 'Error: IBETEAM_CODE_FIELD is not set'."\n";
            exit;
        }
        if(IBETEAM_CODE_FIELD == 'code'){
            $code = $this->_mediaObject->code;
        }else{
            $moc = $this->_mediaObject->getDataForLanguage(null);
            $code = strip_tags($moc->{IBETEAM_CODE_FIELD});
        }
        return str_replace(' ', '', implode(',',array_map('trim',explode(',', $code))));
    }

    /**
     * @return void
     * @throws Exception
     */
    public function import()
    {
        // Nur importieren wenn primary type
        $config = Registry::getInstance()->get('config');
        if(!in_array( $this->_mediaObject->id_object_type, $config['data']['primary_media_type_ids'])){
            return;
        }

        // Löscht Buchungspakete die ggf. durch Pressmind importiert wurden.
        $this->cleanup();

        // some object can have a user generated code list, like "12345, 123456,12345", build a nice request string
        $code_list = $this->getCode();
        if(empty($code_list)){
            $this->_errors[] = Writer::write($this->getTimeAndHeap() . ' Importer::importMediaObject(' . $this->_mediaObject->id . '): '.__CLASS__.': Warning: media object code is empty, no data to fetch', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_WARNING);
            return false;
        }

        // download bookable content
        $url = $this->_getBookingPackageUrl($code_list, $this->_mediaObject->id);
        $result = $this->_fetchJSON($url);
        if(empty($result->bookingPackages)){
            $this->_errors[] = Writer::write($this->getTimeAndHeap() . ' Importer::importMediaObject(' . $this->_mediaObject->id . '): '.__CLASS__.': Warning: booking_packages are empty '.$url, Writer::OUTPUT_BOTH, 'import', Writer::TYPE_WARNING);
            return false;
        }

        // Buchungspakete importieren
        $date_count = 0;
        $booking_packages = [];
        foreach($result->bookingPackages as $data) {
            $booking_package = new Touristic\Booking\Package();
            $booking_package->fromStdClass($data);
            $date_count += count($booking_package->dates);
            // save booking package
            try {
                $this->_log[] = $this->getTimeAndHeap() . 'creating booking package ' . $booking_package->id;
                $booking_package->create();
                $booking_packages[] = $booking_package;
                $this->_log[] = $this->getTimeAndHeap() . 'booking package ' . $booking_package->id . ' created';
            } catch (Exception $e) {
                $this->_log[] = __CLASS__.': Error occurred!';
                $this->_errors[] = $this->getTimeAndHeap() . ' Importer::importMediaObject(' . $this->_mediaObject->id . ') '. $e->getMessage();
                return false;
            }
        }
        $this->_mediaObject->booking_packages = $booking_packages;

        if(!defined('CURRENT_RUNTIME_MARKER')) {
            // Versicherungen
            $this->importInsurances();

            //  Startingpoints
            $this->importStartingPoints();

            // Ermäßigungen
            if(!empty($result->discounts) && is_array($result->discounts)){
                $this->importOptionDiscounts($result->discounts);
            }
        }

        // Cheapest Price, Preis Index
        $this->_log[] = $this->getTimeAndHeap() . 'calculating new cheapest prices';
        $this->_mediaObject->insertCheapestPrice();
        $this->_log[] = $this->getTimeAndHeap() . 'dates imported: '.$date_count;
        $this->_log[] = $this->getTimeAndHeap() . __CLASS__ . ': Import of external data from '.$url.' for media object ID:' . $this->_mediaObject->id . ' is done';
        unset($this->_mediaObject);

        if(!defined('CURRENT_RUNTIME_MARKER')){
            define('CURRENT_RUNTIME_MARKER', true);
        }
    }


    public function cleanup(){
        /** @var AdapterInterface $db */
        $db = Registry::getInstance()->get('db');
        // delete booking packages (bei BVB sehr wichtig, da das Touristikmodul bei Pressmind in Verwendung ist)
        $this->_log[] = Writer::write($this->getTimeAndHeap() . ' Importer::importMediaObject(' . $this->_mediaObject->id . '): deleting old booking packages', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
        $old_booking_packages = $this->_mediaObject->booking_packages;
        foreach ($old_booking_packages as $old_booking_package) {
            //echo 'delete: id_booking_package: '.$old_booking_package->id."\n";
            $old_booking_package->delete(true);
        }
        $this->_mediaObject->booking_packages = [];
        unset($old_booking_packages);
        $this->_log[] = $this->getTimeAndHeap() . 'deleting old cheapest prices';
        $db->delete('pmt2core_cheapest_price_speed', ['id_media_object = ?', $this->_mediaObject->getId()]);

        $this->_mediaObject->update();
    }

    /**
     * @param Touristic\Option\Discount[] $discounts
     * @throws Exception
     */
    public function importOptionDiscounts($discounts){
        $db = Registry::getInstance()->get('db');
        $this->_log[] = Writer::write($this->getTimeAndHeap() . __CLASS__ . ': Import of external (option discount) data', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
        foreach($discounts as $discount){
            if(empty($discount->id)){
                continue;
            }
            $db->delete('pmt2core_touristic_option_discounts', ['id = ?', $discount->id]);
            $db->delete('pmt2core_touristic_option_discount_scales', ['id_touristic_option_discount = ?', $discount->id]);
            $optionDiscount = new Touristic\Option\Discount();
            $optionDiscount->fromStdClass($discount);
            $optionDiscount->create();
            unset($optionDiscount);
        }
    }

    /**
     * @return false|void
     * @throws Exception
     */
    public function importInsurances(){

        /** @var \Pressmind\DB\Adapter\Pdo $db */
        $db = Registry::getInstance()->get('db');

        $insurance_group = new Touristic\Insurance\Group();
        $insurance = new Touristic\Insurance();
        $insurance_to_group = new Touristic\Insurance\InsuranceToGroup();
        $price_table = new Touristic\Insurance\PriceTable();
        $insurance_to_insurance = new Touristic\Insurance\InsuranceToInsurance();
        $price_table_package = new Touristic\Insurance\Package();
        $price_table_to_package = new Touristic\Insurance\PriceTableToPackage();
        $insurance_to_attribute = new Touristic\Insurance\InsuranceToAttribute();
        $insurance_attribute = new Touristic\Insurance\Attribute();

        $db->truncate($insurance_group->getDbTableName());
        $db->truncate($insurance->getDbTableName());
        $db->truncate($insurance_to_group->getDbTableName());
        $db->truncate($price_table->getDbTableName());
        $db->truncate($insurance_to_insurance->getDbTableName());
        $db->truncate($price_table_package->getDbTableName());
        $db->truncate($price_table_to_package->getDbTableName());
        $db->truncate($insurance_to_attribute->getDbTableName());
        $db->truncate($insurance_attribute->getDbTableName());

        $this->_log[] = Writer::write($this->getTimeAndHeap() . __CLASS__ . ': Import of external (insurances) data', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
        $result_insurance_groups = $this->_fetchJSON($this->_endpoint_insurances.'?client='.IBETEAM_CLIENT);
        if(empty($result_insurance_groups)){
            echo 'insurance groups are empty';
            return false;
        }

        // loop trough each insurance

        if(count($result_insurance_groups) > 100){
            echo 'to many insurance groups detected';
            return false;
        }



        foreach($result_insurance_groups as $insurance_group) {
            foreach($insurance_group->insurances as $insurance){
                foreach($insurance->price_tables as $price_table){
                    unset($price_table->id_insurance);
                }
            }
        }



        foreach($result_insurance_groups as $insurance_group) {
            $group = new Touristic\Insurance\Group();
            $group->fromStdClass($insurance_group);
            $group->create();
        }


        $this->_log[] = Writer::write($this->getTimeAndHeap() . __CLASS__ . ': Import of external (insurances price table packages) data', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
        $result_price_table_packages = $this->_fetchJSON($this->_endpoint_insurance_price_table_packages.'?client='.IBETEAM_CLIENT, false);
        if(!empty($result_price_table_packages)){
            foreach($result_price_table_packages as $result_price_table_package) {
                $package = new Touristic\Insurance\Package();
                $package->fromStdClass($result_price_table_package);
                // @TODO diese Loop ist eigentlich nicht notwendig, allerdings werden die DS neu angelegt,
                // obwohl nur in die Verknüpfungen erzeugt werden sollen... M. Graute...
                foreach($package->price_tables as $key => $price_table){
                    $priceTable = new Touristic\Insurance\PriceTable($price_table->id);
                    $package->price_tables[$key] = $priceTable;
                }

                $package->create();
            }
        }else{
            $this->_log[] = Writer::write($this->getTimeAndHeap() . __CLASS__ . ': insurance price table packages are not defined', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);
        }
    }

    public function importStartingPoints(){
        /** @var \Pressmind\DB\Adapter\Pdo $db */
        $db = Registry::getInstance()->get('db');
        // Import Starting Points
        $startingpoint = new Touristic\Startingpoint();
        $startingpoint_options = new Touristic\Startingpoint\Option();
        $startingpoint_option_zip_range = new Touristic\Startingpoint\Option\ZipRange();
        $db->truncate($startingpoint->getDbTableName());
        $db->truncate($startingpoint_options->getDbTableName());
        $db->truncate($startingpoint_option_zip_range->getDbTableName());

        $this->_log[] = Writer::write($this->getTimeAndHeap() . __CLASS__ . ': Import of external (starting points) data', Writer::OUTPUT_BOTH, 'import', Writer::TYPE_INFO);


        $result_startingPoints = $this->_fetchJSON($this->_endpoint_startingPoints.'?client='.IBETEAM_CLIENT);
        foreach($result_startingPoints as $point){
            $startingpoint = new Touristic\Startingpoint();
            $startingpoint->fromStdClass($point);
            $startingpoint->create();
        }
    }

    public function getLog()
    {
        return $this->_log;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function getWarnings()
    {
        return $this->_warnings;
    }

}
