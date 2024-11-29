<?php

namespace App\Services;

use App\Services\Helpers\OpenAiApi;


class OpenAiService
{

    protected $openAiApi;

	public function __construct()
	{
		$this->openAiApi = new OpenAiApi();
	}

    /**
     * Ask ChatGpt to provide movie data.
     */
	public function requestMovieData()
    {
        $prompt = 'Using actual existing movies aired in the US between G and R ratings, please create an array of json objects filling the values for these keys (title, genre, director, release date). Please only return the json with no additional text. Please have at least 10 objects in the array. Remove the json label as well.';

        $response = $this->openAiApi->sendChatPrompt($prompt);
        return $this->getResponseJsonData($response);
    }

    /**
     * Ask ChatGpt to provide theater data.
     */
	public function requestTheaterData()
    {
        $prompt = 'Please put them in an array of json objects filling the values for these keys (location_name, city, state, street, zip5). Please only return the json with no additional text. Please have at least 20 objects in the array. Remove the json label as well.';

        $response = $this->openAiApi->sendChatPrompt($prompt);

        return $this->getResponseJsonData($response);
    }

    private function getResponseJsonData($response) 
    {
        try {
			$choices = $response['body']['choices'] ?? [];
	
			if (empty($choices)) {
				return null;
			}
            // TODO we will probably need to remove those escape characters and new lines. 
			// We will only receive one complete response from ChatGPT.
			return $choices[0]['message'];
		} catch (\Exception $e) {

            // TODO Create openAI service exception.
			throw new OpenAiServiceException("ChatGPTException: " . $e->getMessage());
		}
    }
}
