<?php
namespace Rezdy\Responses;


/**
 * Handles and Processes the ResponseNoData from the API
 *
 * @package Resources
 * @author Brad Ploeger
 */

class ResponseNoData extends BaseResponse {

	public function __construct($response) {
		
		$this->parseResponse($response);

	}

}