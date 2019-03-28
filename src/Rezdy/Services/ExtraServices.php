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

	public function create(Extra $extra) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.extra_create');
            
        // Verify the extra request has the minimum information required prior to submission.
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

    public function delete($extraID) {        
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.extra_delete') . $extraID;
        
        $request = new EmptyRequest;
   
        try {
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl);
        } catch (TransferException $e) {
            return $this->returnExceptionAsErrors($request, $e);                
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
            return $this->returnExceptionAsErrors($session, $e);                
        }    
        
        // Handle the Response
        return new ResponseList($response->getBody(), 'extras');
    }
}