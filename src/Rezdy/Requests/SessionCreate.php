<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the SessionCreate Request
 *
 * @package Resources
 * @author Brad Ploeger
 */
class SessionCreate extends BaseRequest implements RequestInterface {	

	public function __construct($params = '') {
		//Set the required properties of the object and the required datatype
		$this->requiredParams = [	'productCode' 	=> 'string', 
									'seats'			=> 'integer',
								];

		//Set the optional properties of the object and the required datatype
		$this->optionalParams = [	'allDay' 		=> 'boolean', 
									'endTime'		=> 'ISO8601',
									'endTimeLocal'	=> 'date-time',
									'priceOptions'	=> 'priceOptionArray',
									'startTime'		=> 'ISO8601',
									'startTimeLocal'=> 'date-time' 
								];		

		//Sets the class mapping for multiple item sets to the request 				
		$this->addClassMap  =	[	'Rezdy\Resources\Availability\PriceOption'		=> 'priceOptions'
								];	

		if (is_array($params)) {
			$this->buildFromArray($params);
		}
	}

	public function isValid() {
		return $this->isValidRequest();
	}


}