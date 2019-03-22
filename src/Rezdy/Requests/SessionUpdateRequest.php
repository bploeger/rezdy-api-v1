<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the SessionCreateRequest resource
 *
 * @package Resources
 * @author Brad Ploeger
 */
class SessionUpdateRequest extends BaseRequest {	

	public $sessionId = 0; 

	public function __construct($sessionId, $params = '') {
		
		//Set the optional properties of the object and the required datatype
		$this->optionalParams = array(	'allDay' 		=> 'boolean', 
										'seats'			=> 'integer',
										'seatsAvailable'=> 'integer'										
									);		

		if (is_array($params)) {
			$this->buildFromArray($params);
		}	

		$this->sessionId = $sessionId;	
	}

	// Add a custom Price Option
	public function addPriceOption($PriceOption) {		
		//Verify the PriceOption being added is the correct class 
		if (get_class($PriceOption) == 'Rezdy\Resources\PriceOption') {
			$this->priceOptions[] = $PriceOption;
		}		
	}

	public function __toString() {        
        //Verify the params in the Object Prior to Returning
        if ($this->verifyParams()) {
            return json_encode($this);
        } else {
            return '';
        }        
    }
}