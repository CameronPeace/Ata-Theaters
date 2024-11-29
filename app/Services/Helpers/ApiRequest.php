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
     * @var string The OpenAI API Token.
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
     * @return array|null
     */
    public function call(string $method, string $path, array $params = array()): ?array
    {
        try {
            $url = $this->getRequestUrl($path);

            $guzzleSettings = $this->getRequestSettings($params);

            $guzzleResponse = $this->client->request($method, $url, $guzzleSettings);

            $response = array(
                'body' => json_decode($guzzleResponse->getBody(), true),
                'status' => $guzzleResponse->getStatusCode()
            );

            return $response;
        } catch (GuzzleException $e) {
        }

        return collect(['status' => 'error']);
    }

    protected function getRequestSettings(array $params = array()): array
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
        if (in_array($method, array('GET'))) {
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
        return config('api_url') . '/' . $path;
    }

    public function requestTopTheaters(array $queryParams)
    {
        return $this->call('GET', '/theaters/tp[', $queryParams);
    }
}
