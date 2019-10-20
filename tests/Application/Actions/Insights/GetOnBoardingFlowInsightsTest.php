<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Insights;

use App\Application\Actions\ActionPayload;
use App\Application\Responses\SeriesDataResponse;
use App\Domain\Insights\Contracts\UserRetentionRepository;
use App\Domain\Insights\Step;
use App\Domain\Insights\UserDataSample;
use App\Domain\Insights\UserDataSampleCollection;
use App\Domain\Insights\UserRetention\WeeklyCohortSeriesCollection;
use Carbon\CarbonImmutable;
use DI\Container;
use function random_int;
use Tests\Stubs\Repositories\InMemoryUserRetentionRepository;
use Tests\TestCase;
use function json_encode;
use const JSON_PRETTY_PRINT;

class GetOnBoardingFlowInsightsTest extends TestCase
{
    public final function test_the_collection_is_empty_when_there_are_no_data_samples() {
        $app = $this->getAppInstance();
        /** @var Container $container */
        $container = $app->getContainer();
        $container->set(
            UserRetentionRepository::class,
            new InMemoryUserRetentionRepository(new UserDataSampleCollection())
        );

        $request  = $this->createRequest('GET', '/api/v1/on_boarding_flow/insights');
        $response = $app->handle($request);

        $payload            = (string)$response->getBody();

        $expectedPayload   = new ActionPayload(200, (new SeriesDataResponse)->generateResponse(
            new WeeklyCohortSeriesCollection
        ));
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    /** @test **/
    public function when_there_is_a_weekly_cohort_the_series_is_formatted_correctly() {
        $userDataSampleCollection = new UserDataSampleCollection;
        $date                   = CarbonImmutable::now();
        $userDataSampleCollection->add(
            new UserDataSample($date, random_int(1, 5555), Step::createAnAccount())
        );
        $userDataSampleCollection->add(
            new UserDataSample($date, random_int(1, 5555), Step::waitingForApproval())
        );
        $userDataSampleCollection->add(
            new UserDataSample($date, random_int(1, 5555), Step::approval())
        );
        $userDataSampleCollection->add(
            new UserDataSample($date, random_int(1, 5555), Step::approval())
        );
        $userDataSampleCollection->add(
            new UserDataSample($date, random_int(1, 5555), Step::doYouHaveARelevantExperienceInTheseJobs())
        );
        $app = $this->getAppInstance();
        /** @var Container $container */
        $container = $app->getContainer();
        $container->set(UserRetentionRepository::class, new InMemoryUserRetentionRepository($userDataSampleCollection));

        $request  = $this->createRequest('GET', '/api/v1/on_boarding_flow/insights');
        $response = $app->handle($request);

        $payload            = (string)$response->getBody();

        $expectedPayload   = new ActionPayload(
            200,
            include_once __DIR__.'/../../../Stubs/ActionResponses/multiple_steps_response.php'
        );
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    /** @test **/
    public function when_there_are_multiple_weekly_cohorts_returned_in_the_response() {
        $userDataSampleCollection = new UserDataSampleCollection;
        $date                   = CarbonImmutable::now();
        $previousWeek= $date->subWeeks(2);
        $userDataSampleCollection->add(
            new UserDataSample($date, random_int(1, 5555), Step::createAnAccount())
        );
        $userDataSampleCollection->add(
            new UserDataSample($previousWeek, random_int(1, 5555), Step::waitingForApproval())
        );
        $userDataSampleCollection->add(
            new UserDataSample($date, random_int(1, 5555), Step::approval())
        );
        $userDataSampleCollection->add(
            new UserDataSample($previousWeek, random_int(1, 5555), Step::approval())
        );
        $userDataSampleCollection->add(
            new UserDataSample($date, random_int(1, 5555), Step::doYouHaveARelevantExperienceInTheseJobs())
        );
        $app = $this->getAppInstance();
        /** @var Container $container */
        $container = $app->getContainer();
        $container->set(UserRetentionRepository::class, new InMemoryUserRetentionRepository($userDataSampleCollection));

        $request  = $this->createRequest('GET', '/api/v1/on_boarding_flow/insights');
        $response = $app->handle($request);

        $payload            = (string)$response->getBody();

        $expectedPayload   = new ActionPayload(
            200,
            include_once __DIR__.'/../../../Stubs/ActionResponses/multiple_weekly_cohorts.php'
        );
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
