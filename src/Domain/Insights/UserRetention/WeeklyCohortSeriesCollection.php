<?php
declare(strict_types=1);

namespace App\Domain\Insights\UserRetention;

use App\Domain\Insights\UserDataSample;
use Carbon\CarbonInterface;
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

    public function get($key): WeeklyCohortSeries
    {
        return $this->collection[$key];
    }
}
