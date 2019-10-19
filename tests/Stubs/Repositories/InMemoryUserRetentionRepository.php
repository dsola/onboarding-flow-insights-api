<?php
declare(strict_types=1);

namespace Tests\Stubs\Repositories;

use App\Domain\Insights\Contracts\UserRetentionRepository;
use App\Domain\Insights\UserRetentionDataSampleCollection;

class InMemoryUserRetentionRepository implements UserRetentionRepository
{
    public function get(): UserRetentionDataSampleCollection
    {
        return new UserRetentionDataSampleCollection;
    }
}
