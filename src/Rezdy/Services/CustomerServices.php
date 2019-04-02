<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\Customer;
use Rezdy\Requests\SimpleSearch;

use Rezdy\Responses\ResponseStandard;
use Rezdy\Responses\ResponseList;
use Rezdy\Responses\ResponseNoData;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to Rezdy API Customer Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class CustomerServices extends BaseService {
    /**
     * Create a new customer      
     * @param Customer $request object 
     * @return ResponseStandard object
     * @throws Customer request object with errors     
     */
	public function create(Customer $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.customer_create');            
        // Verify the Customer object.
        if ( !$request->isValid() ) return $request;
        try { 
            // Try to Send the request                  
            $response = parent::sendRequestWithBody('POST', $baseUrl, $request);
        } catch (TransferException $e) {
            // Handle Transfer Exceptions            
            return $this->returnExceptionAsErrors($e, $request);         
        }  
        // Return the Response
        return new ResponseStandard($response->getBody(), 'customer');
    }
    /**
     * Load an existing customer by Id   
     * @param int $customerId 
     * @return ResponseStandard object
     * @throws Customer request object with errors     
     */
    public function get(int $customerID) {
        // Build the Request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.customer_get') . $customerId;                       
        try {                   
            // Try to Send the request  
            $response = parent::sendRequestWithOutBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            // Handle Transfer Exceptions  
            return $this->returnExceptionAsErrors($e);         
        }    
        // Return the ResponseStandard
        return new ResponseStandard($response->getBody(), 'customer');
    }
    /**
     * Delete a customer 
     * @param string $customerId 
     * @return ResponseNoData object
     * @throws Customer request object with errors     
     */
    public function delete(string $customerId) {        
        // Build the Request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.customer_delete') . $customerId;
        try {
            // Try to Send the request  
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl);
        } catch (TransferException $e) {
            // Handle Transfer Exceptions 
            return $this->returnExceptionAsErrors($e);                
        }    
        // Return the ResponseNoData
        return new ResponseNoData('The customer was successfully deleted');
    }
    /**
     * Search customers in the account
     * @param SimpleSeach object
     * @return ResponseList object
     * @throws SimpleSearch object with errors     
     */
    public function search(SimpleSearch $request) {
        // Build the Request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.customer_search');
        // Verify the request has the minimum information required prior to submission.
        if ( !$request->isValid() ) return $request;        
        try {
            // Try to Send the Request
            $response = parent::sendRequestWithOutBody('GET', $baseUrl, $request->toArray());
        } catch (TransferException $e) {  
            // Handle Transfer Exceptions           
            return $this->returnExceptionAsErrors($e, $request);      
        }            
        // Return the ResponseList
        return new ResponseList($response->getBody(), 'customers');
    }
}