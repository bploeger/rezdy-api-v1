<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\Product;
use Rezdy\Requests\ProductUpdate;
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
    /**
     * Creates a new product
     *    
     * @param Rezdy\Requests\Product $request
     * @return Rezdy\Responses\ResponseStandard
     * @throws Rezdy\Requests\Product  
     */
	public function create(Product $request) {
		// Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.product_create');
     	// Verify the Product object.
        if ( !$request->isValid() ) return $request;
        try {                   
            // Try to send the request
            $response = parent::sendRequestWithBody('POST', $baseUrl, $request);
        } catch (TransferException $e) {            
            // Handle a TransferException  
            return $this->returnExceptionAsErrors($e, $request);         
        }   
        // Return a ResponseStandard object
        return new ResponseStandard($response->getBody(), 'product');
    }
    /**
     * Load an existing product by Product Code
     *    
     * @param string $productCode 
     * @return Rezdy\Responses\ResponseStandard
     * @throws Rezdy\Requests\EmptyRequest   
     */
    public function get(string $productCode) {
		// Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.product_get') . $productCode;     	
        try {                   
            // Try to send the request
            $response = parent::sendRequestWithBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            // Handle a TransferException  
            return $this->returnExceptionAsErrors($e);         
        }    
        // Return a ResponseStandard object
        return new ResponseStandard($response->getBody(), 'product');
    }
    /**
     * Updates a product.
     *       
     * @param string $productCode 
     * @param Rezdy\Requests\ProductUpdate $request
     * @return Rezdy\Responses\ResponseStandard
     * @throws Rezdy\Requests\ProductUpdate 
     */
    public function update(string $productCode, ProductUpdate $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.product_get') . $productCode;        
        try {                   
            // Try to send the request
            $response = parent::sendRequestWithBody('PUT', $baseUrl, $request);
        } catch (TransferException $e) {            
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e, $request);         
        }  
        // Return a ResponseStandard object
        return new ResponseStandard($response->getBody(), 'product');
    }
    /**
     * Deletes a product.
     *       
     * @param string $productCode 
     * @return Rezdy\Responses\ResponseNoData
     * @throws Rezdy\Requests\EmptyRequest   
     */
    public function delete(string $productCode) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.product_get') . $productCode;        
        try {                   
            // Try to send the request
            $response = parent::sendRequestWithBody('DELETE', $baseUrl);
        } catch (TransferException $e) {            
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e);         
        }    
        // Return a ResponseNoData object
        return new ResponseNoData('The product has been deleted');
    }
    /**
     * Searches a product that matches a search request.
     *    
     * NOTE:  If the search string is empty, all your products will be returned.   Use this service 
     * when acting as a supplier, to load your own products. If you're acting as an agent, use the 
     * searchMarketplace function
     *   
     * @param Rezdy\Requests\SimpleSearch $request 
     * @return Rezdy\Responses\ResponseList
     * @throws Rezdy\Requests\SimpleSearch  
     */
    public function search(SimpleSearch $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.product_create');                     
        try {
            // Try to send the request
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $request->toArray());
        } catch (TransferException $e) {
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e);                
        }    
        // Return a ResponseList object
        return new ResponseList($response->getBody(), 'products');
    }
    /**
     * Load products from the Rezdy Marketplace.
     *    
     * NOTE:  Use this service when acting as an agent, to find products that are available for 
     * you to book.
     *   
     * @param Rezdy\Requests\MarketplaceSearch $request object 
     * @return Rezdy\Responses\ResponseList
     * @throws Rezdy\Requests\SimpleSearch  
     */
    public function searchMarketplace(MarketplaceSearch $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.product_create');
        // Verify the MarketplaceSearch request object.
        if ( !$request->isValid() ) return $request;                  
        try {
            // Try to send the request
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $request->toArray());
        } catch (TransferException $e) {
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e, $search);                
        }    
        // Return a ResponseList object
        return new ResponseList($response->getBody(), 'products');
    }
    /**
     * Gets a list of pickup locations configured for this product.
     *    
     * @param string $productCode   
     * @param Rezdy\Requests\SimpleSearch|optional $request
     * @return Rezdy\Responses\ResponseList
     * @throws Rezdy\Requests\SimpleSearch    
     */
    public function getPickups(string $productCode, SimpleSearch ...$request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . sprintf( Config::get('endpoints.product_pickups'), $productCode );
        // Pluck the SimpleSearch object if passed
        $request = $this->parseOptionalArray($request, new SimpleSearch());
        try {
            // Try to send the request
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $request->toArray());
        } catch (TransferException $e) {
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e, $search);                
        }   
        // Return a ResponseList object
        return new ResponseList($response->getBody(), 'pickupLocations');
    }
}