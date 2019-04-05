<?php
namespace Rezdy\Requests\Objects;

use Rezdy\Requests\BaseRequest;

/**
 * Creates and verifies the Participant request
 *
 * @package Requests
 * @author Brad Ploeger
 */
class Participant extends BaseRequest {

	public function __construct($params = '') {
		// Create Fields Array
		$this->fields = [];
	}		

	public function addFields($data) {
		if (is_array($data)) {
			foreach ($data as $item) {
				$this->addFields($item);
			}
		} elseif (get_class($data) == 'Rezdy\Requests\Objects\Field') {
			$this->fields[] = $data;
		}		
	}
}