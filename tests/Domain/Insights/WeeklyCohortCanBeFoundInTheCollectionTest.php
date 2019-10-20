<?php

namespace Tests\Domain\Insights;

use App\Domain\Insights\UserRetentionByStepCollection;
use App\Domain\Insights\WeeklyCohortSeries;
use App\Domain\Insights\WeeklyCohortSeriesCollection;
use Carbon\CarbonImmutable;
use Tests\TestCase;

class WeeklyCohortCanBeFoundInTheCollectionTest extends TestCase
{
    /** @test **/
    public function a_weekly_cohort_is_not_found_when_collection_is_empty()
    {
        $this->assertFalse((new WeeklyCohortSeriesCollection)->hasWeeklyCohort(CarbonImmutable::now()));
    }

    /** @test **/
    public function a_weekly_cohort_is_not_found_when_is_not_in_the_weekly_range()
    {
        $twoWeeksAgo = CarbonImmutable::createFromFormat('Y-m-d', '2019-10-01');
        $collection = new WeeklyCohortSeriesCollection();
        $collection->add(new WeeklyCohortSeries($twoWeeksAgo, new UserRetentionByStepCollection));

        $this->assertFalse(
            $collection->hasWeeklyCohort(CarbonImmutable::createFromFormat('Y-m-d', '2019-10-20'))
        );
    }

    /** @test **/
    public function a_weekly_cohort_is_found_when_is_in_the_weekly_range()
    {
        $twoDaysAgo = CarbonImmutable::createFromFormat('Y-m-d', '2019-10-01');
        $collection = new WeeklyCohortSeriesCollection();
        $collection->add(new WeeklyCohortSeries($twoDaysAgo, new UserRetentionByStepCollection));

        $this->assertTrue(
            $collection->hasWeeklyCohort(CarbonImmutable::createFromFormat('Y-m-d', '2019-10-03'))
        );
    }

    /** @test **/
    public function a_weekly_cohort_is_found_when_is_exactly_the_first_day_of_the_week()
    {
        $twoDaysAgo = CarbonImmutable::createFromFormat('Y-m-d', '2019-10-01');
        $collection = new WeeklyCohortSeriesCollection();
        $collection->add(new WeeklyCohortSeries($twoDaysAgo, new UserRetentionByStepCollection));

        $this->assertTrue(
            $collection->hasWeeklyCohort(CarbonImmutable::createFromFormat('Y-m-d', '2019-10-01'))
        );
    }

    /** @test **/
    public function a_weekly_cohort_is_found_when_is_exactly_the_last_day_of_the_week()
    {
        $twoDaysAgo = CarbonImmutable::createFromFormat('Y-m-d', '2019-10-01');
        $collection = new WeeklyCohortSeriesCollection();
        $collection->add(new WeeklyCohortSeries($twoDaysAgo, new UserRetentionByStepCollection));

        $this->assertTrue(
            $collection->hasWeeklyCohort(CarbonImmutable::createFromFormat('Y-m-d', '2019-10-08'))
        );
    }
}
