<?php
declare(strict_types=1);

namespace App\Domain\DomainException;

use Doctrine\Common\Collections\Collection;
use InvalidArgumentException;

class StepNotDefinedInCollection extends InvalidArgumentException
{
    public static function fromStep(string $stepName, Collection $collection): self
    {
        return new self(
            "The step '{$stepName}' has not found in the collection '".get_class($collection)."'"
        );
    }
}
