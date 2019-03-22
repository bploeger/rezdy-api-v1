<?php
namespace Rezdy\Requests;

use Carbon\Carbon;

/**
 * Super class for all Requests
 *
 * @package Resources
 * @author Brad Ploeger
 */
abstract class BaseRequest {
	
    protected $requiredParams = array();
    protected $optionalParams = array();
    private $error = array();

    /**
     * Get the requested value from an array, or return the default
     * @param array $array - array to search for the provided array key
     * @param string $item - array key to look for
     * @param string $default - value to return if the item is not found, default is null
     * @return mixed
     */
    protected static function getValue(array $array, $item, $default = null) {
        return (isset($array[$item])) ? $array[$item] : $default;
    }

    // Builds the Resource from an Array Provided
    protected function buildFromArray($params = array()) {
         if (is_array($params) && sizeof($params)) {
            foreach ($params as $param => $value) {                
                // Verify the parameter is acceptable for the object
                if ((sizeof($this->requiredParams) && array_key_exists($param, $this->requiredParams)) || array_key_exists($param, $this->optionalParams) ) {                  
                    //Set the Paramater
                    $this->$param = $value; 
                }               
            }   
        }
    } 

    // Sets a Resource parameter from a Key-Value pair
    protected function setValue($param, $value) {
       //Verify the parameter is acceptable for the object
       if ((sizeof($this->requiredParams) && array_key_exists($param, $this->requiredParams)) || array_key_exists($param, $this->optionalParams) ) {                  
                    //Set the Paramater
                    $this->$param = $value; 
        }  
    } 

    // Verify the Resource Params
    public function verifyParams() {  
        // Verify the Required Params and their type
        foreach ($this->requiredParams as $param => $type) {            
            // Verify The Resource has the required param
            if(!isset($this->$param)) { 
                 $this->error[] = $this->$param . 'IS A REQUIRED VALUE';
            }
            $this->checkType($param, $type);
        }
        // Check for optional params and their type
        foreach ($this->optionalParams as $param => $type) {            
            // Check if the Resource has an optional param
            if(isset($this->$param)) {                
                
                // Check the param to ensure it is the valid type
                $this->checkType($param, $type);
            }                   
        }
    }

