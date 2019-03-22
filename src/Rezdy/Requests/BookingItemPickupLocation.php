<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the BookingItemPickupLocation request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class BookingItemPickupLocation extends BaseRequest {

		public function __construct($params = '') {
			
			//Set the optional properties of the object and the required type
			$this->optionalParams = [		"additionalInstructions"		=> "string",
               								"address"						=> "string",
                							"latitude"						=> "numeric",
                							"locationName"					=> "string",
                							"longitude"						=> "numeric",
                							"minutesPrior"					=> "integer",
                							"pickupInstructions"			=> "string",
                							"pickupTime"					=> "date-time"    								
									];

			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}
}