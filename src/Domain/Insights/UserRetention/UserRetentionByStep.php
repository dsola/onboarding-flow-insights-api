<?php
declare(strict_types=1);

namespace App\Domain\Insights\UserRetention;

use App\Domain\Insights\Step;

final class UserRetentionByStep
{
    private $userRetainedPercentage;
    private $step;

    public function __construct(float $userRetainedPercentage, Step $step)
    {
        $this->userRetainedPercentage = $userRetainedPercentage;
        $this->step                   = $step;
    }

    public function stepName(): string
    {
        return $this->step->name();
    }

    /**
     * @return float
     */
    public function userRetainedPercentage(): float
    {
        return $this->userRetainedPercentage;
    }

    public function stepPercentage(): int
    {
        return $this->step->percentage();
    }

    public function toArray(): array
    {
        return [
            'user_retained_percentage' => $this->userRetainedPercentage(),
            'step'                     => [
                'percentage' => $this->stepPercentage(),
                'name'       => $this->stepName(),
            ],
        ];
    }


}
