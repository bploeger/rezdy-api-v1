<?php
namespace Rezdy\Requests\Objects;

use Rezdy\Requests\BaseRequest;

/**
 * Creates and verifies the ExtraImage request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class ExtraImage extends BaseRequest {

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