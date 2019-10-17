<?php
declare(strict_types=1);

namespace Tests\Application;

use Faker\Factory;
use Faker\Generator;

trait WithFaker
{
    private $faker;

    private function generateFaker(): Generator
    {
        $this->faker = Factory::create();

        return $this->faker;
    }
}
