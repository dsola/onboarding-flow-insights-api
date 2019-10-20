<?php
declare(strict_types=1);

namespace App\Domain\Insights\UserRetention;

use App\Domain\Insights\TotalOfUsers\TotalOfUsersByStepCollection;
use App\Domain\Insights\TotalOfUsers\TotalUsersByStep;

class UserRetentionByStepCollectionFactory
{
    private function __construct()
    {
    }

    public static function fromTotalUsersByStepCollection(
        TotalOfUsersByStepCollection $totalOfUsersByStepCollection
    ): UserRetentionByStepCollection {
        $totalOfUsers = $totalOfUsersByStepCollection->totalOfUsers();
        $userRetentionByStepCollection = new UserRetentionByStepCollection;
        $currentPercentage = 100.0;
        $totalOfUsersForThisStep = 0;
        /** @var TotalUsersByStep $totalOfUsersPerStep */
        foreach ($totalOfUsersByStepCollection->toArray() as $totalOfUsersPerStep) {
            $totalOfUsersForThisStep += $totalOfUsersPerStep->totalOfUsers();
            $userRetentionByStepCollection->add(
                new UserRetentionByStep($currentPercentage, $totalOfUsersPerStep->step())
            );
            $currentPercentage = self::calculateUserRetentionPercentage($totalOfUsersForThisStep, $totalOfUsers);
            print "Total users: $totalOfUsers, Total of users per step: $totalOfUsersForThisStep, Percentage $currentPercentage% \\n";
        }

        return $userRetentionByStepCollection;
    }

    private static function calculateUserRetentionPercentage(int $totalOfUsersForThisStep, int $totalOfUsers)
    {
        if ($totalOfUsersForThisStep > 0) {
            return 100 - ($totalOfUsersForThisStep*100)/$totalOfUsers;
        }

        return 100;
    }
}
