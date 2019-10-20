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

    public function initializeStepCollection(): self
    {
        $this->collection = new ArrayCollection();

        $this->collection->add(new UserRetentionByStep(
            100,
            Step::createAnAccount()
        ));
        $this->collection->add(new UserRetentionByStep(
            100,
            Step::activateAnAccount()
        ));
        $this->collection->add(new UserRetentionByStep(
            100,
            Step::provideProfileInformation()
        ));
        $this->collection->add(new UserRetentionByStep(
            100,
            Step::whatJobsAreYouInterestedIn()
        ));
        $this->collection->add(new UserRetentionByStep(
            100,
            Step::doYouHaveARelevantExperienceInTheseJobs()
        ));
        $this->collection->add(new UserRetentionByStep(
            100,
            Step::areYouAFreelancer()
        ));
        $this->collection->add(new UserRetentionByStep(
            100,
            Step::waitingForApproval()
        ));
        $this->collection->add(new UserRetentionByStep(
            100,
            Step::approval()
        ));

        return $this;
    }

    public function toArray()
    {
        $this->initialize();

        return $this->collection->map(static function (UserRetentionByStep $userRetentionByStep) {
            return $userRetentionByStep->toArray();
        });
    }

    public function get($key): UserRetentionByStep
    {
        return $this->collection[$key];
    }
}
