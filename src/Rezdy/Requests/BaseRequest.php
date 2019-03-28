<?php
namespace Rezdy\Requests;

use Carbon\Carbon;

use Rezdy\Exceptions\RezdyException;

/**
 * Super class for all Requests
 *
 * @package Resources
 * @author Brad Ploeger
 */
abstract class BaseRequest {
	
    protected $requiredParams = [];
    protected $optionalParams = [];

    protected $setClassMap = [];
    protected $addClassMap = [];

    protected $enumFields = [ 
                            'booking-mode'          =>  [   'NO_DATE','DATE_ENQUIRY','INVENTORY'                                              ],
                            
                            'credit-card-type'      =>  [   'VISA', 'MASTERCARD', 'AMEX', 'DINERS','DISCOVER', 'JCB'                          ],

                            'currency-types'        =>  [   'AED','ANG','ARS','AUD','AWG','AZN','BGN','BHD','BOB','BRL','BYR','CAD','CHF','CLP',
                                                            'CNY','COP','CZK','DKK','EGP','EUR','FJD','GBP','GEL','HKD','HRK','HUF','IDR','ILS',
                                                            'INR','ISK','JOD','JPY','KES','KRW','KWD','KZT','LTL','LVL','MAD','MKD','MUR','MXN',
                                                            'MYR','NGN','NOK','NZD','PGK','PHP','OMR','PEN','PLN','PYG','QAR','RON','RSD','RUB',
                                                            'SAR','SBD','SEK','SGD','SRD','SYP','THB','TOP','TRY','TWD','UAH','USD','UYU','VEF',
                                                            'VUV','WST','XAF','XOF','XPF','YER','ZAR','AFA','ALL','DZD','AMD','BSD','BDT','BBD',
                                                            'BZD','BMD','BWP','BND','BIF','KHR','CVE','KYD','KMF','BAM','CRC','CUP','CYP','DJF',
                                                            'DOP','XCD','ECS','SVC','ERN','EEK','ETB','FKP','CDF','GMD','GHS','GIP','GTQ','GNF',
                                                            'GWP','GYD','HTG','HNL','IRR','IQD','JMD','AOA','KGS','KIP','LAK','LBP','LRD','LYD',
                                                            'LSL','MOP','MGF','MGA','MWK','MVR','MTL','MRO','MDL','MNT','MZM','MMK','NAD','NPR',
                                                            'NIO','KPW','PKR','PAB','RWF','STD','SCR','SLL','SKK','SIT','SOS','LKR','SHP','SDD',
                                                            'SZL','TJS','TZS','TTD','TND','TMM','UGX','UZS','VND','YUM','ZMK','ZWD','AFN','MZN',
                                                            'UYI','ZMW','GHC','GGP','IMP','JEP','TRL','TVD'                                   ],

                            'extra-price-type'      =>  [   'ANY','FIXED','QUANTITY'                                                          ],

                            'field-type'            =>  [   'String','List','Boolean','Phone','Date'                                          ],

                            'gender'                =>  [   'MALE','FEMALE'                                                                   ],

                            'online-payment-options'=>  [   'CREDITCARD','PAYPAL','BANKTRANSFER','CASH','INVOICE','EXTERNAL','ALIPAY'         ],

                            'price-group-type'      =>  [   'EACH','TOTAL'                                                                    ],

                            'product-type'          =>  [   'ACTIVITY','DAYTOUR','MULTIDAYTOUR','ENQUIRY','PRIVATE_TOUR','TICKET','RENTAL',
                                                            'CHARTER','EVENT','PASS','HOPONHOPOFF','GIFT_CARD','TRANSFER','LESSON',
                                                            'MERCHANDISE','CUSTOM'                                                            ],

                            'source'                =>  [   'ONLINE','INTERNAL','PARTNERS','COMMUNITY','MARKETPLACE','MARKETPLACE_PREF_RATE', 
                                                            'API'                                                                             ],

                            'status'                =>  [   'PROCESSING','NEW','ON_HOLD','PENDING_SUPPLIER','PENDING_CUSTOMER','CONFIRMED', 
                                                            'CANCELLED','ABANDONED_CART'                                                      ], 

                            'title'                 =>  [   'MR','MS','MRS','MISS'                                                            ], 

                            'voucher-status'        =>  [   'ISSUED','REDEEMED','PARTIALLY_REDEEMED','EXPIRED'                                ], 

                            'voucher-value-type'    =>  [   'VALUE_LIMITPRODUCT','VALUE','VALUE_LIMITCATALOG','PERCENT_LIMITPRODUCT','PERCENT',
                                                            'PERCENT_LIMITCATALOG','PRODUCT'                                                  ],  
                        ];

