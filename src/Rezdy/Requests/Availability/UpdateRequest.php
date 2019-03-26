<?php
namespace Rezdy\Requests\Availability;

use Rezdy\Requests\BaseRequest;
use Rezdy\Requests\RequestInterface;

/**
 * Creates and verifies the SessionCreateRequest resource
 *
 * @package Resources
 * @author Brad Ploeger
 */
class UpdateRequest extends BaseRequest implements RequestInterface {	

	public $sessionId; 

	public function __construct($sessionId, $params = '') {
		
		//Set the optional properties of the object and the required datatype
		$this->optionalParams = [	'allDay' 			=> 'boolean', 
									'seats'				=> 'integer',
									'seatsAvailable'	=> 'integer'										
								];	

		//Sets the class mapping for multiple item sets to the request 	
		$this->addClassMap  = 	[	'Rezdy\Requests\Availability\PriceOption'	=> 'fields'
								];	

		if (is_array($params)) {
			$this->buildFromArray($params);
		}	
		
		$this->sessionId = $sessionId;	
	}

	public function isValid() {
		return $this->isValidRequest();
	}
}