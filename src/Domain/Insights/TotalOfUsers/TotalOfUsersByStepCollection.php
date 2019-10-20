<?php
declare(strict_types=1);

namespace App\Domain\Insights\TotalOfUsers;

use App\Domain\Insights\Step;
use Doctrine\Common\Collections\AbstractLazyCollection;
use Doctrine\Common\Collections\ArrayCollection;

class TotalOfUsersByStepCollection extends AbstractLazyCollection
{
    public const STEP_POSITION_MAP = [
        Step::CREATE_AN_ACCOUNT => 0,
        Step::ACTIVATE_AN_ACCOUNT => 1,
        Step::PROVIDE_PROFILE_INFORMATION => 2,
        Step::WHAT_JOBS_ARE_YOU_INTERESTED_IN => 3,
        Step::DO_YOU_HAVE_RELEVANT_EXPERIENCE_IN_THIS_JOBS => 4,
        Step::ARE_YOU_A_FREELANCER => 5,
        Step::WAITING_FOR_APPROVAL => 6,
        Step::APPROVAL => 7,
    ];

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

    public function addUserRetentionFromStep(Step $step): self
    {
        $this->get(self::STEP_POSITION_MAP[$step->name()])->increaseTotal();

        return $this;
    }

    public function get($key): TotalUsersByStep
    {
        return $this->collection[$key];
    }

    public function count(): int
    {
        return $this->collection->count();
    }
}
