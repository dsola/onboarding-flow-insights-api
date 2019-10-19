<?php
declare(strict_types=1);

namespace App\Domain\Insights\Contracts;

use App\Domain\Insights\UserRetentionDataSampleCollection;

interface UserRetentionRepository
{
    public function get(): UserRetentionDataSampleCollection;
}
