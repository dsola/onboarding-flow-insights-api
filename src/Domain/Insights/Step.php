<?php
declare(strict_types=1);

namespace App\Domain\Insights;

final class Step
{
    private $name;
    private $percentage;

    public static function createAnAccount(): self
    {
        return new self('Create an account', 0);
    }

    public static function activateAnAccount(): self
    {
        return new self('Activate an account', 20);
    }

    public static function provideProfileInformation(): self
    {
        return new self('Provide profile information', 40);
    }

    public static function whatJobsAreYouInterestedIn(): self
    {
        return new self('What jobs are you interested in?', 50);
    }

    public static function doYouHaveARelevantExperienceInTheseJobs(): self
    {
        return new self('Do you have relevant experience in this jobs?', 70);
    }

    public static function areYouAFreelancer(): self
    {
        return new self('Are you a freelancer?', 90);
    }

    public static function waitingForApproval(): self
    {
        return new self('Waiting for approval', 99);
    }

    public static function approval(): self
    {
        return new self('Approval', 100);
    }

    public function percentage(): int
    {
        return $this->percentage;
    }

    public function name(): string
    {
        return $this->name;
    }

    private function __construct(string $name, int $percentage)
    {
        $this->name = $name;
        $this->percentage = $percentage;
    }
}
