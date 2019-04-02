<?php
namespace Rezdy\Requests\Objects;

use Rezdy\Requests\BaseRequest;

/**
 * Creates and verifies the BookingCreatedBy request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class CreatedBy extends BaseRequest {

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