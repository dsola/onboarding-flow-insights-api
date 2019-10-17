<?php
declare(strict_types=1);

namespace App\Application\Actions\Insights;

use App\Application\Actions\Action;
use App\Application\Responses\SeriesDataResponse;
use Psr\Http\Message\ResponseInterface as Response;

final class GetOnBoardingFlowInsights extends Action
{
    protected function action(): Response
    {
        return $this->respondWithData(
            (new SeriesDataResponse)->generateResponse('From 2016-08-01 to 2016-08-07')
        );
    }
}
