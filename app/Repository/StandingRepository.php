<?php

namespace App\Repository;

use App\Interfaces\StandingRepositoryInterface;
use App\Models\Standing;
use App\Models\Team;
use Illuminate\Support\Collection;

class StandingRepository implements StandingRepositoryInterface
{
    private Standing $standing;
    private Team $team;

    public function __construct(Standing $standing, Team $team)
    {
        $this->standing = $standing;
        $this->team = $team;
    }

    /**
     * Generate standing by teams
     */
    public function createStanding(): void
    {
        if (!$this->checkStanding()) {
            return;
        }
        foreach ($this->getTeams() as $value) {
            $data = ['team_id' => $value];
            $this->standing->create($data);
        }
    }

    /**
     * Get standing first item
     *
     * @return Standing|null
     */
    public function checkStandingStatus(): ?Standing
    {
        return $this->standing->select('played')->first();
    }

    /**
     * Check if standing generated
     *
     * @return bool
     */
    public function checkStanding(): bool
    {
        return $this->standing->count() <= 0;
    }

    /**
     * Reset standing data
     */
    public function truncateStanding(): void
    {
        $this->standing->truncate();
    }

    /**
     * Get team ids
     *
     * @return Collection
     */
    public function getTeams(): Collection
    {
        return $this->team->pluck('id');
    }

    /**
     * Get standing table
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->team->leftJoin('standings', 'teams.id', '=', 'standings.team_id')
            ->orderBy('standings.points', 'DESC')
            ->orderBy('standings.goal_difference', 'DESC')
            ->orderBy('standings.won', 'DESC')
            ->get();
    }
}
