<?php
declare(strict_types=1);

namespace Tests\Application\Responses;

use App\Application\Responses\SeriesDataResponse;
use App\Domain\Insights\UserRetentionByStepCollection;
use App\Domain\Insights\WeeklyCohortSeries;
use Carbon\CarbonImmutable;
use Tests\Application\WithFaker;
use Tests\TestCase;

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
}
