<?php
namespace Rezdy\Services;

use Rezdy\Exceptions\RezdyException;

use Rezdy\Requests\EmptyRequest;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;

/**
 * Super class for all services
 *
 * @package Services
 * @author Brad Ploeger
 */
abstract class BaseService {
    /**
     * GuzzleHTTP Client Implementation to use for HTTP requests
     * @var Client
     */
    private $client;
    /**
     * ApiKey for the application
     * @var string
     */
    private $apiKey;
    /**
     * Constructor with the option to to supply an alternative rest client to be used
     * @param string $apiKey - Rezdy API Key
     * @param ClientInterface|null $client - GuzzleHttp Client
     */
    public function __construct(string $apiKey, ClientInterface $client = null) {
        $this->apiKey = $apiKey;
        $this->client = $client ?: new Client();
    }

    /**
     * Get the rest client being used by the service
     * @return Client - GuzzleHTTP Client implementation being used
     */
    protected function getClient() {
        return $this->client;
    }
    /**
     * Send a request to the API without a JSON payload in the body
     * @param string $method - The HTTP Method to be used
     * @param string $baseUrl - The full URL for the request
     * @param array $queryParams - An array holding the query params as key => value
     * @return Response - GuzzleHTTP Response Object
     */
    protected function sendRequestWithoutBody(string $method, string $baseUrl, array $queryParams = array()) {        
        // Insert the API Key to the query array
        $queryParams["apiKey"] = $this->apiKey;  
        // Parse the query array to create the Query String
        $query = $this->buildQueryString($queryParams);      
        // Create the GuzzleHTTP Request
        $request = new Request($method, $baseUrl);        
        // Send the GuzzleHTTP Request
        return $this->client->send($request, [
            'query' => $query,
        ]);
    }
     /**
     * Send a request to the API with a JSON payload in the body
     * @param string $method - The HTTP Method to be used
     * @param string $baseUrl - The full URL for the request
     * @param string|null $body - The JSON payload to include in the request body
     * @param array $queryParams - An array holding the query params as key => value
     * @return Response - GuzzleHTTP Response Object
     */
    protected function sendRequestWithBody(string $method, string $baseUrl, $body = null, array $queryParams = array()) {
        // Insert the API Key to the query array
        $queryParams["apiKey"] = $this->apiKey;
        // Create the GuzzleHTTP Request
        $request = new Request($method, $baseUrl);            
        // Send the GuzzleHTTP Request
        return $this->client->send($request, [
            'query' => $queryParams,
            'json' => $body
        ]);          
    }
    /**
     * Turns a ClientException into a RezdyException - like magic.
     * @param TransferException $exception - Guzzle TransferException can be one of RequestException,
     *        ConnectException, ClientException, ServerException
     * @return RezdyException
     */
    protected function convertException($exception) {
        if ($exception instanceof ClientException || $exception instanceof ServerException) {
            $rezdyException = new RezdyException($exception->getResponse()->getReasonPhrase(), $exception->getCode());
        } else {
            $rezdyException = new RezdyException("Something went wrong", $exception->getCode());
        }
        // Set the 
        $rezdyException->setUrl($exception->getRequest()->getUri());
        // Pull the Error Message
        $errors = $exception->getResponse()->getBody()->getContents();

        // Put the Error Messages into the Exception
        $rezdyException->setErrors(json_decode($errors));
        return $rezdyException;
    }
    /**
     * Parses exceptions and adds them to the request for error handling
     * @param TransferException $e - The exception encountered by the client
     * @param string|null $request - The request submitted
     * @return Request - Return the request submitted with errors
     */
    protected function returnExceptionAsErrors(TransferException $e, $request = null) {  
        // See if a request was passed, if a request was not passed create an empty request.
        $request = $request ?: new EmptyRequest;
        // Convert the Exception to a Rezdy\Exceptions\RezdyException Class            
        $rezdyException = $this->convertException($e);
        // Append the Error Messages from the Exception to the Original Request
        $request->appendTransferErrors($rezdyException);
        // Trigger the Error Flag on the Request 
        $request->hadError = true;
        // Return the Request
        return $request;
    }
    /**
     * Creates a properly formatted query string from an array
     * @param array $queryParams - An array holding the query params as key => value, can be recursive
     * @return string - returns a properly formatted query string
     */
    private function buildQueryString(array $queryParams) {
        // Initialize the query string 
        $query = '';        
        // Parse the array provided
        foreach ($queryParams as $index => $param) {
            // Check if it is an array
            if (is_array($param)) {
                // Parse the inner array
                foreach ($param as $key => $value) {
                    // Append the key and value to the query
                    $query .= $key . "=" . $value . '&';                                     
                }    
            } else {
                // Append the key and value to the query
                $query .= $index . "=" . $param . '&';
            }                    
        }
        // Return a clean query string
        return trim($query, '&');
    }
    /**
     * Handles an array of optional inputs. Use the first item provided, if no items were
     * provided pass the default object
     * @param array $optionalArray - An array holding the multiple items
     * @return mixed 
     */
    protected function parseOptionalArray(array $optionalArray, $default) {
        return (count($optionalArray)) ? $optionalArray[0] : $default;
    }
}
