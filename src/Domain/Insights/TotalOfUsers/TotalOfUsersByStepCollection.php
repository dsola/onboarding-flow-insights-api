<?php
declare(strict_types=1);

namespace App\Domain\Insights\TotalOfUsers;

use App\Domain\Insights\Exceptions\StepNotDefinedInCollection;
use App\Domain\Insights\Step;
use Doctrine\Common\Collections\AbstractLazyCollection;
use Doctrine\Common\Collections\ArrayCollection;
use function array_reduce;

class TotalOfUsersByStepCollection extends AbstractLazyCollection
{
    protected function doInitialize(): void
    {
        $this->collection = new ArrayCollection();
    }

    public function initializeStepCollection(): self
    {
        $this->collection = new ArrayCollection();

        $this->collection->add(new TotalUsersByStep(Step::createAnAccount()));
        $this->collection->add(new TotalUsersByStep(Step::activateAnAccount()));
        $this->collection->add(new TotalUsersByStep(Step::provideProfileInformation()));
        $this->collection->add(new TotalUsersByStep(Step::whatJobsAreYouInterestedIn()));
        $this->collection->add(new TotalUsersByStep(Step::doYouHaveARelevantExperienceInTheseJobs()));
        $this->collection->add(new TotalUsersByStep(Step::areYouAFreelancer()));
        $this->collection->add(new TotalUsersByStep(Step::waitingForApproval()));
        $this->collection->add(new TotalUsersByStep(Step::approval()));

        return clone $this;
    }

    public function addUserSample(Step $step): self
    {
        $this->get($step->name())->increaseTotal();

        return $this;
    }

    public function totalOfUsers(): int
    {
        return array_reduce($this->collection->toArray(), static function (int $total, TotalUsersByStep $item) {
            return $total + $item->totalOfUsers();
        }, 0);
    }

    public function get($stepName): TotalUsersByStep
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

    public function toArray(): array
    {
        return $this->collection->toArray();
    }
}
