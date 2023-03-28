<?php

namespace App\Controller;

use App\Model\ReportListModel;
use App\Service\ReportsEmloyeeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use App\Model\ErrorResponse;

class ReportEmployeeController extends AbstractController
{
    public function __construct(private ReportsEmloyeeService $reportsEmployee)
    {
    }

    #[OA\Tag(name: 'Public')]
    #[OA\Response(response: 200, description: 'Report of emloyees in format ["number of week" => "quantity of hours in the seconds"]', attachables: [new Model(type: ReportListModel::class)])]
    #[OA\Response(response: 404, description: 'File not loaded', attachables: [new Model(type: ErrorResponse::class)])]
    #[Route(path: '/api/v1/report', methods: ['GET'])]
    public function report(): Response
    {
        return $this->json(($this->reportsEmployee->reportEmployeesOnWeek()));
    }

    #[OA\Tag(name: 'Public')]
    #[OA\Response(response: 200, description: 'List emloyees')]
    #[OA\Response(response: 404, description: 'File not loaded', attachables: [new Model(type: ErrorResponse::class)])]
    #[Route(path: '/api/v1/list_employee', methods: ['GET'])]
    public function list(): Response
    {
        return $this->json(($this->reportsEmployee->reportEmployeesList()));
    }
}
