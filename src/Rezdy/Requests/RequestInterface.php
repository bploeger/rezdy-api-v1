<?php
namespace Rezdy\Requests;

use Rezdy\Exceptions\RezdyException;

/**
 * Declare the interface for Requests
 *
 * @package Resources
 * @author Brad Ploeger
 */
interface RequestInterface {
	
	// Validation Function
	public function isValid();
	
	// Error Handling
	public function appendTransferErrors(RezdyException $e);
	public function viewErrors();
	
	// Add Information Settings
	public function set($data, string $key = null);
	public function attach($data);
	
	// Output Formats
	public function toJSON();
	public function toArray();
}

