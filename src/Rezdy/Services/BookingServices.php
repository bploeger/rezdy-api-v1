<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\Booking;
use Rezdy\Requests\Booking\SearchRequest;

use Rezdy\Responses\ResponseStandard;
use Rezdy\Responses\ResponseList;
use Rezdy\Responses\ResponseNoData;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to booking Rezdy API Availability Service Calls
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

	public function create(Booking $booking) {
		$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.booking_create');
     		
        // Verify the booking request has the minimum information required prior to submission.
        if ( !$booking->isValid() ) return $booking;

        // try to Send the request
        try {                   
            $response = parent::sendRequestWithBody('POST', $baseUrl, $booking);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($booking, $e);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'booking');
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
        return new ResponseStandard($response->getBody(), 'booking');
    }

    public function update($orderNumber, Booking $booking) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.booking_update') . $orderNumber;      
        
        // Verify the booking request has the minimum information required prior to submission.
        if ( !$booking->isValid() ) return $booking;

        try {
            $response = parent::sendRequestWithBody('PUT', $baseUrl, $booking);
        } catch (TransferException $e) {
            return $this->returnExceptionAsErrors($booking, $e);            
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'booking');
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
        return new ResponseNoData('The booking was successfully cancelled');
    }

    public function search(SearchRequest $search) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.booking_search');
        
        // Verify the booking request has the minimum information required prior to submission.
        if ( !$search->isValid() ) return $search;

        try {
            $response = parent::sendRequestWithOutBody('GET', $baseUrl, $search->toArray());
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($search, $e);      
        }    
        
        // Handle the Response
        return new ResponseList($response->getBody(), 'bookings');
    }

    public function quote(Booking $booking) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.booking_quote');
            
        // Verify the booking request has the minimum information required prior to submission.
        if ( !$booking->isValid() ) return $booking;

        // try to Send the request
        try {                   
            $response = parent::sendRequestWithBody('POST', $baseUrl, $booking);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($booking, $e);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'booking');
    }
}