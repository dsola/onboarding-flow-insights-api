<?php
declare(strict_types=1);

namespace App\Application\Actions\Insights;

use App\Application\Actions\Action;
use App\Application\Responses\SeriesDataResponse;
use App\Domain\Insights\Contracts\UserRetentionRepository;
use App\Domain\Insights\UserRetentionByStepCollection;
use App\Domain\Insights\UserRetentionDataSample;
use App\Domain\Insights\WeeklyCohortSeries;
use App\Domain\Insights\WeeklyCohortSeriesCollection;
use Carbon\CarbonImmutable;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

final class GetOnBoardingFlowInsights extends Action
{
    private $repository;

    public function __construct(LoggerInterface $logger, UserRetentionRepository $repository)
    {
        parent::__construct($logger);
        $this->repository = $repository;
    }

    protected function action(): Response
    {
        $userRetentionDataSampleCollection = $this->repository->get();
        // group by weekly cohort
        $weeklyCohortSeries = new WeeklyCohortSeriesCollection();
        $userRetentionDataSampleCollection->forAll(
            static function (UserRetentionDataSample $sample) use ($weeklyCohortSeries) {
                $creationDate = $sample->creationDate();
                if (!$weeklyCohortSeries->hasWeeklyCohort($creationDate)) {
                    $weeklyCohortSeries->introduceNewWeeklyCohort($creationDate);
                }
            }
        );
        // for each week, calculate tbe user retention percentage per step

        $collection = new WeeklyCohortSeriesCollection();
        $collection->add(
            new WeeklyCohortSeries(
                CarbonImmutable::createFromFormat('Y-m-d', '2016-08-01'),
                new UserRetentionByStepCollection()
            )
        );

        return $this->respondWithData(
            (new SeriesDataResponse)->generateResponse($collection)
        );
    }
}
