<?php
namespace Pressmind\Travelshop;

use Pressmind\ORM\Object\CheapestPriceSpeed;

class IB3Tools{

    /**
     * Build the booking linked based on several parameters
     * @param CheapestPriceSpeed $CheapestPriceSpeed
     * @param string $url for history back link
     * @param string $dc discount code
     * @param string $booking_type enum(request,option,fix) or null ('fix' is the ib3 default value)
     * @param bool $dont_hide_options prevent hiding the housing option dialog
     * @return string
     */
   public static function get_bookinglink($CheapestPriceSpeed, $url = null, $dc = null, $booking_type = null, $dont_hide_options = false): string
   {

       $p = [];
       $p[] = 'imo='.$CheapestPriceSpeed->id_media_object;
       $p[] = 'idbp='.$CheapestPriceSpeed->id_booking_package;
       $p[] = 'idd='.$CheapestPriceSpeed->id_date;

       /* @TODO not supported anymore?
       if(!empty($CheapestPriceSpeed->id_housing_package)){
           $p[] = 'idhp='.$CheapestPriceSpeed->id_housing_package;
       }
       */

       // @TODO: possible improvement: set more than one housing_options here (with there amount)
       if(!empty($CheapestPriceSpeed->id_option)) {
           $p[] = 'iho[' . $CheapestPriceSpeed->id_option . ']=1';
       }

       if($dont_hide_options === true){
           $p[] = 'hodh=1';
       }

       if(!empty($CheapestPriceSpeed->transport_type)){
           $p[] = 'idt1='.$CheapestPriceSpeed->id_transport_1;
           $p[] = 'idt2='.$CheapestPriceSpeed->id_transport_2;
           $p[] = 'tt='.$CheapestPriceSpeed->transport_type;
       }

       if(!is_null($dc)){
           $p[] = 'dc='.$dc;
       }

       if(!is_null($booking_type)){
           $p[] = 't='.$booking_type;
       }

       if(!is_null($url)){
           $p[] = 'url='.base64_encode($url);
       }
       return trim(TS_IBE3_BASE_URL, '/').'/?'.implode('&', $p);

   }

    /**
     * This function checks the availibilty for the given offer configuration
     * trough the pressmind ib3 from the connected crs.
     * The result is a 1:1 representation of the external crs result.
     * So be aware, there are much possible result messages.
     * @param string $date_code_ibe
     * @param string[] $options_code_ibe
     */
   public static function checkAvailability($date_code_ibe, $options_code_ibe){
       $url = trim(TS_IBE3_BASE_URL, '/').'/api/external/availability';
       $Object = new \stdClass();
       $Object->id = $date_code_ibe;
       $Object->options = $options_code_ibe;
       $data_string = json_encode($Object);
       $ch = curl_init($url);
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
       curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
       curl_setopt($ch, CURLOPT_HEADER, false);
       curl_setopt($ch, CURLOPT_HTTPHEADER,
           [
               'Content-Type:application/json',
               'Content-Length: ' . strlen($data_string)
           ]
       );
       curl_setopt($ch, CURLOPT_USERAGENT, __CLASS__.':'.__FUNCTION__.' '.SITE_URL);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       $result = curl_exec($ch);
       curl_close($ch);
       $decoded = json_decode($result, true);
       if(json_last_error() > 0){
           return false;
       }
       return $decoded;
   }

    /**
     * This function checks the availibilty for the given offer configuration
     * trough the pressmind ib3 from the connected crs.
     * The result is a 1:1 representation of the external crs result.
     * So be aware, there are much possible result messages.
     * @param string $date_code_ibe
     * @param string $housing_package_code_ibe
     * @param string $return_date
     * @return false|mixed
     */
    public static function checkAvailabilityHotel($date_code_ibe, $housing_package_code_ibe, $return_date){
        $url = trim(TS_IBE3_BASE_URL, '/').'/api/external/availabilityHotel';
        $Object = new \stdClass();
        $Object->id = $date_code_ibe;
        $Object->id_hotel = $housing_package_code_ibe;
        $Object->return_date = $return_date;
        $data_string = json_encode($Object);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            [
                'Content-Type:application/json',
                'Content-Length: ' . strlen($data_string)
            ]
        );
        curl_setopt($ch, CURLOPT_USERAGENT, __CLASS__.':'.__FUNCTION__.' '.SITE_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $decoded = json_decode($result, true);
        if(json_last_error() > 0){
            return false;
        }
        return $decoded;
    }
}
