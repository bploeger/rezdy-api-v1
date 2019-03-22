<?php
namespace Rezdy\Requests;

/**
 * Creates and verifies the BookingItemExtraImage request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class BookingItemExtraImage extends BaseRequest {

		public function __construct($params = '') {			
			//Set the optional properties of the object and the required type
			$this->optionalParams = [	"id"			=> "integer",
                        				"itemUrl"		=> "string",
                        				"largeSizeUrl"	=> "string",
                        				"mediumSizeUrl"	=> "string",
                        				"thumbnailUrl"	=> "string"
									];
			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}
}