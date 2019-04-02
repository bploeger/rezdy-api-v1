# Rezdy API PHP SDK

### This library utilizes [GuzzlePHP](http://guzzle.readthedocs.org/)
### This library utilizes [Carbon](https://carbon.nesbot.com/)

## Installing via Composer (recommended)
[Composer](https://getcomposer.org/) is a dependency management tool for PHP that allows you to declare the dependencies your project needs and installs them into your project. In order to use the Rezdy API PHP SDK through composer, you must add "bploeger/rezdy-api-v1" as a dependency in your project's composer.json file.
```javascript
 {
    "require": {
        "bploeger/rezdy-api-v1": "dev-master"
    }
 }
```

### Manual Installation
If you are unable to install using composer, we have provided a zip file that includes a version of the dependencies at the time of our release, as well as our library. Unzip the vendor file in the standalone directory, and require the autoload.php file to use our methods.

## Documentation

The source documentation is hosted at http://bploeger.github.io/php-sdk

API Documentation is located at https://developers.rezdy.com/rezdy-api/reference

## Usage
The RezdyAPI class contains the underlying services that hold the methods that use the API.
```php
use Rezdy\RezdyAPI;
use Rezdy\Requests\SimpleSearch;

// Initialize the API
$rezdyAPI = new RezdyAPI('your api key');

// Set the search parameters
$searchParams =	['search' => 'Smith',
				 'limit'  => 50,
				 'offset' => 0        ];

// Create the Simple Search Request
$search = new SimpleSearch($searchParams);

// Send the request to the API
$response = $this->rezdyAPI->customers->search($search);

// Print the Response
echo $response;

```
## Minimum Requirements
Use of this library requires PHP 7.1.3+, and PHP cURL extension (http://php.net/manual/en/book.curl.php)