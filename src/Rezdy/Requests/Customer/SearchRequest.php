<?php
namespace Rezdy\Requests\Customer;

use Rezdy\Requests\BaseRequest;
use Rezdy\Requests\RequestInterface;

/**
 * Creates and verifies the CustomerSearchRequest resource
 *
 * @package Requests
 * @author Brad Ploeger
 */
class SearchRequest extends BaseRequest implements RequestInterface {	

	public function __construct($params = '') {
		
		//Set the optional properties of the object and the required datatype
		$this->optionalParams = [	'search' 			=> 'string',																		
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