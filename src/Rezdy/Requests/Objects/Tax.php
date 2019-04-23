<?php
namespace Rezdy\Requests\Objects;

use Rezdy\Requests\BaseRequest;

/**
 * Creates and verifies the Tax request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class Tax extends BaseRequest {

		public function __construct($params = '') {
			
			//Set the optional properties of the object and the required type
			$this->optionalParams = [		'compound'		=> 'boolean',
											'label'			=> 'string',
											'priceInclusive'=> 'boolean',
											'supplierId'	=> 'integer',
											'taxAmount'		=> 'numeric',
											'taxPercent'	=> 'numeric',
        									'taxType'		=> 'enum.tax-types',			
									];

			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}
}