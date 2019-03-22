<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the BookingPayment request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class BookingPayment extends BaseRequest {

		public function __construct($params = '') {
			
			//Set the optional properties of the object and the required type
			$this->optionalParams = [		"amount"		=> "numeric",
            								"currency"		=> "string",
            								"date"			=> "date-time",
            								"label"			=> "string",
            								"recipient"		=> "enum-payment-recipient",
           									"type"			=> "string"			
									];

			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}
}