    protected function checkType($param, $type) {
        
        // Parse the type required
        switch ($type) {
                // Verify the data is a string
                case 'string':
                    if(!is_string($this->$param)) { 
                        $this->error[] = $this->$param . ' IS NOT A STRING';
                    }
                    break;  

                // Verify the data is a integer
                case 'integer':
                    if(!is_int($this->$param)) {                         
                        //Try to Fix the Issue
                        $param = intval($this->$param);                        
                        if (is_int($param)) {
                            //Fix the Value
                            $this->$param = $param;                        
                        } else {
                           // It Cannot be Fixed
                           $this->error[] = $this->$param . ' IS NOT AN INTEGER'; 
                       }                        
                    }
                    break;  

                // Verify the data is boolean
                case 'boolean':
                    if(!is_bool($this->$param)) { 
                        $this->error[] = $this->$param . ' IS NOT AN BOOLEAN';
                    }
                    break;  

                // Verify the data is numeric
                case 'numeric':
                    if(!is_numeric($this->$param)) { 
                        $this->error[] = $this->$param . ' IS NOT NUMERIC';
                    }
                    break;  

                // Verify the data is the ISO8601 Format
                case 'ISO8601':
                    
                    // Verify it is a String First
                    if(!is_string($this->$param)) { 
                        $this->error[] = $this->$param . ' IS NOT A STRING';
                    }
                    // Parse it with Carbon
                    $dateTime = Carbon::parse($this->$param);
                    // Was the date time object created
                    if ($dateTime) {   
                        //Check to make sure the Param is in the proper format (eg. '2019-03-01T12:30:00Z' )
                        if (!(  $dateTime->toIso8601ZuluString() === $this->$param)) {
                            // Try to Fix the Input
                            $newParam = $dateTime->toIso8601ZuluString();
                            // Check Again
                            if ((  $dateTime->toIso8601ZuluString() === $newParam)) {
                                //Fix it
                                $this->$param = $newParam;                                
                            } else {
                                $this->error = $this->$param . ' IS NOT IN THE PROPER ISO8601 FORMAT';
                            }                          
                        }

                    } else {
                        // the string was able to be parsed and is invalid
                        $this->error[] = $this->$param . ' COULD NOT BE PARSED';
                    }

                    break;  

                case 'date-time':
                    // Verify it is a String First
                    if(!is_string($this->$param)) { 
                        $this->error[] = $this->$param . ' IS NOT A STRING';
                    }
                    // Parse it with Carbon
                    $dateTime = Carbon::parse($this->$param);
                    // Was the Carbon object created
                    if ($dateTime) {    
                        // Check to make sure the Param is in the proper format (eg. '2019-03-01 12:30:00' )
                        if (!(  $dateTime->toDateTimeString() === $this->$param)) {                            
                            // Try to Fix the Input
                            $newParam = $dateTime->toDateTimeString();
                            // Check Again
                            if ((  $dateTime->toDateTimeString() === $newParam)) {
                                // Fix it
                                $this->$param = $newParam;
                            } else {
                                // the the value is invalis
                                $this->error[] = $this->$param . ' IS NOT IN THE PROPER DATE-TIME FORMAT';                             
                            }
                        }
                    } else {
                        // The string was able to be parsed and is invalid
                        $this->error[] = $this->$param . ' COULD NOT BE PARSED';
                    }
                    break;

                case 'priceOptionArray':
                    if(!is_array($this->$param)) { 
                        $this->error[] = $this->$param . ' IS NOT AN ARRAY';
                    }
                    foreach ($this->$param as $obj) {
                        if (get_class($obj) !== 'Rezdy\Resources\PriceOption') {
                            $this->error[] = $this->$param . ' IS NOT A PRICE OPTION CLASS';
                        }
                    }
                    break;  

                case 'enum-field-type':
                    // Clean the Input
                    $this->$param = ucwords($this->$param);
                    // Acceptable Field Types
                    $acceptable_field_types = [ 'String', 
                                                'List', 
                                                'Boolean', 
                                                'Phone', 
                                                'Date'
                                            ];                        
                        if (!in_array($this->$param, $acceptable_field_types)) {
                            $this->error[] = $this->$param . ' DOES NOT HAVE AN ACCEPTABLE FIELD VALUE';
                        }
                    break;  

                case 'enum-voucher-value-type':
                    // Clean the Input
                    $this->$param = strtoupper($this->$param);
                    // Acceptable Field Types
                    $acceptable_field_types = [ 'VALUE_LIMITPRODUCT',
                                                'VALUE',
                                                'VALUE_LIMITCATALOG',
                                                'PERCENT_LIMITPRODUCT',
                                                'PERCENT',
                                                'PERCENT_LIMITCATALOG',
                                                'PRODUCT'
                                            ];                        
                        if (!in_array($this->$param, $acceptable_field_types)) {
                            $this->error[] = $this->$param . ' DOES NOT HAVE AN ACCEPTABLE VOUCHER VALUE TYPE';
                        }
                    break;  

                case 'enum-voucher-status':
                    // Clean the Input
                    $this->$param = strtoupper($this->$param);
                    // Acceptable Field Types
                    $acceptable_field_types = [ 'ISSUED',
                                                'REDEEMED',
                                                'PARTIALLY_REDEEMED',
                                                'EXPIRED'
                                            ];                        
                        if (!in_array($this->$param, $acceptable_field_types)) {
                            $this->error[] = $this->$param . ' DOES NOT HAVE AN ACCEPTABLE VOUCHER VALUE TYPE';
                        }
                    break;  

                case 'enum-credit-card-type':
                    // Clean the Input
                    $this->$param = strtoupper($this->$param);
                    // Acceptable Field Types
                    $acceptable_field_types = [ 'VISA',
                                                'MASTERCARD',
                                                'AMEX',
                                                'DINERS',
                                                'DISCOVER',
                                                'JCB'
                                            ];                        
                        if (!in_array($this->$param, $acceptable_field_types)) {
                            $this->error[] = $this->$param . ' DOES NOT HAVE AN ACCEPTABLE CREDIT CARD TYPE VALUE';
                        }
                    break;  

                case 'enum-gender':
                    // Clean the Input
                    $this->$param = strtoupper($this->$param);
                    // Acceptable Field Types
                    $acceptable_field_types = [ 'MALE',
                                                'FEMALE'
                                            ];                        
                        if (!in_array($this->$param, $acceptable_field_types)) {
                            $this->error[] = $this->$param . ' DOES NOT HAVE AN ACCEPTABLE CUSTOMER GENDER VALUE';
                        }
                    break;  

                case 'enum-title':
                    // Clean the Input
                    $this->$param = strtoupper($this->$param);
                    // Acceptable Field Types
                    $acceptable_field_types = [ 'MR',
                                                'MS',
                                                'MRS',
                                                'MISS'
                                            ];                        
                        if (!in_array($this->$param, $acceptable_field_types)) {
                            $this->error[] = $this->$param . ' DOES NOT HAVE AN ACCEPTABLE CUSTOMER TITLE VALUE';
                        }
                    break;  

                case 'enum-extra-price-type':
                    // Clean the Input
                    $this->$param = strtoupper($this->$param);
                    // Acceptable Field Types
                    $acceptable_field_types = [ 'ANY',
                                                'FIXED',
                                                'QUANTITY'
                                            ];                        
                        if (!in_array($this->$param, $acceptable_field_types)) {
                            $this->error[] = $this->$param . ' DOES NOT HAVE AN ACCEPTABLE EXTRA PRICE TYPE VALUE';
                        }
                    break; 

                case 'enum-online-payment-options':
                    // Clean the Input
                    $this->$param = strtoupper($this->$param);
                    // Acceptable Field Types
                    $acceptable_field_types = [ 'CREDITCARD',
                                                'PAYPAL',
                                                'BANKTRANSFER',
                                                'CASH',
                                                'INVOICE',
                                                'EXTERNAL',
                                                'ALIPAY'
                                            ];                        
                        if (!in_array($this->$param, $acceptable_field_types)) {
                            $this->error[] = $this->$param . ' DOES NOT HAVE AN ACCEPTABLE EXTRA PRICE TYPE VALUE';
                        }
                    break;   

                case 'enum-currency-types':
                    // Clean the Input
                    $this->$param = strtoupper($this->$param);
                    // Acceptable Field Types
                    $acceptable_field_types = [   'AED','ANG','ARS','AUD','AWG','AZN','BGN',
                                                  'BHD','BOB','BRL','BYR','CAD','CHF','CLP',
                                                  'CNY','COP','CZK','DKK','EGP','EUR','FJD',
                                                  'GBP','GEL','HKD','HRK','HUF','IDR','ILS',
                                                  'INR','ISK','JOD','JPY','KES','KRW','KWD',
                                                  'KZT','LTL','LVL','MAD','MKD','MUR','MXN',
                                                  'MYR','NGN','NOK','NZD','PGK','PHP','OMR',
                                                  'PEN','PLN','PYG','QAR','RON','RSD','RUB',
                                                  'SAR','SBD','SEK','SGD','SRD','SYP','THB',
                                                  'TOP','TRY','TWD','UAH','USD','UYU','VEF',
                                                  'VUV','WST','XAF','XOF','XPF','YER','ZAR',
                                                  'AFA','ALL','DZD','AMD','BSD','BDT','BBD',
                                                  'BZD','BMD','BWP','BND','BIF','KHR','CVE',
                                                  'KYD','KMF','BAM','CRC','CUP','CYP','DJF',
                                                  'DOP','XCD','ECS','SVC','ERN','EEK','ETB',
                                                  'FKP','CDF','GMD','GHS','GIP','GTQ','GNF',
                                                  'GWP','GYD','HTG','HNL','IRR','IQD','JMD',
                                                  'AOA','KGS','KIP','LAK','LBP','LRD','LYD',
                                                  'LSL','MOP','MGF','MGA','MWK','MVR','MTL',
                                                  'MRO','MDL','MNT','MZM','MMK','NAD','NPR',
                                                  'NIO','KPW','PKR','PAB','RWF','STD','SCR',
                                                  'SLL','SKK','SIT','SOS','LKR','SHP','SDD',
                                                  'SZL','TJS','TZS','TTD','TND','TMM','UGX',
                                                  'UZS','VND','YUM','ZMK','ZWD','AFN','MZN',
                                                  'UYI','ZMW','GHC','GGP','IMP','JEP','TRL',
                                                  'TVD'];                        
                        if (!in_array($this->$param, $acceptable_field_types)) {
                            $this->error[] = $this->$param . ' DOES NOT HAVE AN ACCEPTABLE CURRENCY TYPE VALUE';
                        }
                    break;

                case 'enum-payment-recipient':
                    // Clean the Input
                    $this->$param = strtoupper($this->$param);
                    // Acceptable Field Types
                    $acceptable_field_types = [ 'SUPPLIER',
                                                'RESELLER',
                                                'REZDY'
                                            ];                        
                        if (!in_array($this->$param, $acceptable_field_types)) {
                            $this->error[] = $this->$param . ' DOES NOT HAVE AN ACCEPTABLE PAYMENT RECIPIENT TYPE VALUE';
                        }
                    break;     

                case 'enum-source':
                    // Clean the Input
                    $this->$param = strtoupper($this->$param);
                    // Acceptable Field Types
                    $acceptable_field_types = [ 'ONLINE', 
                                                'INTERNAL', 
                                                'PARTNERS', 
                                                'COMMUNITY', 
                                                'MARKETPLACE', 
                                                'MARKETPLACE_PREF_RATE', 
                                                'API' 
                                            ];                        
                        if (!in_array($this->$param, $acceptable_field_types)) {
                            $this->error[] = $this->$param . ' DOES NOT HAVE AN ACCEPTABLE SOURCE TYPE VALUE';
                        }
                    break;  

                case 'enum-status':
                    // Clean the Input
                    $this->$param = strtoupper($this->$param);
                    // Acceptable Field Types
                    $acceptable_field_types = [ 'PROCESSING', 
                                                'NEW', 
                                                'ON_HOLD', 
                                                'PENDING_SUPPLIER', 
                                                'PENDING_CUSTOMER', 
                                                'CONFIRMED', 
                                                'CANCELLED',
                                                'ABANDONED_CART' 
                                            ];                        
                        if (!in_array($this->$param, $acceptable_field_types)) {
                            $this->error[] = $this->$param . ' DOES NOT HAVE AN ACCEPTABLE SOURCE TYPE VALUE';
                        }
                    break;       

                default:
                    // The value type is not on our list
                    $this->error[] = $this->type . ' IS NOT A VALID TYPE FOR ' . $this->param;
                    break;
            }
    }

    public function isValidRequest() {
        $this->verifyParams();
        if (sizeof($this->error)) {
            return false;
        } else {
            return true;
        }
    }

    public function getError() {
        return json_encode($this->error);
    }
}