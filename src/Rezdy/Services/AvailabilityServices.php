<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\SessionCreateRequest;
use Rezdy\Requests\SessionUpdateRequest;
use Rezdy\Requests\SessionSearchRequest;
use Rezdy\Requests\EmptyRequest;

use Rezdy\Responses\ResponseSession;
use Rezdy\Responses\ResponseNoData;
use Rezdy\Responses\ResponseSessionList;

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

	public function create(SessionCreateRequest $session) {
		$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.availability_create');
		try {
            $response = parent::sendRequestWithBody('POST', $baseUrl, $session);
        } catch (TransferException $e) {
        	return $this->returnExceptionAsErrors($session, $e);             	
        }    
        
        // Handle the Response
        return new ResponseSession($response->getBody());
	}

	public function update(SessionUpdateRequest $session) {
		$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.availability_update') . $session->sessionId;		
		try {
            $response = parent::sendRequestWithBody('PUT', $baseUrl, $session);
        } catch (TransferException $e) {
        	return $this->returnExceptionAsErrors($session, $e);           	
        }    
        
        // Handle the Response
        return new ResponseSession($response->getBody());
	}

	public function delete($sessionId) {
        $session = new EmptyRequest;
		$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.availability_delete') . $sessionId;
		
		try {
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl);
        } catch (TransferException $e) {
        	return $this->returnExceptionAsErrors($session, $e);            	
        }    
        
        // Handle the Response
        return new ResponseNoData('The session was successfully deleted');
	}

    public function search(SessionSearchRequest $search) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.availability_search');
        try {
            $response = parent::sendRequestWithOutBody('GET', $baseUrl, $search->asArray());
        } catch (TransferException $e) {
            dd($e);
            return $this->returnExceptionAsErrors($search, $e);      
        }    
        
        // Handle the Response
        return new ResponseSessionList($response->getBody());
    }
}