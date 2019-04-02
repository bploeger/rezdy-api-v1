<?php
namespace Rezdy\Responses;


/**
 * Handles and Processes the ResponseNoData from the API
 *
 * @package Resources
 * @author Brad Ploeger
 */

class ResponseNoData extends BaseResponse {

	public $message;

	public function __construct($response) {
		
		$this->message = $response;

	}

}