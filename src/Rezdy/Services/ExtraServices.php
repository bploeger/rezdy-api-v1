<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\EmptyRequest;
use Rezdy\Requests\Extra;

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
class ExtraServices extends BaseService {

	public function create(Extra $extra) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.extra_create');
            
        // Verify the customer request has the minimum information required prior to submission.
        if ( !$extra->isValid() ) return $extra;

        // try to Send the request
        try {                   
            $response = parent::sendRequestWithBody('POST', $baseUrl, $extra);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($extra, $e);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'extra');
    }

    public function find($extraID) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.extra_get') . $extraID;

        $request = new EmptyRequest;
                         
        // try to Send the request
        try {                   
            $response = parent::sendRequestWithOutBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($request, $e);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'extra');
    }

    public function update($extraID, Extra $extra) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.extra_update') . $extraID;
            
        // Verify the customer request has the minimum information required prior to submission.
        if ( !$extra->isValid() ) return $extra;

        // try to Send the request
        try {                   
            $response = parent::sendRequestWithBody('PUT', $baseUrl, $extra);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($extra, $e);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'extra');
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