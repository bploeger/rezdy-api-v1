<?php
 namespace Rezdy\Requests;
 
/**
 * Creates and verifies the ManifestSearch resource
 *
 * @package Resources
 * @author Brad Ploeger
 */
class Manifest extends BaseRequest implements RequestInterface {	

	public function __construct($params = '') {
		
		//Set the optional properties of the object and the required datatype
		$this->optionalParams = [	'orderNumber'		=> 'string',
									'productCode'		=> 'string',
									'startTime'			=> 'ISO8601',
									'startTimeLocal'	=> 'date-time',
									'checkin'			=> 'boolean',    								
								];	

		// Sets the class mapping for single set items to the request 
		$this->setClassMap = 	[ 	
								]; 

		//Sets the class mapping for multiple item sets to the request 				
		$this->addClassMap  = 	[	
								];	

		if (is_array($params)) {
			$this->buildFromArray($params);
		}
	}

	public function isValid() {			
		return $this->isValidRequest();
	}	
}