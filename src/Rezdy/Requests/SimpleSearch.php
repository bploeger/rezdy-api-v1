<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the SimpleSearchRequest resource
 *
 * @package Requests
 * @author Brad Ploeger
 */
class SimpleSearch extends BaseRequest implements RequestInterface {	

	public function __construct($params = '') {
		
		//Set the optional properties of the object and the required datatype
		$this->optionalParams = [	'search'					=> 'string',
									'limit'						=> 'integer|0-100',
									'offset'					=> 'integer'
								];		

		if (is_array($params)) {
			$this->BuildFromArray($params);
		}	
	}

	public function isValid() {
		return $this->isValidRequest();
	}    
}