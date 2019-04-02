<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Responses\ResponseStandard;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to the Rezdy API RezdyConnect Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class RezdyConnectServices extends BaseService {
	/**
     * Configure a product for RezdyConnect, or update a product Rezdy connect settings.
     *       
     * @param string $productCode
     * @param boolean|optional $skipEndpointsValidation  
     * @return ResponseStandard object
     * @throws EmptyRequest request object with errors     
     */
	public function update(string $productCode, bool $skipEndpointsValidation = false) {
		// Build the request URL
		$baseUrl = Config::get('endpoints.base_url') . sprintf(Config::get('endpoints.rezdy_connect'), $productCode);		
		// Pass the correct Query Parameters
		$query['skipEndpointsValidation'] = $skipEndpointsValidation;
        try {                   
            // Try to send the request
            $response = parent::sendRequestWithoutBody('PUT', $baseUrl, $query);
        } catch (TransferException $e) {            
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e);         
        }    
	    // Return a ResponseStandard object
        return new ResponseStandard($response->getBody(), 'rezdyConnectSettings');
	}
	/**
     * Load an existing product RezdyConnect settings.
     *       
     * @param string $productCode
     * @return ResponseStandard object
     * @throws EmptyRequest request object with errors     
     */
	public function get(string $productCode) {
		// Build the request URL
		$baseUrl = Config::get('endpoints.base_url') . sprintf(Config::get('endpoints.rezdy_connect'), $productCode);
		try {                   
            // Try to send the request
            $response = parent::sendRequestWithoutBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e);         
        }    
        // Return a ResponseStandard object
        return new ResponseStandard($response->getBody(), 'rezdyConnectSettings');
	}
	/**
     * Deconfigure a product from RezdyConnect.
     *       
     * @param string $productCode
     * @return ResponseStandard object
     * @throws EmptyRequest request object with errors     
     */
	public function remove(string $productCode) {
		// Build the request URL
		$baseUrl = Config::get('endpoints.base_url') . sprintf(Config::get('endpoints.rezdy_connect'), $productCode);		
        try {                   
            // Try to send the request
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl);
        } catch (TransferException $e) { 
        	// Handle a TransferException           
            return $this->returnExceptionAsErrors($e);         
        }    
		// Return a ResponseStandard object
        return new ResponseStandard($response->getBody(), 'rezdyConnectSettings');
	}		
}