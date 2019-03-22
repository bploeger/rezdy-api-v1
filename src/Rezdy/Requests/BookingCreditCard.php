<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the BookingCreditCard request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class BookingCreditCard extends BaseRequest {

		public function __construct($params = '') {
			
			//Set the optional properties of the object and the required type
			$this->optionalParams = [		"cardName"				=> "string",
        									"cardNumber"			=> "string",
        									"cardSecurityNumber"	=> "string",
        									"cardToken"				=> "string",
        									"cardType"				=> "enum-credit-card-type",
        									"expiryMonth"			=> "string",
       										"expiryYear"			=> "string"						
									];
			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}
}