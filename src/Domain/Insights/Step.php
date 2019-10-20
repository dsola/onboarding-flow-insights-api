<?php
declare(strict_types=1);

namespace App\Domain\Insights;

use App\Domain\Insights\Exceptions\UnknownStep;
use function array_flip;
use function array_reverse;
use function var_dump;

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

    public const STEP_ORDER_MAP = [
        Step::CREATE_AN_ACCOUNT => 0,
        Step::ACTIVATE_AN_ACCOUNT => 1,
        Step::PROVIDE_PROFILE_INFORMATION => 2,
        Step::WHAT_JOBS_ARE_YOU_INTERESTED_IN => 3,
        Step::DO_YOU_HAVE_RELEVANT_EXPERIENCE_IN_THIS_JOBS => 4,
        Step::ARE_YOU_A_FREELANCER => 5,
        Step::WAITING_FOR_APPROVAL => 6,
        Step::APPROVAL => 7,
    ];

    public const STEP_PERCENTAGE_MAP = [
        Step::CREATE_AN_ACCOUNT => 0,
        Step::ACTIVATE_AN_ACCOUNT => 20,
        Step::PROVIDE_PROFILE_INFORMATION => 40,
        Step::WHAT_JOBS_ARE_YOU_INTERESTED_IN => 50,
        Step::DO_YOU_HAVE_RELEVANT_EXPERIENCE_IN_THIS_JOBS => 70,
        Step::ARE_YOU_A_FREELANCER => 90,
        Step::WAITING_FOR_APPROVAL => 99,
        Step::APPROVAL => 100,
    ];


    private $name;
    private $percentage;

    public static function createAnAccount(): self
    {
        return new self(self::CREATE_AN_ACCOUNT, self::STEP_PERCENTAGE_MAP[self::CREATE_AN_ACCOUNT]);
    }

    public static function activateAnAccount(): self
    {
        return new self(self::ACTIVATE_AN_ACCOUNT, self::STEP_PERCENTAGE_MAP[self::ACTIVATE_AN_ACCOUNT]);
    }

    public static function provideProfileInformation(): self
    {
        return new self(
            self::PROVIDE_PROFILE_INFORMATION,
            self::STEP_PERCENTAGE_MAP[self::PROVIDE_PROFILE_INFORMATION]
        );
    }

    public static function whatJobsAreYouInterestedIn(): self
    {
        return new self(
            self::WHAT_JOBS_ARE_YOU_INTERESTED_IN,
            self::STEP_PERCENTAGE_MAP[self::WHAT_JOBS_ARE_YOU_INTERESTED_IN]
        );
    }

    public static function doYouHaveARelevantExperienceInTheseJobs(): self
    {
        return new self(
            self::DO_YOU_HAVE_RELEVANT_EXPERIENCE_IN_THIS_JOBS,
            self::STEP_PERCENTAGE_MAP[self::DO_YOU_HAVE_RELEVANT_EXPERIENCE_IN_THIS_JOBS]
        );
    }

    public static function areYouAFreelancer(): self
    {
        return new self(
            self::ARE_YOU_A_FREELANCER,
            self::STEP_PERCENTAGE_MAP[self::ARE_YOU_A_FREELANCER]
        );
    }

    public static function waitingForApproval(): self
    {
        return new self(
            self::WAITING_FOR_APPROVAL,
            self::STEP_PERCENTAGE_MAP[self::WAITING_FOR_APPROVAL]
        );
    }

    public static function approval(): self
    {
        return new self(
            self::APPROVAL,
            self::STEP_PERCENTAGE_MAP[self::APPROVAL]
        );
    }

    /**
     * @param int $percentage
     * @throws UnknownStep
     * @return Step
     */
    public static function fromPercentage(int $percentage): self
    {
        $flippedMap = array_flip(self::STEP_PERCENTAGE_MAP);
        if (empty($flippedMap[$percentage])) {
            throw UnknownStep::byPercentage($percentage);
        }

        return new self($flippedMap[$percentage], $percentage);
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
