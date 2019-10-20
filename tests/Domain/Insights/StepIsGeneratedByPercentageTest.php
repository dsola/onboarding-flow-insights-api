<?php
declare(strict_types=1);

namespace Tests\Domain\Insights;

use App\Domain\Insights\Step;
use Tests\TestCase;

class StepIsGeneratedByPercentageTest extends TestCase
{
    /** @test **/
    public function when_percentage_is_defined_by_a_step()
    {
        $step = Step::fromPercentage(99);

        $this->assertEquals(Step::WAITING_FOR_APPROVAL, $step->name());
    }

    /** @test **/
    public function when_percentage_is_NOT_defined_by_a_step()
    {
        $step = Step::fromPercentage(25);

        $this->assertEquals(Step::PROVIDE_PROFILE_INFORMATION, $step->name());
    }

    /** @test **/
    public function when_percentage_is_higher_than_100()
    {
        $step = Step::fromPercentage(150);

        $this->assertEquals(Step::APPROVAL, $step->name());
    }
}
