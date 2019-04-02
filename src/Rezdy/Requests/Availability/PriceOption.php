<?php
namespace Rezdy\Requests\Availability;

use Rezdy\Requests\BaseRequest;
use Rezdy\Requests\RequestInterface;

/**
 * Creates and verifies the PriceOption request
 *
 * @package Resources
 * @author Brad Ploeger
 */
class PriceOption extends BaseRequest implements RequestInterface {

		public function __construct($params = '') {
			
			//Set the optional properties of the object and the required type
			$this->optionalParams = array(	'id' 			=> 'integer', 
											'label'			=> 'string',
											'maxQuantity'	=> 'integer',
											'minQuantity'	=> 'integer',
											'price'			=> 'numeric',
											'priceGroupType'=> 'enum-price-group-type'											
										);

			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}

		public function isValid() {
			return $this->isValidRequest();
		}
}