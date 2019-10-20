<?php
declare(strict_types=1);

namespace App\Domain\Insights;

use Carbon\CarbonInterface;
use DateTimeInterface;

final class UserDataSample
{
    private $creationDate;
    private $userId;
    private $step;

    public function __construct(DateTimeInterface $creationDate, int $userId, Step $step)
    {
        $this->creationDate = $creationDate;
        $this->userId = $userId;
        $this->step = $step;
    }

    public function creationDate(): CarbonInterface
    {
        return $this->creationDate;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function step(): Step
    {
        return $this->step;
    }
}
