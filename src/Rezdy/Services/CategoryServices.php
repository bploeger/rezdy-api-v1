<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\Category\SearchRequest;
use Rezdy\Requests\EmptyRequest;

use Rezdy\Responses\ResponseStandard;
use Rezdy\Responses\ResponseList;
use Rezdy\Responses\ResponseNoData;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to booking Rezdy API Category Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class CategoryServices extends BaseService {

	public function search(SearchRequest $request) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.category_search');
        
        // Verify the search request has the minimum information required prior to submission.
        if ( !$request->isValid() ) return $request;

        try {
            $response = parent::sendRequestWithOutBody('GET', $baseUrl, $request->toArray());
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e, $request);      
        }    
        
        // Handle the Response
        return new ResponseList($response->getBody(), 'categories');
    }

    public function find($categoryID) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.category_get') . $categoryID;
       
        // try to Send the request
        try {                   
            $response = parent::sendRequestWithOutBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'category');
    }

    public function list($categoryID, array $optionalSettings = array()) {        
        $baseUrl = Config::get('endpoints.base_url') . sprintf( Config::get('endpoints.category_list'), $categoryID );
        
        foreach ($optionalSettings as $key => $value) {
            $options[][$key] = $value;
        } 

        try {
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $options);
        } catch (TransferException $e) {
            return $this->returnExceptionAsErrors($e);                
        }    
        
        // Handle the Response
        return new ResponseList($response->getBody(), 'products');
    }

    public function addProduct($categoryID, $productCode) {
        $baseUrl = Config::get('endpoints.base_url') . sprintf( Config::get('endpoints.category_add_product'), $categoryID, $productCode );

        try {
            $response = parent::sendRequestWithoutBody('PUT', $baseUrl);
        } catch (TransferException $e) {
            return $this->returnExceptionAsErrors($e);                
        }    
        
        // Handle the Response
        return new ResponseList($response->getBody(), 'rate');
    }

    public function removeProduct($categoryID, $productCode) {
        $baseUrl = Config::get('endpoints.base_url') . sprintf( Config::get('endpoints.category_remove_product'), $categoryID, $productCode );

        $request = new EmptyRequest;

        try {
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl);
        } catch (TransferException $e) {
            return $this->returnExceptionAsErrors($e);                
        }    
        
        // Handle the Response
        return new ResponseList($response->getBody(), 'rate');
    }
}