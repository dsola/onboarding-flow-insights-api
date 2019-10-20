<?php
declare(strict_types=1);

namespace App\Domain\Insights\Exceptions;

use InvalidArgumentException;

class UnknownStep extends InvalidArgumentException
{
    public static function byPercentage(float $percentage): self
    {
        return new self("The percentage {$percentage} does not match to any step.");
    }
}
