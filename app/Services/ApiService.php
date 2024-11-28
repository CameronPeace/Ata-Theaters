<?php

namespace App\Services;

use App\Services\Helpers\ApiRequest;

class ApiService
{
    protected $apiRequest;

    public function __construct()
    {
       $this->apiRequest = new ApiRequest();
    }

    /**
     * Get the top performing theaters from our Api.
     *
     * @param string $fromDate
     * @param string $toDate
     * @param int $limit
     *
     * @return array
     */
    public function getTopTheaters(string $fromDate, string $toDate, int $limit): array
    {
        $requestParams = ['fromDate' => $fromDate, 'toDate' => $toDate, 'limit' => $limit];
        \Log::info('making sure we passed correctly');
        \Log::info($requestParams);
        return $this->apiRequest->requestTopTheaters($requestParams);
    }
}
