<?php

namespace App\Controller;

use App\Model\ErrorResponse;
use App\Service\TimeService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TimeController extends AbstractController
{
    public function __construct(private readonly TimeService $timeService)
    {
    }

    #[OA\Tag(name: 'Users API')]
    #[Security(name: 'ApiKeyAuth')]
    #[OA\Response(response: 200, description: 'Turn on timer')]
    #[OA\Response(response: 404, description: 'User not found', attachables: [new Model(type: ErrorResponse::class)])]
    #[Route(path: '/api/v1/user/start', methods: ['POST'])]
    public function usersStartTime(): Response
    {
        $this->timeService->startTime();

        return $this->json('success:start');
    }

    #[OA\Tag(name: 'Users API')]
    #[Security(name: 'ApiKeyAuth')]
    #[OA\Response(response: 200, description: 'Turn off timer')]
    #[OA\Response(response: 403, description: 'Timer dont start', attachables: [new Model(type: ErrorResponse::class)])]
    #[OA\Response(response: 404, description: 'User not found', attachables: [new Model(type: ErrorResponse::class)])]
    #[Route(path: '/api/v1/user/stop', methods: ['POST'])]
    public function usersStopTime(): Response
    {
        $this->timeService->stopTime();

        return $this->json('success:stop');
    }
}
