<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\ResourceSessionSearch;
use Rezdy\Requests\SessionResourceSearch;
use Rezdy\Requests\SimpleSearch;

use Rezdy\Responses\ResponseStandard;
use Rezdy\Responses\ResponseList;
use Rezdy\Responses\ResponseNoData;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to the Rezdy API Resource Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class ResourceServices extends BaseService {
	/**
     * Retrieve all supplier resources. 
     *
     * NOTE: Paging using limit and offset is applied to the result list.
     *    
     * @param SimpleSearch|optional $request object  
     * @return ResponseList object
     * @throws SimpleSearch request object with errors     
     */
	public function list(SimpleSearch ...$request) {
		// Build the request URL
		$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.resources');
		// Pluck the queryParams array if passed
		$request = $this->parseOptionalArray($request, new SimpleSearch());
        try {
        	// Try to send the request                   
	        $response = parent::sendRequestWithoutBody('GET', $baseUrl, $request->toArray());
	    } catch (TransferException $e) {            
	        // Handle a TransferException
	        return $this->returnExceptionAsErrors($e, $request);         
	    }    
		// Return a ResponseList object
	    return new ResponseList($response->getBody(), 'resources');
	}
	/**
     * Add the resource to the session.
     *    
     * @param int $resourceId
     * @param int $sessionId
     * @param int|optional $resourceOrder  
     * @return ResponseStandard object
     * @throws EmptyRequest object with errors     
     */
	public function addSessionResource(int $resourceId, int $sessionId, int $resourceOrder = 0) {
		// Build the request URL
		$baseUrl = Config::get('endpoints.base_url') . sprintf(Config::get('endpoints.resources_add_session'), $resourceId, $sessionId);
		// Build the query array
		if ($resourceOrder) {			
			$query['resourceOrder'] = $resourceOrder;
		} else {
			$query = [];
		}
        try {                   
            // Try to send the request
            $response = parent::sendRequestWithoutBody('PUT', $baseUrl, $query);
        } catch (TransferException $e) {            
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e);         
        }    
		// Return a ResponseStandard object
        return new ResponseStandard($response->getBody(), 'resource');
	}
	/**
     * Retrieves all sessions for the specified resource within the start/end datetime range.
     *
     * NOTE: Paging using limit and offset is applied to the result list.
     *    
     * @param int $resourceId
     * @param int $sessionId
     * @param ResourceSessionSearch|optional $request object   
     * @return ResponseStandard object
     * @throws ResourceSessionSearch object with errors     
     */
	public function getResourceSessions(int $resourceId, ResourceSessionSearch ...$request) {
		// Build the request URL
		$baseUrl = Config::get('endpoints.base_url') . sprintf(Config::get('endpoints.resources_sessions'), $resourceId);
		// Pluck the ResourceSessionSearch object if passed
		$request = $this->parseOptionalArray($request, new ResourceSessionSearch);
        try {                   
            // Try to send the request
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $request->toArray());
        } catch (TransferException $e) {            
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e, $request);         
        }  
		// Return a ResponseStandard object
        return new ResponseStandard($response->getBody(), 'sessions');
	}
	/**
     * Retrieve resources assigned to the session. 
     *
     * NOTE: Session has to be specified either by sessionId or by product code and start time 
     * (or start time local).
     *    
     * @param SessionResourceSearch $request object   
     * @return ResponseList object
     * @throws SessionResourceSearch object with errors     
     */
	public function getSessionResources(SessionResourceSearch $request) {
		// Build the request URL
		$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.resources_session');
		// Verify the SessionResourceSearch request object.
    	if ( !$request->isValid() ) return $request;
        try {                   
            // Try to send the request
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $request->toArray());
        } catch (TransferException $e) {            
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e);         
        }  
        // Return a ResponseStandard object
        return new ResponseList($response->getBody(), 'sessions');
	}
	/**
     * Removes the resource from the session.
     *    
     * @param int $resourceId
     * @param int $sessionId    
     * @return ResponseStandard object
     * @throws EmptyRequest object with errors     
     */
	public function removeSessionResources(int $resourceId, int $sessionId) {
		// Build the request URL
		$baseUrl = Config::get('endpoints.base_url') . sprintf(Config::get('endpoints.resource_remove'), $resourceId, $sessionId);
        try {                   
            // Try to send the request
            $response = parent::sendRequestWithoutBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e);         
        }  
		// Return a ResponseStandard object
        return new ResponseStandard($response->getBody(), 'resource');
	}
}