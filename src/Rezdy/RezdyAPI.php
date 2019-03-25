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

use Rezdy\Services\AvailabilityServices;
use Rezdy\Services\BookingServices;

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
     * @var availability
     */
	public $availability;

	/**
     * Handles interaction with booking management
     * @var bookings
     */
	public $bookings;

	/**
     * Handles interaction with category management
     * @var categories
     */
	public $categories;

	/**
     * Handles interaction with company management
     * @var companies
     */
	public $companies;

	/**
     * Handles interaction with customer management
     * @var customer
     */
	public $customers;

	/**
     * Handles interaction with extras management
     * @var extra
     */
	public $extra;

	/**
     * Handles interaction with manifest management
     * @var manifest
     */
	public $manifest;

	/**
     * Handles interaction with pickupList management
     * @var pickupList
     */
	public $pickupList;

	/**
     * Handles interaction with product management
     * @var product
     */
	public $products;

	/**
     * Handles interaction with rate management
     * @var rates
     */
	public $rates;

	/**
     * Handles interaction with resource management
     * @var resources
     */
	public $resources;

	/**
     * Handles interaction with rezdyConnect management
     * @var rezdyConnects
     */
	public $rezdyConnect;

	/**
     * Handles interaction with voucher management
     * @var vouchers
     */
	public $vouchers;

	/**
     * Class constructor
     * Registers the API key with the RezdyAPI class that will be used for all API calls.
     * @param ClientInterface|null $client - GuzzleHttp Client
     */
	public function __construct($apiKey, ClientInterface $client = null) {
           
        $client = $client ?: new Client();

        //Register the Service Handlers to the API object
        $this->availability = new AvailabilityServices($apiKey, $client);
        $this->bookings = new BookingServices($apiKey, $client);

        
    }
}