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

	public function create(Customer $customer) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.customer_create');
            
        // Verify the customer request has the minimum information required prior to submission.
        if ( !$customer->isValid() ) return $customer;

        // try to Send the request
        try {                   
            $response = parent::sendRequestWithBody('POST', $baseUrl, $customer);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($customer, $e);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'customer');
    }

    public function find($customerID) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.customer_get') . $customerID;

        $request = new EmptyRequest;
                         
        // try to Send the request
        try {                   
            $response = parent::sendRequestWithOutBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($request, $e);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'customer');
    }

    public function delete($customerID) {        
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.customer_delete') . $customerID;
        
        $request = new EmptyRequest;
   
        try {
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl);
        } catch (TransferException $e) {
            return $this->returnExceptionAsErrors($request, $e);                
        }    
        
        // Handle the Response
        return new ResponseNoData('The customer was successfully deleted');
    }

    public function search(SearchRequest $search) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.customer_search');
        
        // Verify the booking request has the minimum information required prior to submission.
        if ( !$search->isValid() ) return $search;

        try {
            $response = parent::sendRequestWithOutBody('GET', $baseUrl, $search->toArray());
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($search, $e);      
        }    
        
        // Handle the Response
        return new ResponseList($response->getBody(), 'customers');
    }
}