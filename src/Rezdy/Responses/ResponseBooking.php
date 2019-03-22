<?php
namespace Rezdy\Responses;


/**
 * Handles and Processes the ResponseBooking from the API
 *
 * @package Resources
 * @author Brad Ploeger
 */

class ResponseBooking extends BaseResponse {

	public $booking;

	public function __construct($response) {
		
		$this->parseResponse($response);

		if ($this->wasSuccessful()) {
			$this->booking = $this->responseBody->booking;
		}
	}

}