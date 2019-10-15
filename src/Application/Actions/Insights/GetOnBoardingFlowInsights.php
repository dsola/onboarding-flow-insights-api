<?php
declare(strict_types=1);

namespace App\Application\Actions\Insights;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class GetOnBoardingFlowInsights extends Action
{

    protected function action(): Response
    {
        return $this->respondWithData([
           'message' => 'Get insight of how users flow through the onboarding process'
        ]);
    }
}
