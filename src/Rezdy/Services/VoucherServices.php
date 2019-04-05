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
	/**
     * Load an existing voucher by Voucher Code
     *    
     * @param string $voucherCode  
     * @return Rezdy\Responses\ResponseStandard
     * @throws Rezdy\Requests\EmptyRequest    
     */
	public function get(string $voucherCode) {
		// Build the request URL
		$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.vouchers') . '/' . $voucherCode;
		try {
			// Try to send the request                   
            $response = parent::sendRequestWithoutBody('GET', $baseUrl);
        } catch (TransferException $e) {            
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e);         
        }    
		// Return a ResponseStandard object
        return new ResponseStandard($response->getBody(), 'voucher');
	}
	/**
     * Search vouchers in your account
     *    
     * @param Rezdy\Requests\SimpleSearch|optional $request  
     * @return Rezdy\Responses\ResponseList
     * @throws Rezdy\Requests\SimpleSearch  
     */
	public function search(SimpleSearch ...$request) {
		// Build the request URL
		$baseUrl = Config::get('endpoints.base_url') . Config::get('endpoints.vouchers');
		// Pluck the SimpleSearch request if multiple passed
		$request = $this->parseOptionalArray($request, new SimpleSearch());
        try {                   
            // Try to send the request     
            $response = parent::sendRequestWithoutBody('GET', $baseUrl, $request->toArray());
        } catch (TransferException $e) {            
            // Handle a TransferException
            return $this->returnExceptionAsErrors($e, $request);
        } 
		// Return a ResponseStandard object
        return new ResponseList($response->getBody(), 'vouchers');
	}		
}