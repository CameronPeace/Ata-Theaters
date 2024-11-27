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
     * @param string $toDate
     * @param string $fromDate
     * @param int $limit
     *
     * @return array
     */
    public function getTopTheaters(string $toDate, string $fromDate, int $limit): array
    {
        $queryParams = ['toDate' => $toDate, 'fromDate' => $fromDate, 'limit' => $limit];
        return $this->apiRequest->requestTopTheaters($queryParams);
    }
}
