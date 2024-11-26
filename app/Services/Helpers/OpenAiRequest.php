<?php

namespace App\Services\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;

class OpenAiRequest
{

    /**
	 * Main OPEN AI API URL
	 */
	protected const OPENAI_API_URL = 'https://api.openai.com';

	/* The current Api Version */
	protected const OPENAI_API_VERSION = 'v1';

	/* The default AI model to use */
	protected const DEFAULT_AI_MODEL = 'gpt-4o-mini';

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
        $this->authorizationToken = env('OPEN_API_SECRET');
	}

    

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
		return self::OPENAI_API_URL . '/' . $path;
	}

    /**
	 * Send a prompt to the OpenAI Chat API and get a response.
	 *
	 * @param string $prompt
	 * @return array $response
	 */
	public function sendChatPrompt(string $prompt)
	{
		$payload = [
			'model' => self::DEFAULT_AI_MODEL,
			"seed" => 1, // Will make a best effort to sample deterministically, such that repeated requests with the same seed and parameters should return the same result.
			"temperature" => 0.2, // Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic. MAX LIMIT: 2.
			'messages' => [['role' => 'user', 'content' => $prompt]]
		];

		return $this->call('POST', self::OPENAI_API_VERSION . '/chat/completions', $payload);
	}

}
