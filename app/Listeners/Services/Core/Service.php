<?php

namespace App\Libraries\Services\Core;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

/**
 * Core service class
 */
class Service
{

    /**
     * Guzzle client
     *
     * @var Client
     */
    protected $client;

    /**
     * Base uri service from env
     *
     * @var string
     */
    protected $baseUri = 'SERVICE_URI';

    /**
     * Guzzle Response
     *
     * @var GuzzleResponse
     */
    public $response;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri'      => rtrim(env($this->baseUri, 'localhost'), '/') . '/',
            'headers'       => $this->getHeaders(),
            'http_errors'   => false
        ]);
    }

    /**
     * Get request header
     *
     * @param array $headers
     * @return array
     */
    protected function getHeaders()
    {
        $takes = collect([
            'Accept'        => 'accept',
            'Authorization' => 'authorization',
            'Access-From'   => 'service',
        ]);

        $headers = $takes->transform(function($item) {
            if ($item == 'authorization') {
                $item = isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : 'authorization';
            }
            if ($item == 'accept') {
                $item = app('request')->header('accept');
            }
            
            return $item;
        })->filter(function($item) {
            return $item != null;
        });

        $acceptHeader = collect(explode(',', $headers->get('Accept')))->transform(function($item) {
            return trim($item);
        })->filter(function($item) {
            return $item == 'application/json';
        });

        if ($acceptHeader->isEmpty()) :
            throw new \Exception("Header harus menggunakan Accept: application/json");
        endif;
        
        return $headers->toArray();
    }

    /**
     * Call magic static
     *
     * @param string $method
     * @param array $args
     * @return class
     */
    public static function __callStatic($method, $args)
    {
        if (count($args) < 1){
            throw new \InvalidArgumentException('Magic request methods require a URI and optional options array');
        }

        $uri    = $args[0];
        $opts   = isset($args[1]) ? $args[1] : [];

        if ($opts instanceof Collection){
            $opts = $opts->toArray();
        }else if (is_array($opts)) {
            $opts = ['form_params' => $opts];
        }

        $class      = get_called_class();
        $service    = new $class;

        $service->request($method, $uri, $opts);

        return $service->response();
    }

    /**
     * Send request
     *
     * @param string $method
     * @param string $uri
     * @param array $opts
     * @return void
     */
    public function request($method, $uri, $opts)
    {
        $this->response = $this->client->request($method, $uri, $opts);
    }

    /**
     * Get response json transformed
     *
     * @return \stdClass
     */
    public function response()
    {
        $response   = json_decode($this->response->getBody());
        $statusCode = $this->response->getStatusCode();

        if ($statusCode != 200){
            $message = $this->response->getReasonPhrase();

            return (object) [
                'status'    => 'error',
                'code'      => $statusCode,
                'message'   => $this->response->getReasonPhrase(),
                'errors'    => optional($response)->errors
                    ? $response->errors
                    : (object) ['message' => [$message]]
            ];
        }

        return $response === null
            ? (string) $this->response->getBody()
            : $response;
    }
}
