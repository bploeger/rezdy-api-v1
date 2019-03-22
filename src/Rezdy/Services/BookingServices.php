<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\BookingRequest;

use Rezdy\Responses\ResponseBooking;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to scheduling Rezdy API Availability Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class BookingServices extends BaseService {

	/**
     * Get creates a new session
     * @param SessionCreateRequest object 
     * @return array of VerifiedEmailAddress
     * @throws RezdyException
     */

	public function create(BookingRequest $booking) {
		$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.booking_create');
		try {
            $response = parent::sendRequestWithBody('POST', $baseUrl, $booking);
        } catch (TransferException $e) {
        	dd($e);      	
        }    
        
        // Handle the Response
        return new ResponseBooking($response->getBody());
	}
}