<?php
namespace Rezdy\Resources;

/**
 * Super class for all resources
 *
 * @package Resources
 * @author Brad Ploeger
 */
abstract class BaseResource {
	
    protected $requiredParams;
    protected $optionalParams;

	 
    public function __construct() {
        if (is_array($params) && sizeof($params)) {
            foreach ($params as $param => $value) {
                
                // Verify the Paramater is Acceptable
                if (array_key_exists($param, $this->requiredParams) || array_key_exists($param, $this->optionalParams) ) {                  
                    //Set the Paramater
                    $this->$param = $value; 
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

    //Verify the Resource Params
    protected function verifyParams() {        
        
        //Verify the Required Params and their type
        foreach ($this->requiredParam as $param => $type) {
            
            // Verify The Resource has the required param
            if(!isset($this->$param) { 
                return false; 
            }

            // Check verify the param is the proper type
            if (!$this->checkType($param, $type)) {
                return false;
            }            
        }

        //Check for optional params and their type
        foreach ($this->optionalParams as $param => $type) {
            
            // Check if the Resource has an optional param
            if(isset($this->$param) {                 
                
                // Check the param to ensure it is the valid type
                if (!$this->checkType($param, $type)) {
                return false;
                }       
            }                   
        }

        // Everything checks out
        return true;
    }

    protected function checkType($param, $type) {
        
        // Parse the type required
        switch ($type) {

                // Verify the data is a string
                case 'string':
                    if(!is_string($this->$param)) { 
                        return false; 
                    }
                    break;  

                // Verify the data is a integer
                case 'integer':
                    if(!is_int($this->$param)) { 
                        return false; 
                    }
                    break;  

                // Verify the data is boolean
                case 'boolean':
                    if(!is_bool($this->$param)) { 
                        return false; 
                    }
                    break;  

                // Verify the data is numeric
                case 'numeric':
                    if(!is_numeric($this->$param)) { 
                        return false; 
                    }
                    break;  

                // Verify the data is the ISO8601 Format
                case 'ISO8601':
                    
                    // Verify it is a String First
                    if(!is_string($this->$param)) { 
                        return false; 
                    }

                    //Make Sure it can be parsed by DateTime
                    $dateTime = \DateTime::createFromFormat(\DateTime::ISO8601, $this->$param);

                    // Was the date time object created
                    if ($dateTime) {                        
                        
                        //Check to make sure the Param is in the proper format (eg. '2019-03-01T12:30:00Z' )
                        if !($dateTime->format('Y-m-d\TH:i:s\Z') === $this->$param) {
                            return false;
                        }

                    } else {

                        // the string was able to be parsed and is invalid
                        return false;
                    }

                    break;  

                case 'date-time':
                    // Verify it is a String First
                    if(!is_string($this->$param)) { 
                        return false; 
                    }

                    //Make Sure it can be parsed by DateTime
                    $dateTime = \DateTime::createFromFormat(\DateTime::ISO8601, $this->$param);

                    // Was the date time object created
                    if ($dateTime) {                        
                        
                        //Check to make sure the Param is in the proper format (eg. '2019-03-01 12:30:00' )
                        if !($dateTime->format('Y-m-d H:i:s') === $this->$param) {
                            return false;
                        }

                    } else {

                        // the string was able to be parsed and is invalid
                        return false;
                    }

                    break;

                case 'priceOptionArray':
                    if(!is_array($this->$param)) { 
                        return false; 
                    }

                    foreach ($this->$param as $obj) {
                        if (get_class($obj) !== 'Rezdy\Resources\PriceOption') {
                            return false;
                        }
                    }

                    break;  

                default:
                    // The value type is not on our list
                    return false;
                    break;
            }

        // Everything checks out
        return true;
    }


    public function __toString() {
        
        //Verify the params in the Object Prior to Returning
        if ($this->verifyParms()) {
            //Trim unused params
            return json_encode($this);
        } else {
            return null;
        }        
    }
}