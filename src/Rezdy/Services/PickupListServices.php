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

	public function create(PickupList $request) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.pickup_create');
            
        // Verify the product request has the minimum information required prior to submission.
        if ( !$request->isValid() ) return $request;

        // try to Send the request
        try {                   
            $response = parent::sendRequestWithBody('POST', $baseUrl, $request);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e, $request);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'pickupList');
    }

    public function update(int $pickuplistId, PickupList $request) {
        
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.pickup_create') . '/' . $pickuplistID;
            
        // Verify the product request has the minimum information required prior to submission.
        if ( !$request->isValid() ) return $request;

        // try to Send the request
        try {                   
            $response = parent::sendRequestWithBody('PUT', $baseUrl, $request);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e, $request);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'pickupList');
    }

    public function find(int $pickuplistId) {
        
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.pickup_create') . '/' . $pickuplistId;
            
        // try to Send the request
        try {                   
            $response = parent::sendRequestWithoutBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e, $request);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'pickupList');
    }

    public function search(string ...$search) {
        
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.pickup_create');

        if (count($search)) {
            $request = ['searchString' =>   $search[0]];
        } else {
            $request = [];
        }

        // try to Send the request
        try {                   
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $request);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e, $request);         
        }    

        // Handle the Response
        return new ResponseList($response->getBody(), 'pickupListList');
    }

    public function delete(int $pickupListId) {
        
         $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.pickup_create') . '/' . $pickupListId;

         // try to Send the request
        try {                   
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e);         
        }    
        
        // Handle the Response
        return new ResponseNoData('The pickup list has been deleted');

    }
}