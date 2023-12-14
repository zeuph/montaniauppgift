<?php

namespace App\Controller;

use App\Service\ApiService;
use App\Service\FilterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{

    // The services I made to be used by the controller
    private $apiService;
    private $filterService;

    public function __construct(ApiService $apiService, FilterService $filterService)
    {
        // Initalize the services as the controller is initialized
        $this->apiService = $apiService;
        $this->filterService = $filterService;
    }

    #[Route('/')]
    public function homepage()
    {
        // Fetch the data from API endpoint
        $apiResponse = $this->apiService->fetchDataFromApi();
        $apiData = json_decode($apiResponse->getContent());
        // Get the amount of products in the fetch request
        $amountOfArticles = count($apiData->products);

        // Do some data engineering. Mostly sorting
        // I wanted to maintain the structure and data inside the api response
        $data = $this->filterService->filter($apiData->products, "alphabetical");

        // Render the page with this information
        return $this->render('product/homepage.html.twig', [
            "data" => $data,
            "articleAmount" => $amountOfArticles
        ]);
    }

    // Route is essentially unecessary, could've done the filtering on the homepage
    #[Route('/filter')]
    public function filter(Request $request)
    {
        $apiResponse = $this->apiService->fetchDataFromApi();
        $apiData = json_decode($apiResponse->getContent());
        $amountOfArticles = count($apiData->products);

        $data = $this->filterService->filter($apiData->products, $request->query->get("sortingmethod"));

        return $this->render('product/homepage.html.twig', [
            "data" => $data,
            "articleAmount" => $amountOfArticles
        ]);
    }
}
