<?php
declare(strict_types=1);

namespace Tests\Stubs;

use App\Domain\Insights\Step;
use App\Domain\Insights\UserRetentionByStep;
use function random_int;

final class UserRetentionByStepFaker
{
    private function __construct()
    {
    }

    public static function make(): UserRetentionByStep
    {
        return new UserRetentionByStep(
            random_int(0, 100),
            Step::createAnAccount()
        );
    }
}
