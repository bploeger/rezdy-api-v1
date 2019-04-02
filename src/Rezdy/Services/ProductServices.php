<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\EmptyRequest;
use Rezdy\Requests\Product;
use Rezdy\Requests\MarketplaceSearch;
use Rezdy\Requests\SimpleSearch;

use Rezdy\Responses\ResponseStandard;
use Rezdy\Responses\ResponseList;
use Rezdy\Responses\ResponseNoData;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to booking Rezdy API Product Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class ProductServices extends BaseService {

	public function create(Product $request) {
		$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.product_create');
     		
        // Verify the product request has the minimum information required prior to submission.
        if ( !$request->isValid() ) return $request;

        // try to Send the request
        try {                   
            $response = parent::sendRequestWithBody('POST', $baseUrl, $request);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e, $request);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'product');
    }

    public function find(string $productCode) {
		$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.product_get') . $productCode;
     		
        // try to Send the request
        try {                   
            $response = parent::sendRequestWithBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'product');
    }

    public function update(string $productCode, Product $request) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.product_get') . $productCode;
        
        // try to Send the request
        try {                   
            $response = parent::sendRequestWithBody('PUT', $baseUrl, $request);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e, $request);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'product');
    }

    public function delete(string $productCode) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.product_get') . $productCode;
        
        // try to Send the request
        try {                   
            $response = parent::sendRequestWithBody('DELETE', $baseUrl);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e);         
        }    
        
        // Handle the Response
        return new ResponseNoData('The product has been deleted');
    }

    public function search(SimpleSearch $request) {
        
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.product_create');
                     
        try {
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $request->toArray());
        } catch (TransferException $e) {
            return $this->returnExceptionAsErrors($e);                
        }    
        
        // Handle the Response
        return new ResponseList($response->getBody(), 'products');
    }

    public function searchMarketplace(MarketplaceSearch $request) {
        
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.product_create');

        // Verify the Search Request.
        if ( !$request->isValid() ) return $request;
                  
        try {
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $request->toArray());
        } catch (TransferException $e) {
            return $this->returnExceptionAsErrors($e, $search);                
        }    
        
        // Handle the Response
        return new ResponseList($response->getBody(), 'products');
    }

    public function getPickups(string $productCode, SimpleSearch ...$request) {

        $baseUrl = Config::get('endpoints.base_url') . sprintf( Config::get('endpoints.product_pickups'), $productCode );

        $request = $this->parseOptionalArray($request, new SimpleSearch());

        try {
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $request->toArray());
        } catch (TransferException $e) {
            return $this->returnExceptionAsErrors($e, $search);                
        }   
        
        // Handle the Response
        return new ResponseList($response->getBody(), 'pickupLocations');

    }


}