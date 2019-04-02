<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the ProductRate request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class ProductRate extends BaseRequest implements RequestInterface {

	public function __construct($params = '') {

     	//Set the required properties of the object and the required type
		$this->requiredParams = [	'commissionType'							=>	'enum.commission-type',
								];

		//Set the optional properties of the object and the required type
		$this->optionalParams = [	'percentageCommission'						=> 	'numeric',
									'percentageIncludeExtras'					=>	'boolean',
									'productCode'								=>	'string'
								];						

		//Sets the class mapping for multiple item sets to the request 				
		$this->addClassMap  = 	[	'Rezdy\Requests\Objects\NetRate'			=> 'netRates',
								];	

		if (is_array($params)) {
			$this->buildFromArray($params);
		}
	}

	public function isValid() {
		
		return ( $this->isValidRequest() && $this->validate() );
	}

	private function validate() {
		switch ($this->commissionType) {
			case 'NET_RATE':
				if (!count($this->netRates)) {
					$this->error[] = 'Net Rates Not Given';
					return false;
				}
				break;

			case 'PERMISSION':
				if (!isset($this->percentageCommission)) {
					$this->error[] = 'A percentage Commission Rate is Required';
					return false;
				}
				if (!isset($this->percentageIncludeExtras)) {
					$this->error[] = 'If the commission includes extras is Required';
					return false;
				}
				break;

			default:
				$this->error[] = 'Improper value given for Commission Type';
				return false;
				break;
		}

		return true;		
	}
}