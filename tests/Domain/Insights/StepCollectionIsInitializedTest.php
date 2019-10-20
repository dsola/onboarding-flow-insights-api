<?php
declare(strict_types=1);

namespace Tests\Domain\Insights;

use App\Domain\Insights\Step;
use App\Domain\Insights\TotalOfUsers\TotalOfUsersByStepCollection;
use App\Domain\Insights\TotalOfUsers\TotalUsersByStep;
use App\Domain\Insights\TotalOfUsers\WeeklyCohortSeriesCollection;
use Carbon\CarbonImmutable;
use Tests\TestCase;
use function var_dump;

class StepCollectionIsInitializedTest extends TestCase
{
    /** @test **/
    public function the_collection_is_generated_with_all_the_steps()
    {
        $collection = new TotalOfUsersByStepCollection;

        $initializedCollection = $collection->initializeStepCollection();

        $this->assertTrue(
            $this->hasSameStep(Step::createAnAccount(), $initializedCollection->get(
                TotalOfUsersByStepCollection::STEP_POSITION_MAP[Step::CREATE_AN_ACCOUNT]
            ))
        );
        $this->assertTrue(
            $this->hasSameStep(Step::activateAnAccount(), $initializedCollection->get(
                TotalOfUsersByStepCollection::STEP_POSITION_MAP[Step::ACTIVATE_AN_ACCOUNT]
            ))
        );
        $this->assertTrue(
            $this->hasSameStep(Step::provideProfileInformation(), $initializedCollection->get(
                TotalOfUsersByStepCollection::STEP_POSITION_MAP[Step::PROVIDE_PROFILE_INFORMATION]
            ))
        );
        $this->assertTrue(
            $this->hasSameStep(Step::whatJobsAreYouInterestedIn(), $initializedCollection->get(
                TotalOfUsersByStepCollection::STEP_POSITION_MAP[Step::WHAT_JOBS_ARE_YOU_INTERESTED_IN]
            ))
        );
        $this->assertTrue(
            $this->hasSameStep(Step::doYouHaveARelevantExperienceInTheseJobs(), $initializedCollection->get(
                TotalOfUsersByStepCollection::STEP_POSITION_MAP[Step::DO_YOU_HAVE_RELEVANT_EXPERIENCE_IN_THIS_JOBS]
            ))
        );
        $this->assertTrue(
            $this->hasSameStep(Step::areYouAFreelancer(), $initializedCollection->get(
                TotalOfUsersByStepCollection::STEP_POSITION_MAP[Step::ARE_YOU_A_FREELANCER]
            ))
        );
        $this->assertTrue(
            $this->hasSameStep(Step::waitingForApproval(), $initializedCollection->get(
                TotalOfUsersByStepCollection::STEP_POSITION_MAP[Step::WAITING_FOR_APPROVAL]
            ))
        );
        $this->assertTrue(
            $this->hasSameStep(Step::approval(), $initializedCollection->get(
                TotalOfUsersByStepCollection::STEP_POSITION_MAP[Step::APPROVAL]
            ))
        );
    }

    /** @test **/
    public function all_the_steps_have_a_initial_percentage()
    {
        $collection = new TotalOfUsersByStepCollection();

        $initializedCollection = $collection->initializeStepCollection();

        $this->assertEquals(0, $initializedCollection->get(0)->totalOfUsers());
        $this->assertEquals(0, $initializedCollection->get(1)->totalOfUsers());
        $this->assertEquals(0, $initializedCollection->get(2)->totalOfUsers());
        $this->assertEquals(0, $initializedCollection->get(3)->totalOfUsers());
        $this->assertEquals(0, $initializedCollection->get(4)->totalOfUsers());
        $this->assertEquals(0, $initializedCollection->get(5)->totalOfUsers());
        $this->assertEquals(0, $initializedCollection->get(6)->totalOfUsers());
        $this->assertEquals(0, $initializedCollection->get(7)->totalOfUsers());
    }

    /** @test **/
    public function the_weekly_cohort_generates_all_the_step_collection_based_on_the_date()
    {
        $date = CarbonImmutable::createFromFormat('Y-m-d', '2019-10-20');
        $collection = new WeeklyCohortSeriesCollection;

        $collection->introduceNewWeeklyCohort($date);

        $weeklyCohortSeries = $collection->get(0);
        $this->assertEquals(8, $weeklyCohortSeries->series()->count());
    }

    private function hasSameStep(Step $step, TotalUsersByStep $userRetentionByStep): bool
    {
        return $userRetentionByStep->stepName() === $step->name() &&
            $userRetentionByStep->stepPercentage() === $step->percentage();
    }
}
