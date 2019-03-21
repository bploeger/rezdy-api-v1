<?php
namespace Rezdy\Resources;

/**
 * Creates and verifies the SessionCreateRequest resource
 *
 * @package Resources
 * @author Brad Ploeger
 */
class SessionCreateRequest extends BaseResource {	

	public function __construct() {
		//Set the required properties of the object and the required type
		$this->requiredParams = array(	'productCode' 	=> 'string', 
										'seats'			=> 'integer' 
								);

		//Set the optional properties of the object and the required type
		$this->optionalParams = array(	'allDay' 		=> 'boolean', 
										'endTime'		=> 'ISO8601',
										'endTimeLocal'	=> 'date-time',
										'priceOptions'	=> 'priceOptionArray',
										'startTime'		=> 'ISO8601',
										'startTimeLocal'=> 'date-time' 
									);		
	}

	// Add a custom Price Option
	public function addPriceOption($PriceOption) {		
		//Verify the PriceOption being added is the correct class 
		if (get_class($PriceOption) == 'Rezdy\Resources\PriceOption') {
			$this->priceOptions[] = $PriceOption;
		}		
	}
}