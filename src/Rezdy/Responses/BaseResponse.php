<?php
namespace Rezdy\Responses;

/**
 * Super class for all Responses
 *
 * @package Responses
 * @author Brad Ploeger
 */
abstract class BaseResponse {

	protected $responseBody;

	public $hadError = false;

	public $errorMessage = null;

	protected function parseResponse($response) {
		//Convert the Response into a Standard Object
		$this->responseBody = json_decode($response);		
		$this->handleErrors();
	}

	protected function handleErrors() {

		if (!$this->responseBody->requestStatus->success) {
			$this->hadError = true;
			$this->errorMessage = $this->responseBody->requestStatus->error->errorMessage;
		}
		
	}

	public function wasSuccessful() {
		return !($this->hadError);
	}

	public function __toString() {
		return json_encode($this);
	}
	
}