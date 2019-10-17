<?php
declare(strict_types=1);

namespace App\Application\Responses;

class SeriesDataResponse
{
    public function __construct()
    {
    }

    public function generateResponse(): array
    {
        return [
            'title'  => 'From 2016-08-01 to 2016-08-07',
            'series' => [
                [
                    'user_retained_percentage' => 100,
                    'step'                     => [
                        'percentage' => 10,
                        'title'      => 'Create Account',
                    ],
                ],
                [
                    'user_retained_percentage' => 100,
                    'step'                     => [
                        'percentage' => 10,
                        'title'      => 'Create Account',
                    ],
                ],
                [
                    'user_retained_percentage' => 100,
                    'step'                     => [
                        'percentage' => 10,
                        'title'      => 'Create Account',
                    ],
                ],
                [
                    'user_retained_percentage' => 100,
                    'step'                     => [
                        'percentage' => 10,
                        'title'      => 'Create Account',
                    ],
                ],
            ],
        ];
    }
}
