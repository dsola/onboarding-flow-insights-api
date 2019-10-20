<?php
declare(strict_types=1);

namespace Tests\Stubs\Repositories;

use App\Domain\Insights\Contracts\UserRetentionRepository;
use App\Domain\Insights\UserDataSampleCollection;

class InMemoryUserRetentionRepository implements UserRetentionRepository
{
    private $collection;

    public function __construct(UserDataSampleCollection $collection)
    {
        $this->collection = $collection;
    }

    public function get(): UserDataSampleCollection
    {
        return $this->collection;
    }
}
