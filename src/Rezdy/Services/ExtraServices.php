<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\Extra;

use Rezdy\Responses\ResponseStandard;
use Rezdy\Responses\ResponseList;
use Rezdy\Responses\ResponseNoData;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to Rezdy API Extra Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class ExtraServices extends BaseService {
    /**
     * Creates a new extra
     *
     * @param Extra request object
     * @return ResponseStandard object
     * @throws Extra request object with errors    
     */
	public function create(Extra $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.extra_create');
        // Verify the Extra request object.
        if ( !$request->isValid() ) return $request;        
        try {       
            // Try to send the request           
            $response = parent::sendRequestWithBody('POST', $baseUrl, $request);
        } catch (TransferException $e) {            
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e, $request);         
        }
        // Return a ResponseStandard object 
        return new ResponseStandard($response->getBody(), 'extra');
    }
    /**
     * Retrieves an extra by Id
     *
     * @param int $extraId
     * @return ResponseStandard object
     * @throws Extra request object with errors    
     */
    public function retrieve(int $extraId) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.extra_get') . $extraId;
        try {
            // Try to send the request                     
            $response = parent::sendRequestWithOutBody('GET', $baseUrl);
        } catch (TransferException $e) {
            // Handle a TransferException            
            return $this->returnExceptionAsErrors($e);         
        }    
        // Return a ResponseStandard object 
        return new ResponseStandard($response->getBody(), 'extra');
    }
    /**
     * Updates an extra. 
     *
     * NOTE: The extra ID can change when updating it, since there are business rules to protect 
     * the Order and Product consistency.
     *
     * @param int $extraId
     * @param Extra request object
     * @return ResponseStandard object
     * @throws Extra request object with errors    
     */
    public function update(int $extraID, Extra $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.extra_update') . $extraID;         
        // Verify the Extra request object.
        if ( !$request->isValid() ) return $request;
        try {
            // Try to send the request                     
            $response = parent::sendRequestWithBody('PUT', $baseUrl, $request);
        } catch (TransferException $e) {            
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e, $request);         
        }    
        // Return a ResponseStandard object 
        return new ResponseStandard($response->getBody(), 'extra');
    }
    /**
     * Deletes an extra
     *
     * NOTE: The extra ID can change when updating it, since there are business rules to protect 
     * the Order and Product consistency.
     *
     * @param int $extraId
     * @return ResponseNoData object
     * @throws EmptyRequest object with errors    
     */
    public function delete(int $extraId) {        
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.extra_delete') . $extraId;   
        try {
            // Try to send the request  
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl);
        } catch (TransferException $e) {
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e);                
        }    
        // Return a ResponseNoData object 
        return new ResponseNoData('The extra was successfully deleted');
    }
    /**
     * Searches for extra name
     *
     * NOTE: To retrieve all extras, omit the searchString parameter
     *
     * @param string|optional $searchString
     * @return ResponseList object
     * @throws EmptyRequest object with errors    
     */
    public function search(string $searchString = '') {        
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.extra_search');
        // Build the Search String Array
        $search['searchString'] = $searchString;          
        try {
            // Try to send the request 
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $search);
        } catch (TransferException $e) {
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e);                
        }   
        // Return a ResponseList object 
        return new ResponseList($response->getBody(), 'extras');
    }
}