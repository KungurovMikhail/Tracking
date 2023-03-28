<?php

namespace App\Model;

use App\Entity\Users;

class ReportListResponse
{
    /**
     * @param ReportListModel[] $reports
     */
    public function __construct(private readonly array $reports)
    {
    }

    /**
     * @return ReportListModel
     */
    public function getReports(): array
    {
        return $this->reports;
    }
}
