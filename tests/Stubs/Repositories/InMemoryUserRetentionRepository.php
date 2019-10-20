<?php
declare(strict_types=1);

namespace Tests\Stubs\Repositories;

use App\Domain\Insights\Contracts\UserRetentionRepository;
use App\Domain\Insights\UserDataSampleCollection;

class InMemoryUserRetentionRepository implements UserRetentionRepository
{
    public function get(): UserDataSampleCollection
    {
        return new UserDataSampleCollection;
    }
}
