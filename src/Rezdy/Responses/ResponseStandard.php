<?php
namespace Rezdy\Responses;


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

}