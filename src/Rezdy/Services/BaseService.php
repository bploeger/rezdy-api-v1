<?php
namespace Rezdy\Services;

use Rezdy\Exceptions\RezdyException;
use Rezdy\Util\Config;

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
     * @param string $apiKey - Constant Contact API Key
     * @param ClientInterface|null $client - GuzzleHttp Client
     */
    public function __construct($apiKey, ClientInterface $client = null) {
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

    protected function sendRequestWithoutBody($method, $baseUrl, $queryParams = array()) {        
        $queryParams[]["apiKey"] = $this->apiKey;   

        //Build the query string 
        $query = '';
        foreach ($queryParams as $index => $param) {
            foreach ($param as $key => $value) {
                $query .= $key . "=" . $value . '&';
            }            
        }
        $query = trim($query, '&');
              
        $request = new Request($method, $baseUrl);
        return $this->client->send($request, [
            'query' => $query,
        ]);
    }

    protected function sendRequestWithBody($method, $baseUrl, $body = null, $queryParams = array()) {
        if ($body->isValidRequest()) {
            $queryParams["apiKey"] = $this->apiKey;
            $request = new Request($method, $baseUrl);            
            return $this->client->send($request, [
                'query' => $queryParams,
                'json' => $body
            ]);
        } else {
            return $body->getError();
        }        
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
        $rezdyException->setUrl($exception->getRequest()->getUri());

        // Pull the Error Message
        $errors = $exception->getResponse()->getBody()->getContents();

        // Put the Error Messages into the Exception
        $rezdyException->setErrors(json_decode($errors));
        return $rezdyException;
    }

    public function returnExceptionAsErrors($request, $e) {        
        // Convert the Exception to a Rezdy\Exceptions\RezdyException Class            
        $rezdyException = $this->convertException($e);
        
        // Append the Error Messages from the Exception to the Original Request
        $request->appendTransferErrors($rezdyException);
        
        return $request;
    }
}
