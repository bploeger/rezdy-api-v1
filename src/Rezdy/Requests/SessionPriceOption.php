<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the PriceOption request
 *
 * @package Resources
 * @author Brad Ploeger
 */
class SessionPriceOption extends BaseRequest {

		public function __construct($params = '') {
			
			//Set the optional properties of the object and the required type
			$this->optionalParams = array(	'id' 			=> 'integer', 
											'label'			=> 'string',
											'maxQuantity'	=> 'integer',
											'minQuantity'	=> 'integer',
											'price'			=> 'numeric',											
										);

			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}

		public function setPriceGroupType($type) {
			$allowedPriceGroupTypes = ['EACH', 'TOTAL'];
			if (in_array($type, $allowedPriceGroupTypes)) {
				$this->priceGroupType = $type;
			}
		}	

}