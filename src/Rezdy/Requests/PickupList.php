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
		$this->optionalParams = [		"additionalNotes"			=> "string",
                						"id"						=> "integer",
                						"name"						=> "string",
                						"otherLocationInstructions"	=> "string",
								];

		//Sets the class mapping for multiple item sets to the request 		
		$this->addClassMap = 	[ 	'Rezdy\Resources\Object\PickupLocation'	=> 'pickupLocations'
								];

		if (is_array($params)) {
			$this->buildFromArray($params);
		}	
	}

	public function isValid() {
		return $this->isValidRequest();
	}
}