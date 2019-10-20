<?php
declare(strict_types=1);

namespace App\Domain\Insights\TotalOfUsers;

use App\Domain\Insights\Step;
use Carbon\CarbonInterface;

final class WeeklyCohortSeries
{
    private $firstDay;
    private $series;

    public function __construct(CarbonInterface $firstDay, TotalOfUsersByStepCollection $series)
    {
        $this->firstDay = $firstDay;
        $this->series = $series;
    }

    public function firstDay(): CarbonInterface
    {
        return $this->firstDay;
    }

    public function series(): TotalOfUsersByStepCollection
    {
        return $this->series;
    }

    public function belongsToCohort(CarbonInterface $date): bool
    {
        return $this->firstDay->lessThanOrEqualTo($date) && $this->firstDay->addWeek()->greaterThanOrEqualTo($date);
    }

    public function addSample(Step $step): self
    {
        $this->series->addUserSample($step);

        return clone $this;
    }
}
