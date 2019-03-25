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

			// Sets the class mapping for single set items to the request 
			$this->setClassMap =	[ 	'Rezdy\Requests\BookingItemPickupLocation'	=> 'pickupLocation'
									]; 

			//Sets the class mapping for multiple item sets to the request 				
			$this->addClassMap  =	[	'Rezdy\Requests\BookingItemExtra'		=> 'extras',
										'Rezdy\Requests\BookingItemQuantity'	=> 'quantities'
									];	

			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}		
}