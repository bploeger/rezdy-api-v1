<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the BookingField request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class BookingField extends BaseRequest {

		public function __construct($params = '') {
			
			//Set the optional properties of the object and the required type
			$this->optionalParams = [		"fieldType"				=> "enum-field-type",
            								"label"					=> "string",
            								"listOptions"			=> "string",
            								"requiredPerBooking"	=> "boolean",
            								"requiredPerParticipant"=> "boolean",
            								"value"					=> "string",
            								"visiblePerBooking"		=> "boolean",
            								"visiblePerParticipant"	=> "boolean"				
									];

			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}
}