<?php
namespace Rezdy\Util;

/**
 * Configuration class to hold endpoints, urls, errors messages etc.
 *
 * @package     Util
 * @author      Brad Ploeger
 */
class Config {
    /**
     * @var array - array of configuration properties
     */
    private static $props = [
        /**
         * REST endpoints
         */
        'endpoints' =>  [   'base_url'                  => 'https://api.rezdy.com/v1/',
                            'availability_create'       => 'availability',
                            'availability_update'       => 'availability/',
                            'availability_delete'       => 'availability/',
                            'availability_search'       => 'availability',
                            'booking_create'            => 'bookings',
                            'booking_get'               => 'bookings/',
                            'booking_update'            => 'bookings/',
                            'booking_delete'            => 'bookings/',
                            'booking_search'            => 'bookings',
                            'booking_quote'             => 'bookings/quote',
                            'category_search'           => 'categories',
                            'category_get'              => 'categories/',
                            'category_list'             => 'categories/%s/products',
                            'category_add_product'      => 'categories/%s/products/%s',
                            'category_remove_product'   => 'categories/%s/products/%s',
                            'company_get'               => 'companies/alias/%s',
                            'customer_create'           => 'customers',
                            'customer_get'              => 'customers/',
                            'customer_delete'           => 'customers/',
                            'customer_search'           => 'customers',
                            'extra_create'              => 'extra',
                            'extra_get'                 => 'extra/',
                            'extra_update'              => 'extra/',
                            'extra_delete'              => 'extra/',
                            'extra_search'              => 'extra',
                            'manifest_check_in_session' => 'manifest/checkinSession',
                            'manifest_check_in_status'  => 'manifest/checkinSession',
                            'manifest_remove_check_in'  => 'manifest/checkinSession',
                            'manifest_check_in_item'    => 'manifest/checkinOrderSession',
                            'product_create'            => 'products',
                            'product_get'               => 'products/',
                            'product_marketplace'       => 'products/marketplace',
                            'product_pickups'           => 'products/%s/pickups',
                            'pickup_create'             => 'pickups', 
                            'rate_search'               => 'rates/search',
                            'rate_get'                  => 'rates/',
                            'rate_product'              => 'rates/%s/products/%s',
                            'resources_add_session'     => 'resources/%s/session/%s',
                            'resources_sessions'        => 'resources/%s/sessions',
                            'resources_session'         => 'resources/session',
                            'resource_remove'           => 'resources/%s/session/%s',
                            'rezdy_connect'             => 'products/%s/rezdyConnect',
                        ],
        /**
         * Setting the version of the application used in REST Calls when setting the version header
         */
        'settings' =>   [   'version' => '0.1.0',
                        ],       
    ];

    /**
     * Get a configuration property given a specified location, example usage: Config::get('endpoints.base_url')
     * @param $index - location of the property to obtain
     * @return string
     */
    public static function get($index) {
        $index = explode('.', $index);
        return self::getValue($index, self::$props);
    }

    /**
     * Navigate through a config array looking for a particular index
     * @param array $index The index sequence we are navigating down
     * @param array $value The portion of the config array to process
     * @return mixed
     */
    private static function getValue($index, $value) {
        if (is_array($index) && count($index)) {
            $current_index = array_shift($index);
        }
        if (is_array($index) && count($index) && is_array($value[$current_index]) && count($value[$current_index])) {
            return self::getValue($index, $value[$current_index]);
        } else {
            if (isset($value[$current_index])) {
                return $value[$current_index];
            } else {
                return $current_index;     
            }
            
        }
    }
}
