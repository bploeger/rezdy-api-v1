<?php
namespace Rezdy\Requests\Booking;

use Rezdy\Requests\BaseRequest;

/**
 * Creates and verifies the BookingItemVoucher request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class ItemVoucher extends BaseRequest {

		public function __construct($params = '') {
			
			//Set the optional properties of the object and the required type
			$this->optionalParams = [		"code"				=> "string",
                   							"expiryDate"		=> "date-time",
                    						"internalNotes"		=> "string",
                    						"internalReference"	=> "string",
                    						"issueDate"			=> "date-time",
                    						"sourceOrder"		=> "string",
                    						"status"			=> "enum.voucher-status",
                    						"value"				=> "float",
                    						"valueType"			=> "enum.voucher-value-type"         								
									];

			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}
}