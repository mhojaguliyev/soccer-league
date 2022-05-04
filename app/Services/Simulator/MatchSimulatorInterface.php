<?php

namespace App\Services\Simulator;

use App\Models\Fixture;
use Illuminate\Support\Collection;

interface MatchSimulatorInterface
{
    public function simulate(Fixture $fixture): void;

    public function bulkSimulate(Collection $fixtures): void;
}
