<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the BookingItemExtra request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class BookingItemExtra extends BaseRequest {

		public function __construct($params = '') {
			
			//Set the optional properties of the object and the required type
			$this->optionalParams = [		"description"			=> "string",
                    						"extraPriceType"		=> "enum-extra-price-type",
                    						"id"					=> "integer",
                    						"name"					=> "string",
                    						"price"					=> "float",
                    						"quantity"				=> "integer"
									];

			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}

		// Set the Extra Image
		public function addImage($image) {		
			//Verify the ExtraImage being added is the correct class 
			if (get_class($image) == 'Rezdy\Resources\BookingItemExtraImage') {
				$this->image = $image;
			}		
		}
}