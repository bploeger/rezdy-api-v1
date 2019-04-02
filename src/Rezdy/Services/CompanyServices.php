<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Responses\ResponseStandard;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to Rezdy API Company Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class CompanyServices extends BaseService {
    /**
     * Load an existing Company by it's alias in Rezdy.
     * @param string $companyAlias
     * @return ResponseStandard object
     * @throws EmptyRequest request object with errors     
     */
	public function find(string $companyAlias) {
        // Build the request URL
        $baseUrl = Config::get('endpoints.base_url') . sprintf( Config::get('endpoints.company_get'), $companyAlias );
        try {                   
            // Try to send the request
            $response = parent::sendRequestWithOutBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e);         
        }    
        // Return the ResponseStandard 
        return new ResponseStandard($response->getBody(), 'company');
    }    
}