<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the SessionResourceSearchRequest resource
 *
 * @package Resources
 * @author Brad Ploeger
 */
class SessionResourceSearch extends BaseRequest implements RequestInterface {	

	public function __construct($params = '') {
		
		//Set the optional properties of the object and the required datatype
		$this->optionalParams = [	'sessionId'			=> 'integer',
									'productCode'		=> 'string',
									'startTime' 		=> 'ISO8601', 
									'endTime'			=> 'ISO8601',
									'startTimeLocal'	=> 'date-time',
									'endTimeLocal'		=> 'date-time',	
									'limit'				=> 'integer',
									'offset'			=> 'integer'									
								];		

		if (is_array($params)) {
			$this->buildFromArray($params);
		}	
	}

    public function isValid() {
        if (!isset($this->sessionId) && !isset($this->productCode)) {
        	$this->setError('A Session ID or Product Code must be set');
        }
        return ($this->isValidRequest());
    }   
}