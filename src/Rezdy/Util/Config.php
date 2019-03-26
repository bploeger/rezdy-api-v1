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
                        ],
        /**
         * Setting the version fo the application used in Rest Calls when setting the version header
         */
        'settings' =>   [   'version' => '1.x.x'
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
            return $value[$current_index];
        }
    }
}
