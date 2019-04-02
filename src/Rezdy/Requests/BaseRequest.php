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
                            'booking-modes'         =>  [   'NO_DATE','DATE_ENQUIRY','INVENTORY'                                              ],
                            
                            'credit-card-type'      =>  [   'VISA', 'MASTERCARD', 'AMEX', 'DINERS','DISCOVER', 'JCB'                          ],

                            'commission-type'       =>  [   'NET_RATE','PERCENT'                                                              ],
                            
                            'confirm-modes'         =>  [   'MANUAL','AUTOCONFIRM','MANUAL_THEN_AUTO','AUTO_THEN_MANUAL'                      ],

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

                            'tag-types'             =>  [   'TYPE','CATEGORY','INTEREST','INTENSITY','SKILL_LEVEL','AGE','ACCESSIBILITY',
                                                            'SUITABILITY'                                                                     ],

                            'tag-values'            =>  [   'TYPE'          => ['ATTRACTION','TOUR','ACTIVITY','RENTAL','EVENT','LESSON',
                                                                                'TICKET','TRANSPORT'                                          ],

                                                            'CATEGORY'      => ['ABSEILING','ACCOMMODATION PACKAGE','ACTIVE_TOURS',
                                                                                'ADVENTURE_TOURS','AEROBATIC_FLIGHTS','ANIMAL_EXPERIENCES',
                                                                                'AQUARIUM_&_ZOO','ARCHERY','ART_&_CRAFT_CLASSES','ATTRACTION',
                                                                                'BACKPACKERS_TOURS','BALLOON_FLIGHTS','BEER_TOURS',
                                                                                'BICYCLE_RENTALS','BOAT_DAY_TRIPS','BREWERY_TOURS',
                                                                                'BRIDGE_CLIMBING','BUNGEE_JUMPING','BUS_TOURS','BUSHWALKING',
                                                                                'CAMPING','CANOEING','CANYONING','CAR_RENTAL','CAVING',
                                                                                'CHARTER_BOAT','CITY_BUS_TOURS','CITY_TOURS','CLIMBING',
                                                                                'COACH_TOURS','COOKING_LESSONS','CORPORATE','CRUISES',
                                                                                'CULTURAL_TOURS','CYCLING_TOURS','DANCE_CLASSES','DAY_TOURS',
                                                                                'DISTILLERY_TOURS','DIVING','DOG_MUSHING',
                                                                                'DRIVING_GUIDED_TOURS','ECO-TOURS','ESCAPE_ROOM','EXCURSION',
                                                                                'EXTREME_FLYING','EXTREME_SPORTS','FAMILY_FUN','FARM_TOURS',
                                                                                'FERRY','FESTIVAL','FISHING','FITNESS','FLIGHT_SIMULATOR',
                                                                                'FLYING_FOX','FLYING_LESSONS','FOOD_TOURS',
                                                                                'FOUR_WHEEL_DRIVE_TOURS','GARDEN_TOURS','GHOST_TOURS',
                                                                                'GLIDING','GO-KARTING','GOLF_LESSONS_&_ROUNDS','GOLFING',
                                                                                'GORGE_WALKING','GOURMET_TOURS','GUIDED_TOURS','HARLEY_RIDES',
                                                                                'HELICOPTER_FLIGHTS','HIGH_ROPES_COURSE','HIKING_&_TREKKING',
                                                                                'HISTORIC_TOURS','HORSE_RIDING','HOT_AIR_BALLOONING',
                                                                                'JET_FIGHTER','JET_SKIING','JETBOAT','JOY_FLIGHTS','KAYAKING',
                                                                                'KITESURFING','LASER_SHOOTING','LUXURY','LUXURY_CAR',
                                                                                'MARTIAL_ARTS','MOTORBIKE_TOURS','MOUNTAIN_BIKING',
                                                                                'MULTI-SPORT_TOURS','MUSEUM','MUSIC_EXPERIENCES','OFF_ROAD',
                                                                                'OUTDOOR_EVENTS','PAINTBALL','PARAGLIDING','PARASAILING',
                                                                                'PERSONAL_CHEF','PERSONALISED_GIFTS','PHOTOGRAPHY_LESSONS',
                                                                                'PHOTOGRAPHY_TOURS','PRIVATE_TOURS','PUB_TOURS','QUAD_BIKING',
                                                                                'RACE_CAR_DRIVING','RAFTING','RALLY_DRIVING','ROMANTIC_DINING',
                                                                                'SAFARIS','SAILING','SCENIC_FLIGHTS','SCENIC_TOURS',
                                                                                'SCUBA_DIVING_&_SNORKELING','SEAPLANE_FLIGHTS','SEGWAYS',
                                                                                'SELF-DRIVING','SHOOTING','SHOPPING_TOURS','SHUTTLE',
                                                                                'SIGHTSEEING','SKATING','SKIING_&_SNOW','SKYDIVING',
                                                                                'SMALL_GROUP_TOURS','SPIRIT_TASTING','SPORTING_ATTRACTIONS',
                                                                                'SPORTS_TOURS','STAND_UP_PADDLEBOARDING','STEAM_TRAINS',
                                                                                'STUNT_DRIVING','SURFING','SWIM_WITH_DOLPHINS','TEAM_BUILDING',
                                                                                'TENNIS','THEME_PARKS','TIGER_MOTH','V8_CAR_RACING',
                                                                                'V8_EXPERIENCES','VIRTUAL_REALITY','WALKING_TOURS',
                                                                                'WATER_SPORT','WHALE_&_DOLPHIN WATCHING','WHITE_WATER_RAFTING',
                                                                                'WILDLIFE_TOURS','WILDLIFE_WATCHING','WINDSURFING',
                                                                                'WINE_TASTING','WINTER_SPORTS','YOGA_&_PILATES','ZIPLINING',
                                                                                'ZORBING'                                                      ],

                                                            'INTEREST'       => ['FAMILY','CULTURAL','SIGHTSEEING','LIFESTYLE','LUXURY',
                                                                                 'RELAXATION','ROMANCE','SPECIAL_INTEREST','ECOTOURISM',
                                                                                 'VOLUNTOURISM'                                                ],
                                                            
                                                            'INTENSITY'      => ['RELAXED','QUIET','ACTIVE','SPORTY','EXTREME'                 ],
                                                            
                                                            'SKILL_LEVEL'    => ['BEGINNER','INTERMEDIATE','ADVANCED','EXPERT'                 ],
                                                            
                                                            'AGE'            => ['ADULT','INFANT','CHILD','TEENAGER','SENIOR'                  ],
                                                            
                                                            'ACCESSIBILITY'  => ['VISION_IMPAIRED','HEARING_IMPAIRED','PARAPLEGIC',
                                                                                 'QUADRIPLEGIC','EPILEPTIC','ASTHMATIC'                        ],

                                                            'SUITABILITY'    => ['ANY_WEATHER','DAY_TIME','NIGHT_TIME','FAMILY','GIFT_VOUCHER',
                                                                                 'GROUPS','ONLY_ADULTS','ONLY_MEN','ONLY_WOMEN','SCHOOLS'      ],
                                                                                                                                               ],

                            'title'                 =>  [   'MR','MS','MRS','MISS'                                                             ], 

                            'voucher-status'        =>  [   'ISSUED','REDEEMED','PARTIALLY_REDEEMED','EXPIRED'                                 ], 

                            'voucher-value-type'    =>  [   'VALUE_LIMITPRODUCT','VALUE','VALUE_LIMITCATALOG','PERCENT_LIMITPRODUCT',
                                                            'PERCENT','PERCENT_LIMITCATALOG','PRODUCT'                                         ],  
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

            if ($class == 'Rezdy\Requests\Objects\PickupLocation') {
                $data->isValid();
            }

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

    public function wasSuccessful() {
        return false;
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
                 $this->error[] = $param . ' is a required value';
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

        $lookup = $explode[0];

        if (isset($this->$param)) {
            
            // Parse the type required
            switch ($lookup) {
                
                // Verify the data is a string
                case 'string':
                    if(!is_string($this->$param)) { 
                        $this->setError($param . ' is not a string');
                    }
                    if (isset($explode[1])) {
                        $range = explode('-', $explode[1]);
                        
                        if (strlen ($this->$param) < $range[0] || strlen ($this->$param) > $range[1]) {
                            $this->setError($param . ' must contain between ' . $range[0] . ' and ' . $range[1] . 'characters');
                        }                       
                    }
                    break; 

                // Verify the data is a string or an array of strings
                case 'string-or-array':
                    if( is_string($this->$param) ) {                        
                        // Is a STRING and PASSES                    
                    } elseif( is_array($this->$param) ) {
                        // Is an ARRAY, verify the array contents
                        foreach ($this->$param as $item) {
                            if(!is_string($item)) {
                                $this->setError($param . ' is not an array of strings');
                            }
                        }
                    } else {
                        // DOES NOT PASS
                        $this->setError($param . ' is not a string or array');
                    }
                    break;  

                // Verify the data is a integer or an array of integers
                case 'integer-or-array':
                    if( is_integer($this->$param) ) {                        
                        // Is a integer and passes                    
                    } elseif( is_array($this->$param) ) {
                        // Is an ARRAY, verify the array contents
                        foreach ($this->$param as $item) {
                            if( !is_integer($item) ) {
                                $this->setError($param . ' is not an array of integers');
                            }
                        }
                    } else {
                        // DOES NOT PASS
                        $this->setError($param . ' is not a integer or array');
                    }
                    break;  

                // Verify the data is an array of strings
                case 'array-of-string':
                    if( is_array($this->$param) ) {
                        // Is an ARRAY, verify the array contents
                        foreach ($this->$param as $item) {
                            if(!is_string($item)) {
                                $this->setError($param . ' is not an array of strings');
                            }
                        }
                    } else {
                        // Not an Array
                        $this->setError($param . ' is not an array of strings');
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
                           $this->setError($param . ' is not an integer'); 
                       }

                       //Handle Ranges
                       if (isset($explode[1])) {
                        $range = explode('-', $explode[1]);
                        
                        if ($this->$param <= $range[0] || $this->$param >= $range[1]) {
                                $this->setError($param . ' must have a value between ' . $range[0] . ' and ' . $range[1]);
                            }                       
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
                            $this->setError($param . ' is not a boolean');
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
                            $this->setError($param . ' is not numeric');
                        }
                    }
                    break;  

                // Verify the data is the ISO8601 Format
                case 'ISO8601':
                    // Verify it is a String First
                    if(!is_string($this->$param)) { 
                        $this->error[] = $param . ' is not a string';
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
                                $this->setError($param . ' is not in the proper format [YYYY-MM-DDTHH:MM:SSZ]');
                            }                          
                        }

                    } else {
                        // the string was able to be parsed and is invalid
                        $this->setError($param . ' could not be parsed');
                    }

                    break;  

                case 'date-time':
                    // Verify it is a String First
                    if(!is_string($this->$param)) { 
                        $this->setError($param . ' is not a string');
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
                                $this->setError($param . ' is not in the proper format [YYYY-MM-DD HH:MM:SS]');                             
                            }
                        }
                    } else {
                        // The string was able to be parsed and is invalid
                        $this->setError($param . ' could not be parsed');
                    }
                    break;

                case 'priceOptionArray':
                    if(!is_array($this->$param)) { 
                        $this->setError($param . ' is not a price option array');
                    }
                    foreach ($this->$param as $obj) {
                        if (get_class($obj) !== 'Rezdy\Requests\Availability\PriceOption') {
                            $this->setError($param . ' is not a price option class');
                        }
                    }
                    break; 

                // Verify the data is a string with a properly formatted tag or an array of tags
                case 'tag-or-array':
                    if( is_string($this->$param) ) {                        
                        // Is a string Verify the Tags
                        $tag = explode(':', $this->$param);
                        if (count($tag) != 2) {
                            $this->setError($param . ' the Tag is not formatted properly [TAGTYPE:TAGEVALUE]');                            
                        } else {
                            // Load the Tag Type Values
                            $acceptable_tag_types = $this->enumFields['tag-types'];
                            
                            if (!in_array($tag[0], $acceptable_tag_types)) {
                                    $this->setError($tag[0] . ' is not a valid Tag Type.');
                            } else {
                                // Load the Tag Values
                                $acceptable_tag_values = $this->enumFields['tag-values'][$tag[0]];
                                if (!in_array($tag[1], $acceptable_tag_values)) {
                                    $this->setError($tag[1] . ' is not a valid Tag Value for ' . $tag[0] .'.');
                                }
                            }
                        }                 
                    } elseif( is_array($this->$param) ) {
                        // Is an ARRAY, verify the array contents
                        foreach ($this->$param as $item) {
                            if( !is_string($item) ) {
                                $this->setError($param . ' is not an array of tag values');
                            } else {
                                // Is a string Verify the Tags
                                $tag = explode(':', $item);
                                if (count($tag) != 2) {
                                    $this->setError($param . ' the Tag is not formatted properly [TAGTYPE:TAGEVALUE]');                            
                                } else {
                                    // Load the Tag Type Values
                                    $acceptable_tag_types = $this->enumFields['tag-types'];
                                    
                                    if (!in_array($tag[0], $acceptable_tag_types)) {
                                            $this->setError($tag[0] . ' is not a valid Tag Type.');
                                    } else {
                                        // Load the Tag Values
                                        $acceptable_tag_values = $this->enumFields['tag-values'][$tag[0]];
                                        if (!in_array($tag[1], $acceptable_tag_values)) {
                                            $this->setError($tag[1] . ' is not a valid Tag Value for ' . $tag[0] .'.');
                                        }
                                    }
                                }    
                            }
                        }
                    } else {
                        // DOES NOT PASS
                        $this->setError($param . ' in not formatted properly [TAGTYPE:TAGEVALUE]');
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
                $this->hadError = true;
            }
        } 
        $this->error[] = $error;
        $this->hadError = true;
    }       
}