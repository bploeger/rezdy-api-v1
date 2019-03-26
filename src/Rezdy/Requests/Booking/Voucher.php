<?php
namespace Rezdy\Requests\Booking;

use Rezdy\Requests\BaseRequest;

/**
 * Creates and verifies the BookingVoucher request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class Voucher extends BaseRequest {

		public function __construct($params = '') {
			
			//Set the optional properties of the object and the required type
			$this->optionalParams = [		"string"		=> "string",            								
									];

			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}
}