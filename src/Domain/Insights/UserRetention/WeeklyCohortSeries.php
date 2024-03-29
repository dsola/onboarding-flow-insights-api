<?php
declare(strict_types=1);

namespace App\Domain\Insights\UserRetention;

use App\Domain\Insights\Step;
use Carbon\CarbonInterface;

final class WeeklyCohortSeries
{
    private $firstDay;
    private $series;

    public function __construct(CarbonInterface $firstDay, UserRetentionByStepCollection $series)
    {
        $this->firstDay = $firstDay;
        $this->series = $series;
    }

    public function firstDay(): CarbonInterface
    {
        return $this->firstDay;
    }

    public function series(): UserRetentionByStepCollection
    {
        return $this->series;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->generateTitle(),
            'series' => $this->series->toArray(),
        ];
    }

    private function generateTitle(): string
    {
        return $this->firstDay->format('Y-m-d') . ' ' . $this->firstDay->addWeek()->format('Y-m-d');
    }
}
