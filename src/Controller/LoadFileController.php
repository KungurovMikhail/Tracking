<?php

namespace App\Controller;

use App\Service\LoadCsvService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoadFileController extends AbstractController
{
    public function __construct(private LoadCsvService $loadCsvService)
    {
    }

    #[Route(path: '/api/v1/admin/reports/load_list', methods: ['GET'])]
    public function twigLoad(): Response
    {
        return $this->render('load_file/index.html.twig');
    }

    #[Route(path: '/api/v1/admin/reports/load_list', methods: ['POST'])]
    public function load(Request $request): Response
    {
        $this->loadCsvService->load($request, $this->getParameter('uploadDir'));
        return $this->json('success:load');
    }
}
