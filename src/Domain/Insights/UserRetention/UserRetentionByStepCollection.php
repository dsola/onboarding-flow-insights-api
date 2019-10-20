<?php
declare(strict_types=1);

namespace App\Domain\Insights\UserRetention;

use App\Domain\Insights\Exceptions\StepNotDefinedInCollection;
use App\Domain\Insights\Step;
use Doctrine\Common\Collections\AbstractLazyCollection;
use Doctrine\Common\Collections\ArrayCollection;

final class UserRetentionByStepCollection extends AbstractLazyCollection
{
    protected function doInitialize(): void
    {
        $this->collection = new ArrayCollection();
    }

    public function toArray()
    {
        $this->initialize();

        return $this->collection->map(static function (UserRetentionByStep $userRetentionByStep) {
            return $userRetentionByStep->toArray();
        });
    }

    public function get($stepName): UserRetentionByStep
    {
        $element = $this->collection[Step::STEP_ORDER_MAP[$stepName]];
        if (null === $element) {
            throw StepNotDefinedInCollection::fromStep($stepName, $this);
        }
        return $element;
    }

    public function count(): int
    {
        return $this->collection->count();
    }
}
