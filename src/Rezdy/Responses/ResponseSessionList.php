<?php
namespace Rezdy\Responses;


/**
 * Handles and Processes the ResponseSessionList from the API
 *
 * @package Resources
 * @author Brad Ploeger
 */

class ResponseSessionList extends BaseResponse {

	public $sessions;

	public function __construct($response) {
		
		$this->parseResponse($response);

		if ($this->wasSuccessful()) {
			$this->sessions = $this->responseBody->sessions;
		}
	}

}