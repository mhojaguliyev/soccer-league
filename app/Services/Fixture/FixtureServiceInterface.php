<?php

namespace App\Services\Fixture;

use Illuminate\Support\Collection;
use stdClass;

interface FixtureServiceInterface {
    public function generate(array $ids): void;

    public function playWeek(int $week = 0): void;

    public function playAll(): void;
}
