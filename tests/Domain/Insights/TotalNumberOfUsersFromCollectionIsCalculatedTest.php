<?php
declare(strict_types=1);

namespace Tests\Domain\Insights;

use App\Domain\Insights\Step;
use App\Domain\Insights\TotalOfUsers\TotalOfUsersByStepCollection;
use Tests\TestCase;

class TotalNumberOfUsersFromCollectionIsCalculatedTest extends TestCase
{
    /** @test **/
    public function when_there_are_not_items_in_the_collection()
    {
        $collection = new TotalOfUsersByStepCollection;
        $collection->initializeStepCollection();

        $this->assertEquals(0, $collection->totalOfUsers());
    }

    /** @test **/
    public function when_there_are_items_from_only_one_step()
    {
        $collection = new TotalOfUsersByStepCollection;
        $collection->initializeStepCollection();
        $collection->addUserSample(Step::createAnAccount());
        $collection->addUserSample(Step::createAnAccount());

        $this->assertEquals(2, $collection->totalOfUsers());
    }

    /** @test **/
    public function when_there_are_items_from_multiple_steps()
    {
        $collection = new TotalOfUsersByStepCollection;
        $collection->initializeStepCollection();
        $collection->addUserSample(Step::createAnAccount());
        $collection->addUserSample(Step::areYouAFreelancer());
        $collection->addUserSample(Step::doYouHaveARelevantExperienceInTheseJobs());

        $this->assertEquals(3, $collection->totalOfUsers());
    }
}
