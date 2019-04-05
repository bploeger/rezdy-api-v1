<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\ProductRate;

use Rezdy\Responses\ResponseStandard;
use Rezdy\Responses\ResponseList;
use Rezdy\Responses\ResponseNoData;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to Rezdy API Rate Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */  
class RateServices extends BaseService {
    /**
     * Searches rates based on rate name and product code.
     *
     * NOTE: If rateName and productCode are not specified, then it will return all rates belonging to the supplier
     *    
     * @param array|optional $queryParams  
     * @return Rezdy\Responses\ResponseList
     * @throws Rezdy\Requests\EmptyRequest   
     */
    public function search(array ...$queryParams) {        
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.rate_search');
        // Pluck the queryParams array if passed
        $query = $this->parseOptionalArray($searchParams, []);
        try {                   
            // Try to send the request
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $query);
        } catch (TransferException $e) {            
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e);         
        }    
        // Return a ResponseList object
        return new ResponseList($response->getBody(), 'rates');
    }
    /**
     * Retrieves a rate based on its ID
     *
     * @param int $rateId  
     * @return Rezdy\Responses\ResponseStandard
     * @throws Rezdy\Requests\EmptyRequest    
     */
    public function get(int $rateId) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.rate_get') . $rateId;
        try {                   
            // Try to send the request
            $response = parent::sendRequestWithoutBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e);         
        }    
        // Return a ResponseList object
        return new ResponseStandard($response->getBody(), 'rate');
    }
    /**
     * Adds a product to the specified  rate
     *
     * @param int $rateId  
     * @param string $productCode
     * @param Rezdy\Requests\ProductRate $request
     * @return Rezdy\Responses\ResponseStandard
     * @throws Rezdy\Requests\ProductRate     
     */
    public function addProduct(int $rateId, string $productCode, ProductRate $request) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . sprintf(Config::get('endpoints.rate_product'), $rateId, $productCode);
        //Set the Product Code Automatically
        $request->set('productCode', $productCode);
        // Verify ProductRate request object.
        if ( !$request->isValid() ) return $request;        
        try {                   
            // Try to send the request
            $response = parent::sendRequestWithBody('PUT', $baseUrl, $request);
        } catch (TransferException $e) {            
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e, $request);         
        }    
        // Return a ResponseStandard object
        return new ResponseStandard($response->getBody(), 'rate');
    }
    /**
     * Removes a product from the specified rate
     *
     * @param int $rateId  
     * @param string $productCode
     * @return Rezdy\Responses\ResponseNoData
     * @throws Rezdy\Requests\EmptyRequest   
     */
    public function removeProduct(int $rateId, string $productCode) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . sprintf(Config::get('endpoints.rate_product'), $rateId, $productCode);
        try {                   
            // Try to send the request
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl);
        } catch (TransferException $e) {            
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e);         
        }    
        // Return a ResponseNoData object
        return new ResponseNoData('The Rate has been removed from the product');
    }    
}