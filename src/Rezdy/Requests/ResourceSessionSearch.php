<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the ResourceSessionSearchRequest resource
 *
 * @package Resources
 * @author Brad Ploeger
 */
class ResourceSessionSearch extends BaseRequest implements RequestInterface {	

	public function __construct($params = '') {
		
		//Set the optional properties of the object and the required datatype
		$this->optionalParams = [	'startTime' 		=> 'ISO8601', 
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
        return $this->isValidRequest();
    }   
}