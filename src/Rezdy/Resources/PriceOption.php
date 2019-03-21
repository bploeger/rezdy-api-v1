<?php
namespace Rezdy\Resources;

/**
 * Creates and verifies the PriceOption resource
 *
 * @package Resources
 * @author Brad Ploeger
 */
class PriceOption extends BaseResource {

		public function __construct() {
			//Set the optional properties of the object and the required type
			$this->optionalParams = array(	'id' 			=> 'integer', 
											'label'			=> 'string',
											'maxQuantity'	=> 'integer',
											'maxQuantity'	=> 'integer',
											'price'			=> 'numeric',											
										);
		}

		public function setPriceGroupType($type) {
			$allowedPriceGroupTypes = ['EACH', 'TOTAL'];
			if (in_array($type, $allowedPriceGroupTypes)) {
				$this->priceGroupType = $type;
			}
		}	

}