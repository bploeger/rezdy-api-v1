<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\EmptyRequest;
use Rezdy\Requests\PickupList;

use Rezdy\Responses\ResponseStandard;
use Rezdy\Responses\ResponseList;
use Rezdy\Responses\ResponseNoData;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to booking Rezdy API Manifest Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class PickupListServices extends BaseService {
    /**
     * Creates a new pickup list 
     *    
     * @param PickupList $request object 
     * @return ResponseStandard object
     * @throws PickupList request object with errors     
     */
	public function create(PickupList $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.pickup_create');
        // Verify the PickupList object.
        if ( !$request->isValid() ) return $request;
        try {                   
            // Try to send the request
            $response = parent::sendRequestWithBody('POST', $baseUrl, $request);
        } catch (TransferException $e) {            
            // Handle a TransferException  
            return $this->returnExceptionAsErrors($e, $request);         
        }    
        // Return a ResponseStandard object
        return new ResponseStandard($response->getBody(), 'pickupList');
    }
    /**
     * Updates a pickup list.
     *
     * NOTE: This service should not be used for partial updates. A full pickup list object with the 
     * desired pick up locations should be passed as input   
     *  
     * @param PickupList $request object 
     * @return ResponseStandard object
     * @throws PickupList request object with errors     
     */
    public function update(int $pickuplistId, PickupList $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.pickup_create') . '/' . $pickuplistID;
        // Verify the PickupList object.
        if ( !$request->isValid() ) return $request;
        try { 
            // Try to send the request                  
            $response = parent::sendRequestWithBody('PUT', $baseUrl, $request);
        } catch (TransferException $e) {            
            // Handle a TransferException  
            return $this->returnExceptionAsErrors($e, $request);         
        }    
        // Return a ResponseStandard object
        return new ResponseStandard($response->getBody(), 'pickupList');
    }
    /**
     * Retrieves a pickup list
     *   
     * @param int $pickupListId 
     * @return ResponseStandard object
     * @throws PickupList request object with errors     
     */
    public function get(int $pickupListId) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.pickup_create') . '/' . $pickupListId;            
        try {  
            // Try to send the request                 
            $response = parent::sendRequestWithoutBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            // Handle a TransferException  
            return $this->returnExceptionAsErrors($e, $request);         
        }    
        // Return a ResponseStandard object
        return new ResponseStandard($response->getBody(), 'pickupList');
    }
    /**
     * Searches pickup lists.
     *  
     * NOTE: To retrieve all pick up lists, omit the searchString parameter
     *
     * @param string|optional $searchString 
     * @return ResponseList object
     * @throws EmptyRequest object with errors     
     */
    public function search(string $searchString = null) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.pickup_create');
        // Handle creation of the query array
        if ($searchString != null) {
            // Add the searchString to the query array
            $query['searchString'] = $searchString;
        } else {
            // Create an empty query array
            $query = [];
        }        
        try { 
            // Try to send the request                  
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $query);
        } catch (TransferException $e) {            
            // Handle a TransferException  
            return $this->returnExceptionAsErrors($e);         
        }    
        // Return a ResponseList object
        return new ResponseList($response->getBody(), 'pickupListList');
    }
    /**
     * Deletes a pickup list
     *  
     * @param int $pickupListId
     * @return ResponseNoData object
     * @throws EmptyRequest object with errors     
     */
    public function delete(int $pickupListId) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.pickup_create') . '/' . $pickupListId;
        try {                   
            // Try to send the request
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl);
        } catch (TransferException $e) {            
            // Handle a TransferException 
            return $this->returnExceptionAsErrors($e);         
        }    
        // Return a ResponseNoData object
        return new ResponseNoData('The pickup list has been deleted');

    }
}