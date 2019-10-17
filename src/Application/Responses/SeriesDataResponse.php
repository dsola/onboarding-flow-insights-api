<?php
declare(strict_types=1);

namespace App\Application\Responses;

use App\Domain\Insights\WeeklyCohortSeries;

final class SeriesDataResponse
{
    public function generateResponse(WeeklyCohortSeries $weeklyCohortSeries): array
    {
        return $weeklyCohortSeries->toArray();
    }
}
