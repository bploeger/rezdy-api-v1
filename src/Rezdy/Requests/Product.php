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
		$this->requiredParams = [	'description'					=> 'string|100-15000',
									'durationMinutes'				=> 'integer',
									'name'							=> 'string',
									'productType'					=> 'enum.product-type',
									'shortDescription'				=> 'string|15-240',
								];
		
		//Set the optional properties of the object and the required type
		$this->optionalParams = [	'additionalInformation'			=>	'string',
									'advertisedPrice'				=>	'numeric',
									'bookingMode'					=>	'enum.booking-modes',
									'cancellationPolicyDays' 		=>  'integer',
									'charter'						=>	'boolean',
									'commissionIncludesExtras'		=>  'boolean',
									'confirmMode'					=>  'enum.confirm-modes',
									'confirmModeMinParticipants'	=> 	'integer',
									'currency'						=>  'enum.currency-types',
									'internalCode'					=>	'string',
									'generalTerms'					=> 	'string',
									'languages'						=> 	'array-of-string',
									'minimumNoticeMinutes'			=>	'integer',
									'maxCommissionNetRate'			=>	'numeric',
									'maxCommissionPercent'			=>	'numeric',
									'minimumNoticeMinutes'			=>	'integer',
									'productCode'					=>	'string',
									'pickupId'						=>	'integer',
									'qrCodeType'					=>	'enum.qr-code-types',
									'quantityRequired'				=>	'boolean',
									'quantityRequiredMax'			=>	'integer',
									'quantityRequiredMin'			=>	'integer',
									'supplierAlias'					=>  'string',
									'supplierId'					=>  'integer',
									'supplierName'					=>	'string',
									'tags'							=> 	'tag-or-array',
									'terms'							=>	'string',
									'timezone'						=>  'string',
									'unitLabel'						=>	'string',
									'unitLabelPlural'				=>	'string',
									'waitListingEnabled'			=>	'boolean',
									'xeroAccount'					=>	'string',
								];

		// Sets the class mapping for single set items to the request 
		$this->setClassMap = 	[ 	'Rezdy\Requests\Objects\LocationAddress'	=> 'locationAddress', 
								]; 

		//Sets the class mapping for multiple item sets to the request 				
		$this->addClassMap  = 	[	'Rezdy\Requests\Objects\Field'				=> 'bookingFields',
									'Rezdy\Requests\Extra'						=> 'extras',
									'Rezdy\Requests\Objects\Image'				=> 'images'
									'Rezdy\Requests\Objects\PriceOption'		=> 'priceOptions',
									'Rezdy\Requests\Objects\SeoTag'				=> 'productSeoTags',
									'Rezdy\Requests\Objects\Tax'				=> 'taxes', 
									'Rezdy\Requests\Objects\Video'				=> 'videos', 
								];	

		if (is_array($params)) {
			$this->buildFromArray($params);
		}

		// These are Required to Create the Product
		$this->bookingFields = array();	
		$this->priceOptions = array();
	}

	public function isValid() {
		
		return $this->isValidRequest();
	}
}