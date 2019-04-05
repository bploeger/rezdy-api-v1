<?php
namespace Rezdy\Responses;

use Rezdy\Requests\EmptyRequest;

/**
 * Handles and Processes the Standard Response from the API
 *
 * @package Resources
 * @author Brad Ploeger
 */

class ResponseStandard extends BaseResponse {

	public $itemType;
	public $requestStatus;

	public function __construct($response, $itemType) {
		
		$this->itemType = $itemType;

		$this->parseResponse($response);

		if ($this->wasSuccessful()) {
			$this->$itemType = $this->responseBody->$itemType;
			$this->requestStatus = $this->responseBody->requestStatus;
		}
	}

	public function toRequest() {
		$typeToClass = 	[	'booking'		=> 'Rezdy\Requests\Booking',
							'session'		=> 'Rezdy\Requests\SessionUpdate',
							'customer'		=> 'Rezdy\Requests\Customer',
							'extra'			=> 'Rezdy\Requests\Extra',
							'pickupList'	=> 'Rezdy\Requests\PickupList',
							'product'		=> 'Rezdy\Requests\Product',
						];
		$itemType = $this->itemType;
		if (array_key_exists($itemType, $typeToClass)) {
			$request = new $typeToClass[$itemType];
			$request->assemble($this->$itemType);
		} else {
			$request = new EmptyRequest;
		}		
		return $request;
	}
}