<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\ResourceSessionSearch;
use Rezdy\Requests\SessionSearch;

use Rezdy\Responses\ResponseStandard;
use Rezdy\Responses\ResponseList;
use Rezdy\Responses\ResponseNoData;

use Rezdy\Requests\SimpleSearch;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to booking Rezdy API Rate Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class ResourceServices extends BaseService {

		public function list(SimpleSearch ...$request) {
			$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.resources');

			$request = $this->parseOptionalArray($request, new SimpleSearch());
			
	        // try to Send the request
	        try {                   
	            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $request->toArray());
	        } catch (TransferException $e) {            
	            return $this->returnExceptionAsErrors($e, $request);         
	        }    

	        // Handle the Response
	        return new ResponseList($response->getBody(), 'resources');

		}

		public function addSessionResource(int $resourceId, int $sessionId, int $resourceOrder = 0) {
			
			$baseUrl = Config::get('endpoints.base_url') . sprintf(Config::get('endpoints.resources_add_session'), $resourceId, $sessionId);

			if ($resourceOrder) {
				$request['resourceOrder'] 	= $resourceOrder;
			} else {
				$request = [];
			}

			// try to Send the request
	        try {                   
	            $response = parent::sendRequestWithoutBody('PUT', $baseUrl, $request);
	        } catch (TransferException $e) {            
	            return $this->returnExceptionAsErrors($e);         
	        }    

	        // Handle the Response
	        return new ResponseStandard($response->getBody(), 'resource');

		}

		public function getResourceSessions(int $resourceId, ResourceSessionSearch ...$request) {

			$baseUrl = Config::get('endpoints.base_url') . sprintf(Config::get('endpoints.resources_sessions'), $resourceId);

			$request = $this->parseOptionalArray($request, new ResourceSessionSearch);

			// try to Send the request
	        try {                   
	            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $request->toArray());
	        } catch (TransferException $e) {            
	            return $this->returnExceptionAsErrors($e);         
	        }  

	        // Handle the Response
	        return new ResponseStandard($response->getBody(), 'sessions');
  
		}

		public function getSessionResources(SessionSearch $request) {
			$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.resources_session');

			// WORKING HERE
		}

		public function removeSessionResources() {

		}
}