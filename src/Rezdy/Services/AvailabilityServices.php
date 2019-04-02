<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\SessionCreate;
use Rezdy\Requests\SessionUpdate;
use Rezdy\Requests\SessionSearch;
use Rezdy\Requests\EmptyRequest;

use Rezdy\Responses\ResponseStandard;
use Rezdy\Responses\ResponseNoData;
use Rezdy\Responses\ResponseList;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to the Rezdy API Availability Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class AvailabilityServices extends BaseService {
	/**
     * Create a new session - creates availability for a specific start time. Sessions can be created only for INVENTORY mode products.
     * @param SessionCreate $request object 
     * @return ResponseStandard object
     * @throws SessionCreate request object with errors     
     */
	public function create(SessionCreate $request) {
		// Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.availability_create');
		try {
            // Try to send the request  
            $response = parent::sendRequestWithBody('POST', $baseUrl, $request);
        } catch (TransferException $e) {
            // Handle a TransferException   
        	return $this->returnExceptionAsErrors($e, $request);             	
        } 
        // Return the Response 
        return new ResponseStandard($response->getBody(), 'session');
	}
    /**
     * Update availability for a specific session.
     * @param SessionUpdate $request object 
     * @return ResponseStandard response object
     * @throws EmptyRequest request object with errors     
     */
	public function update(SessionUpdate $request) {
		// Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.availability_update') . $request->sessionId;		
		try {
            // Try to send the request  
            $response = parent::sendRequestWithBody('PUT', $baseUrl, $request);
        } catch (TransferException $e) {
            // Handle a TransferException   
        	return $this->returnExceptionAsErrors($e);           	
        }            
        // Return the Response
        return new ResponseStandard($response->getBody(), 'session');
	}
    /**
     * Delete a single session.
     * @param int $sessionID the availibility sessionID 
     * @return ResponseStandard object
     * @throws EmptyRequest request object with errors     
     */
	public function delete(int $sessionId) {
        // Build the request URL
		$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.availability_delete') . $sessionId;
		try {
            // Try to send the request  
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl);
        } catch (TransferException $e) {
        	// Handle a TransferException   
            return $this->returnExceptionAsErrors($e);            	
        }           
        // Return the Response
        return new ResponseNoData('The session was successfully deleted');
	}
    /**
     * Update availability for a specific session.
     * @param SessionSearch $request object 
     * @return ResponseList response object
     * @throws SessionSearch request object with errors     
     */
    public function search(SessionSearch $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.availability_search');
        try {
            // Try to send the request
            $response = parent::sendRequestWithOutBody('GET', $baseUrl, $request->toArray());
        } catch (TransferException $e) {
            // Handle a TransferException  
            return $this->returnExceptionAsErrors($e, $request);      
        }           
        // Return the Response
        return new ResponseList($response->getBody(), 'sessions');
    }
}