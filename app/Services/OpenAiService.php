<?php

namespace App\Services;

use App\Exceptions\OpenAiServiceException;
use App\Services\Helpers\OpenAiRequest;


class OpenAiService
{

    protected $openAiRequest;

    public function __construct()
    {
        $this->openAiRequest = new OpenAiRequest();
    }

    public function requestMovieData(int $total)
    {
        $prompt = sprintf('Using actual existing movies aired in the US between G and R ratings, please create an array of json objects filling the values for these keys (title, genre, director, release_date). Please only return the json with no additional text. Please have at least %d objects in the array. Remove the json label as well.', $total);
        $response = $this->openAiRequest->sendChatPrompt($prompt);
        return $this->getResponseJsonData($response);
    }

    public function requestTheaterData(int $total)
    {
        $prompt = sprintf('Using actual movie theaters in the United States, please populate an array of json objects filling the values with the address of each movie theater following these keys (location_name, city, state, street, zip5). Please only return the json with no additional text. Please have at least %d objects in the array. Remove the json label as well.', $total);
        $response = $this->openAiRequest->sendChatPrompt($prompt);
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
            return $choices[0]['message']['content'];
        } catch (\Exception $e) {

            throw new OpenAiServiceException("ChatGPTException: " . $e->getMessage());
        }
    }
}
