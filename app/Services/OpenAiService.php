<?php

namespace App\Services;

use App\Exceptions\OpenAiServiceException;
use App\Services\Helpers\OpenAiRequest;
use Illuminate\Database\Eloquent\Casts\Json;

class OpenAiService
{
    /** OpenAiRequest */
    protected $openAiRequest;

    public function __construct()
    {
        $this->openAiRequest = new OpenAiRequest();
    }

    /**
     * Request movie data from ChatGPT.
     *
     * @param int $total The total amount of json objects to ask ChatGPT for.
     *
     * @return Json
     * @throws OpenAiServiceException
     */
    public function requestMovieData(int $total): Json
    {
        try {
            $prompt = sprintf('Using actual existing movies aired in the US between G and R ratings, please create an array of json objects filling the values for these keys (title, genre, director, release_date). Please only return the json with no additional text. Please have at least %d objects in the array. Remove the json label as well.', $total);
            $response = $this->openAiRequest->sendChatPrompt($prompt);
            return $this->getResponseJsonData($response);
        } catch (\Exception $e) {

            throw new OpenAiServiceException("An unexpected error occurred while requesting movie data: " . $e->getMessage());
        }
    }

    /**
     * Request theater data from ChatGPT.
     *
     * @param int $total The total amount of json objects to ask ChatGPT for.
     *
     * @return Json
     * @throws OpenAiServiceException
     */
    public function requestTheaterData(int $total): Json
    {
        try {
            $prompt = sprintf('Using actual movie theaters in the United States, please populate an array of json objects filling the values with the address of each movie theater following these keys (location_name, city, state, street, zip5). Please only return the json with no additional text. Please have at least %d objects in the array. Remove the json label as well.', $total);
            $response = $this->openAiRequest->sendChatPrompt($prompt);
            return $this->getResponseJsonData($response);
        } catch (\Exception $e) {
            throw new OpenAiServiceException("An unexpected error occurred while requesting theater data: " . $e->getMessage());
        }
    }

    /**
     * Parse our ChatGPT data and return the response data.
     *
     * @param array $response
     *
     * @return Json
     * @throws OpenAiServiceException
     */
    private function getResponseJsonData(array $response): Json
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
