<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the BookingCreatedBy request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class BookingCreatedBy extends BaseRequest {

		public function __construct($params = '') {
			
			//Set the optional properties of the object and the required type
			$this->optionalParams = [		"code"			=> "string",
        									"email"			=> "string",
        									"firstName"		=> "string",
       										"lastName"		=> "string"								
									];
			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}
}