<?php
declare(strict_types=1);

namespace App\Domain\Insights;

final class UserRetentionByStep
{
    /**
     * @var float
     */
    private $userRetainedPercentage;
    /**
     * @var Step
     */
    private $step;

    public function __construct(float $userRetainedPercentage, Step $step)
    {
        $this->userRetainedPercentage = $userRetainedPercentage;
        $this->step = $step;
    }

    /**
     * @return float
     */
    public function userRetainedPercentage(): float
    {
        return $this->userRetainedPercentage;
    }

    public function stepName(): string {

    }
}
