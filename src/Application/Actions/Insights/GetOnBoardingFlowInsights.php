<?php
declare(strict_types=1);

namespace App\Application\Actions\Insights;

use App\Application\Actions\Action;
use App\Application\Responses\SeriesDataResponse;
use App\Domain\Insights\UserRetentionByStepCollection;
use App\Domain\Insights\WeeklyCohortSeries;
use Carbon\CarbonImmutable;
use Psr\Http\Message\ResponseInterface as Response;

final class GetOnBoardingFlowInsights extends Action
{
    protected function action(): Response
    {
        return $this->respondWithData(
            (new SeriesDataResponse)->generateResponse(
                new WeeklyCohortSeries(
                    CarbonImmutable::createFromFormat('Y-m-d', '2016-08-01'),
                    new UserRetentionByStepCollection()
                )
            )
        );
    }
}
