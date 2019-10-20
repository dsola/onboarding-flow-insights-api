<?php
declare(strict_types=1);

namespace App\Application\Actions\Insights;

use App\Application\Actions\Action;
use App\Application\Responses\SeriesDataResponse;
use App\Domain\Insights\Contracts\UserRetentionRepository;
use App\Domain\Insights\TotalOfUsers\TotalOfUsersByStepCollection;
use App\Domain\Insights\TotalOfUsers\WeeklyCohortSeries as TotalOfUsersWeeklyCohortSeries;
use App\Domain\Insights\UserDataSample;
use App\Domain\Insights\UserRetention\UserRetentionByStepCollection;
use App\Domain\Insights\UserRetention\WeeklyCohortSeries as UseRetentionWeeklyCohortSeries;
use App\Domain\Insights\UserRetention\WeeklyCohortSeriesCollection as UseRetentionWeeklyCohortSeriesCollection;
use App\Domain\Insights\TotalOfUsers\WeeklyCohortSeriesCollection as TotalOfUsersWeeklyCohortSeriesCollection;
use Carbon\CarbonImmutable;
use Closure;
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

        $weeklyCohortSeriesCollection = new TotalOfUsersWeeklyCohortSeriesCollection();
        $userRetentionDataSampleCollection->forAll($this->includeSampleToCollection($weeklyCohortSeriesCollection));

        $collection = new UseRetentionWeeklyCohortSeriesCollection();
        $weeklyCohortSeriesCollection->forAll(
            static function (TotalOfUsersWeeklyCohortSeries $weeklyCohortSeries) {
                $totalOfUsersByStepCollection = $weeklyCohortSeries->series();
                $totalOfUsers = $totalOfUsersByStepCollection->totalOfUsers();
                $totalOfUsersByStepCollection->forAll(function(TotalOfUsersByStepCollection $totalOfUsersPerStep) {

                });
            }
        );


        $collection = new UseRetentionWeeklyCohortSeriesCollection();
        $collection->add(
            new UseRetentionWeeklyCohortSeries(
                CarbonImmutable::createFromFormat('Y-m-d', '2016-08-01'),
                new UserRetentionByStepCollection()
            )
        );

        return $this->respondWithData(
            (new SeriesDataResponse)->generateResponse($collection)
        );
    }

    private function includeSampleToCollection(TotalOfUsersWeeklyCohortSeriesCollection $weeklyCohortSeriesCollection
    ): Closure {
        return static function (UserDataSample $sample) use ($weeklyCohortSeriesCollection) {
            $creationDate = $sample->creationDate();
            if (!$weeklyCohortSeriesCollection->hasWeeklyCohort($creationDate)) {
                $weeklyCohortSeriesCollection->introduceNewWeeklyCohort($creationDate);
            }
            $weeklyCohortSeriesCollection->addSample($sample);
        };
    }
}
