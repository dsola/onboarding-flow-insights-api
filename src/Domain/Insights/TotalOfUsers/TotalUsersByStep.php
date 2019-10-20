<?php
declare(strict_types=1);

namespace App\Domain\Insights\TotalOfUsers;

use App\Domain\Insights\Step;

class TotalUsersByStep
{
    /**
     * @var int
     */
    private $totalOfUsers;
    /**
     * @var Step
     */
    private $step;

    public function __construct(Step $step)
    {
        $this->totalOfUsers = 0;
        $this->step = $step;
    }

    public function totalOfUsers(): int
    {
        return $this->totalOfUsers;
    }

    public function increaseTotal(): void
    {
        ++$this->totalOfUsers;
    }
    public function stepName(): string
    {
        return $this->step->name();
    }

    public function stepPercentage(): int
    {
        return $this->step->percentage();
    }
}
