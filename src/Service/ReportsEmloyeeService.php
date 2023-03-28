<?php

namespace App\Service;

use App\Entity\Users;
use App\Exception\FileNotLoadedException;
use App\Model\ReportListModel;
use App\Model\ReportListResponse;
use App\Repository\UsersRepository;

class ReportsEmloyeeService
{
    public function __construct(private UsersRepository $usersRepository)
    {
    }

    public function reportEmployeesList(): array
    {
        if (!$this->usersRepository->getListIdAndName()) {
            throw new FileNotLoadedException();
        }
        return $this->usersRepository->getListIdAndName();
    }

    public function reportEmployeesOnWeek(): ReportListResponse
    {
        if (!$this->usersRepository->findAll()) {
            throw new FileNotLoadedException();
        }
        $list = $this->usersRepository->findAll();
        $reports = array_map(
            fn (Users $users) => new ReportListModel(
                $users->getName(),
                $users->getPerWeekHours()
            ),
            $list
        );

        return new ReportListResponse($reports);
    }
}
