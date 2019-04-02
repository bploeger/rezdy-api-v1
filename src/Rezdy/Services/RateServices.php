<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\EmptyRequest;
use Rezdy\Requests\ProductRate;

use Rezdy\Responses\ResponseStandard;
use Rezdy\Responses\ResponseList;
use Rezdy\Responses\ResponseNoData;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to booking Rezdy API Rate Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class RateServices extends BaseService {

    public function search(array ...$searchParams) {        
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.rate_search');

        $request = $this->parseOptionalArray($searchParams, []);

        // try to Send the request
        try {                   
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $request);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e, $request);         
        }    

        // Handle the Response
        return new ResponseList($response->getBody(), 'rates');
    }

    public function find(int $rateId) {
        $baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.rate_get') . $rateId;

        // Try to Send the request
        try {                   
            $response = parent::sendRequestWithoutBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e);         
        }    

        // Handle the Response
        return new ResponseStandard($response->getBody(), 'rate');

    }

    public function addProduct(int $rateId, string $productCode, ProductRate $request) {
        $baseUrl = Config::get('endpoints.base_url') . sprintf(Config::get('endpoints.rate_product'), $rateId, $productCode);

        //Set the Product Code Automatically
        $request->set('productCode', $productCode);

        // Verify the rate request has the minimum information required prior to submission.
        if ( !$request->isValid() ) return $request;        

        // try to Send the request
        try {                   
            $response = parent::sendRequestWithBody('PUT', $baseUrl, $request);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e, $request);         
        }    

        // Handle the Response
        return new ResponseStandard($response->getBody(), 'rate');
    }

    public function removeProduct(int $rateId, string $productCode) {
        $baseUrl = Config::get('endpoints.base_url') . sprintf(Config::get('endpoints.rate_product'), $rateId, $productCode);

        // try to Send the request
        try {                   
            $response = parent::sendRequestWithoutBody('DELETE', $baseUrl);
        } catch (TransferException $e) {            
            return $this->returnExceptionAsErrors($e);         
        }    

        return new ResponseNoData('The Rate has been removed from the product');

    }

    
}