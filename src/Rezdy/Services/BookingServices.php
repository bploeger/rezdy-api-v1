<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\Booking;
use Rezdy\Requests\BookingSearch;
use Rezdy\Requests\EmptyRequest;

use Rezdy\Responses\ResponseStandard;
use Rezdy\Responses\ResponseList;
use Rezdy\Responses\ResponseNoData;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to Rezdy API Booking Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class BookingServices extends BaseService {
    /**
     * Create a new booking.
     *
     * @param Booking $request object 
     * @return ResponseStandard object
     * @throws Booking request object with errors     
     */
	public function create(Booking $request) {
		// Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.booking_create');     		
        // Verify the Booking request object.
        if ( !$request->isValid() ) return $request;
        try {                   
            // Try to send the request  
            $response = parent::sendRequestWithBody('POST', $baseUrl, $request);
        } catch (TransferException $e) {            
            // Handle a TransferException   
            return $this->returnExceptionAsErrors($e, $request);         
        }    
        // Return the Response 
        return new ResponseStandard($response->getBody(), 'booking');
	}
    /**
     * Load an existing booking by Order Number
     * @param string $orderNumber
     * @return ResponseStandard object
     * @throws EmptyRequest request object with errors     
     */
    public function get(string $orderNumber) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.booking_get') . $orderNumber;
        try {                   
            // Try to send the request  
            $response = parent::sendRequestWithOutBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            // Handle a TransferException 
            return $this->returnExceptionAsErrors($e);         
        }    
        // Return the Response 
        return new ResponseStandard($response->getBody(), 'booking');
    }
    /**
     * Updates an existing booking by Order Number
     * 
     * NOTE: This is not a partial update, a full booking object, as it was retrieved from the booking create or 
     * search services, has to be send back to the request payload.
     *
     * @param string $orderNumber
     * @param Booking $request object 
     * @return ResponseStandard object
     * @throws Booking request object with errors     
     */
    public function update(string $orderNumber, Booking $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.booking_update') . $orderNumber;      
        // Verify the Booking request object.
        if ( !$request->isValid() ) return $request;
        try {
            // Try to send the request  
            $response = parent::sendRequestWithBody('PUT', $baseUrl, $request);
        } catch (TransferException $e) {
            // Handle a TransferException 
            return $this->returnExceptionAsErrors($e, $request);            
        } 
        // Return the Response 
        return new ResponseStandard($response->getBody(), 'booking');
    }
    /**
     * Cancels an existing booking and send notifications about the cancellation. 
     *
     * NOTE: In case of an Automated Payment booking, will also refund payment.
     *
     * @param string $orderNumber
     * @param array $optionalSettings an array of the query parameters 
     * @return ResponseNoData object
     * @throws EmptyRequest request object with errors    
     */
    public function cancel(string $orderNumber, array $optionalSettings = array()) {        
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.booking_delete') . $orderNumber;
        foreach ($optionalSettings as $key => $value) {
            // Parse the Optional Settings Array
            $options[][$key] = $value;
        }                
        try {
            // Try to send the request
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl, $options);
        } catch (TransferException $e) {
            // Handle a TransferException 
            return $this->returnExceptionAsErrors($e);                
        }           
        // Return the Response 
        return new ResponseNoData('The booking was successfully cancelled');
    }
    /**
     * Search bookings in the account 
     *
     * @param BookingSearch $request object
     * @return ResponseList object
     * @throws BookingSearch request object with errors    
     */
    public function search(BookingSearch $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.booking_search');
        // Verify the BookingSearch request object.
        if ( !$request->isValid() ) return $request;
        try {
            // Try to send the request
            $response = parent::sendRequestWithOutBody('GET', $baseUrl, $request->toArray());
        } catch (TransferException $e) {            
            // Handle a TransferException 
            return $this->returnExceptionAsErrors($e, $request);      
        }    
        // Return the Response 
        return new ResponseList($response->getBody(), 'bookings');
    }
    /**
     * Get a quote for a booking.
     *
     * NOTE: Use this service to validate your Booking object before making the actual booking.
     * Business rules will be validated, and all amounts and totals will be populated.  It is 
     * not a Booking: It does not have any status or booking number. A Quote does not reserve 
     * any seats. 
     *
     * @param Booking $request object
     * @return ResponseStandard object
     * @throws Booking request object with errors    
     */
    public function quote(Booking $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.booking_quote');            
        // Verify the BookingSearch request object.
        if ( !$request->isValid() ) return $request;
        try { 
            // Try to send the request                  
            $response = parent::sendRequestWithBody('POST', $baseUrl, $request);
        } catch (TransferException $e) {  
            // Handle a TransferException           
            return $this->returnExceptionAsErrors($e, $request);         
        }    
        // Return the Response 
        return new ResponseStandard($response->getBody(), 'booking');
    }
}