<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the BookingSearchRequest resource
 *
 * @package Requests
 * @author Brad Ploeger
 */
class BookingSearch extends BaseRequest implements RequestInterface {	

	public function __construct($params = '') {
		
		//Set the optional properties of the object and the required datatype
		$this->optionalParams = [	'orderStatus' 		=> 'enum.status',
									'search' 			=> 'string',  
									'productCode'		=> 'string-or-array',
									'minTourStartTime'	=> 'ISO8601',
									'maxTourStartTime'	=> 'ISO8601',	
									'updatedSince'		=> 'ISO8601',	
									'minDateCreated'	=> 'ISO8601',	
									'maxDateCreated'	=> 'ISO8601',		
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