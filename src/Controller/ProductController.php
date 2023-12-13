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

    private $apiService;
    private $filterService;

    public function __construct(ApiService $apiService, FilterService $filterService)
    {
        $this->apiService = $apiService;
        $this->filterService = $filterService;
    }

    #[Route('/')]
    public function homepage()
    {
        $apiResponse = $this->apiService->fetchDataFromApi();
        $apiData = json_decode($apiResponse->getContent());

        $amountOfArticles = count($apiData->products);

        $data = $this->filterService->filter($apiData->products, "alphabetical");

        return $this->render('product/homepage.html.twig', [
            "data" => $data,
            "articleAmount" => $amountOfArticles
        ]);
    }

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

    #[Route('/{slug}')]
    public function browse(string $slug): Response
    {
        return new Response("Hello World");
    }
}
