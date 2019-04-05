<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\Manifest;

use Rezdy\Responses\ResponseStandard;
use Rezdy\Responses\ResponseNoData;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to Rezdy API Manifest Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class ManifestServices extends BaseService {
    /**
     * Store Check-in / No show flag for everyone in a specified session.
     * 
     * NOTE: The session is identified by product code and start time (or start time local).  Only 
     * available for the supplier API.
     *
     * @param Rezdy\Requests\Manifest $request
     * @return Rezdy\Responses\ResponseNoData
     * @throws Rezdy\Requests\Manifest
     */
	public function checkInSession(Manifest $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.manifest_check_in_session');
        // Verify the Manifest request object.
        if ( !$request->isValid() ) return $request;     
        try {  
            // Try to send the request
            $response = parent::sendRequestWithoutBody('PUT', $baseUrl, $request->toArray());              
        } catch (TransferException $e) { 
            // Handle a TransferException  
            return $this->returnExceptionAsErrors($e, $request);         
        }    
        // Return a ResponseNoData object
        return new ResponseNoData('Everyone in the Session has had their Check-in status updated');
    }
    /**
     * Retrieves the Check-in status. Checks if everyone in the whole session was checked in. 
     *
     * NOTE: The session is identified by product code and start time (or start time local).  Only 
     * available for the supplier API.
     *
     * @param Rezdy\Requests\Manifest $request
     * @return Rezdy\Responses\ResponseStandard 
     * @throws Rezdy\Requests\Manifest   
     */
    public function getSessionCheckIn(Manifest $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.manifest_check_in_status');
        // Verify the Manifest request object.
        if ( !$request->isValid() ) return $request;     
        try { 
            // Try to send the request 
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $request->toArray());              
        } catch (TransferException $e) { 
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e, $request);         
        }    
        // Return a ResponseStandard object
        return new ResponseStandard($response->getBody(), 'checkin');
    }
    /**
     * Remove Check-in / No show flag from everyone in the whole session.
     *
     * NOTE: The session is identified by product code and start time (or start time local).  Only 
     * available for the supplier API.
     *
     * @param Rezdy\Requests\Manifest $request
     * @return Rezdy\Responses\ResponseNoData
     * @throws Rezdy\Requests\Manifest 
     */
    public function removeSessionCheckIn(Manifest $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.manifest_remove_check_in');
        // Verify the Manifest request object.
        if ( !$request->isValid() ) return $request;     
        try {  
            // Try to send the request 
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl, $request->toArray());              
        } catch (TransferException $e) { 
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e, $request);         
        }    
        // Return a ResponseNoData object
        return new ResponseNoData('Everyone in the Session has had their Check-in status updated');
    }
    /**
     * Place Check-in a / No show flag for the specified order item.
     *
     * NOTE: The order item is identified by order number, product code and start time (or start time local).
     * Only available for the supplier API.
     *
     * @param Rezdy\Requests\Manifest $request
     * @return Rezdy\Responses\ResponseNoData
     * @throws Rezdy\Requests\Manifest    
     */
    public function checkInOrderItem(Manifest $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.manifest_check_in_item');
        // Verify the Manifest request object.
        if ( !$request->isValid() ) return $request;    
        try { 
            // Try to send the request  
            $response = parent::sendRequestWithoutBody('PUT', $baseUrl, $request->toArray());              
        } catch (TransferException $e) { 
            // Handle a TransferException
            return $this->returnExceptionAsErrors($manifest, $e);         
        }  
        // Return a ResponseNoData object
        return new ResponseNoData('The Item has been checked');  
    }
    /**
     * Retrieves the Check-in status. Checks if everyone in the whole session was checked in.
     *
     * NOTE: Retrieves the Check-in status. Checks if everyone in the whole session was checked in.  Only 
     * available for the supplier API.
     *
     * @param Rezdy\Requests\Manifest $request
     * @return Rezdy\Responses\ResponseStandard
     * @throws Rezdy\Requests\Manifest    
     */
    public function getOrderItemCheckIn(Manifest $manifest) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.manifest_check_in_item');
        // Verify the Manifest request object.
        if ( !$request->isValid() ) return $request;     
        try {  
            // Try to send the request  
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $request->toArray());              
        } catch (TransferException $e) { 
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e, $request);         
        }
        // Return a ResponseStandard object
        return new ResponseStandard($response->getBody(), 'checkin');    
    }
    /**
     * Remove order item check-in. 
     *
     * @param Rezdy\Requests\Manifest $request
     * @return Rezdy\Responses\ResponseNoData
     * @throws Rezdy\Requests\Manifest     
     */
    public function removeOrderItemCheckIn(Manifest $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.manifest_check_in_item');
        // Verify the Manifest request object.
        if ( !$request->isValid() ) return $request;     
        try { 
            // Try to send the request   
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl, $request->toArray());              
        } catch (TransferException $e) { 
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e, $request);         
        }
        // Return a ResponseNoData object
        return new ResponseNoData('The items check-in status has been cleared');  
    }
}