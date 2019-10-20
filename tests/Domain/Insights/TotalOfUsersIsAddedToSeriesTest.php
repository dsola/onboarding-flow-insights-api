<?php
declare(strict_types=1);

namespace Tests\Domain\Insights;

use App\Domain\Insights\Exceptions\StepNotDefinedInCollection;
use App\Domain\Insights\Step;
use App\Domain\Insights\TotalOfUsers\TotalOfUsersByStepCollection;
use App\Domain\Insights\TotalOfUsers\WeeklyCohortSeries;
use App\Domain\Insights\TotalOfUsers\WeeklyCohortSeriesCollection;
use App\Domain\Insights\UserDataSample;
use Carbon\CarbonImmutable;
use Tests\TestCase;
use function random_int;

class TotalOfUsersIsAddedToSeriesTest extends TestCase
{
    /** @test **/
    public function when_the_step_is_not_included_in_the_collection()
    {
        $collection   = new WeeklyCohortSeriesCollection();
        $date     = CarbonImmutable::now();
        $weeklySeries = new WeeklyCohortSeries($date, new TotalOfUsersByStepCollection);
        $collection->add($weeklySeries);
        $sample = new UserDataSample($date, random_int(1, 5555), Step::createAnAccount());

        $this->expectException(StepNotDefinedInCollection::class);

        $collection->addSample($sample);
    }

    /** @test **/
    public function when_the_step_is_included_in_the_collection()
    {
        $collection   = new WeeklyCohortSeriesCollection();
        $date     = CarbonImmutable::now();
        $totalOfUsersByStep = new TotalOfUsersByStepCollection;
        $totalOfUsersByStep->initializeStepCollection();
        $weeklySeries = new WeeklyCohortSeries($date, $totalOfUsersByStep);
        $collection->add($weeklySeries);
        $sample = new UserDataSample($date, random_int(1, 5555), Step::createAnAccount());

        $collection->addSample($sample);

        $this->assertEquals(1, $collection->get(0)->series()->get(Step::CREATE_AN_ACCOUNT)->totalOfUsers());
    }

    /** @test **/
    public function when_the_step_is_included_in_the_collection_and_multiple_samples_were_added()
    {
        $collection   = new WeeklyCohortSeriesCollection();
        $date     = CarbonImmutable::now();
        $totalOfUsersByStep = new TotalOfUsersByStepCollection;
        $totalOfUsersByStep->initializeStepCollection();
        $weeklySeries = new WeeklyCohortSeries($date, $totalOfUsersByStep);
        $collection->add($weeklySeries);
        $sample = new UserDataSample($date, random_int(1, 5555), Step::createAnAccount());
        $sample2 = new UserDataSample($date, random_int(1, 5555), Step::areYouAFreelancer());

        $collection->addSample($sample);
        $collection->addSample($sample);
        $collection->addSample($sample);
        $collection->addSample($sample);
        $collection->addSample($sample);
        $collection->addSample($sample2);

        $series = $collection->get(0)->series();
        $this->assertEquals(5, $series->get(Step::CREATE_AN_ACCOUNT)->totalOfUsers());
        $this->assertEquals(1, $series->get(Step::ARE_YOU_A_FREELANCER)->totalOfUsers());
    }
}
