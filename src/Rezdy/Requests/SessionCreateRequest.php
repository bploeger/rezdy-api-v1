<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the SessionCreateRequest resource
 *
 * @package Resources
 * @author Brad Ploeger
 */
class SessionCreateRequest extends BaseRequest {	

	public function __construct($params = '') {
		//Set the required properties of the object and the required datatype
		$this->requiredParams = array(	'productCode' 	=> 'string', 
										'seats'			=> 'integer' 
								);

		//Set the optional properties of the object and the required datatype
		$this->optionalParams = array(	'allDay' 		=> 'boolean', 
										'endTime'		=> 'ISO8601',
										'endTimeLocal'	=> 'date-time',
										'priceOptions'	=> 'priceOptionArray',
										'startTime'		=> 'ISO8601',
										'startTimeLocal'=> 'date-time' 
									);		

		if (is_array($params)) {
			$this->buildFromArray($params);
		}
	}

	// Add a custom Price Option
	public function addPriceOption($PriceOption) {		
		//Verify the PriceOption being added is the correct class 
		if (get_class($PriceOption) == 'Rezdy\Resources\SessionPriceOption') {
			$this->priceOptions[] = $PriceOption;
		}		
	}

	public function __toString() {  
        return json_encode($this);          
    }
}