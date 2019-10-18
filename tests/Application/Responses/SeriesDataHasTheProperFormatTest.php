<?php
declare(strict_types=1);

namespace Tests\Application\Responses;

use App\Application\Responses\SeriesDataResponse;
use App\Domain\Insights\Step;
use App\Domain\Insights\UserRetentionByStep;
use App\Domain\Insights\UserRetentionByStepCollection;
use App\Domain\Insights\WeeklyCohortSeries;
use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\Collection;
use Tests\Application\WithFaker;
use Tests\Stubs\UserRetentionByStepFaker;
use Tests\TestCase;
use function random_int;

class SeriesDataHasTheProperFormatTest extends TestCase
{
    use WithFaker;

    final public function test_the_week_title_is_correct() {
        $dateFrom = '2018-08-01';
        $dateTo = '2018-08-08';

        $response = (new SeriesDataResponse)->generateResponse(
            new WeeklyCohortSeries(
                CarbonImmutable::createFromFormat('Y-m-d', $dateFrom),
                new UserRetentionByStepCollection()
            )
        );

        $this->assertEquals($dateFrom . ' ' . $dateTo, $response['title']);
    }

    final public function test_the_data_series_is_empty() {
        $response = (new SeriesDataResponse)->generateResponse(
            new WeeklyCohortSeries(
                CarbonImmutable::now(),
                new UserRetentionByStepCollection()
            )
        );

        /** @var UserRetentionByStepCollection $series */
        $series = $response['series'];
        $this->assertEquals([], $series->toArray());
    }

    final public function test_when_there_is_a_user_retention_by_step() {

        $userRetainedPercentage = random_int(0, 100);
        $userRetentionByStep = new UserRetentionByStep(
            $userRetainedPercentage,
            Step::createAnAccount()
        );
        $collection = new UserRetentionByStepCollection;
        $collection->add($userRetentionByStep);

        $response = (new SeriesDataResponse)->generateResponse(
            new WeeklyCohortSeries(CarbonImmutable::now(), $collection)
        );

        /** @var Collection $series */
        $series = $response['series'];
        $this->assertEquals([
            [
            'user_retained_percentage' => $userRetainedPercentage,
            'step'                     => [
                    'percentage' => 0,
                    'name'      => 'Create an account',
                ],
            ]
        ], $series->toArray());
    }

    final public function test_when_there_are_multiple_user_retention_by_steps() {

        $userRetainedPercentage = random_int(0, 100);
        $userRetentionByStep1 = UserRetentionByStepFaker::make();
        $userRetentionByStep2 = UserRetentionByStepFaker::make();
        $userRetentionByStep3 = UserRetentionByStepFaker::make();

        $collection = new UserRetentionByStepCollection;
        $collection->add($userRetentionByStep1);
        $collection->add($userRetentionByStep2);
        $collection->add($userRetentionByStep3);


        $response = (new SeriesDataResponse)->generateResponse(
            new WeeklyCohortSeries(CarbonImmutable::now(), $collection)
        );

        /** @var Collection $series */
        $series = $response['series'];
        $this->assertEquals([
            $userRetentionByStep1->toArray(),
            $userRetentionByStep2->toArray(),
            $userRetentionByStep3->toArray()
        ], $series->toArray());
    }
}
