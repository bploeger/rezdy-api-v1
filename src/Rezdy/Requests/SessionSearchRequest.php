<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the SessionSearchRequest resource
 *
 * @package Resources
 * @author Brad Ploeger
 */
class SessionSearchRequest extends BaseRequest {	

	public function __construct($params = '') {
		
		//Set the required properties of the object and the required datatype
		$this->requiredParams = array(	'productCode' 		=> 'string'								
									);		

		//Set the optional properties of the object and the required datatype
		$this->optionalParams = array(	'startTime' 		=> 'ISO8601', 
										'endTime'			=> 'ISO8601',
										'startTimeLocal'	=> 'date-time',
										'endTimeLocal'		=> 'date-time',	
										'minAvailability'	=> 'integer',
										'limit'				=> 'integer',
										'offset'			=> 'integer'									
									);		

		if (is_array($params)) {
			$this->customBuildFromArray($params);
		}	
	}

	public function __toString() {        
        //Verify the params in the Object Prior to Returning
        if ($this->verifyParams()) {
            return json_encode($this);
        } else {
            return '';
        }        
    }

    // Builds the Resource from an Array Provided
    private function customBuildFromArray($params = array()) {
         if (is_array($params) && sizeof($params)) {
            foreach ($params as $param => $value) {                
               
                // Verify the parameter is acceptable for the object
                if ((sizeof($this->requiredParams) && array_key_exists($param, $this->requiredParams)) || array_key_exists($param, $this->optionalParams) ) {                  
                    
                    // Set the Parameter                 
                       $this->$param = $value;                                        
                }               
            }   
        }
    } 
}