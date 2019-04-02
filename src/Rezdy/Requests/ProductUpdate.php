<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the ProductUpdate request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class ProductUpdate extends BaseRequest implements RequestInterface {

	public function __construct($params = '') {

		//Set the optional properties of the object and the required type
		$this->optionalParams = [	'advertisedPrice'				=>	'numeric',									
									'confirmMode'					=>  'enum.confirm-modes',
									'confirmModeMinParticipants'	=> 	'integer',
									'description'					=>  'string|100-15000',
									'durationMinutes'				=>  'integer',									
									'minimumNoticeMinutes'			=>	'integer',
									'name'							=>  'string'
									'pickupId'						=>	'integer',
									'shortDescription'				=>	'string|15-240',
									'terms'							=>	'string'									
								];

		//Sets the class mapping for multiple item sets to the request 				
		$this->addClassMap  = 	[	'Rezdy\Requests\Objects\Field'				=> 'bookingFields',
								];									

		if (is_array($params)) {
			$this->buildFromArray($params);
		}

		// These are required
		$this->bookingFields = array();	
	}

	public function isValid() {
		
		return $this->isValidRequest();
	}
}