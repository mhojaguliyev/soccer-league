<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;
use stdClass;

interface FixtureRepositoryInterface extends RepositoryInterface
{
    public function checkIfFixturesDrawn(): bool;

    public function truncateFixtures(): void;

    public function currentWeek(): ?stdClass;

    public function getFixtures(): Collection;

    public function getFixtureByWeekId($week_num): Collection;

    public function getAllMatchesByTeamId($teamId): Collection;
}
