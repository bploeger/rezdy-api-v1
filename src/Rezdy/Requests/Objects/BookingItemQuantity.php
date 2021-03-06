<?php
namespace Rezdy\Requests\Objects;

use Rezdy\Requests\BaseRequest;

/**
 * Creates and verifies the BookingItemQuantity request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class BookingItemQuantity extends BaseRequest {

		public function __construct($params = '') {
			
			//Set the optional properties of the object and the required type
			$this->optionalParams = [		"optionId"		=> "integer",
                    						"optionLabel"	=> "string",
                    						"optionPrice"	=> "float",
                    						"value"			=> "integer"  								
									];

			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}
}