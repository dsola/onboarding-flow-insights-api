<?php
declare(strict_types=1);

namespace App\Application\Responses;

use App\Domain\Insights\WeeklyCohortSeriesCollection;

final class SeriesDataResponse
{
    public function generateResponse(WeeklyCohortSeriesCollection $weeklyCohortSeriesCollection): array
    {
        return $weeklyCohortSeriesCollection->toArray();
    }
}
