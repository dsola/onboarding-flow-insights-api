<?php
declare(strict_types=1);

namespace App\Infrastructure\Insights;

use App\Domain\Insights\Contracts\UserRetentionRepository;
use App\Domain\Insights\Step;
use App\Domain\Insights\UserDataSample;
use App\Domain\Insights\UserDataSampleCollection;
use function array_shift;
use Carbon\CarbonImmutable;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExcelUserRetentionRepository implements UserRetentionRepository
{
    private $spreadSheet;

    public function __construct(Spreadsheet $spreadSheet)
    {
        $this->spreadSheet = $spreadSheet;
    }

    public function get(): UserDataSampleCollection
    {
        $collection = new UserDataSampleCollection;
        $workSheets = $this->spreadSheet
            ->getActiveSheet()
            ->toArray(null, true, true, true);
        array_shift($workSheets);
        foreach ($workSheets as $workSheet) {
            $collection->add(
                new UserDataSample(
                    CarbonImmutable::createFromFormat('Y-m-d', $workSheet['B']),
                    (int) $workSheet['A'],
                    Step::fromPercentage((int) $workSheet['C'])
                )
            );
        }

        return $collection;
    }
}
