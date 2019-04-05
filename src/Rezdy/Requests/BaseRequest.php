<?php
namespace Rezdy\Requests;

use Carbon\Carbon;

use Rezdy\Util\Validate;

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

    protected $enumFields = [];

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
            // Verify if the item is a PickupLocation request object
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

    protected function createMappingArray() {
        //Create a Mapping Array of Attachable Items        
        $mapping = array();
        $merged_array = array_merge($this->setClassMap , $this->addClassMap);         
        foreach ($merged_array as $class => $param) {
            $mapping[$param] = $class;
        }
        return $mapping;
    } 
 
    /**
     * Get the requested value from an array, or return the default
     *
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
                // Set the Paramater
                $this->$param = $value; 
        }  
    }   

    public function assemble($response) {        
        // Pull the Class Mapping Array
        $mapping = $this->createMappingArray();
        // Parse the Response
        foreach($response as $key => $data) {                    
            // Check if the Data is an array or object
            if (is_array($data) || is_object($data)) {
                // See if the mapping array has an entry
                if (array_key_exists($key, $mapping)) {
                    //Create the new class instance
                    $subItem = new $mapping[$key];
                    if(is_object($data)) {
                        // Assemble class instance from an object
                        $subItem->assemble( (array) $data);
                        $this->attach($subItem);                        
                    } elseif (is_array($data) && isset($data[0])) {
                        // Assemble class instance from an array
                        $subItem->assemble($data[0]); 
                        $this->attach($subItem);                                                          
                    } 
                }
            } else {
                // Set the Value
                $this->setValue($key, $data);
            }            
        }
    }

    // Verifies the Resource Params
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

        // Clean Up the Request
        $allowed = array_merge($this->requiredParams, $this->optionalParams, $this->createMappingArray());
        foreach ($this as $key => $value) {            
            if (!array_key_exists($key, $allowed)) {
                unset($this->$key);
            }
        }                 
    }

    protected function checkType($param, $type) {
        // Handle ranges
        $explode = explode('|', $type);
        $lookup = $explode[0];
        
        if (isset($explode[1]) && isset($explode[2])) {
            $range = array( (int) $explode[1], (int) $explode[2]);
        } else {
            $range = null;
        }
        
        if (isset($this->$param)) {          
            // Parse the type required
            switch ($lookup) {                
                // Verify the data is a string
                case 'string':
                    Validate::string($this, $param, $range);                    
                    break; 
                // Verify the data is a string or an array of strings
                case 'string-or-array':
                    if( is_string($this->$param) ) {                        
                        Validate::string($this, $param, $range);                    
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
                   if (strtoupper($this->$param) === 'TRUE' || $this->$param == 1) {
                        // Handles common errors that recasting would not handle properly
                        $this->$param = 'true';
                    } else {
                        // Recast the value
                        $this->$param = 'false'; 
                    }   
                    break; 
                // Verify the data is numeric
                case 'numeric':
                    if(!is_numeric($this->$param)) {                                    
                        //Try and fix the issue
                        $newParam = (float) $this->$param;
                        // Check the fix
                        if (is_numeric($newParam)) {
                            // Recast the value
                            $this->$param = $newParam;
                        } else {
                            // Set an error
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
                                // Set an error
                                $this->setError($param . ' is not in the proper format [YYYY-MM-DDTHH:MM:SSZ]');
                            }                          
                        }
                    } else {
                        // the string was able to be parsed and is invalid
                        $this->setError($param . ' could not be parsed');
                    }
                    break;  
                // Verify the data is the date-time Format
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
                // Verify it is an array of SessionPriceOption objects
                case 'priceOptionArray':
                    if(!is_array($this->$param)) { 
                        $this->setError($param . ' is not a price option array');
                    }
                    foreach ($this->$param as $obj) {
                        if (get_class($obj) !== 'Rezdy\Requests\Objects\SessionPriceOption') {
                            // Set an Error
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
                            // Set an Error
                            $this->setError($param . ' the Tag is not formatted properly [TAGTYPE:TAGEVALUE]');                            
                        } else {
                            // Load the Tag Type Values
                            $acceptable_tag_types = $this->enumFields['tag-types'];                            
                            if (!in_array($tag[0], $acceptable_tag_types)) {
                                    // Set an Error
                                    $this->setError($tag[0] . ' is not a valid Tag Type.');
                            } else {
                                // Load the Tag Values
                                $acceptable_tag_values = $this->enumFields['tag-values'][$tag[0]];
                                if (!in_array($tag[1], $acceptable_tag_values)) {
                                    // Set an Error
                                    $this->setError($tag[1] . ' is not a valid Tag Value for ' . $tag[0] .'.');
                                }
                            }
                        }                 
                    } elseif( is_array($this->$param) ) {
                        // Is an ARRAY, verify the array contents
                        foreach ($this->$param as $item) {
                            if( !is_string($item) ) {
                                // Set an Error
                                $this->setError($param . ' is not an array of tag values');
                            } else {
                                // Is a string Verify the Tags
                                $tag = explode(':', $item);
                                if (count($tag) != 2) {
                                    // Set an Error
                                    $this->setError($param . ' the Tag is not formatted properly [TAGTYPE:TAGEVALUE]');                            
                                } else {
                                    // Load the Tag Type Values
                                    $acceptable_tag_types = $this->enumFields['tag-types'];                                    
                                    if (!in_array($tag[0], $acceptable_tag_types)) {
                                            // Set an Error
                                            $this->setError($tag[0] . ' is not a valid Tag Type.');
                                    } else {
                                        // Load the Tag Values
                                        $acceptable_tag_values = $this->enumFields['tag-values'][$tag[0]];
                                        if (!in_array($tag[1], $acceptable_tag_values)) {
                                            // Set an Error
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
                // Handle enums
                default:
                    // Build a new Lookup Array
                    $lookup = explode('.', $type);
                    //Load enumFields
                    $this->enumFields = Validate::enumFields();
                    // Handle Value Lists
                    if ($lookup[0] == 'enum' && isset($this->enumFields[$lookup[1]])) {                        
                        // Load the Acceptable Values
                        $acceptable_field_types = $this->enumFields[$lookup[1]];
                        if (!in_array($this->$param, $acceptable_field_types)) {
                            // Set an Error
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