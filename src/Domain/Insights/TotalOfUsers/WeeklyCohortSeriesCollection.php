<?php
declare(strict_types=1);

namespace App\Domain\Insights\TotalOfUsers;

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

    public function hasWeeklyCohort(CarbonInterface $date): bool
    {
        $this->initialize();

        /** @var WeeklyCohortSeries $weeklyCohortSeries */
        foreach ($this->collection as $weeklyCohortSeries) {
            if ($weeklyCohortSeries->belongsToCohort($date)) {
                return true;
            }
        }

        return false;
    }

    public function introduceNewWeeklyCohort(CarbonInterface $date): self
    {
        $this->initialize();

        $userRetentionByStepCollection = new TotalOfUsersByStepCollection();
        $userRetentionByStepCollection->initializeStepCollection();
        $weeklyCohortSeries = new WeeklyCohortSeries($date, $userRetentionByStepCollection);
        $this->collection->add($weeklyCohortSeries);

        return $this;
    }

    public function addSample(UserDataSample $sample): self
    {
        $this->initialize();

        /** @var WeeklyCohortSeries $weeklyCohortSeries */
        foreach ($this->collection as $key => $weeklyCohortSeries) {
            if ($weeklyCohortSeries->belongsToCohort($sample->creationDate())) {
                $this->collection[$key] = $weeklyCohortSeries->addSample($sample->step());
            }
        }

        return clone $this;
    }

    public function get($key): WeeklyCohortSeries
    {
        return $this->collection[$key];
    }

    public function toArray(): array
    {
        $this->initialize();

        return $this->collection->toArray();
    }
}
