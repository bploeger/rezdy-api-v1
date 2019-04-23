<?php
namespace Rezdy\Requests\Objects;

use Rezdy\Requests\BaseRequest;

/**
 * Creates and verifies the Video request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class Video extends BaseRequest {

		public function __construct($params = '') {
			
			//Set the optional properties of the object and the required type
			$this->optionalParams = [		'id'			=> 'integer',
											'platform'		=> 'string',
											'url'			=> 'string',		
									];

			if (is_array($params)) {
				$this->buildFromArray($params);
			}	
		}
}