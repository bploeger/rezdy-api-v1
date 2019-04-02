<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the CategorySearch Request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class CategorySearch extends BaseRequest implements RequestInterface {	

	public function __construct($params = '') {
		
		//Set the optional properties of the object and the required datatype
		$this->optionalParams = [	'search' 			=> 'string',
									'visible'			=> 'boolean',										
									'limit'				=> 'integer',
									'offset'			=> 'integer'				
								];		

		if (is_array($params)) {
			$this->BuildFromArray($params);
		}	
	}

	public function isValid() {
		return $this->isValidRequest();
	}    
}