    // Sets parameter values
    public function set($data, $key = null) {
         // Checks if passed item is an array
        if (is_array($data)) {
            // Recursively process the values
            foreach ($data as $key => $value) {
                $this->set($value, $key);
            }            
        } else {
            // Try set the data provided
            $this->setValue($key, $data);
        }
    }

    public function appendTransferErrors(RezdyException $e) {
        foreach ($e->getErrors() as $error) {
            $this->setError($error->requestStatus->error->errorMessage);
        }        
    }

    public function toJSON() {
        return json_encode($this);
    }

    public function __toString() {        
        return json_encode($this);          
    }

    public function toArray() {      
        // Recast the Object as an array
        $rawArray = (array) $this;

        // Create an empty array for the output 
        $outputArray = array();
    
        // Cycle through the raw array
        foreach ($rawArray as $key => $value) {
            if (array_key_exists($key, $this->requiredParams) || array_key_exists($key, $this->optionalParams)) {
                if (is_array($value)) {
                    foreach ($value as $item) {
                        $outputArray[][$key] = $item;
                    }
                } else {
                    $outputArray[][$key] = $value;
                }                    
            }
        }
        return $outputArray; 
    }

    public function viewErrors() {
        if(is_set($this->error)) {
            return json_encode($this->error);
        } else {
            return '';
        }
    }

