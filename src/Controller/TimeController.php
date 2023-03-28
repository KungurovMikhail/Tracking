<?php

namespace App\Controller;

use App\Service\TimeService;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use App\Model\ErrorResponse;

class TimeController extends AbstractController
{
    public function __construct(private TimeService $TimeService)
    {
    }

    #[OA\Tag(name: 'Users API')]
    #[Security(name: "ApiKeyAuth")]
    #[OA\Response(response: 200, description: 'Turn on timer')]
    #[OA\Response(response: 404, description: 'User not found', attachables: [new Model(type: ErrorResponse::class)])]
    #[Route(path: '/api/v1/user/{id}/start', methods: ['POST'])]

    public function usersStartTime($id): Response
    {
        $this->TimeService->startTime($id);
        return $this->json('success:start');
    }

    #[OA\Tag(name: 'Users API')]
    #[Security(name: "ApiKeyAuth")]
    #[OA\Response(response: 200, description: 'Turn off timer')]
    #[OA\Response(response: 403, description: 'Timer dont start', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Response(response: 404, description: 'User not found', attachables: [new Model(type: ErrorResponse::class)])]
    #[Route(path: '/api/v1/user/{id}/stop', methods: ['POST'])]
    public function usersStopTime($id): Response
    {
        $this->TimeService->stopTime($id);
        return $this->json('success:stop');
    }
}
