<?php

namespace App\Services\Helpers;

use App\Services\JwtService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiRequest
{

    /**
     * @var GuzzleHttp Client
     */
    private $client;

    /**
     * @var string The Api Jwt Token
     */
    private $authorizationToken;

    public function __construct()
    {
        $this->client = new Client();
        $this->authorizationToken = app(JwtService::class)->generate();
    }

    /**
     * Use guzzle to make our request.
     *
     * @param string $method The reqeust method.
     * @param string $path The request path.
     * @param array $params The request query params
     *
     * @return array
     */
    public function call(string $method, string $path, array $params = array()): array
    {
        try {
            $url = $this->getRequestUrl($path);

            $guzzleSettings = $this->getRequestSettings($method, $params);

            $guzzleResponse = $this->client->request($method, $url, $guzzleSettings);

            $response = array(
                'body' => json_decode($guzzleResponse->getBody(), true),
                'status' => $guzzleResponse->getStatusCode()
            );

            return $response;
        } catch (GuzzleException $e) {
            \Log::error($e);
        }

        return ['status' => 'error'];
    }

    /**
     * Build our api request.
     *
     * @param string $method
     * @param array $params
     *
     * @return array
     */
    protected function getRequestSettings(string $method, array $params = array()): array
    {
        $guzzleSettings = array(
            'connect_timeout' => 60,
            'timeout' => 60,
            'headers' => array(
                'Authorization' => 'Bearer ' . $this->authorizationToken,
                'accept' => 'application/json',
            ),
        );

        // Add the query parameters
        if (strtoupper($method) === 'GET') {
            $guzzleSettings['query'] = $params;
        }

        $guzzleSettings['json'] = $params;

        $guzzleSettings['headers']['Content-Type'] = 'application/json; charset=utf-8';

        return $guzzleSettings;
    }

    /**
     * Builds the URL that requests should be sent to.
     *
     * @param string $path Path for the call.
     *
     * @return string URL of the request
     */
    protected function getRequestUrl(string $path): string
    {
        return config('app.api_url') . '/' . $path;
    }

    /**
     * Request top theater data from our internal api.
     *
     * @param array $queryParams
     *
     * @return array
     */
    public function requestTopTheaters(array $queryParams): array
    {
        return $this->call('GET', 'theaters/top', $queryParams);
    }
}
