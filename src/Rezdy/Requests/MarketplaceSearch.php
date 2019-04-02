<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the SearchMarketplaceRequest resource
 *
 * @package Requests
 * @author Brad Ploeger
 */
class MarketplaceSearch extends BaseRequest implements RequestInterface {	

	public function __construct($params = '') {
		
		//Set the optional properties of the object and the required datatype
		$this->optionalParams = [	'marketplaceRates'			=> 'boolean',
									'negotiatedRates'			=> 'boolean',
									'category'					=> 'integer-or-array',
									'language'					=> 'string-or-array',
									'latitude'					=> 'numeric',
									'longitude'					=> 'numeric',
									'minQuantity'				=> 'integer',
									'startDate'					=> 'ISO8601',
									'automatedPayment'			=> 'boolean',
									'updatedSince'				=> 'ISO8601',
									'search'					=> 'string',
									'supplierId'				=> 'integer',
									'supplierAlias'				=> 'string',	
									'limit'						=> 'integer',
									'offset'					=> 'integer',
									'tags'						=> 'tag-or-array'
								];		

		if (is_array($params)) {
			$this->BuildFromArray($params);
		}	
	}

	public function isValid() {
		return $this->isValidRequest();
	}    
}