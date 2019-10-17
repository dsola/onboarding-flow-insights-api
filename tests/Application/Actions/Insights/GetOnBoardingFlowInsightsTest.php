<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Insights;

use App\Application\Actions\ActionPayload;
use DI\Container;
use function json_encode;
use const JSON_PRETTY_PRINT;
use Tests\TestCase;

class GetOnBoardingFlowInsightsTest extends TestCase
{
    public final function test_the_data_has_the_correct_structure() {
        $app = $this->getAppInstance();
        /** @var Container $container */
        $container = $app->getContainer();

        $request = $this->createRequest('GET', '/api/v1/on_boarding_flow/insights');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, include __DIR__.'/../../../Stubs/ActionResponses/sample_response.php');
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
