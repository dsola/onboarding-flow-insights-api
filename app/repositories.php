<?php
declare(strict_types=1);

use App\Domain\Insights\Contracts\UserRetentionRepository;
use App\Infrastructure\Insights\ExcelUserRetentionRepository;
use DI\ContainerBuilder;
use PhpOffice\PhpSpreadsheet\IOFactory;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRetentionRepository::class => new ExcelUserRetentionRepository(
            IOFactory::load(__DIR__.'/../resources/export.csv')
        ),
    ]);
};
