<?php
declare(strict_types=1);

namespace App\Domain\Insights;

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
            'series' => [
                [
                    'user_retained_percentage' => 100,
                    'step'                     => [
                        'percentage' => 10,
                        'title'      => 'Create Account',
                    ],
                ],
                [
                    'user_retained_percentage' => 100,
                    'step'                     => [
                        'percentage' => 10,
                        'title'      => 'Create Account',
                    ],
                ],
                [
                    'user_retained_percentage' => 100,
                    'step'                     => [
                        'percentage' => 10,
                        'title'      => 'Create Account',
                    ],
                ],
                [
                    'user_retained_percentage' => 100,
                    'step'                     => [
                        'percentage' => 10,
                        'title'      => 'Create Account',
                    ],
                ],
            ],
        ];
    }

    private function generateTitle(): string
    {
        return $this->firstDay->format('Y-m-d') . ' ' . $this->firstDay->addWeek()->format('Y-m-d');
    }
}
