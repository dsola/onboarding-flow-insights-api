<?php
declare(strict_types=1);

namespace App\Domain\Insights\Contracts;

use App\Domain\Insights\UserDataSampleCollection;

interface UserRetentionRepository
{
    public function get(): UserDataSampleCollection;
}
