<?php

namespace App\Services\Fixture;

use App\Models\Fixture;
use App\Services\Simulator\MatchSimulatorInterface;
use RuntimeException;

class FixtureService implements FixtureServiceInterface
{
    private MatchSimulatorInterface $matchSimulator;

    public function __construct(MatchSimulatorInterface $matchSimulator)
    {
        $this->matchSimulator = $matchSimulator;
    }

    /**
     * Generate fixtures
     *
     * @param array $ids
     */
    public function generate($ids): void
    {
        if (empty($ids) || count($ids) <= 1) {
            throw new RuntimeException('Too few teams');
        }

        $teams = count($ids);

        // Generate the fixtures using the cyclic algorithm.
        $totalRounds = $teams - 1;
        $matchesPerRound = $teams / 2;
        $rounds = array();
        for ($i = 0; $i < $totalRounds; $i++) {
            $rounds[$i] = array();
        }

        for ($round = 0; $round < $totalRounds; $round++) {
            for ($match = 0; $match < $matchesPerRound; $match++) {
                $home = ($round + $match) % ($teams - 1);
                $away = ($teams - 1 - $match + $round) % ($teams - 1);
                // Last team stays in the same place while the others
                // rotate around it.
                if ($match == 0) {
                    $away = $teams - 1;
                }
                $rounds[$round][$match] = [$ids[$home], $ids[$away]];
                $rounds[$round + $totalRounds][$match] = [$ids[$away], $ids[$home]];
            }
        }


        foreach ($rounds as $week_number => $matches) {
            foreach ($matches as $match) {
                Fixture::create([
                    'week_number' => $week_number + 1,
                    'home_team_id' => $match[0],
                    'away_team_id' => $match[1],
                ]);
            }
        }
    }

    /**
     * Play particular or next week matches
     *
     * @param int $week
     */
    public function playWeek(int $week = 0): void
    {
        if ($week === 0) {
            if ($wn = Fixture::notPlayed()->min('week_number')) {
                $week = $wn;
            } else {
                throw new RuntimeException('Already played all');
            }
        }

        $fixtures = Fixture::with(['homeTeam', 'winnerTeam'])
            ->notPlayed()
            ->where('week_number', $week)
            ->get();

        $this->matchSimulator->bulkSimulate($fixtures);
    }

    /**
     * Play all upcoming fixtures
     */
    public function playAll(): void
    {
        $fixtures = Fixture::with(['homeTeam', 'winnerTeam'])
            ->notPlayed()
            ->ordered()
            ->get();

        if ($fixtures->isEmpty()) {
            throw new RuntimeException('No fixture to play');
        }

        $this->matchSimulator->bulkSimulate($fixtures);
    }
}
