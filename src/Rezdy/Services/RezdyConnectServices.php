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

		public function update(string $productCode, bool $skipEndpointsValidation = false) {
			$baseUrl = Config::get('endpoints.base_url') . sprintf(Config::get('endpoints.rezdy_connect'), $productCode);
			
			//Pass the correct Query Parameters
			$request['skipEndpointsValidation'] = $skipEndpointsValidation;

	        // try to Send the request
	        try {                   
	            $response = parent::sendRequestWithoutBody('PUT', $baseUrl, $request);
	        } catch (TransferException $e) {            
	            return $this->returnExceptionAsErrors($e);         
	        }    

	        // Handle the Response
	        return new ResponseStandard($response->getBody(), 'rezdyConnectSettings');
		}

		public function get(string $productCode) {
			$baseUrl = Config::get('endpoints.base_url') . sprintf(Config::get('endpoints.rezdy_connect'), $productCode);
			
			// try to Send the request
	        try {                   
	            $response = parent::sendRequestWithoutBody('GET', $baseUrl);
	        } catch (TransferException $e) {            
	            return $this->returnExceptionAsErrors($e);         
	        }    

	        // Handle the Response
	        return new ResponseStandard($response->getBody(), 'rezdyConnectSettings');
		}

		public function remove(string $productCode) {
			$baseUrl = Config::get('endpoints.base_url') . sprintf(Config::get('endpoints.rezdy_connect'), $productCode);
			
			 // try to Send the request
	        try {                   
	            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl);
	        } catch (TransferException $e) {            
	            return $this->returnExceptionAsErrors($e);         
	        }    

	        // Handle the Response
	        return new ResponseStandard($response->getBody(), 'rezdyConnectSettings');
		}		
}