<?php

namespace App\Model;

class ReportListModel
{
    private string $name;

    /**
     * @var string[]
     */
    private array $perWeekHours = [];

    public function __construct(string $name, array $perWeekHours)
    {
        $this->name = $name;
        $this->perWeekHours = $perWeekHours;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPerWeekHours(): array
    {
        return $this->perWeekHours;
    }

    public function setPerWeekHours(array $perWeekHours): self
    {
        $this->perWeekHours = $perWeekHours;
        return $this;
    }
}
