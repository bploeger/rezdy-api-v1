<?php
namespace Rezdy\Requests\Booking;

use Rezdy\Requests\BaseRequest;

/**
 * Creates and verifies the BookingPayment request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class Payment extends BaseRequest {

		public function __construct($params = '') {
			
			//Set the optional properties of the object and the required type
			$this->optionalParams = [		"amount"		=> "numeric",
            								"currency"		=> "string",
            								"date"			=> "date-time",
            								"label"			=> "string",
            								"recipient"		=> "enum.payment-recipient",
           									"type"			=> "string"			
									];

			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}
}