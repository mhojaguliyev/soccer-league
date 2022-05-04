<?php

namespace App\Interfaces;

use App\Models\Standing;
use Illuminate\Support\Collection;

interface StandingRepositoryInterface extends RepositoryInterface
{
    public function createStanding(): void;

    public function checkStandingStatus(): ?Standing;

    public function checkStanding(): bool;

    public function truncateStanding(): void;

    public function getTeams(): Collection;

    public function getAll(): Collection;
}
