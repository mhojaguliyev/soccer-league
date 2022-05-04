<?php

namespace App\Services\Simulator;

use App\Models\Fixture;
use App\Models\Team;
use Illuminate\Support\Collection;

class MatchSimulator implements MatchSimulatorInterface
{
    /**
     * Simulate one fixture by team power
     *
     * @param Fixture $fixture
     */
    public function simulate(Fixture $fixture): void
    {
        /** @var Team $home_team */
        $home_team = $fixture->homeTeam;

        /** @var Team $away_team */
        $away_team = $fixture->awayTeam;

        if ($home_team->power > $away_team->power) {
            $homeGoal = floor(rand(0, 10) / 10 * (6 - 2)) + 2;
            $awayGoal = floor(rand(0, 10) / 10 * (4 - 1)) + 1;
        } else {
            $awayGoal = floor(rand(0, 10) / 10 * (6 - 2)) + 2;
            $homeGoal = floor(rand(0, 10) / 10 * (4 - 1)) + 1;
        }

        $fixture->home_goal = $homeGoal;
        $fixture->away_goal = $awayGoal;
        $fixture->winner_id = $homeGoal > $awayGoal ? $home_team->id : ($homeGoal == $awayGoal ? 0 : $away_team->id);
        $fixture->status = true;
        $fixture->save();

        $gd = abs($homeGoal - $awayGoal);
        if ($home_team->id == $fixture->winner_id) {
            $home_team->won($gd);
            $away_team->lost($gd);
        } elseif ($away_team->id == $fixture->winner_id) {
            $home_team->lost($gd);
            $away_team->won($gd);
        } else {
            $home_team->draw();
            $away_team->draw();
        }
    }

    /**
     * Simulate multiple fixtures by team powers
     *
     * @param Collection $fixtures
     */
    public function bulkSimulate(Collection $fixtures): void
    {
        foreach ($fixtures as $match) {
            $this->simulate($match);
        }
    }
}
