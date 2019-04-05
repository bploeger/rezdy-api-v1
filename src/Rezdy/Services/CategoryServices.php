<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\CategorySearch;

use Rezdy\Responses\ResponseStandard;
use Rezdy\Responses\ResponseList;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to Rezdy API Category Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class CategoryServices extends BaseService {
    /**
     * Load all categories matching a search request
     *
     * NOTE: If the search string is empty, all categories will be returned.  This will only 
     * return categories belonging to the company doing the request.
     *
     * @param Rezdy\Requests\CategorySearch $request
     * @return Rezdy\Responses\ResponseList
     * @throws Rezdy\Requests\CategorySearch  
     */
	public function search(CategorySearch $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.category_search');
        // Verify the CategorySearch object.
        if ( !$request->isValid() ) return $request;
        try {
            // Try to send the request
            $response = parent::sendRequestWithOutBody('GET', $baseUrl, $request->toArray());
        } catch (TransferException $e) { 
            // Handle a TransferException             
            return $this->returnExceptionAsErrors($e, $request);      
        }    
        // Return a ResponseList object
        return new ResponseList($response->getBody(), 'categories');
    }
    /**
     * Load an existing category by Id
     *
     * @param int $categoryId
     * @return Rezdy\Responses\ResponseStandard
     * @throws Rezdy\Requests\EmptyRequest  
     */
    public function get(int $categoryId) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.category_get') . $categoryId;
        try {   
            // Try to send the request                
            $response = parent::sendRequestWithOutBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e);         
        }    
        // Return a ResponseStandard object 
        return new ResponseStandard($response->getBody(), 'category');
    }
    /**
     * Load all products within a category. 
     *
     * @param int $categoryId
     * @param array|optional $optionalSettings
     * @return Rezdy\Responses\ResponseList
     * @throws Rezdy\Requests\EmptyRequest   
     */
    public function list(int $categoryId, array $optionalSettings = array()) {        
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . sprintf( Config::get('endpoints.category_list'), $categoryId );
        foreach ($optionalSettings as $key => $value) {
            // Parse the Optional Settings Array
            $options[][$key] = $value;
        } 
        try {
            // Try to send the request
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $options);
        } catch (TransferException $e) {
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e);                
        }    
        // Return a ResponseList object 
        return new ResponseList($response->getBody(), 'products');
    }
    /**
     * Adds a product to an existing category. 
     *
     * @param int $categoryId
     * @param string $productCode
     * @return Rezdy\Responses\ResponseList
     * @throws Rezdy\Requests\EmptyRequest
     */
    public function addProduct(int $categoryId, string $productCode) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . sprintf( Config::get('endpoints.category_add_product'), $categoryId, $productCode );
        try {
            // Try to send the request
            $response = parent::sendRequestWithoutBody('PUT', $baseUrl);
        } catch (TransferException $e) {
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e);                
        }    
        // Return a ResponseList object
        return new ResponseList($response->getBody(), 'rate');
    }
    /**
     * Removes a product from an existing category
     *
     * @param int $categoryId
     * @param string $productCode
     * @return Rezdy\Responses\ResponseList
     * @throws Rezdy\Requests\EmptyRequest
     */
    public function removeProduct(int $categoryID, string $productCode) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . sprintf( Config::get('endpoints.category_remove_product'), $categoryID, $productCode );
        try {
            // Try to send the request
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl);
        } catch (TransferException $e) {
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e);                
        }    
        // Return a ResponseList object
        return new ResponseList($response->getBody(), 'rate');
    }
}