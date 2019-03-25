<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\BookingRequest;

use Rezdy\Responses\ResponseBooking;
use Rezdy\Responses\ResponseNoData;

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
     		
        // Verify the booking request has the minimum information required prior to submission.
        if (!$booking->isValidBooking()) {                
            $booking->setError('The booking request does not include the minimum information required to be processed by the API. A valid request must include a customer and at least one item.');
            return $booking;
        }
        
        // try to Send the request
        try {                   
            $response = parent::sendRequestWithBody('POST', $baseUrl, $booking);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($booking, $e);         
        }    
        
        // Handle the Response
        return new ResponseBooking($response->getBody());
	}

    public function find($orderNumber) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.booking_get') . $orderNumber;
                   
        // try to Send the request
        try {                   
            $response = parent::sendRequestWithOutBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($booking, $e);         
        }    
        
        // Handle the Response
        return new ResponseBooking($response->getBody());
    }

    public function update($orderNumber, BookingRequest $booking) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.booking_update') . $orderNumber;      
        try {
            $response = parent::sendRequestWithBody('PUT', $baseUrl, $booking);
        } catch (TransferException $e) {
            return $this->returnExceptionAsErrors($booking, $e);            
        }    
        
        // Handle the Response
        return new ResponseBooking($response->getBody());
    }

    public function cancel($orderNumber, array $optionalSettings = array()) {        
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.booking_delete') . $orderNumber;
        foreach ($optionalSettings as $key => $value) {
            $options[][$key] = $value;
        }        
        try {
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl, $options);
        } catch (TransferException $e) {
            return $this->returnExceptionAsErrors($session, $e);                
        }    
        
        // Handle the Response
        return new ResponseNoData('The booking was successfully deleted');
    }
}