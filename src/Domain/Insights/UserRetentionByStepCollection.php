<?php
declare(strict_types=1);

namespace App\Domain\Insights;

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
}
