<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\EmptyRequest;
use Rezdy\Requests\Customer;
use Rezdy\Requests\Customer\SearchRequest;

use Rezdy\Responses\ResponseStandard;
use Rezdy\Responses\ResponseList;
use Rezdy\Responses\ResponseNoData;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to booking Rezdy API Customer Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class CustomerServices extends BaseService {

	public function create(Customer $request) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.customer_create');
            
        // Verify the customer request has the minimum information required prior to submission.
        if ( !$request->isValid() ) return $request;

        // try to Send the request
        try {                   
            $response = parent::sendRequestWithBody('POST', $baseUrl, $request);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e, $request);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'customer');
    }

    public function find($customerID) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.customer_get') . $customerID;
                         
        // Try to Send the request
        try {                   
            $response = parent::sendRequestWithOutBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'customer');
    }

    public function delete($customerID) {        
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.customer_delete') . $customerID;
   
        try {
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl);
        } catch (TransferException $e) {
            return $this->returnExceptionAsErrors($e);                
        }    
        
        // Handle the Response
        return new ResponseNoData('The customer was successfully deleted');
    }

    public function search(SearchRequest $request) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.customer_search');
        
        // Verify the request has the minimum information required prior to submission.
        if ( !$request->isValid() ) return $request;

        try {
            $response = parent::sendRequestWithOutBody('GET', $baseUrl, $request->toArray());
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($request, $e);      
        }    
        
        // Handle the Response
        return new ResponseList($response->getBody(), 'customers');
    }
}