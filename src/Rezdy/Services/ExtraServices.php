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
 * Performs all actions pertaining to booking Rezdy API Extra Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class ExtraServices extends BaseService {

	public function create(Extra $request) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.extra_create');
            
        // Verify the request has the minimum information required prior to submission.
        if ( !$request->isValid() ) return $request;

        // try to Send the request
        try {                   
            $response = parent::sendRequestWithBody('POST', $baseUrl, $request);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e, $request);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'extra');
    }

    public function find($extraID) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.extra_get') . $extraID;
                         
        // try to Send the request
        try {                   
            $response = parent::sendRequestWithOutBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'extra');
    }

    public function update($extraID, Extra $request) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.extra_update') . $extraID;
            
        // Verify the customer request has the minimum information required prior to submission.
        if ( !$request->isValid() ) return $request;

        // try to Send the request
        try {                   
            $response = parent::sendRequestWithBody('PUT', $baseUrl, $request);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e, $request);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'extra');
    }

    public function delete($extraID) {        
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.extra_delete') . $extraID;
   
        try {
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl);
        } catch (TransferException $e) {
            return $this->returnExceptionAsErrors($e);                
        }    
        
        // Handle the Response
        return new ResponseNoData('The extra was successfully deleted');
    }

    public function search(string $searchString = '') {        
        
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.extra_search');
        
        // Build the Search String Array
        $search['searchString'] = $searchString;
             
        try {
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $search);
        } catch (TransferException $e) {
            return $this->returnExceptionAsErrors($e);                
        }    
        
        // Handle the Response
        return new ResponseList($response->getBody(), 'extras');
    }
}