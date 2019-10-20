<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Insights;

use App\Application\Actions\ActionPayload;
use App\Application\Responses\SeriesDataResponse;
use App\Domain\Insights\UserRetention\UserRetentionByStepCollection;
use App\Domain\Insights\UserRetention\WeeklyCohortSeries;
use App\Domain\Insights\UserRetention\WeeklyCohortSeriesCollection;
use App\Domain\User\UserRepository;
use Carbon\CarbonImmutable;
use DI\Container;
use Tests\Stubs\Repositories\InMemoryUserRetentionRepository;
use Tests\TestCase;
use function json_encode;
use const JSON_PRETTY_PRINT;

class GetOnBoardingFlowInsightsTest extends TestCase
{
    public final function test_the_data_has_the_correct_structure() {
        $app = $this->getAppInstance();
        /** @var Container $container */
        $container = $app->getContainer();
        $container->set(UserRepository::class, new InMemoryUserRetentionRepository);

        $request  = $this->createRequest('GET', '/api/v1/on_boarding_flow/insights');
        $response = $app->handle($request);

        $payload            = (string)$response->getBody();
        $collection         = new WeeklyCohortSeriesCollection;
        $weeklyCohortSeries = new WeeklyCohortSeries(
            CarbonImmutable::createFromFormat('Y-m-d', '2016-08-01'),
            new UserRetentionByStepCollection
        );
        $collection->add($weeklyCohortSeries);
        $expectedPayload   = new ActionPayload(200, (new SeriesDataResponse)->generateResponse($collection));
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
