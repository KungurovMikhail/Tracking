<?php

namespace App\Controller;

use App\Model\ErrorResponse;
use App\Service\LoadCsvService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoadFileController extends AbstractController
{
    public function __construct(private readonly LoadCsvService $loadCsvService)
    {
    }

    #[OA\Tag(name: 'Admin API')]
    #[Route(path: '/api/v1/admin/reports/load_list', methods: ['GET'])]
    public function twigLoad(): Response
    {
        return $this->render('load_file/index.html.twig');
    }

    #[OA\Tag(name: 'Admin API')]
    #[OA\Response(response: 200, description: 'Uploading a file emloyees by the admin')]
    #[OA\Response(response: 404, description: 'Invalid file format', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\RequestBody(description: 'file to upload', content: new OA\MediaType(
        mediaType: 'application/octet-stream',
        schema: new OA\Schema(
            new OA\Property(property: 'file', description: 'file to upload', format: 'file')
        )
    )
    )]
    #[Route(path: '/api/v1/admin/reports/load_list', methods: ['POST'])]
    public function load(Request $request): Response
    {
        $this->loadCsvService->load($request, $this->getParameter('uploadDir'));

        return $this->json('success:load');
    }
}
