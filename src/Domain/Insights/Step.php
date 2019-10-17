<?php
declare(strict_types=1);

namespace App\Domain\Insights;

final class Step
{
    private $name;
    private $percentage;

    public function __construct(string $name, int $percentage)
    {
        $this->name = $name;
        $this->percentage = $percentage;
    }

    public function percentage(): int
    {
        return $this->percentage;
    }

    public function name(): string
    {
        return $this->name;
    }
}
