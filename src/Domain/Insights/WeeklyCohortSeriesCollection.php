<?php
declare(strict_types=1);

namespace App\Domain\Insights;

use Doctrine\Common\Collections\AbstractLazyCollection;
use Doctrine\Common\Collections\ArrayCollection;

class WeeklyCohortSeriesCollection extends AbstractLazyCollection
{
    protected function doInitialize(): void
    {
        $this->collection = new ArrayCollection();
    }

    public function toArray(): array
    {
        $this->initialize();

        return $this->collection->map(static function (WeeklyCohortSeries $weeklyCohortSeries) {
            return $weeklyCohortSeries->toArray();
        })->toArray();
    }
}
