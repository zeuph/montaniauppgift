<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiService
{
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = HttpClient::create();
    }

    public function fetchDataFromApi(): JsonResponse
    {
        $url = 'http://dev14.ageraehandel.se/sv/api/product/';
        $response = $this->httpClient->request('GET', $url);
        $data = $response->toArray();

        return new JsonResponse($data);
    }
}
