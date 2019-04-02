<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the SessionSearch request
 *
 * @package Resources
 * @author Brad Ploeger
 */
class SessionSearch extends BaseRequest implements RequestInterface {	

	public function __construct($params = '') {
		
		//Set the required properties of the object and the required datatype
		$this->requiredParams = [	'productCode' 		=> 'string-or-array'
                                ];		

		//Set the optional properties of the object and the required datatype
		$this->optionalParams = [	'startTime' 		=> 'ISO8601', 
									'endTime'			=> 'ISO8601',
									'startTimeLocal'	=> 'date-time',
									'endTimeLocal'		=> 'date-time',	
									'minAvailability'	=> 'integer',
									'limit'				=> 'integer',
									'offset'			=> 'integer'									
								];		

		if (is_array($params)) {
			$this->customBuildFromArray($params);
		}	
	}

    public function isValid() {
        return $this->isValidRequest();
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