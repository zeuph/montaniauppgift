<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;


/*
API Service to fetch data from a api endpoint
*/

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