    // Attached an item in the Request based on the class of item passed to the function
    public function attach($data) {
        
        // Check if the value passed was an array
        if (is_array($data)) {
            // Go through each item recursively
            foreach ($data as $item) {
                $this->attach($item);
            }       
        } else {
            
            // Check the class of the data passed
            $class = get_class($data);

            // Check if is a single item class
            if (array_key_exists($class, $this->setClassMap)) {
                
                // Use the Lookup Array
                $type = $this->setClassMap[$class];
                
                // Set the value
                $this->$type = $data;
            
            // Check if is a multiple item class
            } elseif(array_key_exists($class, $this->addClassMap)) {
               
                // Use the Lookup Array
                $type = $this->addClassMap[$class];
              
                // Handles a Booking Voucher item which is only an array of strings.
                if ($class == 'Rezdy\Requests\Booking\Voucher') {  
                    
                    // Set the value
                    $this->$type[] = $data->string;         
                } else {
                    
                    // Set the value
                    $this->$type[] = $data;
                }
            }
        }       
    }

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
         if (is_array($params) && count($params)) {
            foreach ($params as $param => $value) {                
                // Verify the parameter is acceptable for the object
                if ( (count($this->requiredParams) && array_key_exists($param, $this->requiredParams) ) || array_key_exists($param, $this->optionalParams) ) {                  
                    //Set the Paramater
                    $this->$param = $value; 
                }               
            }   
        }
    } 

    // Sets a Resource parameter from a Key-Value pair
    protected function setValue($param, $value) {
       //Verify the parameter is acceptable for the object
       if ((count($this->requiredParams) && array_key_exists($param, $this->requiredParams)) || array_key_exists($param, $this->optionalParams) ) {                  
                //Set the Paramater
                $this->$param = $value; 
        }  
    }   

    // Verify the Resource Params
    protected function verifyParams() {  
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

        $explode = explode('|', $type);

        // Parse the type required
        switch ($type) {
                
                // Verify the data is a string
                case 'string':
                    if(!is_string($this->$param)) { 
                        $this->setError($param . ' IS NOT A STRING');
                    }
                    if (isset($explode[1])) {
                        $range = explode('-', $explode[1]);
                        
                        if (strlen ($this->$param) < $range[0] || strlen ($this->$param) > $range[1]) {
                            $this->setError($param . ' must contain between ' . $range[0] . ' and ' . $range[1] . 'characters');
                        }                       
                    }
                    break; 

                // Verify the data is a string and between 100 and 15,000 characters
                case 'string|100-15000':

                    if(!is_string($this->$param)) { 
                        $this->setError($param . ' IS NOT A STRING');
                    
                    } elseif (strlen ($this->$param) < 100) {
                        $this->setError($param . ' IS NOT LONG ENOUGH');
                    
                    } elseif (strlen ($this->$param) > 15000) {
                        $this->setError($param . ' IS TOO LONG');

                    }
                    break; 

                // Verify the data is a string
                case 'string-or-array':
                    if( is_string($this->$param) ) {                        
                        // Is a STRING and PASSES                    
                    } elseif( is_array($this->$param) ) {
                        // Is an ARRAY, verify the array contents
                        foreach ($this->$param as $item) {
                            if(!is_string($item)) {
                                $this->setError($param . ' IS NOT AN ARRAY OF STRINGS');
                            }
                        }
                    } else {
                        // DOES NOT PASS
                        $this->setError($param . ' IS NOT A STRING OR ARRAY');
                    }
                    break;  

                // Verify the data is a integer
                case 'integer':
                    if(!is_int($this->$param)) {                         
                        // Try to fix the issue
                        $newParam = intval($this->$param);                        
                        if (is_int($newParam)) {
                            //Fix the Value
                            $this->$param = $newParam;                        
                        } else {
                           // It Cannot be Fixed
                           $this->setError($param . ' IS NOT AN INTEGER'); 
                       }                        
                    }
                    break;  

                // Verify the data is boolean
                case 'boolean':                

                    if(!is_bool($this->$param)) { 
                        
                        // Try to fix the issue
                        if (strtoupper($this->$param) === 'TRUE' || $this->$param === 1) {
                            // Handles common errors that recasting would not handle properly
                            $this->$param = true;
                        } else {
                            // recast the value
                            $this->$param = false; 
                        } 

                        // Verify the Fix Worked
                        if(!is_bool($this->$param)) {
                            $this->setError($param . ' IS NOT AN BOOLEAN');
                        } 
                    }

                    // Cast Correction to string
                    if (is_bool($this->$param)) {
                        if ($this->$param) {
                            $this->$param = 'true';
                        } else {
                            $this->param = 'false';
                        }
                    } 

                    break;  

                // Verify the data is numeric
                case 'numeric':
                    if(!is_numeric($this->$param)) {                                    
                        //Try and fix the issue
                        $newParam = (float) $this->$param;

                        // Check the fix
                        if (is_numeric($newParam)) {
                            $this->$param = $newParam;
                        } else {
                            $this->setError($param . ' IS NOT NUMERIC');
                        }
                    }
                    break;  

                // Verify the data is the ISO8601 Format
                case 'ISO8601':
                    // Verify it is a String First
                    if(!is_string($this->$param)) { 
                        $this->error[] = $param . ' IS NOT A STRING';
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
                                $this->setError($param . ' IS NOT IN THE PROPER ISO8601 FORMAT');
                            }                          
                        }

                    } else {
                        // the string was able to be parsed and is invalid
                        $this->setError($param . ' COULD NOT BE PARSED');
                    }

                    break;  

                case 'date-time':
                    // Verify it is a String First
                    if(!is_string($this->$param)) { 
                        $this->setError($param . ' IS NOT A STRING');
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
                                $this->setError($param . ' IS NOT IN THE PROPER DATE-TIME FORMAT');                             
                            }
                        }
                    } else {
                        // The string was able to be parsed and is invalid
                        $this->setError($param . ' COULD NOT BE PARSED');
                    }
                    break;

                case 'priceOptionArray':
                    if(!is_array($this->$param)) { 
                        $this->setError($param . ' IS NOT AN PRICE OPTION ARRAY');
                    }
                    foreach ($this->$param as $obj) {
                        if (get_class($obj) !== 'Rezdy\Requests\Availability\PriceOption') {
                            $this->setError($param . ' IS NOT A PRICE OPTION CLASS');
                        }
                    }
                    break;   

                default:
                    $lookup = explode('.', $type);
                    
                    // Handle Value Lists
                    if ($lookup[0] == 'enum' && isset($this->enumFields[$lookup[1]])) {
                        
                        // Load the Acceptable Values
                        $acceptable_field_types = $this->enumFields[$lookup[1]];
                        if (!in_array($this->$param, $acceptable_field_types)) {
                            $this->setError($this->$param . ' is not acceptable value for ' . $param);
                        }

                    } else {
                        // The value type is not on our list
                        $this->setError($type . ' is not a valid datatype');
                    } 
                    break;
            }
    }  

    protected function isValidRequest() {        
        // Verify all the parameters
        $this->verifyParams();

        // Check for Errors        
        return (!isset($this->error));        
    }

    protected function setError($error) {
        if (is_array($error)) {
            foreach ($error as $item) {
                $this->setError($error);
            }
        } 
        $this->error[] = $error;
    }       
}