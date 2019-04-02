<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\Availability\CreateRequest;
use Rezdy\Requests\Availability\UpdateRequest;
use Rezdy\Requests\Availability\SearchRequest;
use Rezdy\Requests\EmptyRequest;

use Rezdy\Responses\ResponseStandard;
use Rezdy\Responses\ResponseNoData;
use Rezdy\Responses\ResponseList;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to scheduling Rezdy API Availability Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class AvailabilityServices extends BaseService {

	/**
     * Get creates a new session
     * @param SessionCreateRequest object 
     * @return array of VerifiedEmailAddress
     * @throws RezdyException
     */

	public function create(CreateRequest $request) {
		$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.availability_create');
		try {
            $response = parent::sendRequestWithBody('POST', $baseUrl, $request);
        } catch (TransferException $e) {
        	return $this->returnExceptionAsErrors($e, $request);             	
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'session');
	}

	public function update(UpdateRequest $request) {
		$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.availability_update') . $request->sessionId;		
		try {
            $response = parent::sendRequestWithBody('PUT', $baseUrl, $request);
        } catch (TransferException $e) {
        	return $this->returnExceptionAsErrors($e, $request);           	
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'session');
	}

	public function delete($sessionId) {
        $session = new EmptyRequest;
		$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.availability_delete') . $sessionId;
		
		try {
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl);
        } catch (TransferException $e) {
        	return $this->returnExceptionAsErrors($e);            	
        }    
        
        // Handle the Response
        return new ResponseNoData('The session was successfully deleted');
	}

    public function search(SearchRequest $request) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.availability_search');
        try {
            $response = parent::sendRequestWithOutBody('GET', $baseUrl, $request->toArray());
        } catch (TransferException $e) {
            return $this->returnExceptionAsErrors($e, $request);      
        }    
        
        // Handle the Response
        return new ResponseList($response->getBody(), 'sessions');
    }
}