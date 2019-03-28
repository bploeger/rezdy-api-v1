<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the Product request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class Product extends BaseRequest implements RequestInterface {

	public function __construct($params = '') {

		//Set the required properties of the object and the required type
		$this->requiredParams = [	'description'				=> 'string|100-15000',
									'durationMinutes'			=> 'integer',
									'name'						=> 'string',
									'productType'				=> 'enum.product-type',
									'shortDescription'			=> 'string|15-240',
								];
		
		//Set the optional properties of the object and the required type
		$this->optionalParams = [	'additionalInformation'		=>	'string',
									'advertisedPrice'			=>	'numeric',
									'bookingMode'				=>	'enum.booking-mode',
									'charter'					=>	'boolean',
									

								];

		if (is_array($params)) {
			$this->buildFromArray($params);
		}

		// These are Required to Create the Product
		$this->bookingFields = array();	
		$this->priceOptions = array();
	}

	public function isValid() {
		
		return $this->isValidBooking();
	}
}