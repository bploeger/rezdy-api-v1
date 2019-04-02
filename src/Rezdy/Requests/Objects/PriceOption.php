<?php
namespace Rezdy\Requests\Objects;

use Rezdy\Requests\BaseRequest;

/**
 * Creates and verifies the PriceOption request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class PriceOption extends BaseRequest {

		public function __construct($params = '') {
			
			//Set the optional properties of the object and the required type
			$this->optionalParams = [		"label"				=> "string",
											"maxQuantity"		=> "integer",
                    						"minQuantity"		=> "integer",
                    						"price"				=> "numeric",
                    						"priceGroupType"	=> "enum.price-group-type",
                    						"productCode"		=> "string",
                    						"seatsUsed"			=> "integer"							
									];

			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}
}