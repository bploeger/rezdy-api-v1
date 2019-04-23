<?php
namespace Rezdy\Requests\Objects;

use Rezdy\Requests\BaseRequest;

/**
 * Creates and verifies the SeoTag request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class SeoTag extends BaseRequest {

		public function __construct($params = '') {
			
			//Set the optional properties of the object and the required type
			$this->optionalParams = [		'id'			=> 'integer',
											'attrKey'		=> 'string',
											'attrValue'		=> 'string',
        									'metaType'		=> 'string',
        									'productCode'	=> 'string',				
									];

			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}
}