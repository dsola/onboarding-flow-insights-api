<?php
declare(strict_types=1);

namespace Tests\Application\Responses;

use App\Application\Responses\SeriesDataResponse;
use App\Domain\Insights\Step;
use App\Domain\Insights\UserRetention\UserRetentionByStep;
use App\Domain\Insights\UserRetention\UserRetentionByStepCollection;
use App\Domain\Insights\UserRetention\WeeklyCohortSeries;
use App\Domain\Insights\UserRetention\WeeklyCohortSeriesCollection;
use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\Collection;
use Tests\Application\WithFaker;
use Tests\Stubs\UserRetentionByStepFaker;
use Tests\TestCase;
use function random_int;

class SeriesDataHasTheProperFormatTest extends TestCase
{
    use WithFaker;

    final public function test_the_collection_is_empty() {
        $collection = new WeeklyCohortSeriesCollection();

        $response = (new SeriesDataResponse)->generateResponse($collection);

        $this->assertEquals([], $response);
    }

    final public function test_the_week_title_is_correct() {
        $dateFrom = '2018-08-01';
        $dateTo = '2018-08-08';

        $collection = new WeeklyCohortSeriesCollection();
        $weeklyCohortSeries = new WeeklyCohortSeries(
            CarbonImmutable::createFromFormat('Y-m-d', $dateFrom),
            new UserRetentionByStepCollection()
        );
        $collection->add($weeklyCohortSeries);

        $response = (new SeriesDataResponse)->generateResponse($collection);

        $this->assertEquals($dateFrom . ' ' . $dateTo, $response[0]['title']);
    }

    final public function test_the_data_series_is_empty() {
        $collection = new WeeklyCohortSeriesCollection();
        $weeklyCohortSeries = new WeeklyCohortSeries(
            CarbonImmutable::now(),
            new UserRetentionByStepCollection()
        );
        $collection->add($weeklyCohortSeries);

        $response = (new SeriesDataResponse)->generateResponse($collection);

        /** @var UserRetentionByStepCollection $series */
        $series = $response[0]['series'];
        $this->assertEquals([], $series);
    }

    final public function test_when_there_is_a_user_retention_by_step() {

        $userRetainedPercentage = random_int(0, 100);
        $userRetentionByStep = new UserRetentionByStep(
            $userRetainedPercentage,
            Step::createAnAccount()
        );
        $collection = new UserRetentionByStepCollection;
        $collection->add($userRetentionByStep);
        $weeklyCohortCollection = new WeeklyCohortSeriesCollection;
        $weeklyCohortCollection->add(new WeeklyCohortSeries(CarbonImmutable::now(), $collection));

        $response = (new SeriesDataResponse)->generateResponse($weeklyCohortCollection);

        /** @var Collection $series */
        $series = $response[0]['series'];
        $this->assertEquals([
            [
            'user_retained_percentage' => $userRetainedPercentage,
            'step'                     => [
                    'percentage' => 0,
                    'name'      => 'Create an account',
                ],
            ]
        ], $series);
    }

    final public function test_when_there_are_multiple_user_retention_by_steps() {

        $userRetentionByStep1 = UserRetentionByStepFaker::make();
        $userRetentionByStep2 = UserRetentionByStepFaker::make();
        $userRetentionByStep3 = UserRetentionByStepFaker::make();

        $collection = new UserRetentionByStepCollection;
        $collection->add($userRetentionByStep1);
        $collection->add($userRetentionByStep2);
        $collection->add($userRetentionByStep3);

        $weeklyCohortCollection = new WeeklyCohortSeriesCollection;
        $weeklyCohortCollection->add(new WeeklyCohortSeries(CarbonImmutable::now(), $collection));

        $response = (new SeriesDataResponse)->generateResponse($weeklyCohortCollection);

        /** @var Collection $series */
        $series = $response[0]['series'];
        $this->assertEquals([
            $userRetentionByStep1->toArray(),
            $userRetentionByStep2->toArray(),
            $userRetentionByStep3->toArray()
        ], $series);
    }
}
