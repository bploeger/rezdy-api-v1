<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the BookingItem request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class BookingItem extends BaseRequest {

		public function __construct($params = '') {
			
			//Set the optional properties of the object and the required type
			$this->optionalParams = [		"amount"			=> "numeric",
            								"endTime"			=> "ISO8601",
            								"endTimeLocal"		=> "date-time",   
            								"productCode"		=> "string",
           									"productName"		=> "string", 
           									"startTime"			=> "ISO8601",
            								"startTimeLocal"	=> "date-time",
            								"subtotal"			=> "numeric",
            								"totalItemTax"		=> "numeric",
            								"totalQuantity"		=> "integer",
            								"transferFrom"		=> "string",
            								"transferReturn"	=> "boolean",
            								"transferTo"		=> "string",       								
									];

			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}
			
		// Adds an extra to the Item
		public function addExtra($extra) {		
			//Verify the Extra being added is the correct class 
			if (get_class($extra) == 'Rezdy\Requests\BookingItemExtra') {
				$this->extras[] = $extra;
			}		
		}

		// Adds an quantity to the Item
		public function addQuantity($quantity) {		
			//Verify the Quantity being added is the correct class 
			if (get_class($quantity) == 'Rezdy\Requests\BookingItemQuantity') {
				$this->quantities[] = $quantity;
			}		
		}

		// Adds an quantity to the Item
		public function addVoucher($voucher) {		
			//Verify the Voucher being added is the correct class 
			if (get_class($voucher) == 'Rezdy\Requests\BookingItemVoucher') {
				$this->quantities[] = $voucher;
			}		
		}

		// Adds an Pickup Location to the Item
		public function setPickupLocation($pickup) {		
			//Verify the Pickup Location being added is the correct class 
			if (get_class($pickup) == 'Rezdy\Requests\BookingItemPickupLocation') {
				$this->pickupLocation = $pickup;
			}		
		}
}