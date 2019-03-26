<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\EmptyRequest;

use Rezdy\Responses\ResponseStandard;
use Rezdy\Responses\ResponseList;
use Rezdy\Responses\ResponseNoData;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to booking Rezdy API Company Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class CompanyServices extends BaseService {

	public function find($companyAlias) {
        $baseUrl = Config::get('endpoints.base_url') . sprintf( Config::get('endpoints.company_get'), $companyAlias );
        
        $request = new EmptyRequest;

        // try to Send the request
        try {                   
            $response = parent::sendRequestWithOutBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($request, $e);         
        }    
        
        // Handle the Response
        return new ResponseStandard($response->getBody(), 'company');
    }    
}