<?php
declare(strict_types=1);

namespace Tests\Domain\Insights;

use App\Domain\Insights\Step;
use App\Domain\Insights\UserRetentionByStep;
use App\Domain\Insights\UserRetentionByStepCollection;
use Tests\TestCase;

class StepCollectionIsInitializedTest extends TestCase
{
    /** @test **/
    public function the_collection_is_generated_with_all_the_steps()
    {
        $collection = new UserRetentionByStepCollection;

        $initializedCollection = $collection->initializeStepCollection();

        $this->assertTrue($this->hasSameStep(Step::createAnAccount(), $initializedCollection->get(0)));
        $this->assertTrue($this->hasSameStep(Step::activateAnAccount(), $initializedCollection->get(1)));
        $this->assertTrue($this->hasSameStep(Step::provideProfileInformation(), $initializedCollection->get(2)));
        $this->assertTrue($this->hasSameStep(Step::whatJobsAreYouInterestedIn(), $initializedCollection->get(3)));
        $this->assertTrue(
            $this->hasSameStep(Step::doYouHaveARelevantExperienceInTheseJobs(), $initializedCollection->get(4))
        );
        $this->assertTrue($this->hasSameStep(Step::areYouAFreelancer(), $initializedCollection->get(5)));
        $this->assertTrue($this->hasSameStep(Step::waitingForApproval(), $initializedCollection->get(6)));
        $this->assertTrue($this->hasSameStep(Step::approval(), $initializedCollection->get(7)));
    }

    /** @test **/
    public function all_the_steps_have_a_initial_percentage()
    {
        $collection = new UserRetentionByStepCollection;

        $initializedCollection = $collection->initializeStepCollection();

        $this->assertEquals(100, $initializedCollection->get(0)->userRetainedPercentage());
        $this->assertEquals(100, $initializedCollection->get(1)->userRetainedPercentage());
        $this->assertEquals(100, $initializedCollection->get(2)->userRetainedPercentage());
        $this->assertEquals(100, $initializedCollection->get(3)->userRetainedPercentage());
        $this->assertEquals(100, $initializedCollection->get(4)->userRetainedPercentage());
        $this->assertEquals(100, $initializedCollection->get(5)->userRetainedPercentage());
        $this->assertEquals(100, $initializedCollection->get(6)->userRetainedPercentage());
        $this->assertEquals(100, $initializedCollection->get(7)->userRetainedPercentage());
    }

    private function hasSameStep(Step $step, UserRetentionByStep $userRetentionByStep): bool
    {
        return $userRetentionByStep->stepName() === $step->name() &&
            $userRetentionByStep->stepPercentage() === $step->percentage();
    }
}