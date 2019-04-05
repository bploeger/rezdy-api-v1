<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the Extra request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class Extra extends BaseRequest implements RequestInterface {

	public function __construct($params = '') {
		
		//Set the optional properties of the object and the required type
		$this->optionalParams = [		"description"			=> "string",
                						"extraPriceType"		=> "enum.extra-price-type",
                						"id"					=> "integer",
                						"name"					=> "string",
                						"price"					=> "numeric",
                						"quantity"				=> "integer"
								];

		// Sets the class mapping for single set items to the request 
		$this->setClassMap = 	[ 	'Rezdy\Resources\Objects\ExtraImage'	=> 'image'
								];

		if (is_array($params)) {
			$this->buildFromArray($params);
		}	
	}

	public function isValid() {
		return $this->isValidRequest();
	}
}