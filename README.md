# Rezdy API PHP SDK
[![Latest Stable Version](https://poser.pugx.org/bploeger/rezdy-api-v1/v/stable)](https://packagist.org/packages/bploeger/rezdy-api-v1)
[![Latest Unstable Version](https://poser.pugx.org/bploeger/rezdy-api-v1/v/unstable)](https://packagist.org/packages/bploeger/rezdy-api-v1)
[![License](https://poser.pugx.org/bploeger/rezdy-api-v1/license)](https://packagist.org/packages/bploeger/rezdy-api-v1)

### This library utilizes [GuzzlePHP](http://guzzle.readthedocs.org/)
### This library utilizes [Carbon](https://carbon.nesbot.com/)

## Installing via Composer
[Composer](https://getcomposer.org/) is a dependency management tool for PHP that allows you to declare the dependencies your project needs and installs them into your project. In order to use the Rezdy API PHP SDK through composer, you must add *"bploeger/rezdy-api-v1"* as a dependency in your project's composer.json file.
```javascript
 {
    "require": {
        "bploeger/rezdy-api-v1": "^1.0"
    }
 }
```

## Documentation

The source documentation is hosted at https://github.com/bploeger/rezdy-api-v1/wiki

API Documentation provided by Rezdy is located at https://developers.rezdy.com/rezdy-api/reference

## Usage
The RezdyAPI class contains the underlying services that hold the methods that use the API.
```php
use Rezdy\RezdyAPI;
use Rezdy\Requests\SimpleSearch;

// Initialize the API
$rezdyAPI = new RezdyAPI('your api key');

// Set the search parameters
$searchParams =	[
	'search' => 'Smith',
	'limit'  => 50,
	'offset' => 0 
];

// Create the Simple Search Request
$search = new SimpleSearch($searchParams);

// Send the request to the API
$response = $this->rezdyAPI->customers->search($search);

// View the Response
echo $response;

```
## Minimum Requirements
Use of this library requires PHP 7.1.3+, and PHP cURL extension (http://php.net/manual/en/book.curl.php)