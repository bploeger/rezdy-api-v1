<?php
namespace Rezdy\Requests\Category;

use Rezdy\Requests\BaseRequest;
use Rezdy\Requests\RequestInterface;

/**
 * Creates and verifies the CategorySearchRequest resource
 *
 * @package Requests
 * @author Brad Ploeger
 */
class SearchRequest extends BaseRequest implements RequestInterface {	

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