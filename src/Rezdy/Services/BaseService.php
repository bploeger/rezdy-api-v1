<?php
namespace Rezdy\Services;

use Rezdy\Exceptions\RezdyException;
use Rezdy\Util\Config;
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

    protected function sendRequestWithoutBody($method, $baseUrl, Array $queryParams = array()) {
        $queryParams["apiKey"] = $this->apiKey;
        $request = new Request($method, $baseUrl);
        return $this->client->send($request, [
            'query' => $queryParams,
        ]);
    }

    protected function sendRequestWithBody($method, $baseUrl, $body, Array $queryParams = array()) {
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
        $rezdyException->setErrors($exception->getResponse()->getBody()->getContents());
        return $rezdyException;
    }
}
