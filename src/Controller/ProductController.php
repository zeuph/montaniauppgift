<?php

namespace App\Controller;

use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{

    private $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    #[Route('/')]
    public function homepage()
    {
        $apiResponse = $this->apiService->fetchDataFromApi();
        $apiData = json_decode($apiResponse->getContent());

        return $this->render('product/homepage.html.twig', [
            "data" => $apiData
        ]);
    }

    #[Route('/browse/{slug}')]
    public function browse(string $slug): Response
    {
        return new Response("Hello World");
    }
}
