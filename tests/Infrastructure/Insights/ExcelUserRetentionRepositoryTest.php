<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Insights;

use App\Domain\Insights\Step;
use App\Domain\Insights\UserDataSample;
use App\Infrastructure\Insights\ExcelUserRetentionRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Tests\TestCase;

class ExcelUserRetentionRepositoryTest extends TestCase
{
    /** @test **/
    public function the_repository_reads_an_empty_csv()
    {
        $filename = __DIR__.'/../../Stubs/SampleInputs/empty.csv';
        $spreadSheet = IOFactory::load($filename);
        $repository = new ExcelUserRetentionRepository($spreadSheet);

        $userDataSampleCollection = $repository->get();
        $this->assertEquals(0, $userDataSampleCollection->count());
    }

    /** @test **/
    public function the_repository_reads_one_user_data_sample()
    {
        $filename = __DIR__.'/../../Stubs/SampleInputs/one_data_sample.csv';
        $spreadSheet = IOFactory::load($filename);
        $repository = new ExcelUserRetentionRepository($spreadSheet);

        $userDataSampleCollection = $repository->get();
        /** @var UserDataSample $dataSample */
        $dataSample = $userDataSampleCollection->get(0);
        $this->assertEquals('2016-07-19', $dataSample->creationDate()->format('Y-m-d'));
        $this->assertEquals(3121, $dataSample->userId());
        $this->assertEquals(40, $dataSample->step()->percentage());
        $this->assertEquals(Step::PROVIDE_PROFILE_INFORMATION, $dataSample->step()->name());
    }

    /** @test **/
    public function the_repository_reads_multipe_data_samples()
    {
        $filename = __DIR__.'/../../Stubs/SampleInputs/multiple_data_samples.csv';
        $spreadSheet = IOFactory::load($filename);
        $repository = new ExcelUserRetentionRepository($spreadSheet);

        $userDataSampleCollection = $repository->get();

        $this->assertEquals(4, $userDataSampleCollection->count());
    }

    /** @test **/
    public function the_repository_skips_the_rows_with_wrong_step_percentages()
    {
        $filename = __DIR__.'/../../Stubs/SampleInputs/with_wrong_percentages.csv';
        $spreadSheet = IOFactory::load($filename);
        $repository = new ExcelUserRetentionRepository($spreadSheet);

        $userDataSampleCollection = $repository->get();

        $this->assertEquals(3, $userDataSampleCollection->count());
    }
}
