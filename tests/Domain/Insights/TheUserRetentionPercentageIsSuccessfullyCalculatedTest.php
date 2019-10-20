<?php
declare(strict_types=1);

namespace Tests\Domain\Insights;

use App\Domain\Insights\Step;
use App\Domain\Insights\TotalOfUsers\TotalOfUsersByStepCollection;
use App\Domain\Insights\UserRetention\UserRetentionByStepCollectionFactory;
use Tests\TestCase;

class TheUserRetentionPercentageIsSuccessfullyCalculatedTest extends TestCase
{
    /** @test **/
    public function when_any_users_are_retained_in_any_step()
    {
        $totalOfUsersByStepCollection = new TotalOfUsersByStepCollection;
        $totalOfUsersByStepCollection->initializeStepCollection();
        $userRetentionByStepCollection = UserRetentionByStepCollectionFactory::fromTotalUsersByStepCollection(
            $totalOfUsersByStepCollection
        );

        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::CREATE_AN_ACCOUNT)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::ACTIVATE_AN_ACCOUNT)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::PROVIDE_PROFILE_INFORMATION)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::WHAT_JOBS_ARE_YOU_INTERESTED_IN)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::DO_YOU_HAVE_RELEVANT_EXPERIENCE_IN_THIS_JOBS)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::ARE_YOU_A_FREELANCER)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::WAITING_FOR_APPROVAL)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::APPROVAL)->userRetainedPercentage()
        );
    }

    /** @test **/
    public function when_users_are_retained_in_the_approval()
    {
        $totalOfUsersByStepCollection = new TotalOfUsersByStepCollection;
        $totalOfUsersByStepCollection->initializeStepCollection();
        $userRetentionByStepCollection = UserRetentionByStepCollectionFactory::fromTotalUsersByStepCollection(
            $totalOfUsersByStepCollection
        );
        $totalOfUsersByStepCollection->addUserSample(Step::approval());
        $totalOfUsersByStepCollection->addUserSample(Step::approval());
        $totalOfUsersByStepCollection->addUserSample(Step::approval());
        $totalOfUsersByStepCollection->addUserSample(Step::approval());
        $totalOfUsersByStepCollection->addUserSample(Step::approval());

        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::CREATE_AN_ACCOUNT)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::ACTIVATE_AN_ACCOUNT)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::PROVIDE_PROFILE_INFORMATION)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::WHAT_JOBS_ARE_YOU_INTERESTED_IN)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::DO_YOU_HAVE_RELEVANT_EXPERIENCE_IN_THIS_JOBS)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::ARE_YOU_A_FREELANCER)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::WAITING_FOR_APPROVAL)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::APPROVAL)->userRetainedPercentage()
        );
    }

    /** @test **/
    public function when_the_users_are_retained_in_a_specific_step()
    {
        $totalOfUsersByStepCollection = new TotalOfUsersByStepCollection;
        $totalOfUsersByStepCollection->initializeStepCollection();
        $totalOfUsersByStepCollection->addUserSample(Step::waitingForApproval());
        $totalOfUsersByStepCollection->addUserSample(Step::waitingForApproval());
        $totalOfUsersByStepCollection->addUserSample(Step::waitingForApproval());
        $totalOfUsersByStepCollection->addUserSample(Step::waitingForApproval());

        $userRetentionByStepCollection = UserRetentionByStepCollectionFactory::fromTotalUsersByStepCollection(
            $totalOfUsersByStepCollection
        );

        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::CREATE_AN_ACCOUNT)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::ACTIVATE_AN_ACCOUNT)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::PROVIDE_PROFILE_INFORMATION)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::WHAT_JOBS_ARE_YOU_INTERESTED_IN)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::DO_YOU_HAVE_RELEVANT_EXPERIENCE_IN_THIS_JOBS)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::ARE_YOU_A_FREELANCER)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::WAITING_FOR_APPROVAL)->userRetainedPercentage()
        );
        $this->assertEquals(
            0,
            $userRetentionByStepCollection->get(Step::APPROVAL)->userRetainedPercentage()
        );
    }

    /** @test **/
    public function when_the_user_is_retained_in_multiple_steps()
    {
        $totalOfUsersByStepCollection = new TotalOfUsersByStepCollection;
        $totalOfUsersByStepCollection->initializeStepCollection();
        $totalOfUsersByStepCollection->addUserSample(Step::activateAnAccount());
        $totalOfUsersByStepCollection->addUserSample(Step::activateAnAccount());
        $totalOfUsersByStepCollection->addUserSample(Step::doYouHaveARelevantExperienceInTheseJobs());
        $totalOfUsersByStepCollection->addUserSample(Step::doYouHaveARelevantExperienceInTheseJobs());
        $totalOfUsersByStepCollection->addUserSample(Step::doYouHaveARelevantExperienceInTheseJobs());
        $totalOfUsersByStepCollection->addUserSample(Step::doYouHaveARelevantExperienceInTheseJobs());
        $totalOfUsersByStepCollection->addUserSample(Step::areYouAFreelancer());
        $totalOfUsersByStepCollection->addUserSample(Step::areYouAFreelancer());
        $totalOfUsersByStepCollection->addUserSample(Step::waitingForApproval());
        $totalOfUsersByStepCollection->addUserSample(Step::waitingForApproval());

        $userRetentionByStepCollection = UserRetentionByStepCollectionFactory::fromTotalUsersByStepCollection(
            $totalOfUsersByStepCollection
        );

        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::CREATE_AN_ACCOUNT)->userRetainedPercentage()
        );
        $this->assertEquals(
            100,
            $userRetentionByStepCollection->get(Step::ACTIVATE_AN_ACCOUNT)->userRetainedPercentage()
        );
        $this->assertEquals(
            80,
            $userRetentionByStepCollection->get(Step::PROVIDE_PROFILE_INFORMATION)->userRetainedPercentage()
        );
        $this->assertEquals(
            80,
            $userRetentionByStepCollection->get(Step::WHAT_JOBS_ARE_YOU_INTERESTED_IN)->userRetainedPercentage()
        );
        $this->assertEquals(
            80,
            $userRetentionByStepCollection->get(Step::DO_YOU_HAVE_RELEVANT_EXPERIENCE_IN_THIS_JOBS)->userRetainedPercentage()
        );
        $this->assertEquals(
            40,
            $userRetentionByStepCollection->get(Step::ARE_YOU_A_FREELANCER)->userRetainedPercentage()
        );
        $this->assertEquals(
            20,
            $userRetentionByStepCollection->get(Step::WAITING_FOR_APPROVAL)->userRetainedPercentage()
        );
        $this->assertEquals(
            0,
            $userRetentionByStepCollection->get(Step::APPROVAL)->userRetainedPercentage()
        );
    }
}
