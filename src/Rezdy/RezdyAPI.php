<?php

/*
 * This file is part of the Rezdy API Wrapper package.
 *
 * (c) Brad Ploeger <bploeger@arkturis.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rezdy;
use Rezdy\Services\AvailabilityService;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

/**
 * Exposes all implemented Rezdy API functionality
 *
 * @package Rezdy
 * @version 1.0.0
 * @author Brad Ploeger
 */
class RezdyAPI
{
	/**
     * Handles interaction with availability management
     * @var availabilityServices
     * @todo WORKING HERE
     */
	public $availabiltyServices;

	/**
     * Handles interaction with booking management
     * @var bookingServices
     */
	public $bookingServices;

	/**
     * Handles interaction with category management
     * @var categoryServices
     */
	public $categoryServices;

	/**
     * Handles interaction with company management
     * @var companyServices
     */
	public $companyServices;

	/**
     * Handles interaction with customer management
     * @var customerServices
     */
	public $customerServices;

	/**
     * Handles interaction with extras management
     * @var extraServices
     */
	public $extraServices;

	/**
     * Handles interaction with manifest management
     * @var manifestServices
     */
	public $manifestServices;

	/**
     * Handles interaction with pickupList management
     * @var pickupListServices
     */
	public $pickupListServices;

	/**
     * Handles interaction with product management
     * @var productServices
     */
	public $productServices;

	/**
     * Handles interaction with rate management
     * @var rateServices
     */
	public $rateServices;

	/**
     * Handles interaction with resource management
     * @var resourceServices
     */
	public $resourceServices;

	/**
     * Handles interaction with rezdyConnect management
     * @var rezdyConnectServices
     */
	public $rezdyConnectServices;

	/**
     * Handles interaction with voucher management
     * @var voucherServices
     */
	public $voucherServices;

	/**
     * Class constructor
     * Registers the API key with the RezdyAPI class that will be used for all API calls.
     * @param string $apiKey - Rezdy API Key
     * @param ClientInterface|null $client - GuzzleHttp Client
     */
	public function __construct($apiKey, ClientInterface $client = null) {
        $client = $client ?: new Client();

        $this->availabilityService = new AvailabilityService($apiKey, $client);
        
    }
}