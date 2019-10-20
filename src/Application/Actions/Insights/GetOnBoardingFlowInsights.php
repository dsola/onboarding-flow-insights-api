<?php
declare(strict_types=1);

namespace App\Application\Actions\Insights;

use App\Application\Actions\Action;
use App\Application\Responses\SeriesDataResponse;
use App\Domain\Insights\Contracts\UserRetentionRepository;
use App\Domain\Insights\TotalOfUsers\WeeklyCohortSeries as TotalOfUsersWeeklyCohortSeries;
use App\Domain\Insights\UserDataSample;
use App\Domain\Insights\UserRetention\UserRetentionByStepCollectionFactory;
use App\Domain\Insights\UserRetention\WeeklyCohortSeries as UseRetentionWeeklyCohortSeries;
use App\Domain\Insights\UserRetention\WeeklyCohortSeriesCollection as UserRetentionWeeklyCohortCollection;
use App\Domain\Insights\TotalOfUsers\WeeklyCohortSeriesCollection as TotalOfUsersWeeklyCohortSeriesCollection;
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
        /** @var UserDataSample $sample */
        foreach ($userRetentionDataSampleCollection->toArray() as $sample) {
            $creationDate = $sample->creationDate();
            if (!$weeklyCohortSeriesCollection->hasWeeklyCohort($creationDate)) {
                $weeklyCohortSeriesCollection->introduceNewWeeklyCohort($creationDate);
            }
            $weeklyCohortSeriesCollection->addSample($sample);
        }

        $collection = new UserRetentionWeeklyCohortCollection;
        /** @var  TotalOfUsersWeeklyCohortSeries $weeklyCohortSeries */
        foreach ($weeklyCohortSeriesCollection->toArray() as $weeklyCohortSeries) {
            $userRetentionByStepCollection = UserRetentionByStepCollectionFactory::fromTotalUsersByStepCollection(
                $weeklyCohortSeries->series()
            );
            $collection->add(new UseRetentionWeeklyCohortSeries(
                $weeklyCohortSeries->firstDay(),
                $userRetentionByStepCollection
            ));
        }

        return $this->respondWithData((new SeriesDataResponse)->generateResponse($collection));
    }
}
