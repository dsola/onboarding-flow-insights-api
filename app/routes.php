<?php
declare(strict_types=1);

use App\Application\Actions\Insights\GetOnBoardingFlowInsights;
use Slim\App;

return static function (App $app) {
    $app->get('/api/v1/on_boarding_flow/insights', GetOnBoardingFlowInsights::class);
};
