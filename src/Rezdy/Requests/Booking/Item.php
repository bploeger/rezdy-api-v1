<?php
namespace Rezdy\Requests\Booking;

use Rezdy\Requests\BaseRequest;

/**
 * Creates and verifies the BookingItem request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class Item extends BaseRequest {

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

			// Sets the class mapping for single set items to the request 
			$this->setClassMap =	[ 	'Rezdy\Requests\Objects\PickupLocation'		=> 'pickupLocation'
									]; 

			//Sets the class mapping for multiple item sets to the request 				
			$this->addClassMap  =	[	'Rezdy\Requests\Booking\Extra'				=> 'extras',
										'Rezdy\Requests\Booking\ItemQuantity'		=> 'quantities'
									];	

			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}		
}