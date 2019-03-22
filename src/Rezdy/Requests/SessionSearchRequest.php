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
			$this->buildFromArray($params);
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
}