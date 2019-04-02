<?php
namespace Rezdy\Requests\Booking;

use Rezdy\Requests\BaseRequest;

/**
 * Creates and verifies the BookingResellerUser request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class ResellerUser extends BaseRequest {

		public function __construct($params = '') {
			
			//Set the optional properties of the object and the required type
			$this->optionalParams = [		"code"		=> "string",
        									"email"		=> "string",
        									"firstName"	=> "string",
        									"lastName"	=> "string"		
									];

			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}
}