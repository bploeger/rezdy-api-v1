<?php
namespace Rezdy\Services;

use Rezdy\Util\Config;

use Rezdy\Requests\SimpleSearch;

use Rezdy\Responses\ResponseStandard;
use Rezdy\Responses\ResponseList;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7;

/**
 * Performs all actions pertaining to the Rezdy API Voucher Service Calls
 *
 * @package Services
 * @author Brad Ploeger
 */
class VoucherServices extends BaseService {

		public function get(string $voucherCode) {
			$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.vouchers') . '/' . $voucherCode;
			
			// try to Send the request
	        try {                   
	            $response = parent::sendRequestWithoutBody('GET', $baseUrl);
	        } catch (TransferException $e) {            
	            return $this->returnExceptionAsErrors($e);         
	        }    

	        // Handle the Response
	        return new ResponseStandard($response->getBody(), 'voucher');
		}

		public function search(SimpleSearch ...$request) {
			$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.vouchers');

			$request = $this->parseOptionalArray($request, new SimpleSearch());

			// try to Send the request
	        try {                   
	            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $request->toArray());
	        } catch (TransferException $e) {            
	            return $this->returnExceptionAsErrors($e, $request);
	        } 

	        // Handle the Response
	        return new ResponseList($response->getBody(), 'vouchers');
		}
		
}