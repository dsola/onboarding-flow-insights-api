<?php
declare(strict_types=1);

use App\Domain\Insights\Contracts\UserRetentionRepository;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use function DI\autowire;
use DI\ContainerBuilder;
use Tests\Stubs\Repositories\InMemoryUserRetentionRepository;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        UserRetentionRepository::class => autowire(InMemoryUserRetentionRepository::class),
    ]);
};
