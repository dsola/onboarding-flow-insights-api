<?php
declare(strict_types=1);

namespace App\Domain\Insights;

final class Step
{
    public const CREATE_AN_ACCOUNT = 'Create an account';
    public const ACTIVATE_AN_ACCOUNT = 'Activate an account';
    public const PROVIDE_PROFILE_INFORMATION = 'Provide profile information';
    public const WHAT_JOBS_ARE_YOU_INTERESTED_IN = 'What jobs are you interested in?';
    public const DO_YOU_HAVE_RELEVANT_EXPERIENCE_IN_THIS_JOBS = 'Do you have relevant experience in this jobs?';
    public const ARE_YOU_A_FREELANCER = 'Are you a freelancer?';
    public const WAITING_FOR_APPROVAL = 'Waiting for approval';
    public const APPROVAL = 'Approval';

    private $name;
    private $percentage;

    public static function createAnAccount(): self
    {
        return new self(self::CREATE_AN_ACCOUNT, 0);
    }

    public static function activateAnAccount(): self
    {
        return new self(self::ACTIVATE_AN_ACCOUNT, 20);
    }

    public static function provideProfileInformation(): self
    {
        return new self(self::PROVIDE_PROFILE_INFORMATION, 40);
    }

    public static function whatJobsAreYouInterestedIn(): self
    {
        return new self(self::WHAT_JOBS_ARE_YOU_INTERESTED_IN, 50);
    }

    public static function doYouHaveARelevantExperienceInTheseJobs(): self
    {
        return new self(self::DO_YOU_HAVE_RELEVANT_EXPERIENCE_IN_THIS_JOBS, 70);
    }

    public static function areYouAFreelancer(): self
    {
        return new self(self::ARE_YOU_A_FREELANCER, 90);
    }

    public static function waitingForApproval(): self
    {
        return new self(self::WAITING_FOR_APPROVAL, 99);
    }

    public static function approval(): self
    {
        return new self(self::APPROVAL, 100);
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
