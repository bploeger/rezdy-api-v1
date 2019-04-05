<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the SessionCreateRequest resource
 *
 * @package Resources
 * @author Brad Ploeger
 */
class SessionUpdate extends BaseRequest implements RequestInterface {	

	public $sessionId; 

	public function __construct($params = '') {		
		//Set the required properties of the object and the required datatype
		$this->requiredParams = [   'sessionId'			=> 'integer'
								];		
		//Set the optional properties of the object and the required datatype
		$this->optionalParams = [	'allDay' 			=> 'boolean', 
									'seats'				=> 'integer',
									'seatsAvailable'	=> 'integer'										
								];			
		//Sets the class mapping for multiple item sets to the request 	
		$this->addClassMap  = 	[	'Rezdy\Requests\Objects\SessionPriceOption'	=> 'fields'
								];	
		// Populate the fields from a array passed at construction
		if (is_array($params)) {
			$this->buildFromArray($params);
		}	
	}

	public function isValid() {
		return $this->isValidRequest();
	}
}