<?php
namespace Rezdy\Responses;


/**
 * Handles and Processes the ResponseList from the API
 *
 * @package Resources
 * @author Brad Ploeger
 */

class ResponseList extends BaseResponse {

	public $listType;

	public $requestStatus;

	public function __construct($response, $listType) {

		$this->listType = $listType;
		
		$this->parseResponse($response);

		if ($this->wasSuccessful()) {
			$this->$listType = $this->responseBody->$listType;
			$this->requestStatus = $this->responseBody->requestStatus;
		}
	}

}