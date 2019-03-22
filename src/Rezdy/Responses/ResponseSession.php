<?php
namespace Rezdy\Responses;


/**
 * Handles and Processes the ResponseSession from the API
 *
 * @package Resources
 * @author Brad Ploeger
 */

class ResponseSession extends BaseResponse {

	public $session;

	public function __construct($response) {
		
		$this->parseResponse($response);

		if ($this->wasSuccessful()) {
			$this->session = $this->responseBody->session;
		}
	}

}